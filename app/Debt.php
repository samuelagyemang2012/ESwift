<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Debt extends Model
{
    public function insert($user_id, $loan_id, $telephone, $amount_borrowed, $half_debt, $total_debt)
    {
        DB::table('debts')->insert([
            'user_id' => $user_id,
            'loan_id' => $loan_id,
            'telephone' => $telephone,
            'amount_borrowed' => $amount_borrowed,
            'half_debt' => $half_debt,
            'total_debt' => $total_debt
        ]);
    }

    public function get_debts()
    {
        return DB::table('debts')
            ->join('users', 'users.id', '=', 'debts.user_id')
            ->select('debts.id', 'users.first_name', 'users.last_name', 'users.telephone', 'debts.amount_borrowed', 'debts.amount_paid', 'debts.created_at')
            ->where('is_paid', '=', 0)
            ->get();
    }
}
