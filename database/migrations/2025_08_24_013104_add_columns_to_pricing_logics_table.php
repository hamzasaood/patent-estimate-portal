<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPricingLogicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pricing_logics', function (Blueprint $table) {
            //
             $table->integer('claims_threshold')->default(20);
             $table->integer('pages_threshold')->default(25);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pricing_logics', function (Blueprint $table) {
            //
        });
    }
}
