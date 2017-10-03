<?php

namespace App\Http\Controllers;

use App\Log;
use App\Rate;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class SuperAdminController extends Controller
{
    public function show_login()
    {
        return view('super_admin.login');
    }

    public function login(Request $request)
    {
//        $lg = new Log();

//        $r = new Rate();
//        $a = $r->get_rate(3);
//        return ($a[0]->rate / 100);

        $data = $request->all();

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {

            return redirect('eswift/superadmin');
        } else {

            return redirect('eswift/super_admin/login')->with('error', 'These credentials do not match our records.');

        }
    }

    public function index()
    {
        $r = new Rate();

        if (request()->isXmlHttpRequest()) {
            $data = $r->get_rates();

            return Datatables::of($data)->make(true);
        }

        return view('super_admin.dashboard');
    }

    public function show_edit_rate($id)
    {
        $r = new Rate();

        $data = $r->get_rate($id);

        return view('super_admin.edit')->with(['data' => $data[0]]);

    }

    public function edit_rate(Request $request)
    {
        $r = new Rate();
        $l = new Log;
        $done_by = Auth::user();

        $input = $request->all();

        $rule = [
            'rate' => 'required|numeric|min:0|max:100'
        ];

        $this->validate($request, $rule);

        $r->update_rate($input['id'], $input['rate']);

        $l->insert($done_by['email'], $done_by['email'] . " edited rate with id " . $input['id'] . " to " . $input['rate'] . "%", 5);

        return redirect('eswift/superadmin')->with('status', 'Rate updated successfully');
    }

    public function get_admins()
    {
        $u = new User();

        if (request()->isXmlHttpRequest()) {
            $data = $u->get_all_admins();

            return Datatables::of($data)->make(true);
        }

        return view('super_admin.admins');
    }

    public function show_admin()
    {
        return view('super_admin.add_admin');
    }

    public function add_admin(Request $request)
    {
        $input = $request->all();

        $u = new User;
        $l = new Log;
        $done_by = Auth::user();

        $rules = [
            'last_name' => 'required|min:2',
            'first_name' => 'required|min:2',
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password'
        ];

        $this->validate($request, $rules);

        $npass = bcrypt($input['password']);

        $tel = uniqid();

        $u->insert($input['first_name'], "n/a", $input['last_name'], $input['email'], $npass, $tel, 'n/a', 'n/a', 'n/a', 'n/a', 'n/a', 'n/a', 2, 'n/a', 'n/a');

//        Log
        $msg = $done_by['email'] . ' added ' . $input['email'] . ' as a new admin';
        $l->insert($done_by['email'], $msg, 2);

        return redirect('eswift/admins')->with('status', 'New Administrator added successfully');
    }

    public function show_edit_admin($id)
    {
        $u = new User;

        $data = $u->get_admin($id);

        return view('super_admin.edit_admin')
            ->with('data', $data[0]);
    }

    public function edit_admin($id, Request $request)
    {
        $input = $request->all();

        $u = new User;
        $l = new Log;
        $done_by = Auth::user();

        $rules = [
            'last_name' => 'required|min:2',
            'first_name' => 'required|min:2',
            'email' => 'required|email|unique:users,email,' . $id,
        ];

        $this->validate($request, $rules);

        $u->edit_admin($id, $input['first_name'], $input['last_name'], $input['email']);

        $l->insert($done_by['email'], $done_by['email'] . " edited the details of amin with id " . $id, 5);

        return redirect('eswift/admins')->with('status', 'Administrator updated successfully');

    }

    public function logs()
    {
        $l = new Log;

        if (request()->isXmlHttpRequest()) {
            $data = $l->get_super_admin_logs();

            return Datatables::of($data)->make(true);
        }

        return view('super_admin.logs');
    }

}
