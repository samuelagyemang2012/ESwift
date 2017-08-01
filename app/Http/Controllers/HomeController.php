<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    public function view_all_clients()
    {
        $user = new User;

        if (request()->isXmlHttpRequest()) {

            $data = $user->get_clients();

            return Datatables::of($data)->make(true);
        }

        return view('data');
    }
}
