<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PhotoComment extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('photo_comments', function ($tbl) {
            $tbl->increments('id');
            $tbl->integer('user_id');
            $tbl->integer('user_photo_id');
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
        Schema::drop('photo_comments');
    }
}
