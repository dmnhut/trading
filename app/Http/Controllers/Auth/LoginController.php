<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use App\Fun\__;
use App\RoleUser;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected function redirectTo()
    {
        $role = RoleUser::where('id_user', Auth::user()->id)
                        ->where('del_flag', 0)
                        ->first();
        if (Auth::check() && $role->id_role == __::ROLES['ADMIN']) {
            return 'portal';
        } elseif (Auth::check() && $role->id_role == __::ROLES['USER']) {
            return '/';
        } else {
            return 'logout';
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
