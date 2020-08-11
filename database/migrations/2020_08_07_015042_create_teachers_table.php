<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('area_id')->nullable();
            $table->string('name');
            $table->string('nationality');
            $table->string('email');
            $table->string('native_language');
            $table->string('other_languages');
            $table->date('date_of_birth')->nullable();
            $table->boolean('is_public')->default(0);
            $table->string('education_level');
            $table->string('education_institution');
            $table->string('education_qualification');
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
        Schema::dropIfExists('teachers');
    }
}
