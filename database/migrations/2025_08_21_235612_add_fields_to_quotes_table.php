<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('quotes', function (Blueprint $table) {
        // Extra metadata
        $table->string('title')->nullable();
        $table->string('applicant')->nullable();
        $table->date('priority_date')->nullable();
        $table->date('filing_date')->nullable();
        $table->date('deadline_30m')->nullable();
        $table->date('deadline_31m')->nullable();

        // Pages breakdown
        $table->integer('sequence_pages')->default(0);

        // Contact / references
        $table->string('client_ref')->nullable();
        $table->string('emuna_ref')->nullable();

        // Fees (if per country breakdown later, keep summary here)
        $table->json('fees_breakdown')->nullable(); // store country/language/fees as JSON
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotes', function (Blueprint $table) {
            //
        });
    }
}
