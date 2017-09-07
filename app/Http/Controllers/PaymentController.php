<?php

namespace App\Http\Controllers;

use App\Debt;
use App\Loan;
use App\Log;
use App\Payment;
use App\Sms;
use App\User;
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

    public function show_make_payment($id, $amount, $user_id, $telephone, $loan_id)
    {
        return view('payments.make-payment')
            ->with('amount', $amount)
            ->with('id', $id)
            ->with('user_id', $user_id)
            ->with('telephone', $telephone)
            ->with('loan_id', $loan_id);
    }

    public function make_payment(Request $request)
    {
        $user = Auth::user();
        $input = $request->all();

//        return $input;

        $l = new Loan();
        $p = new Payment();
        $d = new Debt();
        $s = new Sms();
        $lg = new Log();

        $rules = [
            'amount_transferred' => 'required|same:amount_to_transfer',
            'transaction_id' => 'required',
        ];

        $this->validate($request, $rules);

        $p->make_payment($input['id'], $input['transaction_id'], $user['email'], $input['amount_transferred'], $input['comments'], $input['telephone']);

        $data = $l->get_loan_period($input['loan_id']);

        $total_debt = $this->calculate_total_debt($input['amount_transferred'], $data[0]->loan_period);
        $half_debt = $total_debt / 2;

        $dates = $this->calculate_loan_dates($data[0]->loan_period);

        //insert to debt
        $d->insert($input['user_id'], $input['loan_id'], $input['telephone'], $input['amount_transferred'], $half_debt, $dates[0], $total_debt, $dates[1]);

        $msg = $this->prepare_msg($input['amount_transferred'], $data[0]->loan_period, $input['user_id'], $total_debt);

        $s->send($input['telephone'], $msg);

        $s->send($input['telephone'], "Your loan request for GHC " . $input['amount_transferred'] . "has been transferred to your mobile money account.");

        $lg->insert($user['email'], $user['email'] . " transferred GHC " . $input['amount_transferred'] . " to " . $input['telephone'], $user['role_id']);

        return redirect('eswift/payments/pending-transfers')->with('status', 'Transaction Recorded');
    }

    private function prepare_msg($amount, $period, $user_id, $total_debt)
    {

        $u = new User();
        $data = $u->get_user_package($user_id);
        $package = $data[0]->package;
        $monthly = $total_debt / $period;
        $monthly_installment = round($monthly, 1);
        $next_month = date('jS F Y', strtotime('+ 1 month'));

        $message = 'Your request for an amount of GHC ' . $amount . ' as loan for ' . $period . ' months from your ' . $package . ' package has been successful. Your debt is now GHC ' . $total_debt . '. You are required to pay an amount of GHC ' . $monthly_installment . ' each month starting from ' . $next_month;

        return $message;
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

    private function calculate_total_debt($amount, $loan_period)
    {
        $interest = 0.03;

        $total_interest_percentage = $interest * $loan_period;

        $total_interest = $total_interest_percentage * $amount;

        $total_debt = $total_interest + $amount;

        return $total_debt;
    }

    private function calculate_loan_dates($loan_period)
    {
        date_default_timezone_set("GMT");

        $half_loan_period = $loan_period / 2;

        if (is_int($half_loan_period)) {

            $full_date = date('Y-m-d', strtotime("+" . $loan_period . " month"));

            $half_date = date('Y-m-d', strtotime("+" . $half_loan_period . " month"));

            $a = array($half_date, $full_date);

            return $a;

        } else {

            $array = explode(".", $half_loan_period);

            $full_date = date('Y-m-d', strtotime("+" . $loan_period . " month"));

            $date1 = date('Y-m-d', strtotime("+" . $array[0] . " month"));
            $half_date = date('Y-m-d', strtotime($date1 . '+ 2 weeks'));

            $a = array($half_date, $full_date);

            return $a;

        }

    }
}
