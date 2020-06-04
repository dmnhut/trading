<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GeoLocation;
use App\Orders;
use App\Fun\Messages;
use App\FUn\__;
use Auth;
use Carbon\Carbon;

class MapController extends Controller
{
    /**
     * index
     *
     * @param  Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $destination = Orders::select('lat', 'lng')
                             ->where('id', $request->order)
                             ->where('del_flag', 0)
                             ->first();
        $title = [
            'location' => __::map('location'),
            'address'  => __::map('address')
        ];
        return view('map.index', [
            'title'       => $title,
            'order'       => $request->order,
            'destination' => $destination
        ]);
    }

    /**
     * get
     *
     * @param  Request
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request)
    {
        $data = GeoLocation::select('lat', 'lng')
                           ->where('id_order', $request->order)
                           ->where('id', GeoLocation::max('id'))
                           ->first();
        if (empty($data)) {
            return [
                'error' => true,
                'data'  => []
            ];
        }
        return [
            'error' => false,
            'data'  => $data
        ];
    }

    /**
     * location
     *
     * @param  Request
     * @return \Illuminate\Http\Response
     */
    public function location(Request $request)
    {
        $shipper = Orders::select('id_shipper as id')
                         ->where('id', $request->order)
                         ->where('del_flag', 0)
                         ->first();
        return view('map.location', [
            'order'   => $request->order,
            'shipper' => $shipper->id
        ]);
    }

    /**
     * store
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $location = GeoLocation::create([
            'id_user'  => $request->shipper,
            'id_order' => $request->order,
            'lat'      => $request->lat,
            'lng'      => $request->lng,
            'datetime' => Carbon::now()->toDateTimeString()
        ]);
        return [
            'error' => false,
            'data'  => $location
        ];
    }

    /**
     * check_shipping
     *
     * @param  Request
     * @return \Illuminate\Http\Response
     */
    public function check_shipping(Request $request)
    {
        $query = Orders::select('orders.id as id', 'orders.code as code', 'users.id as user_id', 'shipper.id as shipper_id')
                       ->leftjoin('users', 'users.id', '=', 'orders.id_user')
                       ->leftjoin('status_user', 'status_user.id_user', '=', 'users.id')
                       ->leftjoin('status_order', 'status_order.id_order', '=', 'orders.id')
                       ->leftjoin('status', 'status.id', '=', 'status_order.id_status')
                       ->leftjoin('detail_shipper', 'detail_shipper.id_user', '=', 'orders.id_shipper')
                       ->leftjoin('users as shipper', 'shipper.id', '=', 'detail_shipper.id_user')
                       ->leftjoin('status_user as status_shipper', 'status_shipper.id_user', '=', 'detail_shipper.id_user')
                       ->where('orders.id', $request->id)
                       ->where('orders.del_flag', 0)
                       ->where('users.del_flag', 0)
                       ->where('detail_shipper.del_flag', 0)
                       ->where('status_user.id_status', 1)
                       ->where('status_user.del_flag', 0)
                       ->where('status_order.id_status', __::status('shipping'))
                       ->where('shipper.del_flag', 0)
                       ->where('status_shipper.id_status', 1)
                       ->where('status_shipper.del_flag', 0)
                       ->where('status_order.del_flag', 0)
                       ->where('status.del_flag', 0);
        if ($query->count() == 0) {
            return [
                'message' => Messages::errors()->map('shipping'),
                'error'   => true
            ];
        }
        if ($request->btn == 'map') {
            if (__::get_role_code(Auth::user()->id) == __::ROLES['USER']) {
                $query = $query->where('users.id', Auth::user()->id);
            }
        } elseif ($request->btn == 'location') {
            $query = $query->where('shipper.id', Auth::user()->id);
        }
        if ($query->count() > 0) {
            return [
                'message' => '',
                'error'   => false
            ];
        }
        return [
            'message' => Messages::errors()->map($request->btn),
            'error'   => true
        ];
    }
}
