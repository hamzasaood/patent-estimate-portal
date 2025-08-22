<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('quotes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

        // Step 1 - Application Details
        $table->string('application_type');
        $table->string('jurisdiction');
        $table->string('application_number')->nullable();
        $table->integer('claims')->default(0);
        $table->integer('pages')->default(0);
        $table->integer('drawings')->default(0);

        // Step 2 - Options
        $table->boolean('expedited')->default(false);
        $table->enum('translation',['none','en','from_en'])->default('none');
        $table->boolean('priority')->default(false);

        // Step 3 - Calculated fees
        $table->integer('base_fee')->default(0);
        $table->integer('extra_fee')->default(0);
        $table->integer('tax')->default(0);
        $table->integer('total')->default(0);

        $table->string('status')->default('draft'); // draft, quoted, paid
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
        Schema::dropIfExists('quotes');
    }
}
