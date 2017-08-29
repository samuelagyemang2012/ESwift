<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MmfAccountsChange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eswift_accounts', function (Blueprint $table) {
            $table->dropColumn('telephone');
        });

        Schema::table('mmf_accounts', function (Blueprint $table) {
            $table->dropColumn('telephone');
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
