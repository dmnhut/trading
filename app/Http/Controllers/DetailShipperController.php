<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\DetailShipper;
use App\__;

class DetailShipperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::select('users.id as id', 'users.name as name', 'users.email as email', 'users.phone')
                      ->leftjoin('status_user', 'status_user.id_user', '=', 'users.id')
                      ->leftjoin('status', 'status.id', '=', 'status_user.id_status')
                      ->where('users.del_flag', 0)
                      ->where('status.name', 'active')
                      ->get();
        $shippers = DetailShipper::select('users.id as id', 'detail_shipper.id as id_shipper', 'provinces.name as province', 'districts.name as district', 'wards.name as ward')
                                  ->rightjoin('users', 'users.id', '=', 'detail_shipper.id_user')
                                  ->leftjoin('status_user', 'status_user.id_user', '=', 'users.id')
                                  ->leftjoin('status', 'status.id', '=', 'status_user.id_status')
                                  ->leftjoin('provinces', 'provinces.id', '=', 'detail_shipper.id_province')
                                  ->leftjoin('districts', 'districts.id', '=', 'detail_shipper.id_district')
                                  ->leftjoin('wards', 'wards.id', '=', 'detail_shipper.id_ward')
                                  ->where('users.del_flag', 0)
                                  ->where('status.name', 'active')
                                  ->get();
        $detail_shippers = [];
        foreach ($shippers as $val) {
            $detail_shippers[$val->id] = [
              'id_shipper' => $val->id_shipper,
              'province' => $val->province,
              'district' => $val->district,
              'ward' => $val->ward
          ];
        }
        return view('detail-shippers.index', ['data' => $users, 'detail_shippers' => $detail_shippers]);
    }

    /**
     * detail
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request)
    {
        $data = User::find($request->get('id'));
        if (empty($data)) {
            $data = [];
        } else {
            $data = $data->toArray();
            if ($data['gender'] == 1) {
                $data['gender'] = 'Nam';
            } else {
                $data['gender'] = 'Nữ';
            }
        }
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DetailShipper::create([
          'id_user' => $request->user,
          'id_province' => $request->province,
          'id_district' => $request->district,
          'id_ward' => $request->ward
        ]);
        return [
          'message' => __::messages()->success(),
          'error' => false
        ];
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
        $detail_shippers = DetailShipper::find($id);
        $detail_shippers->delete();
        return redirect(route('detail-shippers.index'));
    }
}
