<?php

namespace App\Http\Controllers;

use App\Account;
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

    public function t_show_add_client()
    {
        $p = new Package();
        $packages = $p->get_packages();

        return view('transactions.add_client')->with('packages', $packages);
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
            'carthograph' => 'required',
            'multimoney_account_number' => 'required',
//            'percentage' => 'required|numeric',
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


        $insert_id = $u->insert($input['first_name'], $input['multimoney_account_number'], $input['last_name'], $input['email'], $npass, $ntelephone, $input['employer'], $input['employer_location'], $input['residential_address'], $file_name, $input['salary'], $input['mobile_money_account'], 1, $input['package'], $picture);

        $mbalance = $this->get_minimum_balance($input['package']);

        $account_number = uniqid();

        $a->create_accounts($insert_id, $ntelephone, $account_number, $mbalance[0], $mbalance[1]);

        $s->send($input['telephone'], "You have successfully created an account with Multi Money Microfinance Company Limited. Your Eswift password is " . $input['password']);

        $sc->add($ntelephone, $input['secret_question'], $input['secret_answer']);

        $lg->insert($auth['email'], $auth['email'] . " registered " . $input['email'] . " as a new client", $auth['role_id']);

        return redirect('eswift/transactions/clients')->with('status', 'Client added successfully');

    }

    public function get_client_details($id)
    {
        $user = new User();
        $account = new Account();
//        $maccount = new Account();

        $data = $user->get_client($id);
        $edata = $account->get_eswift_account($id);
        $mdata = $account->get_mmf_account($id);

        return view('transactions.client_details')
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

        return view('transactions.tedit')
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

        return redirect('eswift/transactions/clients')->with('status', 'Client updated successfully');
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

        return redirect('eswift/transactions/clients')->with('status', 'Client deleted');
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
