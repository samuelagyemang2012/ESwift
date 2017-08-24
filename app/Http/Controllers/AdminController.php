<?php

namespace App\Http\Controllers;

use App\Account;
use App\Debt;
use App\Loan;
use App\Log;
use App\Package;
use App\Payment;
use App\Sms;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
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

//        return $packages;

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
            'salary' => 'required|numeric',
            'mobile_money_account' => 'required',
            'password' => 'required|min:4',
            'package' => 'required',
            'confirm_password' => 'required|same:password'
        ];

        $this->validate($request, $rules);

        $pass = '$2y$10$ATsAxLSLnSOelhwN91fr2eNJnRtbScR.ayIhzsdf0Z3RsEm6169yy';
        $method = 'aes128';
        $options = 0;
        $iv = '595d234644at789h';

        $npass = openssl_encrypt($input['password'], $method, $pass, $options, $iv);
        $ntelephone = $this->process_telephone($input['telephone']);

        if (Input::hasFile('carthograph')) {
            $file = Input::file('carthograph');
            $file->move('uploads', $file->getClientOriginalName());
            $file_name = $file->getClientOriginalName();
        }
//insertions

        $u->insert($input['first_name'], $input['last_name'], $input['email'], $npass, $ntelephone, $input['employer'], $input['employer_location'], $input['residential_address'], $file_name, $input['salary'], $input['mobile_money_account'], 1, $input['package']);

        $s->send($input['telephone'], "You have successfully created an account with Multi Money Microfinance Company Limited.");

        $minimum = $this->get_minimum_balance($input['package']);

        $a->create_account($ntelephone, $minimum);

        $lg->insert($auth['email'], $auth['email'] . " registered " . $input['email'] . " as a new client", $auth['role_id']);

        return redirect('eswift/clients')->with('status', 'Client added successfully');

    }

    public function delete_client($id, $telephone)
    {
        $u = new User;
        $a = new Account();
        $date = date("Y-m-d H:i:s");

        $date = date("Y-m-d H:i:s");
        $u->remove($id, $date);
        $a->delete_account($date);

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
        $lg = new Log();
        $auth = Auth::user();

        $input = $request->all();

//        return $input;

        $file_name = '';

        $rules = [
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'email' => 'required|email|unique:users,email,' . $id,
            'employer' => 'required|min:2',
            'employer_location' => 'required|min:2',
            'residential_address' => 'required|min:2',
            'telephone' => 'required|min:12|max:12|unique:users,telephone,' . $id,
            'salary' => 'required',
            'mobile_money_account' => 'required',
//            'packages' => 'required'
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

        $u->update_client($id, $input['first_name'], $input['last_name'], $input['email'], $input['telephone'], $input['employer'], $input['employer_location'], $input['residential_address'], $file_name, $input['salary'], $input['mobile_money_account'], $input['package']);

        $lg->insert($auth['email'], $auth['email'] . " edited a client with id=" . $id, $auth['role_id']);

        return redirect('eswift/clients')->with('status', 'Client updated successfully');
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

    public function get_client_details($id)
    {
        $user = new User();

        $data = $user->get_client($id);

        return view('clients.client_details')->with('data', $data[0]);
    }

    public function get_debts()
    {
        $d = new Debt();

        if (request()->isXmlHttpRequest()) {

            $data = $d->get_debts();

            return Datatables::of($data)->make(true);
        }

        return view('admin.debts');
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

        $s->send($telephone, "Your loan request for GHC " . $amount . " has been refused.");
        $lg->insert($auth['email'], $auth['email'] . " refused a loan", $auth['role_id']);

        return redirect('eswift/loans/pending')->with('status', 'Loan Refused');
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

    public function show_make_payments($id, $amount, $user_id, $telephone)
    {
        return view('admin.make_payment')
            ->with('amount', $amount)
            ->with('id', $id)
            ->with('user_id', $user_id)
            ->with('telephone', $telephone);
    }

    public function make_payment(Request $request)
    {
        $user = Auth::user();
        $input = $request->all();

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

        //insert to debt
        $d->insert($input['user_id'], $input['id'], $input['telephone'], $input['amount_transferred']);

        $s->send($input['telephone'], "Your loan request for GHC " . $input['amount_transferred'] . "has been transferred to your mobile money account.");

        $lg->insert($user['email'], $user['email'] . " transferred GHC " . $input['amount_transferred'] . " to " . $input['telephone'], $user['role_id']);
        return redirect('eswift/admin/pending-transfers')->with('status', 'Transaction Recorded');
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
//        $data = $u->all_payments_personnel();
//        return $data;

        if (request()->isXmlHttpRequest()) {

            $data = $u->all_payments_personnel();

            return Datatables::of($data)->make(true);
        }

        return view('admin.payments');
    }

    public function get_transactions_personnel()
    {
        $u = new User();
///
        if (request()->isXmlHttpRequest()) {

            $data = $u->all_transactions_personnel();

//        return $data;

            return Datatables::of($data)->make(true);
        }

        return view('admin.transactions');
    }

    public function get_minimum_balance($name)
    {

        $fee_percentage = 0.80;

        $p = new Package();

        $data = $p->get_maximum($name);

        $registration_fee = $fee_percentage * $data;

//        $minimum = $registration_fee;// + $mobile_fee;

        return $registration_fee;
    }

    public function get_upgrade_balance($tel, $package)
    {
        $a = new Account();

        $cur_balance = $a->get_balance($tel);

        $minimum = $this->get_minimum_balance($package);

        $new_balance = $minimum + $cur_balance;

        return $new_balance;
    }

}
