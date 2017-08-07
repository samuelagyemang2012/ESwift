<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    public function insert($fname, $lastname, $email, $password, $telephone, $employer, $e_loc, $r_add, $carthograph, $salary, $mmacount, $role)
    {
        DB::table('users')->insert(
            ['first_name' => $fname,
                'last_name' => $lastname,
                'email' => $email,
                'password' => $password,
                'telephone' => $telephone,
                'employer' => $employer,
                'employer_location' => $e_loc,
                'residential_address' => $r_add,
                'carthograph' => $carthograph,
                'monthly_salary' => $salary,
                'mobile_money_account' => $mmacount,
                'role_id' => $role
            ]);
    }

    public function delete_client($id)
    {
        DB::table('users')
            ->where('id', $id)
            ->delete();
    }

    public function update_client($id, $fname, $lastname, $email, $telephone, $employer, $e_loc, $r_add, $carthograph, $salary, $mmacount)
    {
        DB::table('users')
            ->where('id', '=', $id)
            ->update([
                'first_name' => $fname,
                'last_name' => $lastname,
                'email' => $email,
                'telephone' => $telephone,
                'employer' => $employer,
                'employer_location' => $e_loc,
                'residential_address' => $r_add,
                'carthograph' => $carthograph,
                'monthly_salary' => $salary,
                'mobile_money_account' => $mmacount
            ]);
    }

    public function get_clients()
    {
        return DB::table('users')
//            ->select('id', 'first_name', 'last_name', 'telephone', 'employer', 'employer_location', 'residential_address', 'monthly_salary', 'mobile_money_account')
            ->where('role_id', '=', 1)
            ->get();
    }

    public function get_client($id)
    {
        return DB::table('users')
//            ->select('id', 'first_name', 'last_name', 'telephone', 'employer', 'employer_location', 'residential_address', 'monthly_salary', 'mobile_money_account')
            ->where('role_id', '=', 1)
            ->where('id', '=', $id)
            ->get();
    }

    public function get_client_with_account($id)
    {

    }

    public function change_password($email, $password)
    {
        DB::table('users')
            ->where('email', '=', $email)
            ->update(['password' => $password]);
    }

    public function get_password($email)
    {
        return DB::table('users')
            ->select('password')
            ->where('email', '=', $email)
            ->get();
    }
}
