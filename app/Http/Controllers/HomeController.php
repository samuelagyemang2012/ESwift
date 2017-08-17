<?php

namespace App\Http\Controllers;

use App\Loan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Facades\Datatables;

class HomeController extends Controller
{

    public function index()
    {
        $l = new Loan();

        $processed_loans = $l->get_num_processed_loans();
        $amount_given = $l->get_total_amount_given();
        $total_returns = $l->get_total_returns();
        $total_pending = $l->get_pending_loans();
        $total_approved = $l->get_approved_loans();
        $total_refused = $l->get_refused_loans();

//        return $processed_loans;

        return view('index')
            ->with('processed', count($processed_loans)-1)
            ->with('amount_given', $amount_given)
            ->with('total_returns', $total_returns)
            ->with('total_pending', count($total_pending))
            ->with('total_approved', count($total_approved))
            ->with('total_refused', count($total_refused));
    }

    public function view_all_clients()
    {
        $user = new User;

        if (request()->isXmlHttpRequest()) {

            $data = $user->get_clients();

            return Datatables::of($data)->make(true);
        }

        return view('data');
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('');
    }

}
