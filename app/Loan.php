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
            ->join('packages', 'packages.id', '=', 'loans.package_id')
            ->join('statuses', 'loans.status_id', '=', 'statuses.id')
            ->select('loans.id', 'loans.user_id', 'users.first_name', 'users.last_name', 'packages.pname', 'loans.amount', 'statuses.sname', 'loans.created_at')
            ->orderby('loans.created_at', 'asc')
            ->get();
    }

    public function get_pending_loans()
    {
        return DB::table('loans')
            ->join('users', 'loans.user_id', '=', 'users.id')
            ->join('packages', 'packages.id', '=', 'loans.package_id')
//            ->join('statuses', 'loans.status_id', '=', 'statuses.id')
            ->select('loans.id', 'loans.user_id', 'users.first_name', 'users.last_name', 'packages.pname', 'loans.amount', 'loans.created_at', 'users.mobile_money_account')
            ->where('loans.status_id', '=', 1)
            ->orderby('loans.created_at', 'asc')
            ->get();
    }

    public function get_approved_loans()
    {
        return DB::table('loans')
            ->join('users', 'loans.user_id', '=', 'users.id')
            ->join('packages', 'packages.id', '=', 'loans.package_id')
//            ->join('statuses', 'loans.status_id', '=', 'statuses.id')
            ->select('loans.id', 'loans.user_id', 'users.first_name', 'users.last_name', 'packages.pname', 'loans.amount', 'loans.created_at', 'users.mobile_money_account')
            ->where('loans.status_id', '=', 2)
            ->orderby('loans.created_at', 'asc')
            ->get();
    }

    public function get_refused_loans()
    {
        return DB::table('loans')
            ->join('users', 'loans.user_id', '=', 'users.id')
            ->join('packages', 'packages.id', '=', 'loans.package_id')
//            ->join('statuses', 'loans.status_id', '=', 'statuses.id')
            ->select('loans.id', 'loans.user_id', 'users.first_name', 'users.last_name', 'packages.pname', 'loans.amount', 'loans.created_at')
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
