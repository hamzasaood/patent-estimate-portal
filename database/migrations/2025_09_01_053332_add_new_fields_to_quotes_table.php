<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->string('reference_number')->nullable()->after('application_number');
            $table->string('region')->nullable()->after('jurisdiction'); // replacing jurisdiction
            $table->text('special_instructions')->nullable()->after('drawings');
            $table->string('attachment')->nullable()->after('special_instructions'); // store file path
            $table->string('service')->nullable()->after('application_type'); // new dropdown
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
