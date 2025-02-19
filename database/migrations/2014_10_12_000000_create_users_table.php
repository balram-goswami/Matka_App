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
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('photo')->nullable();
            $table->string('password'); 
            $table->string('role');
            $table->string('parent')->nullable();
            $table->string('admin_cut_toss_game')->nullable();
            $table->string('admin_cut_crossing')->nullable();
            $table->string('admin_cut_harf')->nullable();
            $table->string('admin_cut_odd_even')->nullable();
            $table->string('admin_cut_jodi')->nullable();
            $table->string('user_cut_toss_game')->nullable();
            $table->string('user_cut_crossing')->nullable();
            $table->string('user_cut_harf')->nullable();
            $table->string('user_cut_odd_even')->nullable();
            $table->string('user_cut_jodi')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('ac_holder_name')->nullable();
            $table->string('ac_number')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('upi_one')->nullable();
            $table->string('upi_two')->nullable();
            $table->string('upi_three')->nullable();
            $table->enum("status",["Active","Block","BlockByAdmin"]);
            $table->datetime('email_verified_at');
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
