<?php

namespace App\Http\Controllers;

use App\Loan;
use App\Log;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

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

//            $user_data = Auth::user();

//            $this->get_all_loans();
            return redirect('eswift/transactions/pending-loans');

        } else {
            return redirect('eswift/transactions/login')->with('error', 'These credentials do not match our records.');
        }
    }

    public function get_pending_loans()
    {
        $loan = new Loan();

        if (request()->isXmlHttpRequest()) {

            $data = $loan->get_pending_loans();

            return Datatables::of($data)->make(true);
        }

        return view('transactions.pending');
    }

    public function get_approved_loans()
    {
        $loan = new Loan();

        if (request()->isXmlHttpRequest()) {

            $data = $loan->get_approved_loans();
//        return $data;
//
            return Datatables::of($data)->make(true);
        }

        return view('transactions.approved');
    }

    public function get_refused_loans()
    {
        $loan = new Loan();

        if (request()->isXmlHttpRequest()) {

            $data = $loan->get_refused_loans();
//        return $data;
//
            return Datatables::of($data)->make(true);
        }

        return view('transactions.refused');
    }

    public function approve_loan($id, $user_id, $amount, $loan_id, $telephone)
    {
        $l = new Loan();
        $p = new Payment();

        $l->approve_loan($id);
        $p->insert($id, $amount, $user_id, $loan_id, $telephone);

        return redirect('eswift/transactions/pending-loans')->with('status', 'Loan Approved');
    }

    public function refuse_loan($id)
    {
        $l = new Loan();

        $l->refuse_loan($id);

        return redirect('eswift/transactions/pending-loans')->with('status', 'Loan Refused');
    }

    public function get_client_details($id)
    {

    }
}
