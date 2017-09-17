<?php

namespace App\Http\Controllers;

use App\Package;
use App\Rate;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function get_minimum_balance($name)
    {
        $r = new Rate();

        $fee_percentage = $r->get_rate(3);

        $p = new Package();

        $data = $p->get_maximum($name);

        $registration_fee = ($fee_percentage[0]->rate / 100) * $data[0]->maximum;

        return response()->json(['code' => 1, 'minimum' => $registration_fee]);
    }

//    public function get_minimum_balance($name)
//    {
//        $r = new Rate();
//
//        $fee_percentage = $r->get_rate(3);
//
//        $p = new Package();
//
//        $data = $p->get_maximum($name);
//
//        $registration_fee = ($fee_percentage[0]->rate / 100) * $data[0]->maximum;
//
//        return $registration_fee;
//    }

}
