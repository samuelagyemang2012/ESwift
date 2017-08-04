<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PaymentMiddleware
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

//        return $user;

        if ($user['role_id'] == '3') {

            return redirect('eswift/payments/login')->with('error', 'Please use the Transactions Portal');
        }

        if ($user['role_id'] == '2') {

            return redirect('eswift/payments/login')->with('error', 'Please use the Admin Portal');
        }

        if($user['role_id'] == null){
            return redirect('eswift/payments/login')->with('error', 'Session cleared. Please login again');
        }

        return $next($request);
    }
}
