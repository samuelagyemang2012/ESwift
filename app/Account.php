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
}
