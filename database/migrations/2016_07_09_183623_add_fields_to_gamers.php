<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToGamers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gamers', function (Blueprint $table) {
            $table->string('level');
            $table->string('username');
            $table->unsignedInteger('quick_wins');
            $table->unsignedInteger('quick_lost');
            $table->unsignedInteger('quick_played');
            $table->unsignedInteger('competitive_wins');
            $table->unsignedInteger('competitive_lost');
            $table->unsignedInteger('competitive_played');
            $table->string('competitive_playtime');
            $table->string('quick_playtime');
            $table->string('competitive_rank');
            $table->string('competitive_rank_img');
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
