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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('wallet_id');
            $table->integer('parent_id')->nullable();
            $table->string('transaction_type')->nullable();
            $table->string('utr_number')->nullable();
            $table->string('diposit_image')->nullable();
            $table->string('deposit_amount')->nullable();
            $table->string('withdraw_amount')->nullable();
            $table->string('remark')->nullable();
            $table->string('request_status')->default('pending');
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
        Schema::dropIfExists('wallet_transactions');
    }
};
