<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPricingLevelsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('pf_level_id')->nullable()->after('remember_token');
            $table->unsignedBigInteger('tf_level_id')->nullable()->after('pf_level_id');

            $table->foreign('pf_level_id')->references('id')->on('pricing_levels')->onDelete('set null');
            $table->foreign('tf_level_id')->references('id')->on('pricing_levels')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
