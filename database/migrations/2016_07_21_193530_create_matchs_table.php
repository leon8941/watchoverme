<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Model::unguard();
        Schema::create('matchs',function(Blueprint $table){
            $table->increments("id");
            $table->unsignedInteger("user_id"); // Criador
            $table->smallInteger("status"); // 1 - aberta, 2 - picking, 3 - jogando , 4 - encerrada, 5 - contestada,
            $table->string("winner")->nullable(); // Time A ou B

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('gamer_match',function(Blueprint $table){
            $table->increments("id");
            $table->unsignedInteger("gamer_id");
            $table->unsignedInteger("match_id");
            $table->string("team")->nullable(); // Time A ou B

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('matchs');
        Schema::drop('gamer_match');
    }
}
