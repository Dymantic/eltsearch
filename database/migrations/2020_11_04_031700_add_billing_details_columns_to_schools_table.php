<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBillingDetailsColumnsToSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->string('billing_address')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_zip')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_country')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn([
                'billing_address',
                'billing_city',
                'billing_zip',
                'billing_state',
                'billing_country',
            ]);
        });
    }
}
