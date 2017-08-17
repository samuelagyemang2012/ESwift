<?php

namespace App\Http\Controllers;

use App\Package;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    function get_packages($name)
    {
        $p = new Package();

        $data = $p->get_package_by_name($name);

        return response()->json($data);
    }
}
