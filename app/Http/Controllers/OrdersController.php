<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Orders;
use App\OrderDetail;
use App\OrderPay;
use App\OrderPrice;
use App\OrderUnit;
use App\StatusOrder;
use App\Traces;
use App\TracesLog;
use App\User;
use App\Provinces;
use App\Districts;
use App\Wards;
use App\Units;
use App\Prices;
use App\Pays;
use DateTime;
use App\Fun\__;
use App\Fun\Messages;
use App\Fun\Notes;
use App\Fun\Sql;
use App\Fun\Validate;
use Auth;

class OrdersController extends Controller
{
    /**
     * general code
     *
     * @return string
     */
    public function code()
    {
        return [
            'code' => __::uuid()
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = empty($request->page) ? 1 : $request->page;
        $query = Orders::select(
            'orders.id as id',
            'orders.code as code',
            'users.name as user_name',
            'users.phone as user_phone',
            'orders.address as ship_address',
            'status_order.id_status as id_status',
            'status.name as name_status',
            'orders.note as note'
        )->leftjoin('users', 'users.id', '=', 'orders.id_user')
         ->leftjoin('status_user', 'status_user.id_user', '=', 'users.id')
         ->leftjoin('status_order', 'status_order.id_order', '=', 'orders.id')
         ->leftjoin('status', 'status.id', '=', 'status_order.id_status')
         ->where('orders.del_flag', 0)
         ->where('users.del_flag', 0)
         ->where('status_user.id_status', 1)
         ->where('status_user.del_flag', 0)
         ->where('status_order.del_flag', 0)
         ->where('status.del_flag', 0);
        $role = __::get_role_code(Auth::user()->id);
        if ($role === __::ROLES['USER']) {
            $query = $query->where('orders.id_user', Auth::user()->id);
        }
        $total = $query->count();
        $page_number = ceil($total/__::TAKE_ITEM);
        return view('orders.index', [
            'data'        => $query->paginate(__::TAKE_ITEM),
            'page_number' => $page_number,
            'page_active' => $page
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = __::get_role_code(Auth::user()->id);
        if ($role === __::ROLES['USER']) {
            $users = DB::select(Sql::getUsers2CreateOrder(true, Auth::user()->id));
        } elseif ($role === __::ROLES['ADMIN']) {
            $users = DB::select(Sql::getUsers2CreateOrder(true, null));
        }
        $provinces = Provinces::select(
            'id as id',
            'name as text'
        )->orderBy('text')
         ->get();
        $units = Units::select(
            'id',
            'name'
        )->where('del_flag', 0)
         ->orderBy('name')
         ->get();
        $prices = Prices::select(
            'id',
            'kg',
            'amount'
        )->where('del_flag', 0)
         ->where('turn_on', 1)
         ->get();
        $messages = [
            'item'     => Messages::errors()->items('item'),
            'unit'     => Messages::errors()->items('unit'),
            'quantity' => Messages::errors()->items('quantity'),
            'items'    => Messages::errors()->orders('items'),
            'province' => Messages::errors()->orders('province'),
            'district' => Messages::errors()->orders('district'),
            'ward'     => Messages::errors()->orders('ward'),
            'address'  => Messages::errors()->orders('address'),
            'receiver' => Messages::errors()->orders('receiver'),
            'phone'    => Messages::errors()->orders('phone'),
            'kg'       => Messages::errors()->orders('kg')
        ];
        $validator = [
            'quantity' => [
                're'    => substr(Validate::reg('QUANTITY'), 1, 6),
                'error' => Validate::message('quantity')
            ]
        ];
        return view('orders.create', [
            'code'      => __::uuid(),
            'users'     => $users,
            'provinces' => $provinces,
            'units'     => $units,
            'prices'    => $prices,
            'messages'  => $messages,
            'validator' => $validator
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = __::get_role_code(Auth::user()->id);
        if ($role === __::ROLES['USER']) {
            if ($request->user != Auth::user()->id) {
                Auth::logout();
                return redirect('login')->with([
                    'message' => Messages::errors()->permission(),
                    'error'   => true
                ]);
            }
        }
        try {
            DB::beginTransaction();
            $date_time = date_format(new DateTime('NOW'), 'd/m/Y H:i:s');
            $order = Orders::create([
                'code'         => $request->code,
                'id_user'      => $request->user,
                'id_province'  => $request->province,
                'id_district'  => $request->district,
                'id_ward'      => $request->ward,
                'total_amount' => $request->total_amount,
                'address'      => $request->address,
                'lat'          => $request->lat,
                'lng'          => $request->lng,
                'receiver'     => $request->receiver,
                'phone'        => $request->phone,
                'note'         => Notes::order('create', $request->code, Auth::user()->name, $date_time)
            ]);
            $items = json_decode($request->items);
            foreach ($items as $value) {
                $order_detail = OrderDetail::create([
                    'id_order'  => $order->id,
                    'item_name' => $value->item_name,
                    'quantity'  => $value->quantity
                ]);
                $order_unit = OrderUnit::create([
                    'id_item' => $order_detail->id,
                    'id_unit' => $value->id_unit
                ]);
            }
            $order_pay = OrderPay::create([
                'id_order' => $order->id,
                'id_pay'   => Pays::select(
                    'id'
                )->where('turn_on', 1)
                 ->where('del_flag', 0)
                 ->first()
                 ->id
            ]);
            $order_price = OrderPrice::create([
                'id_order' => $order->id,
                'id_price' =>  $request->kg
            ]);
            $status_order = StatusOrder::create([
                'id_status' => __::status('create'),
                'id_order'  => $order->id
            ]);
            $traces = Traces::create([
                'id_order'  => $order->id,
                'id_status' => __::status('create'),
                'time'      => $date_time,
                'note'      => Notes::trace('create', $request->code, $date_time)
            ]);
            $traces_log = TracesLog::create([
                'id_trace'  => $traces->id,
                'id_status' => __::status('create'),
                'time'      => $date_time,
                'note'      => Notes::trace('create', $request->code, $date_time)
            ]);
            DB::commit();
            return [
                'message' => Messages::success(),
                'error'   => false
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'message' => Messages::errors()->_500(),
                'error'   => true
            ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Orders::select(
            'orders.id as id',
            'orders.code as code',
            'orders.id_user as id_user',
            'orders.id_province as id_province',
            'orders.id_district as id_district',
            'orders.id_ward as id_ward',
            'orders.total_amount as total_amount',
            'orders.address as address',
            'orders.receiver as receiver',
            'orders.phone as phone',
            'order_price.id_price as id_price',
            'prices.amount as amount',
            'order_pay.id_pay as id_pay'
        )->leftjoin('order_price', 'order_price.id_order', '=', 'orders.id')
         ->leftjoin('order_pay', 'order_pay.id_order', '=', 'orders.id')
         ->leftjoin('prices', 'prices.id', '=', 'order_price.id_price')
         ->where('orders.id', $id)
         ->where('orders.del_flag', 0)
         ->where('order_price.del_flag', 0)
         ->where('order_pay.del_flag', 0)
         ->where('prices.del_flag', 0)
         ->first();
        $role = __::get_role_code(Auth::user()->id);
        if ($role === __::ROLES['USER']) {
            if ($order->id_user != Auth::user()->id) {
                Auth::logout();
                return redirect('login')->with([
                    'message' => Messages::errors()->permission(),
                    'error'   => true
                ]);
            }
        }
        if ($role === __::ROLES['USER']) {
            $users = DB::select(Sql::getUsers2CreateOrder(true, Auth::user()->id));
        } elseif ($role === __::ROLES['ADMIN']) {
            $users = DB::select(Sql::getUsers2CreateOrder(true, null));
        }
        $units = Units::select(
            'id',
            'name'
        )->where('del_flag', 0)
         ->orderBy('name')
         ->get();
        $prices = Prices::select(
            'id',
            'kg',
            'amount'
        )->where('del_flag', 0)
         ->where('turn_on', 1)
         ->get();
        $messages = [
            'item'     => Messages::errors()->items('item'),
            'unit'     => Messages::errors()->items('unit'),
            'quantity' => Messages::errors()->items('quantity'),
            'items'    => Messages::errors()->orders('items'),
            'province' => Messages::errors()->orders('province'),
            'district' => Messages::errors()->orders('district'),
            'ward'     => Messages::errors()->orders('ward'),
            'address'  => Messages::errors()->orders('address'),
            'receiver' => Messages::errors()->orders('receiver'),
            'phone'    => Messages::errors()->orders('phone'),
            'kg'       => Messages::errors()->orders('kg')
        ];
        $validator = [
            'quantity' => [
                're'    => substr(Validate::reg('QUANTITY'), 1, 6),
                'error' => Validate::message('quantity')
            ]
        ];
        $order_detail = OrderDetail::select(
            'order_detail.item_name as item_name',
            'order_detail.quantity as quantity',
            'order_unit.id_unit as id_unit',
            'units.name as name_unit'
        )->leftjoin('order_unit', 'order_unit.id_item', '=', 'order_detail.id')
         ->leftjoin('units', 'units.id', '=', 'order_unit.id_unit')
         ->where('order_detail.id_order', $id)
         ->where('order_detail.del_flag', 0)
         ->where('order_unit.del_flag', 0)
         ->where('units.del_flag', 0)
         ->get();
        $provinces = Provinces::select(
            'id as id',
            'name as text'
        )->orderBy('text')
         ->get();
        $districts = Districts::select(
            'id as id',
            'name as text'
        )->where('id_province', $order->id_province)
         ->orderBy('text')
         ->get();
        $wards = Wards::select(
            'id as id',
            'name as text'
        )->where('id_district', $order->id_district)
         ->orderBy('text')
         ->get();
        return view('orders.edit', [
            'id'        => $id,
            'code'      => $order->code,
            'users'     => $users,
            'provinces' => $provinces,
            'districts' => $districts,
            'wards'     => $wards,
            'units'     => $units,
            'prices'    => $prices,
            'messages'  => $messages,
            'validator' => $validator,
            'data'      => $order,
            'details'   => $order_detail
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = __::get_role_code(Auth::user()->id);
        if ($role === __::ROLES['USER']) {
            if ($request->user != Auth::user()->id) {
                Auth::logout();
                return redirect('login')->with([
                    'message' => Messages::errors()->permission(),
                    'error'   => true
                ]);
            }
        }
        try {
            DB::beginTransaction();
            $date_time = date_format(new DateTime('NOW'), 'd/m/Y H:i:s');
            $order               = Orders::find($id);
            $order->id_user      = $request->user;
            $order->id_province  = $request->province;
            $order->id_district  = $request->district;
            $order->id_ward      = $request->ward;
            $order->total_amount = $request->total_amount;
            $order->address      = $request->address;
            $order->lat          = $request->lat;
            $order->lng          = $request->lng;
            $order->receiver     = $request->receiver;
            $order->phone        = $request->phone;
            $order->note         = Notes::order('updated', $request->code, Auth::user()->name, $date_time);
            $order->version_no   = $order->version_no + 1;
            $order->save();
            $items = OrderDetail::select(
                'id'
            )->where('id_order', $order->id)
             ->get();
            foreach ($items as $value) {
                OrderDetail::find($value->id)
                           ->update([
                               'del_flag'   => 1,
                               'version_no' => DB::raw('version_no + 1')
                           ]);
                OrderUnit::find($value->id)
                         ->update([
                             'del_flag'   => 1,
                             'version_no' => DB::raw('version_no + 1')
                         ]);
            }
            $items = json_decode($request->items);
            foreach ($items as $value) {
                $order_detail = OrderDetail::create([
                    'id_order'  => $order->id,
                    'item_name' => $value->item_name,
                    'quantity'  => $value->quantity
                ]);
                $order_unit = OrderUnit::create([
                    'id_item' => $order_detail->id,
                    'id_unit' => $value->id_unit
                ]);
            }
            $order_pay = OrderPay::where('id_order', $order->id)
                                 ->where('del_flag', 0)
                                 ->update([
                                     'id_pay'    => Pays::select(
                                         'id'
                                     )->where('turn_on', 1)
                                      ->where('del_flag', 0)
                                      ->first()
                                      ->id,
                                     'version_no' => DB::raw('version_no + 1')
                                 ]);
            $order_price = OrderPrice::where('id_order', $order->id)
                                     ->where('del_flag', 0)
                                     ->update([
                                         'id_price'   => $request->kg,
                                         'version_no' => DB::raw('version_no + 1')
                                     ]);
            $status_order = StatusOrder::where('id_order', $order->id)
                                       ->where('del_flag', 0)
                                       ->update([
                                           'id_status'  => __::status('updated'),
                                           'version_no' => DB::raw('version_no + 1')
                                       ]);
            $traces = Traces::where('id_order', $order->id)
                            ->where('del_flag', 0);
            $traces->update([
                'id_status'  => __::status('updated'),
                'time'       => $date_time,
                'note'       => Notes::trace('updated', $request->code, $date_time),
                'version_no' => DB::raw('version_no + 1')
            ]);
            $traces_log = TracesLog::create([
                'id_trace'  => $traces->first()->id,
                'id_status' => __::status('updated'),
                'time'      => $date_time,
                'note'      => Notes::trace('updated', $request->code, $date_time)
            ]);
            DB::commit();
            return [
                'message' => Messages::update(),
                'error'   => false
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'message' => Messages::errors()->_500(),
                'error'   => true
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Orders::find($id);
        $role = __::get_role_code(Auth::user()->id);
        if ($role === __::ROLES['USER']) {
            if ($order->id_user != Auth::user()->id) {
                Auth::logout();
                return redirect('login')->with([
                    'message' => Messages::errors()->permission(),
                    'error'   => true
                ]);
            }
        }
        $order->update([
            'del_flag' => 1,
            DB::raw('version_no + 1')
        ]);
        return redirect(route('orders.index'))->with([
            'message' => Messages::cancel(__::get_text('order')),
            'error'   => false
        ]);
    }
}
