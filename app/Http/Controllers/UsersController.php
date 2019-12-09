<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Session;
use App\__;
use App\User;
use App\Status;
use App\StatusUser;
use App\RoleUser;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::select("select
                                 users.id as id,
                                 users.name as name,
                                 users.email as email,
                                 users.path as path,
                                 if(users.gender = 1, 'Nam', 'Nữ') as 'gender',
                                 users.birthdate as birthdate,
                                 users.identity_card as identity_card,
                                 users.phone as phone,
                                 status.name as status
                             from users
                             left join status_user
                             on status_user.id_user = users.id
                             left join status
                             on status.id = status_user.id_status
                             where users.del_flag = 0
                             order by users.name asc");
        return view('users.index', ['data' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * [status description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function status(Request $request)
    {
        $data = Status::select('id', 'name')->wherein('name', __::$STATUS)->get();
        foreach ($data as $value) {
            $status[$value->name] = $value->id;
        }
        $statusUser = StatusUser::where('id_user', $request->id)->get();
        foreach ($statusUser as $value) {
            if ($value->id_status == $status['active']) {
                $value->id_status = $status['locked'];
            } else {
                $value->id_status = $status['active'];
            }
            $value->save();
        }
        return redirect(route('users.index'))->with([
        'message' => __::$MESSAGES['status'],
        'error' => false
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
        Log::debug('REDIRECT_USER: ', ['Session' => Session::get('REDIRECT_USER')]);
        if (Session::has('REDIRECT_USER')) {
            Session::forget('REDIRECT_USER');
            redirect(route('users.index'))->with([
              'message' => __::$MESSAGES['success'],
              'error' => false
            ]);
        }
        $validate = [];
        if (preg_match(__::$RE_NAME, $request->name) || $request->name == null) {
            array_push($validate, __::$MESSAGES['errors']['users'][0]);
        }
        if (preg_match(__::$RE_IDENTITY_CARD, $request->identity_card) || $request->identity_card == null) {
            array_push($validate, __::$MESSAGES['errors']['users'][1]);
        }
        if (preg_match(__::$RE_GENDER, $request->gender) || $request->gender == null) {
            array_push($validate, __::$MESSAGES['errors']['users'][2]);
        }
        if ($request->birthdate == null) {
            array_push($validate, __::$MESSAGES['errors']['users'][3]);
        }
        if (preg_match(__::$RE_PHONE, $request->phone) || $request->phone == null) {
            array_push($validate, __::$MESSAGES['errors']['users'][4]);
        }
        if ($request->password == null) {
            array_push($validate, __::$MESSAGES['errors']['users'][5]);
        }
        if (preg_match(__::$RE_EMAIL, $request->email) || $request->email == null) {
            array_push($validate, __::$MESSAGES['errors']['users'][6]);
        }
        if (empty($validate)) {
            $user = new User();
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
              'id_user' => $user->id
            ]);
            RoleUser::create([
              'id_role' => __::$ROLES['USER'],
              'id_user' => $user->id
            ]);
            Session::put('REDIRECT_USER', true);
            return [
              'messages' => [],
              'error' => false
            ];
        } else {
            return [
              'messages' => $validate,
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
        return view('users.edit', ['data' => User::find($id)]);
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
        $validate = [];
        if (preg_match(__::$RE_NAME, $request->name) || $request->name == null) {
            array_push($validate, __::$MESSAGES['errors']['users'][0]);
        }
        if (preg_match(__::$RE_IDENTITY_CARD, $request->identity_card) || $request->identity_card == null) {
            array_push($validate, __::$MESSAGES['errors']['users'][1]);
        }
        if (preg_match(__::$RE_GENDER, $request->gender) || $request->gender == null) {
            array_push($validate, __::$MESSAGES['errors']['users'][2]);
        }
        if ($request->birthdate == null) {
            array_push($validate, __::$MESSAGES['errors']['users'][3]);
        }
        if (preg_match(__::$RE_PHONE, $request->phone) || $request->phone == null) {
            array_push($validate, __::$MESSAGES['errors']['users'][4]);
        }
        if (preg_match(__::$RE_EMAIL, $request->email) || $request->email == null) {
            array_push($validate, __::$MESSAGES['errors']['users'][6]);
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
            $user->save();
            return [
              'messages' => [__::$MESSAGES['update']],
              'error' => false
            ];
        } else {
            return [
              'messages' => $validate,
              'error' => true
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
        User::find($id)->update(['del_flag'=> 1]);
        return redirect(route('users.index'))->with([
          'message' => __::$MESSAGES['delete'],
          'error' => false
        ]);
    }
}
