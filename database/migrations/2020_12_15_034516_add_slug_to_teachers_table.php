<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugToTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable();
        });

        \App\Teachers\Teacher::eachById(function($teacher) {
            if(!$teacher->slug) {
                $teacher->update(['slug' => \App\UniqueKey::for('teachers:slug')]);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
