<?php

namespace App\Http\Controllers;

use App\Debt;
use App\Log;
use App\Payment;
use App\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Facades\Datatables;

class PaymentController extends Controller
{
    public function show_login()
    {
        return view('payments.login');
    }

    public function login(Request $request)
    {
        $l = new Log();

        $data = $request->all();

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {

            return redirect('eswift/payments/');

        } else {
            return redirect('eswift/payments/login')->with('error', 'These credentials do not match our records.');
        }
    }

    public function index()
    {
        $p = new Payment();

        $total_transfers = $p->get_transfers();
        $total_amount = $p->get_total_amount_transferred();
        $total_transfers_today = $p->get_today_transfers();
//        $total_amount_today = $p->get_total_amount_today();

//        return $total_amount_today;

        return view('payments.dashboard')
            ->with('total_transfers', $total_transfers)
            ->with('total_amount', $total_amount)
            ->with('total_transfers_today', count($total_transfers_today));
//            ->with('total_amount_today', $total_amount_today);

    }

    public function get_pending_transfers()
    {
        $p = new Payment();
//        $data = $p->get_pending_transfers();
//        return $data;

        if (request()->isXmlHttpRequest()) {

            $data = $p->get_pending_transfers();

            return Datatables::of($data)->make(true);
        }

        return view('payments.pending');
    }

    public function get_completed_transfers()
    {
        $p = new Payment();

        if (request()->isXmlHttpRequest()) {

            $data = $p->get_completed_transfers();

            return Datatables::of($data)->make(true);
        }

        return view('payments.completed');
    }

    public function show_make_payment($id, $amount, $user_id, $telephone)
    {
        return view('payments.make-payment')
            ->with('amount', $amount)
            ->with('id', $id)
            ->with('user_id', $user_id)
            ->with('telephone', $telephone);
    }

    public function make_payment(Request $request)
    {
        $s = new Sms();
        $lg = new Log();
        $user = Auth::user();
        $input = $request->all();


        $p = new Payment();
        $d = new Debt();

        $rules = [
            'amount_transferred' => 'required|same:amount_to_transfer',
            'transaction_id' => 'required',
        ];

        $this->validate($request, $rules);

        $p->make_payment($input['id'], $input['transaction_id'], $user['email'], $input['amount_transferred'], $input['comments'], $input['telephone']);

        //insert to debt
        $d->insert($input['user_id'], $input['id'], $input['telephone'], $input['amount_transferred']);

        $s->send($input['telephone'], "Your loan request for GHC " . $input['amount_transferred'] . "has been transferred to your mobile money account.");

        $lg->insert($user['email'], $user['email'] . "transferred GHC " . $user['amount_transferred'] . " to " . $user['telephone'], $user['role_id']);

        return redirect('eswift/payments/pending-transfers')->with('status', 'Transaction Recorded');
    }

    public function logs()
    {
        $lg = new Log();

        if (request()->isXmlHttpRequest()) {

            $data = $lg->get_payment_logs();

            return Datatables::of($data)->make(true);
        }

        return view('payments.logs');
    }
}
