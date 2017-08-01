<?php

namespace App\Http\Controllers;

use App\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        return view('transactions.index');
    }

    public function show_login()
    {
        return view('transactions.login');
    }

    public function login(Request $request)
    {
        $l = new Log();

        $data = $request->all();

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {

            $user_data = Auth::user();

            return $user_data;

        } else {
            return redirect('eswift/transactions/login')->with('error', 'These credentials do not match our records.');
        }
    }
}
