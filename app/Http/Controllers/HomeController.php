<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Fun\__;
use App\Fun\Messages;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $role = __::get_role_code(Auth::user()->id);
        if (Auth::check() && $role == __::ROLES['ADMIN']) {
            return redirect()->route('portal.index');
        } elseif (Auth::check() && $role == __::ROLES['USER']) {
            return redirect()->route('dashboard');
        }
    }

    /**
     * dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return view('dashboard.index', ['role' => __::get_role_code(Auth::user()->id)]);
    }

    /**
     * logout
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        if ($request->error) {
            return redirect('login')->with([
              'message' => Messages::errors()->permission(),
              'error'   => true
            ]);
        } else {
            return redirect('login');
        }
    }
}
