<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class History extends Model
{
    public function insert($telephone, $amount, $trans, $purpose, $by, $date)
    {
        DB::table('histories')->insert([
            'telephone' => $telephone,
            'amount_paid' => $amount,
            'transaction_id' => $trans,
            'purpose' => $purpose,
            'by' => $by,
            'date_of_payment' => $date
        ]);
    }

    public function get_history()
    {
        return DB::table('histories')->get();
    }
}
