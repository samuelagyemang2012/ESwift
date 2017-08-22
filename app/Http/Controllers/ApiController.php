<?php

namespace App\Http\Controllers;

use App\Package;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function get_minimum_balance($name)
    {
        $p = new Package();

        $data = $p->get_maximum($name);

        return response()->json($data[0]);
    }

}
