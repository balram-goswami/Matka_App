<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->integer('post_id');
            $table->text("comment_author");
            $table->string("comment_author_email");
            $table->string("comment_author_url");
            $table->string("comment_author_IP");
            $table->text("comment_content");
            $table->string("comment_approved")->default("1");
            $table->string("comment_type");
            $table->BigInteger("comment_parent");
            $table->BigInteger("user_id");
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
        Schema::dropIfExists('comments');
    }
}
