<?php

namespace App\Http\Controllers;

use App\Log;
use App\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class PackageController extends Controller
{
    public function index()
    {
        $p = new Package;

        if (request()->isXmlHttpRequest()) {

            $data = $p->get_packages();

            return Datatables::of($data)
                ->make();
        }

        return view('packages.package');
    }

    public function show_add_package()
    {
        return view('packages.add_package');
    }

    public function p_show_add_client()
    {
        $p = new Package();
        $packages = $p->get_packages();

        return view('admin.add_client')->with('packages', $packages);
    }

    public function add_package(Request $request)
    {
//        return $request;
        $l = new Log;
        $done_by = Auth::user();

        $input = $request->all();

        $rules = [
            'pname' => 'required|min:2|unique:packages',
//            'description' => 'min:5',
            'maximum' => 'required|numeric|unique:packages|max:999999'
        ];

        $messages = [
            'pname.unique' => 'This package already exist',
            'maximum.unique' => 'There is an existing package with this maximum amount',
        ];

        $this->validate($request, $rules, $messages);

        $p = new Package;

        $p->insert($input['pname'], $input['description'], $input['maximum']);

//        Logs
        $msg = $done_by['email'] . ' created a new package called ' . $input['pname'];
        $l->insert($done_by['email'], $msg, '2');

        return redirect('/eswift/packages')->with('status', 'Package added successfully');
    }

    public function edit_package(Request $request)
    {
        $l = new Log;
        $done_by = Auth::user();

        $input = $request->all();

        $rules = [
            'pname' => 'required|min:2',
//            'description' => 'required|min:5',
            'maximum' => 'required|numeric|max:999999'
        ];

        $this->validate($request, $rules);

        $p = new Package;

        $p->update_package($input['id'], $input['pname'], $input['description'], $input['maximum']);

//        Log
        $msg = $done_by['email'] . ' edited a package with id ' . $input['id'];
        $l->insert($done_by['email'], $msg, 2);

        return redirect('/eswift/packages')->with('status', 'Package updated successfully');
    }

    public function delete_package($id)
    {
        $p = new Package;
        $l = new Log;
        $done_by = Auth::user();

        $p->delete_package($id);

//        Log
        $msg = $done_by['email'] . ' deleted a package with id ' . $id;

        $l->insert($done_by['email'], $msg, 2);

        return redirect('/eswift/packages')->with('status', 'Package deleted successfully');
    }

    public function show_edit_package($id)
    {
        $p = new Package;

        $data = $p->get_package($id);

        return view('packages.edit_package')
            ->with('id', $id)
            ->with('data', $data[0]);
    }

}
