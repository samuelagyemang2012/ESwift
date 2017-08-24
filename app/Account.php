<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Account extends Model
{
    public function create_account($telephone, $balance)
    {
        DB::table('accounts')->insert([
            'telephone' => $telephone,
            'balance' => $balance,
        ]);
    }

    public function delete_account($telephone, $date)
    {
        DB::table('accounts')
            ->where('telephone', '=', $telephone)
            ->update(['deleted_at' => $date]);
    }

    public function update_account($telephone, $balance)
    {
        DB::table('accounts')
            ->where('telephone', '=', $telephone)
            ->update(['balance' => $balance]);
    }

    public function get_balance($telephone)
    {
        return DB::table('accounts')
            ->where('telephone', '=', $telephone)
            ->select('balance')
            ->get();
    }
}
