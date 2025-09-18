<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWipoSamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wipo_samples', function (Blueprint $table) {
            $table->id();
            $table->string('application_country')->nullable();
            $table->string('application_number')->unique();
            $table->date('application_date')->nullable();
            $table->date('priority_date')->nullable();
            $table->string('applicant')->nullable();
            $table->string('language',10)->nullable();
            $table->integer('page_count')->nullable();
            $table->string('office')->nullable();
            $table->date('report_date')->nullable();
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
        Schema::dropIfExists('wipo_samples');
    }
}
