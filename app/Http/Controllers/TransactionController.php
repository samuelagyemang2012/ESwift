<?php

namespace App\Http\Controllers;

use App\Loan;
use App\Log;
use App\Payment;
use App\Sms;
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

            return redirect('eswift/transactions/pending-loans');

        } else {
            return redirect('eswift/transactions/login')->with('error', 'These credentials do not match our records.');
        }
    }

    public function get_pending_loans()
    {
        $loan = new Loan();
//        $data = $loan->get_pending_loans();
//        return $data;

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

    public function approve_loan($amount, $user_id, $loan_id, $telephone)
    {
        $l = new Loan();
        $p = new Payment();
        $s = new Sms();
        $lg = new Log();

        $auth = Auth::user();

        $l->approve_loan($loan_id);
        $p->insert($user_id, $amount, $loan_id, $telephone);
        $s->send($telephone, "Your loan for GHC " . $amount . " has been approved and will be transferred to you shortly.");

        $lg->insert($auth['email'], $auth['email'] . " approved a loan", $auth['role_id']);

        return redirect('eswift/transactions/pending-loans')->with('status', 'Loan Approved');
    }

    public function refuse_loan($id, $amount, $telephone)
    {
        $l = new Loan();
        $s = new Sms();
        $lg = new Log();

        $auth = Auth::user();

        $l->refuse_loan($id);
        $s->send($telephone, "Your loan request for GHC " . $amount . " has been rejected.");

        $lg->insert($auth['email'], $auth['email'] . " rejected a loan", $auth['role_id']);

        return redirect('eswift/transactions/pending-loans')->with('status', 'Loan Rejected');
    }

    public function logs()
    {
        $lg = new Log();

        if (request()->isXmlHttpRequest()) {

            $data = $lg->get_transaction_logs();

            return Datatables::of($data)->make(true);
        }

        return view('transactions.logs');
    }
}
