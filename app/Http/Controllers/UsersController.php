<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;

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
                             where users.del_flag = 0");
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
        if (empty($request->name) || empty($request->identity_card) ||
            empty($request->path) || empty($request->gender) ||
            empty($request->birthdate) || empty($request->phone) ||
            empty($request->password) || empty($request->email)) {
            return redirect(route('users.index'))->with([
            'message' => 'Chưa đủ thông tin',
            'error' => true
          ]);
        } else {
            $file = $request->file('path');
            chmod($file, 0777 - umask());
            $extension = $request->file('path')->extension();
            $name = uniqid();
            $path = $name . '.' . $extension;
            $image = $path;
            $user = new User();
            $user->path = $image;
            $file->move(public_path('img'), $path);
            $user->name = $request->name;
            $user->identity_card = $request->identity_card;
            $user->gender = $request->gender;
            $user->birthdate = $request->birthdate;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->email = $request->email;
            $user->save();
            return redirect(route('users.index'))->with([
              'message' => 'Thêm mới thành công',
              'error' => false
            ]);
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
