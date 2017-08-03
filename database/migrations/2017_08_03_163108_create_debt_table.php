<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDebtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debts', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->integer('loan_id')->index();
            $table->integer('user_id')->index();
            $table->string('telephone')->index();
            $table->decimal('amount_borrowed');
            $table->decimal('amount_paid')->default(0.00);
            $table->decimal('amount_left');
            $table->integer('is_paid')->default(0);
            $table->timestamps();
        });
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
