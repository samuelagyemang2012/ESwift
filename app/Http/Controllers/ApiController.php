<?php

namespace App\Http\Controllers;

use App\Package;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    function get_packages($id)
    {
        $p = new Package();

        $data = $p->get_package($id);

        return response()->json($data);
    }
}
