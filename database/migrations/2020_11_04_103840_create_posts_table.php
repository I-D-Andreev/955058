<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            
            $table->string('title');
            $table->string('text');
            // "created_at" and "updated_at" are made automatically from timestamps()
            
            // $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('user_id');

            // $table->foreign('user_id')->references('id')->on('users')->
            //     onDelete('set null')->onUpdate('cascade');

            $table->foreign('user_id')->references('id')->on('users')->
                onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
