<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Notification extends Model
{
    public function unread()
    {
        return DB::table('notifications')
            ->where('is_read', '=', 0)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function read()
    {
        return DB::table('notifications')
            ->where('is_read', '=', 1)
            ->orderBy('created_at', 'asc')
            ->get();

    }

    public function mark_as_read($id)
    {
        DB::table('notifications')
            ->where('id', '=', $id)
            ->update(['is_read' => 1]);
    }
}
