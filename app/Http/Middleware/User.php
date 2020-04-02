<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Fun\__;
use App\RoleUser;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $role = RoleUser::where('id_user', Auth::user()->id)
                        ->where('del_flag', 0)
                        ->first();
        if (Auth::check() && $role->id_role == __::ROLES['USER']) {
            return $next($request);
        } else {
            return redirect('logout');
        }
    }
}
