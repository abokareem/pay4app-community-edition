<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gateway');
            $table->integer('phone_number')->nullable();
            $table->string('transaction_code')->nullable();
            $table->string('sender_name')->nullable();
            $table->float('amount');
            $table->float('balance')->nullable();
            $table->integer('checkout_id')->nullable();
            $table->integer('gateway_id')->nullable();
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
        Schema::drop('transfers');
    }
}
