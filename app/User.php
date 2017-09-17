<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    public function insert($fname, $mman, $lastname, $email, $password, $telephone, $employer, $e_loc, $r_add, $carthograph, $salary, $mmacount, $role, $package)
    {
        $id = DB::table('users')->insertGetId(
            ['multimoney_account_number' => $mman,
                'first_name' => $fname,
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

        return $id;
    }

    public function remove($id, $date)
    {
        DB::table('users')
            ->where('id', '=', $id)
            ->update(['deleted_at' => $date]);
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

    public function update_personnel($id, $firstname, $lastname, $email, $telephone, $employer, $employer_loc, $r_address)
    {
        DB::table('users')
            ->where('id', '=', $id)
            ->update([
                'first_name' => $firstname,
                'last_name' => $lastname,
                'email' => $email,
                'telephone' => $telephone,
                'employer' => $employer,
                'employer_location' => $employer_loc,
                'residential_address' => $r_address
            ]);
    }

    public function get_clients()
    {
        return DB::table('users')
//            ->select('id', 'first_name', 'last_name', 'telephone', 'employer', 'employer_location', 'residential_address', 'monthly_salary', 'mobile_money_account')
            ->where('role_id', '=', 1)
            ->whereNull('deleted_at')
            ->get();
    }

    public function get_client($id)
    {
        return DB::table('users')
//            ->join('accounts', 'accounts.telephone', '=', 'users.telephone')
//            ->select('id', 'first_name', 'last_name', 'telephone', 'employer', 'employer_location', 'residential_address', 'monthly_salary', 'mobile_money_account')
            ->where('users.role_id', '=', 1)
            ->where('users.id', '=', $id)
//            ->whereNull('users.deleted_at')
            ->get();
    }

    public function get_payments_personnel($id)
    {
        return DB::table('users')
            ->where('users.role_id', '=', 4)
            ->where('users.id', '=', $id)
            ->get();
    }

    public function get_transactions_personnel($id)
    {
        return DB::table('users')
            ->where('users.role_id', '=', 3)
            ->where('users.id', '=', $id)
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
            'multimoney_account_number' => 'n/a',
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
            'multimoney_account_number' => 'n/a',
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

    public function all_payments_personnel()
    {
        return DB::table('users')
            ->where('role_id', '=', 4)
            ->whereNull('deleted_at')
            ->get();
    }

    public function all_transactions_personnel()
    {
        return DB::table('users')
            ->where('role_id', '=', 3)
            ->whereNull('deleted_at')
            ->get();
    }

    public function get_all_admins(){
        return DB::table('users')
            ->where('role_id', '=', 2)
            ->whereNull('deleted_at')
            ->get();
    }

    public function get_user_package($user_id)
    {
        return DB::table('users')
            ->where('id', '=', $user_id)
            ->select('package')
            ->get();
    }

//    public function is_deleted_account($telephone)
//    {
//        return DB::table('users')
//            ->where('telephone','=',$telephone)
//            ->whereNotNull()
//    }

}
