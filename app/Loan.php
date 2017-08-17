<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Loan extends Model
{
    public function insert()
    {

    }

    public function get_all_loans()
    {
        return DB::table('loans')
            ->join('users', 'loans.user_id', '=', 'users.id')
//            ->join('packages', 'packages.id', '=', 'loans.package_id')
            ->join('statuses', 'loans.status_id', '=', 'statuses.id')
            ->select('loans.id', 'loans.user_id', 'users.first_name', 'users.last_name', 'loans.amount', 'statuses.sname', 'loans.created_at', 'users.telephone')
            ->orderby('loans.created_at', 'asc')
            ->get();
    }

    public function get_processed_loans()
    {
        return DB::table('loans')->count();
    }

    public function get_total_amount_given()
    {
        return DB::table('payments')->sum('amount_transferred');
    }

    public function get_total_returns()
    {
        return DB::table('debts')->sum('amount_left');
    }

    public function get_num_pending()
    {
//        return DB::table('loans')
//            ->where('status_id', '=', 1)
//            ->count('id');

        return DB::table('loans')
            ->select(DB::raw('COUNT(id)'))
            ->where('status_id', '=', 1)
            ->get();

    }

    public function get_num_approved()
    {
        return DB::table('loans')
            ->where('status_id', '=', 2)
            ->count();
    }

    public function get_num_refused()
    {
        return DB::table('loans')
            ->where('status_id', '=', 3)
            ->count();
    }

    public function get_pending_loans()
    {
        return DB::table('loans')
            ->join('users', 'loans.user_id', '=', 'users.id')
//            ->join('packages', 'packages.id', '=', 'loans.package_id')
//            ->join('statuses', 'loans.status_id', '=', 'statuses.id')
            ->select('loans.id', 'loans.user_id', 'users.first_name', 'users.last_name', 'loans.amount', 'loans.created_at', 'users.mobile_money_account', 'users.telephone')
            ->where('loans.status_id', '=', 1)
            ->orderby('loans.created_at', 'asc')
            ->get();
    }

    public function get_approved_loans()
    {
        return DB::table('loans')
            ->join('users', 'loans.user_id', '=', 'users.id')
//            ->join('packages', 'packages.id', '=', 'loans.package_id')
//            ->join('statuses', 'loans.status_id', '=', 'statuses.id')
            ->select('loans.id', 'loans.user_id', 'users.first_name', 'users.last_name', 'loans.amount', 'loans.created_at', 'users.mobile_money_account')
            ->where('loans.status_id', '=', 2)
            ->orderby('loans.created_at', 'asc')
            ->get();
    }

    public function get_refused_loans()
    {
        return DB::table('loans')
            ->join('users', 'loans.user_id', '=', 'users.id')
//            ->join('packages', 'packages.id', '=', 'loans.package_id')
//            ->join('statuses', 'loans.status_id', '=', 'statuses.id')
            ->select('loans.id', 'loans.user_id', 'users.first_name', 'users.last_name', 'loans.amount', 'loans.created_at')
            ->where('loans.status_id', '=', 3)
            ->orderby('loans.created_at', 'asc')
            ->get();
    }

    public function approve_loan($id)
    {
        DB::table('loans')
            ->where('id', $id)
            ->update(['status_id' => 2]);
    }

    public function refuse_loan($id)
    {
        DB::table('loans')
            ->where('id', $id)
            ->update(['status_id' => 3]);
    }

}
