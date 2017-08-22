<?php

namespace App\Http\Controllers;

use App\Package;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function get_minimum_balance($name)
    {
        $fee_percentage = 0.42;
        $mobile_percentage = 0.425;

        $p = new Package();

        $data = $p->get_maximum($name);

        $registration_fee = $fee_percentage * $data[0]->maximum;
        $mobile_fee = $mobile_percentage * $data[0]->maximum;

        $minimum = $registration_fee + $mobile_fee;

        return response()->json(['code' => 1, 'minimum' => $minimum]);
    }

}
