<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Package extends Model
{
    public function insert($name, $desc, $max)
    {
        DB::table('packages')->insert([
            'pname' => $name,
            'description' => $desc,
            'maximum' => $max
        ]);
    }

    public function get_packages()
    {
        return DB::table('packages')
//            ->select('id','name','maximum')
            ->get();
    }

    public function get_package($id)
    {
        return DB::table('packages')
            ->where('id', '=', $id)
            ->get();
    }

    public function update_package($id, $name, $desc, $max)
    {
        DB::table('packages')
            ->where('id', '=', $id)
            ->update(['pname' => $name, 'description' => $desc, 'maximum' => $max]);
    }

    public function delete_package($id)
    {
        DB::table('packages')
            ->where('id', $id)
            ->delete();
    }

}
