<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Account extends Model
{
    public function create_accounts($id, $name, $account_number, $ebalance, $mbalance)
    {
        DB::table('eswift_accounts')->insert([
            'user_id' => $id,
            'name' => $name,
            'eaccount_number' => 'ESWIFT-' . $account_number,
            'balance' => $ebalance
        ]);

        DB::table('mmf_accounts')->insert([
            'user_id' => $id,
            'name' => $name,
            'maccount_number' => 'MMF-' . $account_number,
            'balance' => $mbalance
        ]);
    }

    public function delete_account($id, $date)
    {
        DB::table('eswift_accounts')
            ->where('user_id', '=', $id)
            ->update(['deleted_at' => $date]);

        DB::table('mmf_accounts')
            ->where('user_id', '=', $id)
            ->update(['deleted_at' => $date]);
    }

    public function update_accounts($id, $ebalance, $mbalance)
    {
        DB::table('eswift_accounts')
            ->where('user_id', '=', $id)
//            ->whereNull('deleted_at')
            ->update(['balance' => $ebalance]);

        DB::table('mmf_accounts')
            ->where('user_id', '=', $id)
//            ->whereNull('deleted_at')
            ->update(['balance' => $mbalance]);
    }

    public function update_account_name($id, $telephone)
    {
        DB::table('eswift_accounts')
            ->where('user_id', $id)
            ->update(['name' => $telephone]);

        DB::table('mmf_accounts')
            ->where('user_id', $id)
            ->update(['name' => $telephone]);
    }

    public function get_eswift_account($id)
    {
        return DB::table('eswift_accounts')
            ->where('user_id', '=', $id)
            ->whereNull('deleted_at')
            ->get();
    }

    public function get_mmf_account($id)
    {
        return DB::table('mmf_accounts')
            ->where('user_id', '=', $id)
            ->whereNull('deleted_at')
            ->get();
    }

}
