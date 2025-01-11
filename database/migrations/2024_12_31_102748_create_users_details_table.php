<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('dob')->nullable(); 
            $table->string('address')->nullable(); 
            $table->string('education')->nullable(); 
            $table->string('languages')->nullable(); 
            $table->string('experience')->nullable(); 
            $table->string('expertise')->nullable(); 
            $table->string('about')->nullable(); 
            $table->string('price')->nullable(); 
            $table->string('service')->nullable();
            $table->string('rating')->nullable(); 
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
        Schema::dropIfExists('users_details');
    }
}
