<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\Model;

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
            $table->string("slug");
            $table->string("image")->nullable();
            $table->text("description")->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('team_user',function(Blueprint $table){

            $table->unsignedInteger("user_id");
            $table->unsignedInteger("team_id");

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('request_team',function(Blueprint $table){

            $table->unsignedInteger("user_id");
            $table->unsignedInteger("team_id");
            $table->boolean("aproved")->default(0);

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
        Schema::drop('team_user');
        Schema::drop('request_team');
    }
}
