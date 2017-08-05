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
        return DB::table('payments')
            ->join('users', 'users.id', '=', 'payments.user_id')
            ->select('payments.id', 'users.telephone', 'amount_to_transfer')
            ->where('is_transferred', '=', 0)
            ->get();
    }

    public function get_completed_transfers()
    {
        return DB::table('payments')
//            ->join('users', 'users.id', '=', 'payments.user_id')
//            ->select('payments.id', 'users.telephone', 'amount_to_transfer','transaction_id','transferred_by')
            ->where('is_transferred', '=', 1)
            ->get();
    }

    public function make_payment($id, $transaction_id, $transferred_by, $amount_transferred, $comments)
    {
        DB::table('payments')
            ->where('id', $id)
            ->update(['transferred_by' => $transferred_by,
                'transaction_id' => $transaction_id,
                'amount_transferred' => $amount_transferred,
                'is_transferred' => 1,
                'comments' => $comments]);

    }
}
