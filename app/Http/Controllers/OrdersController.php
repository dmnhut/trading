<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Orders;
use App\OrderDetail;
use App\OrderPay;
use App\OrderPrice;
use App\OrderUnit;
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
use App\Fun\Sql;
use App\Fun\Validate;

class OrdersController extends Controller
{
    /**
     * general code
     *
     * @return string
     */
    public function code()
    {
        return ['code' => __::uuid()];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('orders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = DB::select(Sql::getUsers2CreateOrder());
        $provinces = Provinces::select('id as id', 'name as text')
                              ->orderBy('text')
                              ->get();
        $units = Units::select('id', 'name')
                      ->where('del_flag', 0)
                      ->orderBy('name')
                      ->get();
        $prices = Prices::select('id', 'kg', 'amount')
                        ->where('del_flag', 0)
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
          'kg'       => Messages::errors()->orders('kg')
        ];
        $validator = [
          'quantity' => ['re'    => substr(Validate::reg('QUANTITY'), 1, 6),
                         'error' => Validate::message('quantity')]
        ];
        return view('orders.create', ['code'      => __::uuid(),
                                      'users'     => $users,
                                      'provinces' => $provinces,
                                      'units'     => $units,
                                      'prices'    => $prices,
                                      'messages'  => $messages,
                                      'validator' => $validator]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $order = Orders::create([
              'code'         => $request->code,
              'id_user'      => $request->user,
              'id_province'  => $request->province,
              'id_district'  => $request->district,
              'id_ward'      => $request->ward,
              'total_amount' => $request->total_amount,
              'address'      => $request->address,
              'note'         => 'đơn hàng '.$request->code.' được tạo bởi '.'admin'.' vào lúc '.date_format(new DateTime('NOW'), 'd/m/Y H:i:s')
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
                'id_pay'   => Pays::select('id')
                                  ->where('turn_on', 1)
                                  ->where('del_flag', 0)
                                  ->first()
                                  ->id
            ]);
            $order_price = OrderPrice::create([
              'id_order' => $order->id,
              'id_price' =>  $request->kg
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
