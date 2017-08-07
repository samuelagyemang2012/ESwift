<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Debt extends Model
{
    public function insert($user_id, $loan_id, $telephone, $amount_borrowed)
    {
        DB::table('debts')->insert([
            'user_id' => $user_id,
            'loan_id' => $loan_id,
            'telephone' => $telephone,
            'amount_borrowed' => $amount_borrowed,
        ]);
    }
}
