<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePricingLogicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pricing_logics', function (Blueprint $table) {
            if (!Schema::hasColumn('pricing_logics', 'filing_fee')) {
                $table->decimal('filing_fee', 10,2)->nullable();
            }
            if (!Schema::hasColumn('pricing_logics', 'official_fee')) {
                $table->decimal('official_fee', 10,2)->nullable();
            }
            if (!Schema::hasColumn('pricing_logics', 'translation_fee')) {
                $table->decimal('translation_fee', 10,2)->nullable();
            }
            if (!Schema::hasColumn('pricing_logics', 'examination_fee')) {
                $table->decimal('examination_fee', 10,2)->nullable();
            }
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
