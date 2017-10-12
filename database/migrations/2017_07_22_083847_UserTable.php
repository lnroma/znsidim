<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_tables', function ($tbl) {
            $tbl->increments('id');
            $tbl->integer('user_id');
            $tbl->integer('user_tables_id');
            $tbl->boolean('is_enabled');
            $tbl->boolean('is_delete');
            $tbl->text('name');
            $tbl->text('comment');
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
