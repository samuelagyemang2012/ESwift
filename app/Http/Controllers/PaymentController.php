<?php

namespace App\Http\Controllers;

use App\Account;
use App\Debt;
use App\Loan;
use App\Log;
use App\Package;
use App\Payment;
use App\Rate;
use App\Secret;
use App\Sms;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
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

    public function p_show_add_client()
    {
        $p = new Package();
        $packages = $p->get_packages();

        return view('payments.add_client')->with('packages', $packages);
    }

    public function add_client(Request $request)
    {
        $u = new User;
        $lg = new Log();
        $s = new Sms();
        $a = new Account();
        $sc = new Secret();
        $auth = Auth::user();

        $file_name = '';

        $input = $request->all();

        $rules = [
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'email' => 'required|email|unique:users',
            'telephone' => 'required|min:12|max:12|unique:users',
            'employer' => 'required|min:2',
            'employer_location' => 'required|min:2',
            'residential_address' => 'required|min:2',
            'carthograph' => 'required',
            'multimoney_account_number' => 'required',
//            'percentage' => 'required|numeric',
            'salary' => 'required|numeric',
            'mobile_money_account' => 'required',
            'password' => 'required|min:4',
            'package' => 'required',
            'confirm_password' => 'required|same:password',
            'secret_question' => 'required',
            'secret_answer' => 'required|min:2'
        ];

        $this->validate($request, $rules);

        $pass = '$2y$10$ATsAxLSLnSOelhwN91fr2eNJnRtbScR.ayIhzsdf0Z3RsEm6169yy';
        $method = 'aes128';
        $options = 0;
        $iv = '595d234644at789h';

        $npass = openssl_encrypt($input['password'], $method, $pass, $options, $iv);
        $ntelephone = $this->process_telephone($input['telephone']);

//        $deleted_account =

        if (Input::hasFile('carthograph')) {
            $file = Input::file('carthograph');
            $file->move('uploads', $file->getClientOriginalName());
            $file_name = $file->getClientOriginalName();
        }

        $insert_id = $u->insert($input['first_name'], $input['multimoney_account_number'], $input['last_name'], $input['email'], $npass, $ntelephone, $input['employer'], $input['employer_location'], $input['residential_address'], $file_name, $input['salary'], $input['mobile_money_account'], 1, $input['package']);

        $mbalance = $this->get_minimum_balance($input['package']);

        $account_number = uniqid();

        $a->create_accounts($insert_id, $ntelephone, $account_number, $mbalance[0], $mbalance[1]);

        $s->send($input['telephone'], "You have successfully created an account with Multi Money Microfinance Company Limited. Your Eswift password is " . $input['password']);

        $sc->add($ntelephone, $input['secret_question'], $input['secret_answer']);

        $lg->insert($auth['email'], $auth['email'] . " registered " . $input['email'] . " as a new client", $auth['role_id']);

        return redirect('eswift/clients')->with('status', 'Client added successfully');

    }

    public function get_client_details($id)
    {
        $user = new User();
        $account = new Account();
//        $maccount = new Account();

        $data = $user->get_client($id);
        $edata = $account->get_eswift_account($id);
        $mdata = $account->get_mmf_account($id);

        return view('payments.client_details')
            ->with('data', $data[0])
            ->with('edata', $edata[0])
            ->with('mdata', $mdata[0]);
    }

    public function show_edit_client($id)
    {
        $u = new User;
        $p = new Package();

        $data = $u->get_client($id);
        $packages = $p->get_packages();

        return view('payments.pedit')
            ->with('data', $data[0])
            ->with('packages', $packages);
    }

    public function edit_client(Request $request, $id)
    {
        $u = new User;
        $a = new Account();
        $lg = new Log();
        $auth = Auth::user();

        $input = $request->all();

        $file_name = '';

        $rules = [
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'email' => 'required|email|unique:users,email,' . $id,
            'employer' => 'required|min:2',
            'employer_location' => 'required|min:2',
            'residential_address' => 'required|min:2',
//            'telephone' => 'required|min:12|max:12|unique:users,telephone,' . $id,
            'salary' => 'required',
            'mobile_money_account' => 'required',
        ];
//        $rules = [
//            'first_name' => 'required|min:2',
//            'last_name' => 'required|min:2',
//            'email' => Rule::unique('users')->ignore($id, 'id')->where(function ($query) {
//                $query->whereNull('deleted_at');
//            }),
//            'email'=> Rule::
//            'employer' => 'required|min:2',
//            'employer_location' => 'required|min:2',
//            'residential_address' => 'required|min:2',
//            'telephone' => 'required|min:12|max:12|unique:users,telephone,' . $id,
//            'salary' => 'required',
//            'mobile_money_account' => 'required',
//        ];
        $this->validate($request, $rules);

        if (Input::hasFile('carthograph')) {

            $file = Input::file('carthograph');
            $file->move('uploads', $file->getClientOriginalName());
            $file_name = $file->getClientOriginalName();
        } else {
            $carthograph = $u->get_client($id);
            $file_name = $carthograph[0]->carthograph;
        }

//        $ntelephone = $this->process_telephone($input['telephone']);

        $u->update_client($id, $input['first_name'], $input['last_name'], $input['email'], $input['employer'], $input['employer_location'], $input['residential_address'], $file_name, $input['salary'], $input['mobile_money_account'], $input['package']);
//        $a->update_account_name($id, $ntelephone);
        $lg->insert($auth['email'], $auth['email'] . " edited a client with id=" . $id, $auth['role_id']);

        return redirect('eswift/payments/clients')->with('status', 'Client updated successfully');
//        } else {
//
////            return 'package upgrade';
//            $new_balance = $this->get_upgrade_balance($telephone, $input['packages']);
//
//            $u->update_client($id, $input['first_name'], $input['last_name'], $input['email'], $input['telephone'], $input['employer'], $input['employer_location'], $input['residential_address'], $file_name, $input['salary'], $input['mobile_money_account'], $input['packages']);
//
//            $a->update_account($telephone, $new_balance);
//
//            $lg->insert($auth['email'], $auth['email'] . " edited a client with id=" . $id, $auth['role_id']);
//            $lg->insert($auth['email'], "Client with id=" . $id . " upgraded his package from " . $package . " to " . $input['packages'], $auth['role_id']);
//
//            return redirect('eswift/clients')->with('status', 'Client data and account updated successfully');
//
//        }

    }

    public function delete_client($id, $telephone)
    {
        $u = new User();
        $a = new Account();
        $date = date("Y-m-d H:i:s");

        $u->remove($id, $date);
        $a->delete_account($id, $date);

        return redirect('eswift/payments/clients')->with('status', 'Client deleted');
    }

    public function index()
    {
        $p = new Payment();

        return redirect('eswift/payments/pending-transfers');

//        $total_transfers = $p->get_transfers();
//        $total_amount = $p->get_total_amount_transferred();
//        $total_transfers_today = $p->get_today_transfers();
//        $total_amount_today = $p->get_total_amount_today();

//        return $total_amount_today;

//        return view('payments.dashboard')
//            ->with('total_transfers', $total_transfers)
//            ->with('total_amount', $total_amount)
//            ->with('total_transfers_today', count($total_transfers_today));
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
        $r = new Rate();

        $interest = $r->get_rate(1);

        $total_interest_percentage = ($interest[0]->rate / 100) * $loan_period;

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

    public function get_minimum_balance($name)
    {
        $r = new Rate();

        $fee_percentage = $r->get_rate(3);

        $p = new Package();

        $data = $p->get_maximum($name);

        $registration_fee = ($fee_percentage[0]->rate / 100) * $data[0]->maximum;

        $twenty = $data[0]->maximum - $registration_fee;

        $array = array($twenty, $registration_fee);

        return $array;

    }

    private function process_telephone($telephone)
    {
        $tel = str_replace("+", "", $telephone);

        $array = substr($telephone, 0, 1);
        $array1 = substr($telephone, 1, 9);

        if ($array == "0") {
            $ntelephone = "233" . $array1;
            return $ntelephone;
        } else {
            return $tel;
        }
    }
}
