<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWhitelabelToQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotes', function (Blueprint $table) {
            // Applicant field (missing in your model)

            // White label fields
            $table->unsignedBigInteger('firm_id')->nullable()->after('user_id');
            $table->string('firm_logo')->nullable();
            $table->decimal('firm_fees', 10, 2)->default(0);
            $table->decimal('total_with_firm', 12, 2)->nullable();
            $table->boolean('is_white_label')->default(false);
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
