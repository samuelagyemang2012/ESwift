<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Log extends Model
{
    public function insert($by, $message, $role)
    {
        DB::table('logs')->insert([
            'by' => $by,
            'message' => $message,
            'role_id' => $role
        ]);
    }

    public function get_client_logs()
    {
        return DB::table('logs')
            ->where('role_id', '=', 1)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function get_admin_logs()
    {
        return DB::table('logs')
            ->select('by', 'message', 'created_at')
            ->where('role_id', '=', 2)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function get_transaction_logs()
    {
        return DB::table('logs')
            ->select('by', 'message', 'created_at')
            ->where('role_id', '=', 3)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function get_payment_logs()
    {
        return DB::table('logs')
            ->select('by', 'message', 'created_at')
            ->where('role_id', '=', 4)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function get_super_admin_logs()
    {
        return DB::table('logs')
            ->select('by', 'message', 'created_at')
            ->where('role_id', '=', 5)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
