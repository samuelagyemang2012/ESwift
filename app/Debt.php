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

    public function get_unpaid_debts()
    {
        return DB::table('debts')
            ->join('users', 'users.id', '=', 'debts.user_id')
            ->select('debts.id', 'debts.loan_id', 'users.first_name', 'users.last_name', 'users.telephone', 'debts.amount_borrowed', 'debts.amount_paid', 'debts.half_debt', 'debts.total_debt', 'debts.created_at')
            ->where('is_paid', '=', 0)
            ->get();
    }

    public function get_paid_debts()
    {
        return DB::table('debts')
            ->join('users', 'users.id', '=', 'debts.user_id')
            ->select('debts.id', 'debts.loan_id', 'users.first_name', 'users.last_name', 'users.telephone', 'debts.amount_borrowed', 'debts.amount_paid', 'debts.half_debt', 'debts.total_debt', 'debts.updated_at')
            ->where('is_paid', '=', 1)
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

    public function get_user_id($id)
    {
        return DB::table('debts')
            ->select('debts.user_id')
            ->where('id', '=', $id)
            ->get();
    }

    public function get_debt_details_by_did($debt_id)
    {
        return DB::table('debts')
            ->select('debts.total_debt')
            ->where('debts.id', '=', $debt_id)
            ->get();
    }

    public function update_amount_paid($did, $amount)
    {
        DB::table('debts')
            ->where('debts.id', '=', $did)
            ->update(['amount_paid' => $amount]);
    }

    public function mark_as_paid($loan_id, $debt_id)
    {
        DB::table('debts')
            ->where('debts.id', '=', $debt_id)
            ->update(['is_paid' => 1]);

        DB::table('loans')
            ->where('loans.id', '=', $loan_id)
            ->update(['is_paid' => 1]);
    }

    public function two_days_to_half_elapsed()
    {
        return DB::select(DB::raw("SELECT * FROM `debts` WHERE DATE_ADD(CURDATE() , INTERVAL 2 DAY) = half_loan_date AND amount_paid = 0"));
    }

    public function half_elapsed()
    {
        return DB::select(DB::raw("SELECT * FROM `debts` WHERE CURDATE() = half_loan_date AND amount_paid = 0"));
    }

    public function two_days_to_full_elapsed()
    {
        return DB::select(DB::raw("SELECT * FROM `debts` WHERE DATE_ADD(CURDATE() , INTERVAL 2 DAY) = full_loan_date"));
    }

    public function full_elapsed()
    {
        return DB::select(DB::raw("SELECT * FROM `debts` WHERE CURDATE() = full_loan_date"));
    }


}
