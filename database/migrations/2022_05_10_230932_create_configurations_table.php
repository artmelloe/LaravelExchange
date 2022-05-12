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
        Schema::create('configurations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->float('boleto_fee', 10, 4);
            $table->float('credit_card_fee', 10, 4);
            $table->float('fee_amount_less', 10, 4);
            $table->float('fee_amount_less_value', 10, 2);
            $table->float('fee_amount_greater', 10, 4);
            $table->float('fee_amount_greater_value', 10, 2);
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
        Schema::dropIfExists('configurations');
    }
};
