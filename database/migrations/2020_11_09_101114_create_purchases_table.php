<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('customer_type');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('package_id');
            $table->integer('price');
            $table->string('currency');
            $table->string('card_last_four');
            $table->string('card_type');
            $table->boolean('paid')->default(0);
            $table->string('gateway_ref_no');
            $table->string('gateway_status');
            $table->text('gateway_error')->nullable();
            $table->string('ref_no');
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
        Schema::dropIfExists('purchases');
    }
}
