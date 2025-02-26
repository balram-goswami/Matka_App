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
            $table->string('slot')->nullable();
            $table->string('harf_digit')->nullable();
            $table->string('bid_result')->nullable();
            $table->string('bid_amount')->nullable();
            $table->string('win_amount')->nullable();
            $table->string('subadmin_amount')->nullable();
            $table->string('player_commission')->nullable();
            $table->string('winamount_from_admin')->nullable();
            $table->string('admin_amount')->nullable();
            $table->string('subadmin_commission')->nullable();
            $table->string('admin_dif')->nullable();
            $table->string('subadmin_dif')->nullable();
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
