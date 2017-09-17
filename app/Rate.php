<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Rate extends Model
{
    public function get_rates()
    {
        return
            DB::table('rates')->get();
    }

    public function get_rate($id)
    {
        return
            DB::table('rates')
                ->where('id', '=', $id)
                ->get();
    }

    public function get_rate_by_name($name)
    {
        return
            DB::table('rates')
                ->where('name', '=', $name)
                ->get();
    }

    public function update_rate($id, $rate)
    {
        DB::table('rates')
            ->where('id', '=', $id)
            ->update(['rate' => $rate]);
    }

//    public function


}
