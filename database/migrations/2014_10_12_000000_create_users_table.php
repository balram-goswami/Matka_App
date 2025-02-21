<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('user_id');
            $table->string('name')->unique();
            $table->string('photo')->nullable();
            $table->string('password'); 
            $table->string('role');
            $table->string('parent')->nullable();
            $table->string('toss_game_rate')->nullable();
            $table->string('crossing_game_rate')->nullable();
            $table->string('harf_game_rate')->nullable();
            $table->string('oddEven_game_rate')->nullable();
            $table->string('jodi_game_rate')->nullable();
            $table->string('toss_game_commission')->nullable();
            $table->string('crossing_commission')->nullable();
            $table->string('harf_commission')->nullable();
            $table->string('oddEven_commission')->nullable();
            $table->string('jodi_commission')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('ac_holder_name')->nullable();
            $table->string('ac_number')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('upi_one')->nullable();
            $table->string('upi_two')->nullable();
            $table->string('upi_three')->nullable();
            $table->enum("status",["Active","Block","BlockByAdmin"]);
            $table->datetime('email_verified_at');
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
