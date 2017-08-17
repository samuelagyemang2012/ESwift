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
//        return 'das';
        return view('payments.dashboard');
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

        return redirect('eswift/payments/pending-transfers')->with('status', 'Transaction Recorded');
    }

    public function logs()
    {
        $lg = new Log();

        if (request()->isXmlHttpRequest()) {

            $data = $lg->get_payment_logs();

//        return $data;

            return Datatables::of($data)->make(true);
        }

        return view('payments.logs');
    }
}
