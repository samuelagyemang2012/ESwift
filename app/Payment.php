<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
    public function insert($user_id, $amount_to_transfer)
    {
        DB::table('payments')->insert([
            'user_id' => $user_id,
            'amount_to_transfer' => $amount_to_transfer
        ]);
    }

    public function get_pending_transfers()
    {
        DB::table('payments')
            ->get();
    }

    public function make_payment($transaction_id, $transferred_by, $amount_to_transfer, $amount_transferred, $comments)
    {
        DB::table('payments')
            ->where('transaction_id', $transaction_id)
            ->update(['transferred_by' => $transferred_by,
                'amount_to_transfer' => $amount_to_transfer,
                'amount_transerred' => $amount_transferred,
                'comments' => $comments]);

    }
}
