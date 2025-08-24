<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricingLogicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pricing_logics', function (Blueprint $table) {
            $table->id();
            $table->string('jurisdiction')->nullable();   // e.g. "US", "EP", "JP"
            $table->string('application_type')->nullable(); // e.g. "Patent", "Design", "Trademark"

            $table->decimal('base_fee', 10, 2)->default(0);
            $table->decimal('per_claim_fee', 10, 2)->default(0);
            $table->decimal('per_page_fee', 10, 2)->default(0);
            $table->decimal('per_drawing_fee', 10, 2)->default(0);
            $table->decimal('per_sequence_page_fee', 10, 2)->default(0);

            $table->decimal('translation_fee', 10, 2)->default(0);
            $table->decimal('expedited_fee', 10, 2)->default(0);
            $table->decimal('tax_percentage', 5, 2)->default(0); // e.g. 7.5 %

            $table->string('status')->default('active'); // active/inactive
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
        Schema::dropIfExists('pricing_logics');
    }
}
