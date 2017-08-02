<?php

namespace App\Http\Controllers;

use App\Log;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Datatables;

class AdminController extends Controller
{
    public function show_login()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $l = new Log();

        $data = $request->all();

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {

            $user_data = Auth::user();
//            return $user_data;
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

        $u->insert($input['firstname'], $input['lastname'], $input['email'], $npass, $tel, 'n/a', 'n/a', 'n/a', 'n/a', 'n/a', 'n/a', 2);

//        Log
        $msg = $done_by['email'] . ' added ' . $input['email'] . ' as a new admin';
        $l->insert($done_by['email'], $msg, 2);

        return redirect('eswift/add_admin')->with('status', 'New Administrator added successfully');
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
            return redirect('eswift/change_password')->with('status1', 'Your password has been changed successfuly');

        } else {

            $msg = $email . ' tried to change password but failed';
            $l->insert($email, $msg, 2);
            return redirect('eswift/change_password')->with('status', 'Your old password does not match your current password');
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
        return view('admin.add_client');
    }

    public function add_client(Request $request)
    {
        $u = new User;

        $file_name = '';

        $input = $request->all();

        $rules = [
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'email' => 'required',
            'telephone' => 'required|min:10|unique:users',
            'employer' => 'required|min:2',
            'employer_location' => 'required|min:2',
            'residential_address' => 'required|min:2',
            'carthograph' => 'required',
            'salary' => 'required',
            'mobile_money_account' => 'required',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password'

        ];

        $this->validate($request, $rules);

        $pass = '$2y$10$ATsAxLSLnSOelhwN91fr2eNJnRtbScR.ayIhzsdf0Z3RsEm6169yy';
        $method = 'aes128';
        $options = 0;
        $iv = '595d234644at789h';

        $npass = openssl_encrypt($input['password'], $method, $pass, $options, $iv);

//        return $en;

        if (Input::hasFile('carthograph')) {
            $file = Input::file('carthograph');
            $file->move('uploads', $file->getClientOriginalName());
            $file_name = $file->getClientOriginalName();
        }

//        Convert numbers to 233

        $u->insert($input['first_name'], $input['last_name'], $input['email'], $npass, $input['telephone'], $input['employer'], $input['employer_location'], $input['residential_address'], $file_name, $input['salary'], $input['mobile_money_account'], 1);

        return redirect('eswift/clients')->with('status', 'Client added successfully');

    }

    public function delete_client($id)
    {
        $u = new User;

        $u->delete_client($id);

        return redirect('eswift/clients')->with('status', 'Client deleted');
    }

    public function show_edit_client($id)
    {
        $u = new User;

        $data = $u->get_client($id);

//        print_r($data[0]);
//
        return view('admin.edit')->with('data', $data[0]);
    }

    public function edit_client(Request $request, $id)
    {
        $u = new User;

        $input = $request->all();

//        $file_name = Input::file('carthograph')->getClientOriginalName();

        $rules = [
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'email' => 'required',
            'employer' => 'required|min:2',
            'employer_location' => 'required|min:2',
            'residential_address' => 'required|min:2',
            'carthograph' => 'required',
            'salary' => 'required',
            'mobile_money_account' => 'required'
        ];

        $this->validate($request, $rules);

        if (Input::hasFile('carthograph')) {

//            return 'true';

            $file = Input::file('carthograph');
            $file->move('uploads', $file->getClientOriginalName());
            $file_name = $file->getClientOriginalName();
        }

        $u->update_client($id, $input['first_name'], $input['last_name'], $input['email'], $input['telephone'], $input['employer'], $input['employer_location'], $input['residential_address'], $file_name, $input['salary'], $input['mobile_money_account']);

        return redirect('eswift/clients')->with('status', 'Client updated successfully');

    }

    function get_client_details($id)
    {
        $user = new User();

        $data = $user->get_client($id);

        return view('clients.client_details')->with('data', $data[0]);
    }
}
