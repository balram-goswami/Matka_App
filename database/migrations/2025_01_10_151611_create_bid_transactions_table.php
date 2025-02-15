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
        Schema::create('bid_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('game_id');
            $table->string('parent_id')->nullable();
            $table->string('answer')->nullable();
            $table->string('harf_digit')->nullable();
            $table->string('bid_result')->nullable();
            $table->string('bid_amount')->nullable();
            $table->string('win_amount')->nullable();
            $table->string('admin_share')->nullable();
            $table->string('subadmin_share')->nullable();
            $table->string('admin_cut')->nullable();
            $table->string('subadmin_cut')->nullable();
            $table->string('subadminGet')->nullable();
            $table->string('result_status')->nullable();
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('bid_transactions');
    }
};
