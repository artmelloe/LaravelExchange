<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchanges', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('origin_currency');
            $table->string('income_currency');
            $table->string('amount_exchange');
            $table->string('payment_method');
            $table->string('current_currency');
            $table->string('exchange_total');
            $table->string('payment_fee');
            $table->string('exchange_fee');
            $table->string('exchange_without_fees');
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
        Schema::dropIfExists('exchanges');
    }
};
