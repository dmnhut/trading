<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Orders;
use App\User;
use App\Provinces;
use App\Districts;
use App\Wards;
use App\Units;
use App\Prices;
use App\__;

class OrdersController extends Controller
{
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
        $users = DB::select("select CONCAT(name, ' - ', phone) as name,
                                    users.id                   as id
                               from users
                               left join status_user
                                 on status_user.id_user        = users.id
                              where users.del_flag             = 0
                                and status_user.id_status      = 1
                              order by users.name");
        $provinces = Provinces::select('id as id', 'name as text')->orderBy('text')->get();
        $units = Units::select('id', 'name')->where('del_flag', 0)->orderBy('name')->get();
        $prices = Prices::select('id', 'kg', 'amount')->where('del_flag', 0)->where('turn_on', 1)->get();
        $messages = [
          'item' => __::messages()->errors()->items('item'),
          'unit' => __::messages()->errors()->items('unit'),
          'quantity' => __::messages()->errors()->items('quantity')
        ];
        $validator = [
          're' => substr(__::re('QUANTITY'), 1, 6),
          'error' => __::validates('quantity')
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
        //
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
