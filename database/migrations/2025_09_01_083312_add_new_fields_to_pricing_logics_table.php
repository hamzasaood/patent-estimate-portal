<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToPricingLogicsTable extends Migration
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
             $table->string('service');   // e.g. pct_national_phase, ep_validation
            $table->string('region');    // e.g. US, EU, CN
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
