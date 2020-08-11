<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreviousEmploymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('previous_employments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('teacher_id');
            $table->string('employer');
            $table->date('employed_from')->nullable();
            $table->date('employed_to')->nullable();
            $table->string('job_title');
            $table->text('description');
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
        Schema::dropIfExists('previous_employments');
    }
}
