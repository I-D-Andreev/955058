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
            $table->timestamps();

            $table->string('text');
            $table->unsignedInteger('post_id');

            $table->foreign('post_id')->references('id')->
                on('posts')->onDelete('cascade')->onUpdate('cascade');
            
            // one to many with post
            // one to many with author/user
            // many-to-many with user liked by, disliked by
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
