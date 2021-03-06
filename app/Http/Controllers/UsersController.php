<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use Session;
use App\User;
use App\Status;
use App\StatusUser;
use App\RoleUser;
use App\Fun\__;
use App\Fun\Messages;
use App\Fun\Sql;
use App\Fun\Validate;

class UsersController extends Controller
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
        $limit = __::TAKE_ITEM;
        $offset = ($page-1)*$limit;
        $role = __::get_role_code(Auth::user()->id);
        if ($role === __::ROLES['USER']) {
            $data = DB::select(DB::raw(Sql::getUsers4IndexUser(false, Auth::user()->id)), [
                'limit' => $limit,
                'offset' => $offset
            ]);
            $total = collect(DB::select(Sql::getUsers4IndexUser(true, Auth::user()->id)))->count();
        } elseif ($role === __::ROLES['ADMIN']) {
            $data = DB::select(DB::raw(Sql::getUsers4IndexUser()), [
                'limit' => $limit,
                'offset' => $offset
            ]);
            $total = collect(DB::select(Sql::getUsers4IndexUser(true, null)))->count();
        }
        $page_number = ceil($total/__::TAKE_ITEM);
        return view('users.index', [
            'data'        => $data,
            'page_number' => $page_number,
            'page_active' => $page,
            'role'        => $role
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create', [
            'text' => [
                'cancel'         => __::CANCEL,
                'clear'          => __::CLEAR,
                'done'           => __::DONE,
                'weekdays'       => __::WEEKDAYS,
                'weekdaysShort'  => __::WEEKDAYS,
                'weekdaysAbbrev' => __::WEEKDAYS_ABBREV,
                'months'         => __::MONTHS,
                'monthsShort'    => __::MONTHS_SHORT
            ]
        ]);
    }

    /**
     * status
     *
     * @param  Request
     * @return redirect
     */
    public function status(Request $request)
    {
        $role = __::get_role_code(Auth::user()->id);
        if ($role === __::ROLES['USER']) {
            Auth::logout();
            return redirect('login')->with([
                'message' => Messages::errors()->permission(),
                'error'   => true
            ]);
        }
        $data = Status::select(
            'id',
            'name'
        )->wherein('name', __::STATUS)
         ->get();
        foreach ($data as $value) {
            $status[$value->name] = $value->id;
        }
        $statusUser = StatusUser::where('id_user', $request->id)
                                ->get();
        foreach ($statusUser as $value) {
            if ($value->id_status == $status['active']) {
                $value->id_status = $status['locked'];
            } else {
                $value->id_status = $status['active'];
            }
            $value->save();
        }
        return redirect(route('users.index'))->with([
            'message' => Messages::status(),
            'error'   => false
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
            Auth::logout();
            return redirect('login')->with([
                'message' => Messages::errors()->permission(),
                'error'   => true
            ]);
        }
        $validator = Validator::make($request->all(), [
            'email'         => 'unique:users',
            'identity_card' => 'unique:users',
            'phone'         => 'unique:users'
        ], [
            'email.unique'         => Validate::message('email'),
            'identity_card.unique' => Validate::message('identity_card'),
            'phone.unique'         => Validate::message('phone')
        ]);
        if ($validator->fails()) {
            return [
                'messages' => $validator->messages()->all(),
                'error'    => true
            ];
        }
        $validate = [];
        if (preg_match(Validate::reg('NAME'), $request->name) || $request->name == null) {
            array_push($validate, Messages::errors()->users('name'));
        }
        if (preg_match(Validate::reg('IDENTITY_CARD'), $request->identity_card) || $request->identity_card == null) {
            array_push($validate, Messages::errors()->users('identity_card'));
        }
        if (preg_match(Validate::reg('GENDER'), $request->gender) || $request->gender == null) {
            array_push($validate, Messages::errors()->users('gender'));
        }
        if ($request->birthdate == null) {
            array_push($validate, Messages::errors()->users('birthdate'));
        }
        if (preg_match(Validate::reg('PHONE'), $request->phone) || $request->phone == null) {
            array_push($validate, Messages::errors()->users('phone'));
        }
        if ($request->password == null) {
            array_push($validate, Messages::errors()->users('password'));
        }
        if (preg_match(Validate::reg('EMAIL'), $request->email) || $request->email == null) {
            array_push($validate, Messages::errors()->users('email'));
        }
        if (empty($validate)) {
            $user = new User;
            if ($request->hasFile('path')) {
                $file = $request->file('path');
                chmod($file, 0777 - umask());
                $extension = $request->file('path')->extension();
                $name = uniqid();
                $path = $name . '.' . $extension;
                $image = $path;
                $user->path = $image;
                $file->move(public_path('img'), $path);
            }
            $user->name = $request->name;
            $user->identity_card = $request->identity_card;
            $user->gender = $request->gender;
            $user->birthdate = $request->birthdate;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->email = $request->email;
            $user->save();
            StatusUser::create([
                'id_status' => 1,
                'id_user'   => $user->id
            ]);
            RoleUser::create([
                'id_role' => __::ROLES['USER'],
                'id_user' => $user->id
            ]);
            return [
                'messages' => [
                    Messages::success()
                ],
                'error'    => false
            ];
        } else {
            return [
                'messages' => $validate,
                'error'    => true
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
        $role = __::get_role_code(Auth::user()->id);
        if ($role === __::ROLES['USER']) {
            if ($id != Auth::user()->id) {
                Auth::logout();
                return redirect('login')->with([
                    'message' => Messages::errors()->permission(),
                    'error'   => true
                ]);
            }
        }
        return view('users.edit', [
            'data' => User::find($id),
            'text' => [
                'cancel'         => __::CANCEL,
                'clear'          => __::CLEAR,
                'done'           => __::DONE,
                'weekdays'       => __::WEEKDAYS,
                'weekdaysShort'  => __::WEEKDAYS,
                'weekdaysAbbrev' => __::WEEKDAYS_ABBREV,
                'months'         => __::MONTHS,
                'monthsShort'    => __::MONTHS_SHORT
            ]
        ]);
    }

    /**
     * info
     *
     * @return \Illuminate\Http\Response
     */
    public function info()
    {
        return view('users.info', [
            'data' => User::find(Auth::user()->id)
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
            if ($id != Auth::user()->id) {
                Auth::logout();
                return redirect('login')->with([
                    'message' => Messages::errors()->permission(),
                    'error'   => true
                ]);
            }
        }
        $validator = Validator::make($request->all(), [
            'email'         => 'unique:users,email,'.$id,
            'identity_card' => 'unique:users,identity_card,'.$id,
            'phone'         => 'unique:users,phone,'.$id
          ], [
              'email.unique'         => Messages::errors()->users('email'),
              'identity_card.unique' => Messages::errors()->users('identity_card'),
              'phone.unique'         => Messages::errors()->users('phone')
          ]);
        if ($validator->fails()) {
            return [
                'messages' => $validator->messages()->all(),
                'error'    => true
            ];
        }
        $validate = [];
        if (preg_match(Validate::reg('NAME'), $request->name) || $request->name == null) {
            array_push($validate, Messages::errors()->users('name'));
        }
        if (preg_match(Validate::reg('IDENTITY_CARD'), $request->identity_card) || $request->identity_card == null) {
            array_push($validate, Messages::errors()->users('identity_card'));
        }
        if (preg_match(Validate::reg('GENDER'), $request->gender) || $request->gender == null) {
            array_push($validate, Messages::errors()->users('gender'));
        }
        if ($request->birthdate == null) {
            array_push($validate, Messages::errors()->users('birthdate'));
        }
        if (preg_match(Validate::reg('PHONE'), $request->phone) || $request->phone == null) {
            array_push($validate, Messages::errors()->users('phone'));
        }
        if (preg_match(Validate::reg('EMAIL'), $request->email) || $request->email == null) {
            array_push($validate, Messages::errors()->users('email'));
        }
        if (empty($validate)) {
            $user = User::find($id);
            if ($request->hasFile('path')) {
                $file = $request->file('path');
                chmod($file, 0777 - umask());
                $extension = $request->file('path')->extension();
                $name = uniqid();
                $path = $name . '.' . $extension;
                $image = $path;
                $user->path = $image;
                $file->move(public_path('img'), $path);
            }
            $user->name = $request->name;
            $user->identity_card = $request->identity_card;
            $user->gender = $request->gender;
            $user->birthdate = $request->birthdate;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->version_no = $user->version_no + 1;
            $user->save();
            return [
                'messages' => [Messages::update()],
                'error'    => false
            ];
        } else {
            return [
                'messages' => $validate,
                'error'    => true
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
        $role = __::get_role_code(Auth::user()->id);
        if ($role === __::ROLES['USER']) {
            Auth::logout();
            return redirect('login')->with([
                'message' => Messages::errors()->permission(),
                'error'   => true
            ]);
        }
        User::find($id)
            ->update([
                'del_flag'=> 1,
                DB::raw('version_no + 1')
            ]);
        return redirect(route('users.index'))->with([
            'message' => Messages::delete(),
            'error'   => false
        ]);
    }
}
