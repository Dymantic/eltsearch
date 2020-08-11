<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('school_id');
            $table->unsignedInteger('posted_by');
            $table->unsignedInteger('last_edited_by');
            $table->unsignedInteger('area_id')->nullable();
            $table->string('school_name');
            $table->string('position');
            $table->text('description');
            $table->json('student_ages');
            $table->json('requirements');
            $table->json('benefits');
            $table->boolean('work_on_weekends')->default(0);
            $table->string('salary_rate');
            $table->integer('salary_min')->nullable();
            $table->integer('salary_max')->nullable();
            $table->integer('min_students_per_class')->nullable();
            $table->integer('max_students_per_class')->nullable();
            $table->string('contract_length');
            $table->string('engagement');
            $table->integer('hours_per_week')->nullable();
            $table->date('start_date');
            $table->dateTime('first_published_at')->nullable();
            $table->boolean('is_public')->default(0);
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
        Schema::dropIfExists('job_posts');
    }
}
