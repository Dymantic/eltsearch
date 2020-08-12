<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobSearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_searches', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('teacher_id');
            $table->json('area_ids');
            $table->json('student_ages');
            $table->json('benefits');
            $table->json('contract_type');
            $table->boolean('weekends')->default(1);
            $table->tinyInteger('salary')->nullable();
            $table->tinyInteger('hours_per_week')->nullable();
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
        Schema::dropIfExists('job_searches');
    }
}
