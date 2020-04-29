<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Fun\__;

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
        $role = __::get_role_code(Auth::user()->id);
        if (Auth::check()) {
            if ($role == __::ROLES['USER'] || $role == __::ROLES['ADMIN']) {
                return $next($request);
            }
        } else {
            return redirect('logout');
        }
    }
}
