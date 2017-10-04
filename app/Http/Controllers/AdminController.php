<?php

namespace App\Http\Controllers;

use App\Account;
use App\Debt;
use App\Loan;
use App\Log;
use App\Notification;
use App\Package;
use App\Payment;
use App\Rate;
use App\Secret;
use App\Sms;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

//use Illuminate\Support\Facades\Validator;
//use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;

class AdminController extends Controller
{
    public function show_login()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $lg = new Log();

        $data = $request->all();

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {

            return redirect('eswift/home');
        } else {

            return redirect('eswift/admin/login')->with('error', 'These credentials do not match our records.');

        }
    }

    public function show_add_admin()
    {
        return view('admin.add_admin');
    }

    public function add_admin(Request $request)
    {
        $input = $request->all();

        $u = new User;
        $l = new Log;
        $done_by = Auth::user();

        $rules = [
            'lastname' => 'required|min:2',
            'firstname' => 'required|min:2',
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password'
        ];

        $this->validate($request, $rules);

        $npass = bcrypt($input['password']);

        $tel = uniqid();

        $u->insert($input['firstname'], $input['lastname'], $input['email'], $npass, $tel, 'n/a', 'n/a', 'n/a', 'n/a', 'n/a', 'n/a', 2, 'n/a');

//        Log
        $msg = $done_by['email'] . ' added ' . $input['email'] . ' as a new admin';
        $l->insert($done_by['email'], $msg, 2);

        return redirect('eswift/admin/add-admin')->with('status', 'New Administrator added successfully');
    }

    public function show_change_password()
    {
        $data = Auth::user();
        $email = $data['email'];
        return view('admin.change_password')->with('email', $email);
    }

    public function change_password(Request $request)
    {
        $u = new User;
        $l = new Log;

        $data = Auth::user();
        $email = $data['email'];

        $input = $request->all();

        $rules = [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password'
        ];

        $this->validate($request, $rules);

        $d = $u->get_password($email);

        $password = $d[0]->password;

        if (Hash::check($input['old_password'], $password)) {

            $npass = bcrypt($input['new_password']);
            $u->change_password($email, $npass);

            $msg = $email . ' changed password successfully';
            $l->insert($email, $msg, 2);
            return redirect('eswift/admin/change_password')->with('status1', 'Your password has been changed successfuly');

        } else {

            $msg = $email . ' tried to change password but failed';
            $l->insert($email, $msg, 2);
            return redirect('eswift/admin/change_password')->with('status', 'Your old password does not match your current password');
        }
    }

    public function show_admin_logs()
    {
        $l = new Log;

        if (request()->isXmlHttpRequest()) {
            $data = $l->get_admin_logs();

            return Datatables::of($data)->make(true);
        }

        return view('admin.logs');
    }

    public function show_client_logs()
    {
        $l = new Log;

        $data = $l->get_client_logs();

        return view('admin.logs')->with('data', $data);
    }

    public function show_add_client()
    {
        $p = new Package();
        $packages = $p->get_packages();

        return view('admin.add_client')->with('packages', $packages);
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

    public function add_client(Request $request)
    {
        $u = new User;
        $lg = new Log();
        $s = new Sms();
        $a = new Account();
        $sc = new Secret();
        $auth = Auth::user();

        $file_name = '';
        $picture = '';

        $input = $request->all();

        $rules = [
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'email' => 'required|email|unique:users',
            'telephone' => 'required|min:12|max:12|unique:users',
            'employer' => 'required|min:2',
            'employer_location' => 'required|min:2',
            'residential_address' => 'required|min:2',
            'gender' => 'required',
            'date_of_birth' => 'required|date',
            'carthograph' => 'required',
            'marital_status' => 'required',
            'interest_rate' => 'required|numeric|max:100|min:1',
            'multimoney_account_number' => 'required',
            'salary' => 'required|numeric',
            'mobile_money_account' => 'required',
            'password' => 'required|min:4',
            'package' => 'required',
            'confirm_password' => 'required|same:password',
            'secret_question' => 'required',
            'secret_answer' => 'required|min:2',
            'picture' => 'required'
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

        if (Input::hasFile('picture')) {
            $file = Input::file('picture');
            $file->move('uploads', $file->getClientOriginalName());
            $picture = $file->getClientOriginalName();
        }

        $insert_id = $u->insert($input['first_name'], $input['multimoney_account_number'], $input['last_name'], $input['email'], $npass, $ntelephone, $input['employer'], $input['employer_location'], $input['residential_address'], $file_name, $input['salary'], $input['mobile_money_account'], 1, $input['package'], $picture, $input['gender'], $input['date_of_birth'], $input['marital_status'], $input['interest_rate']);

        $mbalance = $this->get_minimum_balance($input['package']);

        $account_number = uniqid();

        $a->create_accounts($insert_id, $ntelephone, $account_number, $mbalance[0], $mbalance[1]);

        $s->send($input['telephone'], "You have successfully created an account with Multi Money Microfinance Company Limited. Your Eswift password is " . $input['password']);

        $sc->add($ntelephone, $input['secret_question'], $input['secret_answer']);

        $lg->insert($auth['email'], $auth['email'] . " registered " . $input['email'] . " as a new client", $auth['role_id']);

        return redirect('eswift/clients')->with('status', 'Client added successfully');

    }

    public function delete_client($id, $telephone)
    {
        $u = new User();
        $a = new Account();
        $date = date("Y-m-d H:i:s");

        $u->remove($id, $date);
        $a->delete_account($id, $date);

        return redirect('eswift/clients')->with('status', 'Client deleted');
    }

    public function delete_payments($id)
    {
        $u = new User();

        $date = date("Y-m-d H:i:s");
        $u->remove($id, $date);

        return redirect('eswift/payments_personnel')->with('status', 'Payment Personnel deleted');

    }

    public function delete_transactions($id)
    {
        $u = new User();

        $date = date("Y-m-d H:i:s");
        $u->remove($id, $date);

        return redirect('eswift/transactions_personnel')->with('status', 'Transactions Payment deleted');
    }

    public function show_edit_client($id)
    {
        $u = new User;
        $p = new Package();

        $data = $u->get_client($id);
        $packages = $p->get_packages();

        return view('admin.edit')
            ->with('data', $data[0])
            ->with('packages', $packages);
    }

    public function show_edit_payment($id)
    {
        $u = new User();

        $data = $u->get_payments_personnel($id);

        return view('admin.edit_payment')->with('data', $data[0]);
    }

    public function edit_payments_personnel(Request $request, $id)
    {
        $u = new User;
        $lg = new Log();
        $auth = Auth::user();

        $input = $request->all();

//        return $input;

        $rules = [
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'email' => 'required|email|unique:users,email,' . $id,
            'telephone' => 'required|min:12|max:12|unique:users,telephone,' . $id,
            'employer' => 'required|min:2',
            'employer_location' => 'required|min:2',
            'residential_address' => 'required|min:2'
        ];

        $this->validate($request, $rules);

        $u->update_personnel($id, $input['first_name'], $input['last_name'], $input['email'], $input['telephone'], $input['employer'], $input['employer_location'], $input['residential_address']);

        $lg->insert($auth['email'], $auth['email'] . " edited a client with id=" . $id, $auth['role_id']);

        return redirect('eswift/payments_personnel')->with('status', 'Personnel updated successfully');
    }

    public function edit_transactions_personnel(Request $request, $id)
    {
        $u = new User;
        $lg = new Log();
        $auth = Auth::user();

        $input = $request->all();

        $rules = [
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'email' => 'required|email|unique:users,email,' . $id,
            'telephone' => 'required|min:12|max:12|unique:users,telephone,' . $id,
            'employer' => 'required|min:2',
            'employer_location' => 'required|min:2',
            'residential_address' => 'required|min:2'
        ];

        $this->validate($request, $rules);

        $u->update_personnel($id, $input['first_name'], $input['last_name'], $input['email'], $input['telephone'], $input['employer'], $input['employer_location'], $input['residential_address']);

        $lg->insert($auth['email'], $auth['email'] . " edited a client with id=" . $id, $auth['role_id']);

        return redirect('eswift/transactions_personnel')->with('status', 'Personnel updated successfully');
    }

    public function show_edit_transaction($id)
    {
        $u = new User();

        $data = $u->get_transactions_personnel($id);

        return view('admin.edit_transaction')->with('data', $data[0]);
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
            'salary' => 'required',
            'mobile_money_account' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'required|date',
            'marital_status' => 'required'
        ];

        $this->validate($request, $rules);

        if (Input::hasFile('carthograph')) {

            $file = Input::file('carthograph');
            $file->move('uploads', $file->getClientOriginalName());
            $file_name = $file->getClientOriginalName();
        } else {
            $carthograph = $u->get_client($id);
            $file_name = $carthograph[0]->carthograph;
        }

        $u->update_client($id, $input['first_name'], $input['last_name'], $input['email'], $input['employer'], $input['employer_location'], $input['residential_address'], $file_name, $input['salary'], $input['mobile_money_account'], $input['package'], $input['gender'], $input['date_of_birth'], $input['marital_status']);

        $lg->insert($auth['email'], $auth['email'] . " edited a client with id=" . $id, $auth['role_id']);

        return redirect('eswift/clients')->with('status', 'Client updated successfully');

    }

    public function get_client_details($id)
    {
        $user = new User();
        $account = new Account();
//        $maccount = new Account();

        $data = $user->get_client($id);
        $edata = $account->get_eswift_account($id);
        $mdata = $account->get_mmf_account($id);


        $b_date = strtotime($data[0]->date_of_birth);
        $date_words = date('jS F, Y', $b_date);

        return view('clients.client_details')
            ->with('data', $data[0])
            ->with('edata', $edata[0])
            ->with('mdata', $mdata[0])
            ->with('b_date', $date_words);
    }

    public function get_unpaid_debts()
    {
        $d = new Debt();

        if (request()->isXmlHttpRequest()) {

            $data = $d->get_unpaid_debts();

            return Datatables::of($data)->make(true);
        }

        return view('admin.unpaid_debts');
    }

    public function get_paid_debts()
    {
        $d = new Debt();
//        return $d->get_paid_debts();
        if (request()->isXmlHttpRequest()) {

            $data = $d->get_paid_debts();

            return Datatables::of($data)->make(true);
        }

        return view('admin.paid_debts');
    }

    public function get_all_loans()
    {
        $l = new Loan();
//        return $l->get_all_loans();

        if (request()->isXmlHttpRequest()) {

            $data = $l->get_all_loans();

            return Datatables::of($data)->make(true);
        }

        return view('admin.all_loans');
    }

    public function get_pending_loans()
    {
        $l = new Loan();

        if (request()->isXmlHttpRequest()) {

            $data = $l->get_pending_loans();

            return Datatables::of($data)->make(true);
        }

        return view('admin.pending_loans');
    }

    public function get_approved_loans()
    {
        $l = new Loan();

        if (request()->isXmlHttpRequest()) {

            $data = $l->get_approved_loans();

            return Datatables::of($data)->make(true);
        }

        return view('admin.approved');
    }

    public function get_refused_loans()
    {
        $l = new Loan();

        if (request()->isXmlHttpRequest()) {

            $data = $l->get_refused_loans();

            return Datatables::of($data)->make(true);
        }

        return view('admin.refused');
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

        return redirect('eswift/loans/pending')->with('status', 'Loan Approved');
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

        return redirect('eswift/loans/pending')->with('status', 'Loan Rejected');
    }

    public function get_pending_payments()
    {
        $p = new Payment();

        if (request()->isXmlHttpRequest()) {

            $data = $p->get_pending_transfers();

            return Datatables::of($data)->make(true);
        }

        return view('admin.pending-transfers');
    }

    public function get_completed_payments()
    {
        $p = new Payment();

        if (request()->isXmlHttpRequest()) {

            $data = $p->get_completed_transfers();

            return Datatables::of($data)->make(true);
        }

        return view('admin.completed-transfers');
    }

    public function show_make_payments($id, $amount, $user_id, $telephone, $loan_id)
    {
        return view('admin.make_payment')
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

        $total_debt = $this->calculate_total_debt($input['telephone'], $input['amount_transferred'], $data[0]->loan_period);
        $half_debt = $total_debt / 2;

        $dates = $this->calculate_loan_dates($data[0]->loan_period);

        $d->insert($input['user_id'], $input['loan_id'], $input['telephone'], $input['amount_transferred'], $half_debt, $dates[0], $total_debt, $dates[1]);

        $msg = $this->prepare_msg($input['amount_transferred'], $data[0]->loan_period, $input['user_id'], $total_debt);

        $s->send($input['telephone'], $msg);

        $lg->insert($user['email'], $user['email'] . " transferred GHC " . $input['amount_transferred'] . " to " . $input['telephone'], $user['role_id']);
        return redirect('eswift/admin/pending-transfers')->with('status', 'Transaction Recorded');
    }

    private function prepare_msg($amount, $period, $user_id, $total_debt)
    {

        $u = new User();
        $data = $u->get_user_package($user_id);
        $package = $data[0]->package;
        $monthly = $total_debt / $period;
        $monthly_installment = round($monthly, 1);
        $next_month = date('jS F Y', strtotime('+ 1 month'));
        $two_weeks = date('jS F Y', strtotime('+ 2 weeks'));

        if ($period == 1) {
            $message = 'Your request for an amount of GHC ' . $amount . ' as loan for ' . $period . ' month from your ' . $package . ' package has been successful. Your debt is now GHC ' . $total_debt . '. You are required to pay an amount of GHC ' . round(($monthly_installment / 2), 2) . ' in 2 weeks starting from ' . $two_weeks;
            return $message;
        } else {

            $message = 'Your request for an amount of GHC ' . $amount . ' as loan for ' . $period . ' months from your ' . $package . ' package has been successful. Your debt is now GHC ' . $total_debt . '. You are required to pay an amount of GHC ' . $monthly_installment . ' each month starting from ' . $next_month;

            return $message;
        }
    }

    public function show_add_payment()
    {
        return view('admin.add_payment');
    }

    public function add_payment(Request $request)
    {
        $u = new User();
        $lg = new Log();
        $auth = Auth::user();

        $input = $request->all();

        $rules = [
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'email' => 'required|email|unique:users',
            'telephone' => 'required|max:12|min:12|unique:users',
            'residential_address' => 'required|min:2',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password'
        ];

        $this->validate($request, $rules);

        $npass = bcrypt($input['password']);

        $u->add_payment($input['first_name'], $input['last_name'], $input['email'], $npass, $input['telephone'], $input['residential_address']);

        $lg->insert($auth['email'], $auth['email'] . " added " . $input['email'] . " as a payments personnel", $auth['role_id']);

        return redirect('eswift/payments_personnel')->with('status', 'Payments Personnel Added');
    }

    public function show_add_transaction()
    {
        return view('admin.add_transaction');
    }

    public function add_transaction(Request $request)
    {
        $u = new User();
        $lg = new Log();
        $auth = Auth::user();

        $input = $request->all();

        $rules = [
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'email' => 'required|email|unique:users',
            'telephone' => 'required|max:12|min:12|unique:users',
            'residential_address' => 'required|min:2',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password'
        ];

        $this->validate($request, $rules);

        $npass = bcrypt($input['password']);

        $u->add_transaction($input['first_name'], $input['last_name'], $input['email'], $npass, $input['telephone'], $input['residential_address']);

        $lg->insert($auth['email'], $auth['email'] . " added " . $input['email'] . " as a transactions personnel", $auth['role_id']);

        return redirect('eswift/transactions_personnel')->with('status', 'Transactions Personnel Added');
    }

    public function get_payements_personnel()
    {
        $u = new User();

        if (request()->isXmlHttpRequest()) {

            $data = $u->all_payments_personnel();

            return Datatables::of($data)->make(true);
        }

        return view('admin.payments');
    }

    public function get_transactions_personnel()
    {
        $u = new User();

        if (request()->isXmlHttpRequest()) {

            $data = $u->all_transactions_personnel();

            return Datatables::of($data)->make(true);
        }

        return view('admin.transactions');
    }

    public function show_accounts()
    {
        return view('admin.accounts');
    }

    public function show_edit_account($id)
    {
        $account = new Account();

        $ea = $account->get_eswift_account($id);
        $ma = $account->get_mmf_account($id);

        return view('admin.edit_account')
            ->with('edata', $ea[0])
            ->with('mdata', $ma[0])
            ->with('id', $id);
    }

    public function update_accounts(Request $request, $id)
    {
        $a = new Account();
        $l = new Log();
        $auth = Auth::user();

        $input = $request->all();

        $rules = [
            'eswift_balance' => 'required|numeric',
            'mobile_registration_balance' => 'required|numeric'
        ];

        $this->validate($request, $rules);

        $a->update_accounts($id, $input['eswift_balance'], $input['mobile_registration_balance']);
        $l->insert($auth['email'], $auth['email'] . ' updated client with id ' . $id . ' accounts', $auth['role_id']);

        return redirect('eswift/accounts')->with('status', 'Account Updated Successfully');

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

    private function calculate_total_debt($tel, $amount, $loan_period)
    {
        $r = new User();

        $interest = $r->get_user_rate($tel);

//        return $interest;

        $total_interest_percentage = ($interest[0]->interest_rate / 100) * $loan_period;

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

    public function get_debt_details($loan_id)
    {
        $d = new Debt();

        $data = $d->get_debt_details($loan_id);

        $half_date = strtotime($data[0]->half_loan_date);
        $half_date_words = date('jS F Y', $half_date);

        $full_date = strtotime($data[0]->full_loan_date);
        $full_loan_words = date('jS F Y', $full_date);

        return view('admin.debt_details')
            ->with('data', $data[0])
            ->with('half', $half_date_words)
            ->with('full', $full_loan_words);

    }

    public function get_unread()
    {
        $n = new Notification();

        if (request()->isXmlHttpRequest()) {
            $data = $n->unread();

            return Datatables::of($data)->make(true);
        }

        return view('admin.unread');
    }

    public function get_read()
    {
        $n = new Notification();

//        return $data = $n->read();

        if (request()->isXmlHttpRequest()) {
            $data = $n->read();

            return Datatables::of($data)->make(true);
        }

        return view('admin.read');
    }

    public function mark_as_read($id)
    {
        $n = new Notification();

        $n->mark_as_read($id);

        return redirect('eswift/notifications/unread')->with('status', 'Marked as read');
    }

    public function get_half_loans_due()
    {
        $l = new Loan();

//        return $l->get_half_loans_due();

        if (request()->isXmlHttpRequest()) {
            $data = $l->get_half_loans_due();

            return Datatables::of($data)->make(true);
        }

        return view('admin.half_loans');

    }

    public function get_elapsed_loans()
    {
        $l = new Loan();
//        return $l->get_elapsed_loans();
        if (request()->isXmlHttpRequest()) {
            $data = $l->get_elapsed_loans();

            return Datatables::of($data)->make(true);
        }

        return view('admin.full_loan');

    }

    public function show_edit_account_hld($id)
    {
        $account = new Account();

        $ea = $account->get_eswift_account_hld($id);
        $ma = $account->get_mmf_account_hld($id);

        return view('admin.hld_account')
            ->with('edata', $ea[0])
            ->with('mdata', $ma[0])
            ->with('id', $id);
    }

    public function update_accounts_hld(Request $request, $id)
    {
//        return $request . 'user_id =' . $id;
        $a = new Account();
        $ln = new Loan();
        $l = new Log();
        $auth = Auth::user();

        $input = $request->all();

        $rules = [
            'eswift_balance' => 'required|numeric',
            'mobile_registration_balance' => 'required|numeric',
            'debt_id' => 'required'
        ];
///
        $this->validate($request, $rules);

        $a->update_accounts($id, $input['eswift_balance'], $input['mobile_registration_balance']);
        $ln->update_hld($input['debt_id']);
//
        $l->insert($auth['email'], $auth['email'] . ' updated client with id ' . $id . ' accounts', $auth['role_id']);
//
        return redirect('eswift/loans/half_loans_due')->with('status', 'Account Updated Successfully');

    }

}
