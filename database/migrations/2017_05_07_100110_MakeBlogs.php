<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeBlogs extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('user_blogs', function ($tbl) {
            $tbl->increments('id');
            $tbl->integer('user_id');
            $tbl->boolean('is_enable');
            $tbl->text('content');
            $tbl->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('user_blogs');
    }
}
