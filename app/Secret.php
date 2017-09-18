<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Secret extends Model
{
    public function add($telephone, $question, $answer)
    {
        DB::table('secrets')->insert([
            'telepphone' => $telephone,
            'secret_question' => $question,
            'secret_answer' => $answer
        ]);
    }
}
