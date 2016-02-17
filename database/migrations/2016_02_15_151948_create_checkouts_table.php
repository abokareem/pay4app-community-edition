<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('paid')->default(false);
            $table->boolean('open')->default(true);
            $table->string('status')->nullable();
            $table->string('order');
            $table->float('amount');
            $table->string('gateway');
            $table->integer('phone_number')->nullable();
            $table->string('transaction_code')->nullable();
            $table->string('redirect_url')->nullable();
            $table->string('cancel_url')->nullable();
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
        Schema::drop('checkouts');
    }
}
