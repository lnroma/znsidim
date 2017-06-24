<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserPhotoImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('photos', function ($tbl) {
            $tbl->increments('id');
            $tbl->text('description');
            $tbl->integer('directory_id');
            $tbl->integer('user_id');
            $tbl->string('url');
            $tbl->string('file_name');
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
        Schema::drop('photos');
    }
}
