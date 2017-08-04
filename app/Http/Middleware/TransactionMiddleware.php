<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TransactionMiddleware
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

        if ($user['role_id'] == '2') {

            return redirect('eswift/transactions/login')->with('error', 'Please use the Admin Portal');
        }

        if ($user['role_id'] == '4') {

            return redirect('eswift/transactions/login')->with('error', 'Access Denied. Please use the Payments Portal');
        }

        if($user['role_id'] == null){
            return redirect('eswift/transactions/login')->with('error', 'Session cleared. Please login again');
        }

        return $next($request);
    }
}
