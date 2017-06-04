<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BlogsTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // create blog tags
        Schema::create('blog_tags', function ($tbl) {
            $tbl->increments('id');
            $tbl->text('url_key');
            $tbl->text('title');
            $tbl->text('description');
            $tbl->timestamps();
        });

        Schema::create('blog_tags_user_blogs', function (Blueprint $tbl) {
            $tbl->increments('id');
            $tbl->integer('blog_ids');
            $tbl->integer('tag_ids');
            $tbl->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
