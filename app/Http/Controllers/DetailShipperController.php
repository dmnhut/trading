<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use App\DetailShipper;
use App\Balances;
use App\Fun\__;
use App\Fun\Messages;
use Auth;

class DetailShipperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = empty($request->page) ? 1 : $request->page;
        $query = User::select('users.id as id', 'users.name as name', 'users.email as email', 'users.phone')
                     ->leftjoin('status_user', 'status_user.id_user', '=', 'users.id')
                     ->leftjoin('status', 'status.id', '=', 'status_user.id_status')
                     ->where('users.del_flag', 0)
                     ->where('status.id', __::status('active'));
        $role = __::get_role_code(Auth::user()->id);
        if ($role === __::ROLES['USER']) {
            $query = $query->where('users.id', Auth::user()->id);
        }
        $total = $query->count();
        $page_number = ceil($total/__::TAKE_ITEM);
        $shippers = DetailShipper::select('users.id as id', 'detail_shipper.id as id_shipper', 'provinces.id as id_province', 'provinces.name as province', 'districts.id as id_district', 'districts.name as district', 'wards.id as id_ward', 'wards.name as ward')
                                 ->rightjoin('users', 'users.id', '=', 'detail_shipper.id_user')
                                 ->leftjoin('status_user', 'status_user.id_user', '=', 'users.id')
                                 ->leftjoin('status', 'status.id', '=', 'status_user.id_status')
                                 ->leftjoin('provinces', 'provinces.id', '=', 'detail_shipper.id_province')
                                 ->leftjoin('districts', 'districts.id', '=', 'detail_shipper.id_district')
                                 ->leftjoin('wards', 'wards.id', '=', 'detail_shipper.id_ward')
                                 ->where('users.del_flag', 0)
                                 ->where('status.name', 'active')->get();
        $detail_shippers = [];
        foreach ($shippers as $val) {
            $detail_shippers[$val->id] = [
                                       'id_shipper' => $val->id_shipper,
                                       'province'   => [
                                          'id'      => $val->id_province,
                                          'name'    => $val->province
                                       ],
                                       'district'   => [
                                          'id'      => $val->id_district,
                                          'name'    => $val->district
                                       ],
                                       'ward'       => [
                                          'id'      => $val->id_ward,
                                          'name'    => $val->ward
                                       ]
            ];
        }
        return view('detail-shippers.index', [
                                               'data'            => $query->paginate(__::TAKE_ITEM),
                                               'page_number'     => $page_number,
                                               'page_active'     => $page,
                                               'detail_shippers' => $detail_shippers,
                                               'captions'        => ['add' => __::ADD, 'update' => __::UPDATE],
                                               'role'            => $role
                                             ]);
    }

    /**
     * detail
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request)
    {
        if ($request->id != Auth::user()->id) {
            Auth::logout();
            return [
              'message' => Messages::errors()->permission(),
              'error'   => true
            ];
        }
        $data = User::find($request->id);
        if (empty($data)) {
            $data = [];
        } else {
            $data = $data->toArray();
            if ($data['gender'] == 1) {
                $data['gender'] = __::GENDER['MALE'];
            } else {
                $data['gender'] = __::GENDER['FEMALE'];
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
        $role = __::get_role_code(Auth::user()->id);
        if ($role === __::ROLES['USER']) {
            Auth::logout();
            return [
              'message' => Messages::errors()->permission(),
              'error'   => true
            ];
        }
        DetailShipper::create([
          'id_user'     => $request->user,
          'id_province' => $request->province,
          'id_district' => $request->district,
          'id_ward'     => $request->ward
        ]);
        Balances::create([
          'id_shipper' => $request->user,
          'total'      => '0'
        ]);
        return [
          'message' => Messages::success(),
          'error'   => false
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
        $role = __::get_role_code(Auth::user()->id);
        if ($role === __::ROLES['USER']) {
            if ($id != Auth::user()->id) {
                Auth::logout();
                return [
                  'message' => Messages::errors()->permission(),
                  'error'   => true
                ];
            }
        }
        $detail_shippers = DetailShipper::find($id);
        $detail_shippers->update([
                            'id_province' => $request->province,
                            'id_district' => $request->district,
                            'id_ward'     => $request->ward,
                            'version_no'  => $detail_shippers->version_no + 1
                          ]);
        return [
          'message' => Messages::update(),
          'error'   => false
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = __::get_role_code(Auth::user()->id);
        if ($role === __::ROLES['USER']) {
            Auth::logout();
            return redirect('login')->with([
            'message' => Messages::errors()->permission(),
            'error'   => true
          ]);
        }
        $detail_shippers = DetailShipper::find($id);
        $balances = Balances::where('id_shipper', $detail_shippers->id_user);
        $detail_shippers->delete();
        $balances->update(['del_flag' => 1, 'version_no' => DB::raw('version_no + 1')]);
        return redirect(route('detail-shippers.index'));
    }
}
