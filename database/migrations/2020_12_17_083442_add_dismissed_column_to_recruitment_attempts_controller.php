<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDismissedColumnToRecruitmentAttemptsController extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recruitment_attempts', function (Blueprint $table) {
            $table->boolean('dismissed')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recruitment_attempts', function (Blueprint $table) {
            $table->dropColumn('dismissed');
        });
    }
}
