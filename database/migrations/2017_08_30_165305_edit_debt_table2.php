<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditDebtTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('debts', function (Blueprint $table) {
//            $table->dropColumn('total_debt')->default(0.00);
//            $table->decimal('half_debt')->default(0.00);
//            $table->dropColumn('amount_left');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
