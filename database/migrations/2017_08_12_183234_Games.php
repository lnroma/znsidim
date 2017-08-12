<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Games extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('games', function ($tbl) {
            $tbl->increments('id');
            $tbl->text('name');
            $tbl->text('description_top');
            $tbl->text('description_bottom');
            $tbl->text('short_description');
            $tbl->text('type');
            $tbl->text('rom_url');
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
