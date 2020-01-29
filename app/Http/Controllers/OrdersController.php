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
use App\__;
use App\Sql;
use DateTime;

class OrdersController extends Controller
{
    /**
     * generalCode
     * @return string
     */
    public function generalCode()
    {
        return ['code' => __::struuid()];
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
          'item' => __::messages()->errors()->items('item'),
          'unit' => __::messages()->errors()->items('unit'),
          'quantity' => __::messages()->errors()->items('quantity'),
          'items' => __::messages()->errors()->orders('items'),
          'province' => __::messages()->errors()->orders('province'),
          'district' => __::messages()->errors()->orders('district'),
          'ward' => __::messages()->errors()->orders('ward'),
          'address' => __::messages()->errors()->orders('address'),
          'kg' => __::messages()->errors()->orders('kg')
        ];
        $validator = [
          'quantity' => ['re' => substr(__::re('QUANTITY'), 1, 6),
                         'error' => __::validates('quantity')]
        ];
        return view('orders.create', ['code' => __::struuid(),
                                      'users' => $users,
                                      'provinces' => $provinces,
                                      'units' => $units,
                                      'prices' => $prices,
                                      'messages' => $messages,
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
              'code' => $request->code,
              'id_user' => $request->user,
              'id_province' => $request->province,
              'id_district' => $request->district,
              'id_ward' => $request->ward,
              'total_amount' => $request->total_amount,
              'address' => $request->address,
              'note' => 'đơn hàng '.$request->code.' được tạo bởi '.'admin'.' vào lúc '.date_format(new DateTime('NOW'), 'd/m/Y H:i:s')
            ]);
            $items = json_decode($request->items);
            foreach ($items as $value) {
                $order_detail = OrderDetail::create([
                  'id_order' => $order->id,
                  'item_name' => $value->item_name,
                  'quantity' => $value->quantity
                ]);
                $order_unit = OrderUnit::create([
                  'id_item' => $order_detail->id,
                  'id_unit' => $value->id_unit
                ]);
            }
            $order_pay = OrderPay::create([
                'id_order' => $order->id,
                'id_pay' => Pays::select('id')
                                ->where('turn_on', 1)
                                ->where('del_flag', 0)
                                ->first()
                                ->id
            ]);
            $order_price = OrderPrice::create([
              'id_order' =>$order->id,
              'id_price' =>  $request->kg
            ]);
            DB::commit();
            return [
              'message' => __::messages()->success(),
              'error' => false
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
              'message' => __::messages()->errors()->_500(),
              'error' => true
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
