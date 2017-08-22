<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Account extends Model
{
    public function create_account($user_id, $balance, $telephone)
    {
        DB::table('accounts')->insert([
            'user_id' => $user_id,
            'balance' => $balance,
            'telephone' => $telephone,
        ]);
    }
}
