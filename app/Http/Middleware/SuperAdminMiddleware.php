<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
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
        $user = Auth::user();

        if ($user['deleted_at'] != null) {
            return redirect('eswift/super_admin/login')->with('error', 'You are no longer authorized to use this system.');
        }

        if ($user['role_id'] == '3') {

            return redirect('eswift/super_admin/login')->with('error', 'Access Denied. Please use the Transactions Portal');
        }

        if ($user['role_id'] == '4') {

            return redirect('eswift/super_admin/login')->with('error', 'Access Denied. Please use the Payments Portal');
        }

        if ($user['role_id'] == '2') {

            return redirect('eswift/super_admin/login')->with('error', 'Access Denied. Please use the Admin Portal');
        }

        if ($user['role_id'] === null) {
            return redirect('eswift/super_admin/login')->with('error', 'Session cleared. Please login again');
        }

        return $next($request);
    }
}
