<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    public function insert($fname, $lastname, $email, $password, $telephone, $employer, $e_loc, $r_add, $carthograph, $salary, $mmacount, $role, $package)
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
                'role_id' => $role,
                'package' => $package
            ]);
    }

    public function delete_client($id)
    {
        DB::table('users')
            ->where('id', $id)
            ->delete();
    }

    public function update_client($id, $fname, $lastname, $email, $telephone, $employer, $e_loc, $r_add, $carthograph, $salary, $mmacount, $package)
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
                'mobile_money_account' => $mmacount,
                'package' => $package
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

    public function change_password($email, $password)
    {
        DB::table('users')
            ->where('email', '=', $email)
            ->update(['password' => $password]);
    }

    public function add_payment($firstname, $lastname, $email, $password, $telephone, $residential)
    {
        DB::table('users')->insert([
            'first_name' => $firstname,
            'last_name' => $lastname,
            'email' => $email,
            'password' => $password,
            'telephone' => $telephone,
            'employer' => 'Multi-Money',
            'employer_location' => 'Agbobloshie',
            'residential_address' => $residential,
            'carthograph' => 'n/a',
            'monthly_salary' => 'n/a',
            'mobile_money_account' => 'n/a',
            'role_id' => 4
        ]);
    }

    public function add_transaction($firstname, $lastname, $email, $password, $telephone, $residential)
    {
        DB::table('users')->insert([
            'first_name' => $firstname,
            'last_name' => $lastname,
            'email' => $email,
            'password' => $password,
            'telephone' => $telephone,
            'employer' => 'Multi-Money',
            'employer_location' => 'Agbobloshie',
            'residential_address' => $residential,
            'carthograph' => 'n/a',
            'monthly_salary' => 'n/a',
            'mobile_money_account' => 'n/a',
            'role_id' => 3
        ]);
    }

    public function get_password($email)
    {
        return DB::table('users')
            ->select('password')
            ->where('email', '=', $email)
            ->get();
    }

//    public function get_telephone($msisdn)
//    {
//        return DB::table('users')
//            ->select('telephone')
//            ->where('telephone', '=', $msisdn)
//            ->get();
//    }
}
