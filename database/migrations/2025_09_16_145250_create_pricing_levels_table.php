<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricingLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pricing_levels', function (Blueprint $table) {
            $table->id();
            $table->string('region'); // e.g. US, EU, CN
            $table->unsignedTinyInteger('level'); // 0–5
            $table->decimal('adjustment_percent', 5,2)->default(0); // -5.00, -10.00 etc.
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('pricing_level_id')->nullable()->after('role');
            $table->foreign('pricing_level_id')->references('id')->on('pricing_levels')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pricing_levels');
    }
}
