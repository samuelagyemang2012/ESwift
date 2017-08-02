<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

//        return $user;

        if ($user['role_id'] == '3') {

            return redirect('eswift/admin/login')->with('error', 'Access Denied. Please use the Transactions Portal');
        }

        if ($user['role_id'] == '4') {

            return redirect('eswift/admin/login')->with('error', 'Access Denied. Please use the Payments Portal');
        }

        if($user['role_id'] == null){
            return redirect('eswift/admin/login')->with('error', 'Session cleared. Please login again');
        }

        return $next($request);
    }

}
