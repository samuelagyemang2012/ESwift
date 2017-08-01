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
        $role_id = $user['role_id'];

        if ($role_id == '2') {
            // is admin
            return $next($request);
        } else {
            return redirect('eswift/admin/login');
        }

//        abort('403');

    }
}
