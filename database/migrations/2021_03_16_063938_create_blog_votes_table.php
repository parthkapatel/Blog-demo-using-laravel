<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_votes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("blog_id");
            $table->unsignedBigInteger("user_id");
            $table->integer("likes")->default(0);
            $table->integer("dislikes")->default(0);
            $table->timestamps();
            $table->foreign("blog_id")->references("id")->on("blogs")->onDelete('cascade');
            $table->foreign("user_id")->references("id")->on("users")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_votes');
    }
}
