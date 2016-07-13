<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Model::unguard();
        Schema::create('teams',function(Blueprint $table){
            $table->increments("id");
            $table->string("title");
            $table->string("image")->nullable();
            $table->text("description")->nullable();
            $table->integer("user_id")->references("id")->on("user"); // Captain

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('teams');
    }
}
