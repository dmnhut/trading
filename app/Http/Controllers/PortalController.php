<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Orders;
use App\Status;
use App\StatusOrder;
use App\Traces;
use App\TracesLog;
use App\Balances;
use App\BalanceLog;
use App\Pays;
use App\User;
use App\DetailShipper;
use DateTime;
use App\Fun\__;
use App\Fun\Messages;
use App\Fun\Notes;
use Auth;

class PortalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $role = __::get_role_code(Auth::user()->id);
        if ($role === __::ROLES['ADMIN']) {
            $tab = empty($request->tab) ? __::get_tab('ASSIGN') : $request->tab;
            $status_not_show = [
                                 __::status('create'),
                                 __::status('active'),
                                 __::status('locked'),
                                 __::status('updated'),
                                 __::status('pay'),
                                 __::status('transfers')
                               ];
        } elseif ($role === __::ROLES['USER']) {
            $tab = __::get_tab('SHIPPING');
            $status_not_show = [
                                 __::status('create'),
                                 __::status('active'),
                                 __::status('locked'),
                                 __::status('updated'),
                                 __::status('pay'),
                                 __::status('transfers'),
                                 __::status('cancel')
                               ];
        }
        $page = empty($request->page) ? 1 : $request->page;
        $status = Status::select('id', 'name')
                        ->where('del_flag', 0)
                        ->whereNotIn('id', $status_not_show)
                        ->get();
        foreach ($status as $value) {
            $value->name = __::status_name($value->name);
        }
        if ($tab === __::get_tab('ASSIGN')) {
            $query = Orders::select('orders.id as id', 'orders.code as code', 'users.name as user_name', 'users.phone as user_phone', 'orders.address as ship_address', 'status_order.id_status as id_status', 'status.name as name_status', 'orders.note as note')
                           ->leftjoin('users', 'users.id', '=', 'orders.id_user')
                           ->leftjoin('status_user', 'status_user.id_user', '=', 'users.id')
                           ->leftjoin('status_order', 'status_order.id_order', '=', 'orders.id')
                           ->leftjoin('status', 'status.id', '=', 'status_order.id_status')
                           ->where('orders.del_flag', 0)
                           ->where('users.del_flag', 0)
                           ->where('status_user.id_status', 1)
                           ->where('status_user.del_flag', 0)
                           ->whereIn('status_order.id_status', [__::status('create'), __::status('updated'), __::status('rollback')])
                           ->where('status_order.del_flag', 0)
                           ->where('status.del_flag', 0);
        } elseif ($tab === __::get_tab('SHIPPING')) {
            $query = Orders::select('orders.id as id', 'orders.code as code', 'users.name as user_name', 'users.phone as user_phone', 'orders.address as ship_address', 'status_order.id_status as id_status', 'status.name as name_status', 'orders.note as note', 'shipper.name as shipper_name', 'shipper.phone as shipper_phone')
                           ->leftjoin('users', 'users.id', '=', 'orders.id_user')
                           ->leftjoin('status_user', 'status_user.id_user', '=', 'users.id')
                           ->leftjoin('status_order', 'status_order.id_order', '=', 'orders.id')
                           ->leftjoin('status', 'status.id', '=', 'status_order.id_status')
                           ->leftjoin('detail_shipper', 'detail_shipper.id_user', '=', 'orders.id_shipper')
                           ->leftjoin('users as shipper', 'shipper.id', '=', 'detail_shipper.id_user')
                           ->leftjoin('status_user as status_shipper', 'status_shipper.id_user', '=', 'detail_shipper.id_user')
                           ->where('orders.del_flag', 0)
                           ->where('users.del_flag', 0)
                           ->where('detail_shipper.del_flag', 0)
                           ->where('status_user.id_status', 1)
                           ->where('status_user.del_flag', 0)
                           ->where('shipper.del_flag', 0)
                           ->where('status_shipper.id_status', 1)
                           ->where('status_shipper.del_flag', 0)
                           ->where('status_order.del_flag', 0)
                           ->where('status.del_flag', 0)
                           ->whereIn('status_order.id_status', [__::status('pack'), __::status('assign'), __::status('shipping'), __::status('pending')]);
            if ($role === __::ROLES['USER']) {
                $id = Auth::user()->id;
                $query = $query->where(function ($query) use ($id) {
                    $query->orWhere('orders.id_user', $id)
                          ->orWhere('detail_shipper.id_user', $id);
                });
            }
        } elseif ($tab === __::get_tab('TRANSFERS')) {
            $query = Orders::select('orders.id as id', 'orders.code as code', 'users.name as user_name', 'users.phone as user_phone', 'orders.address as ship_address', 'status_order.id_status as id_status', 'status.name as name_status', 'orders.note as note', 'shipper.name as shipper_name', 'shipper.phone as shipper_phone')
                           ->leftjoin('users', 'users.id', '=', 'orders.id_user')
                           ->leftjoin('status_user', 'status_user.id_user', '=', 'users.id')
                           ->leftjoin('status_order', 'status_order.id_order', '=', 'orders.id')
                           ->leftjoin('status', 'status.id', '=', 'status_order.id_status')
                           ->leftjoin('detail_shipper', 'detail_shipper.id_user', '=', 'orders.id_shipper')
                           ->leftjoin('users as shipper', 'shipper.id', '=', 'detail_shipper.id_user')
                           ->leftjoin('status_user as status_shipper', 'status_shipper.id_user', '=', 'detail_shipper.id_user')
                           ->where('orders.del_flag', 0)
                           ->where('users.del_flag', 0)
                           ->where('detail_shipper.del_flag', 0)
                           ->where('status_user.id_status', 1)
                           ->where('status_user.del_flag', 0)
                           ->where('shipper.del_flag', 0)
                           ->where('status_shipper.id_status', 1)
                           ->where('status_shipper.del_flag', 0)
                           ->whereIn('status_order.id_status', [__::status('success')])
                           ->where('status_order.del_flag', 0)
                           ->where('status.del_flag', 0);
        }
        $total = $query->count();
        $page_number = ceil($total/__::TAKE_ITEM);
        return view('portal.index', [
                                      'data'        => $query->paginate(__::TAKE_ITEM),
                                      'page_number' => $page_number,
                                      'page_active' => $page,
                                      'tab'         => $tab,
                                      'status'      => $status,
                                      'role'        => $role
                                    ]);
    }

    /**
     * get_shippers
     *
     * @return \Illuminate\Http\Response
     */
    public function get_shippers()
    {
        $data = DetailShipper::select(
            'detail_shipper.id_user as id_shipper',
            'users.name as name',
            'users.email as email',
            'users.phone as phone',
            'provinces.name as province',
            'districts.name as district',
            'wards.name as ward'
        )->leftjoin('users', 'users.id', '=', 'detail_shipper.id_user')
         ->leftjoin('status_user', 'status_user.id_user', '=', 'users.id')
         ->leftjoin('provinces', 'provinces.id', '=', 'id_province')
         ->leftjoin('districts', 'districts.id', '=', 'id_district')
         ->leftjoin('wards', 'wards.id', '=', 'id_ward')
         ->where('detail_shipper.del_flag', 0)
         ->where('users.del_flag', 0)
         ->where('status_user.id_status', __::status('active'))
         ->where('status_user.del_flag', 0)
         ->where('provinces.del_flag', 0)
         ->where('districts.del_flag', 0)
         ->where('wards.del_flag', 0)
         ->get();
        if ($data->isEmpty()) {
            return [
              'error'   => true,
              'message' => Messages::errors()->detail_shipper('empty'),
              'data'    => []
            ];
        } else {
            return [
              'error'   => false,
              'message' => '',
              'data'    => $data
            ];
        }
    }

    /**
     * assign
     *
     * @param  Request
     * @return \Illuminate\Http\Response
     */
    public function assign(Request $request)
    {
        try {
            DB::beginTransaction();
            $date_time = date_format(new DateTime('NOW'), 'd/m/Y H:i:s');
            $shipper = DetailShipper::select('users.name as name', 'users.phone as phone')
                                    ->leftjoin('users', 'users.id', '=', 'detail_shipper.id_user')
                                    ->leftjoin('status_user', 'status_user.id_user', '=', 'users.id')
                                    ->where('detail_shipper.id_user', $request->shipper)
                                    ->where('detail_shipper.del_flag', 0)
                                    ->where('users.del_flag', 0)
                                    ->where('status_user.id_status', __::status('active'))
                                    ->where('status_user.del_flag', 0)
                                    ->first();
            $order             = Orders::find($request->order);
            $order->id_shipper = $request->shipper;
            $order->note       = Notes::order('assign', $order->code, Auth::user()->name, $date_time, $shipper->name.' - '.$shipper->phone);
            $order->version_no = $order->version_no + 1;
            $order->save();
            $status_order = StatusOrder::where('id_order', $order->id)
                                       ->where('del_flag', 0)
                                       ->update([
                                                  'id_status'  => __::status('assign'),
                                                  'version_no' => DB::raw('version_no + 1')
                                                ]);
            $traces = Traces::where('id_order', $order->id)
                            ->where('del_flag', 0);
            $traces->update([
                              'id_status'  => __::status('assign'),
                              'time'       => $date_time,
                              'note'       => Notes::trace('assign', $order->code, $date_time, $shipper->name.' - '.$shipper->phone),
                              'version_no' => DB::raw('version_no + 1')
                            ]);
            $traces_log = TracesLog::create([
              'id_trace'  => $traces->first()->id,
              'id_status' => __::status('assign'),
              'time'      => $date_time,
              'note'      => Notes::trace('assign', $order->code, $date_time, $shipper->name.' - '.$shipper->phone)
            ]);
            DB::commit();
            return [
              'message' => Messages::assign($order->code, $shipper->name.' - '.$shipper->phone),
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
     * update_status
     *
     * @param  Request
     * @return \Illuminate\Http\Response
     */
    public function update_status(Request $request)
    {
        try {
            DB::beginTransaction();
            $date_time = date_format(new DateTime('NOW'), 'd/m/Y H:i:s');
            $status_order = StatusOrder::where('id_order', $request->id);
            if (empty($request->status)) {
                $request->status = __::status('shipping');
            }
            $status = Status::select('name')
                            ->where('id', $request->status)
                            ->where('del_flag', 0)
                            ->first()
                            ->name;
            if ($status_order->first()->id_status == $request->status) {
                DB::rollBack();
                return [
                  'message' => Messages::errors()->orders('status'),
                  'error'   => true
                ];
            } else {
                $status_order->where('del_flag', 0)
                             ->update([
                                        'id_status'  => __::status($status),
                                        'version_no' => DB::raw('version_no + 1')
                                      ]);
            }
            $order             = Orders::find($request->id);
            $order->note       = Notes::order($status, $order->code, Auth::user()->name, $date_time);
            $order->version_no = $order->version_no + 1;
            $order->save();
            $traces = Traces::where('id_order', $order->id)
                            ->where('del_flag', 0);
            $traces->update([
                              'id_status'  => __::status($status),
                              'time'       => $date_time,
                              'note'       => Notes::trace($status, $order->code, $date_time),
                              'version_no' => DB::raw('version_no + 1')
                           ]);
            $traces_log = TracesLog::create([
              'id_trace'  => $traces->first()->id,
              'id_status' => __::status($status),
              'time'      => $date_time,
              'note'      => Notes::trace($status, $order->code, $date_time)
            ]);
            DB::commit();
            if ($request->status == __::status('cancel')) {
                return [
                  'message' => Messages::cancel('', $order->code),
                  'error'   => false
                ];
            } elseif ($request->status == __::status('success')) {
                return [
                  'message' => Messages::success($order->code),
                  'error'   => false
                ];
            } else {
                return [
                  'message' => Messages::$status($order->code),
                  'error'   => false
                ];
            }
        } catch (Exception $e) {
            DB::rollBack();
            return [
              'message' => Messages::errors()->_500(),
              'error'   => true
            ];
        }
    }

    /**
     * transfers
     *
     * @param  Request
     * @return \Illuminate\Http\Response
     */
    public static function transfers(Request $request)
    {
        try {
            DB::beginTransaction();
            $date_time = date_format(new DateTime('NOW'), 'd/m/Y H:i:s');
            $order             = Orders::find($request->id);
            $order->note       = Notes::order('transfers', $order->code, Auth::user()->name, $date_time);
            $order->version_no = $order->version_no + 1;
            $order->save();
            $status_order = StatusOrder::where('id_order', $order->id)
                                       ->where('del_flag', 0)
                                       ->update([
                                                  'id_status'  => __::status('transfers'),
                                                  'version_no' => DB::raw('version_no + 1')
                                                ]);
            $traces = Traces::where('id_order', $order->id)
                            ->where('del_flag', 0);
            $traces->update([
                              'id_status'  => __::status('transfers'),
                              'time'       => $date_time,
                              'note'       => Notes::trace('transfers', $order->code, $date_time),
                              'version_no' => DB::raw('version_no + 1')
                            ]);
            $traces_log = TracesLog::create([
              'id_trace'  => $traces->first()->id,
              'id_status' => __::status('transfers'),
              'time'      => $date_time,
              'note'      => Notes::trace('transfers', $order->code, $date_time)
            ]);
            $percent = Pays::select('percent')
                           ->leftjoin('order_pay', 'order_pay.id_pay', '=', 'pays.id')
                           ->where('pays.del_flag', 0)
                           ->where('order_pay.id_order', $order->id)
                           ->where('order_pay.del_flag', 0)
                           ->first()
                           ->percent;
            $balances = Balances::where('id_shipper', $order->id_shipper)
                                ->where('del_flag', 0)
                                ->first();
            $balances->total += (int) $order->total_amount*$percent/100;
            $balances->version_no += 1;
            $balances->save();
            $user = User::select('name', 'phone')
                        ->where('id', $order->id_shipper)
                        ->where('del_flag', 0)
                        ->first();
            $balance_log = BalanceLog::create([
              'id_order'    => $order->id,
              'id_user'     => $order->id_user,
              'id_shipper'  => $order->id_shipper,
              'amount'      => $order->total_amount,
              'pay_shipper' => (int) $order->total_amount*$percent/100,
              'note'        => Notes::balance_log('create', $order->code, $date_time, $user->name.' - '.$user->phone, $order->total_amount*$percent/100)
            ]);
            DB::commit();
            return [
              'message' => Messages::transfers($order->code),
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
}
