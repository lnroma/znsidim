<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserPhoto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // create photoalbum
        Schema::create('photo_directories', function ($tbl) {
            $tbl->increments('id');
            $tbl->text('title');
            $tbl->text('description');
            $tbl->integer('user_id');
            $tbl->string('password')->nullable();
            $tbl->string('storage_path');
            $tbl->string('alias');
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
        Schema::drop('photo_directories');
    }
}
