<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Debt extends Model
{
    public function insert($user_id, $loan_id, $telephone, $amount_borrowed, $half_debt, $half_date, $total_debt, $full_date)
    {
        DB::table('debts')->insert([
            'user_id' => $user_id,
            'loan_id' => $loan_id,
            'telephone' => $telephone,
            'amount_borrowed' => $amount_borrowed,
            'half_debt' => $half_debt,
            'half_loan_date' => $half_date,
            'total_debt' => $total_debt,
            'full_loan_date' => $full_date,
        ]);
    }

    public function get_debts()
    {
        return DB::table('debts')
            ->join('users', 'users.id', '=', 'debts.user_id')
            ->select('debts.id', 'debts.loan_id', 'users.first_name', 'users.last_name', 'users.telephone', 'debts.amount_borrowed', 'debts.amount_paid', 'debts.half_debt', 'debts.total_debt', 'debts.created_at')
            ->where('is_paid', '=', 0)
            ->get();
    }

    public function get_debt_details($loan_id)
    {
        return DB::table('debts')
            ->join('users', 'users.id', '=', 'debts.user_id')
            ->select('debts.id', 'users.first_name', 'users.last_name', 'users.telephone', 'debts.amount_borrowed', 'debts.amount_paid', 'debts.half_debt', 'debts.half_loan_date', 'debts.total_debt', 'debts.full_loan_date', 'debts.created_at')
            ->where('is_paid', '=', 0)
            ->where('loan_id', '=', $loan_id)
            ->get();
    }

}
