<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('markets',function(Blueprint $table){
            $table->increments("id");
            $table->char("type",1); // (P)layer, (T)eam
            $table->char("action",1); // (I)n, (O)ut
            $table->unsignedInteger("user_id")->nullable(); //
            $table->unsignedInteger("team_id")->nullable(); //
            $table->text("description")->nullable(); //

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
        //
        Schema::drop('markets');
    }
}
