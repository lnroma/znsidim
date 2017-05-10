<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BlogsComment extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('blog_comments', function ($tbl) {
            $tbl->increments('id');
            $tbl->integer('user_id');
            $tbl->integer('user_blogs_id');
            $tbl->boolean('is_enabled');
            $tbl->boolean('is_delete');
            $tbl->text('name');
            $tbl->text('comment');
            $tbl->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('blog_comments');
    }
}
