<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\Model;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Model::unguard();
        Schema::create('categories',function(Blueprint $table){
            $table->increments("id");
            $table->string("title");
            $table->string("slug");
            $table->string("image")->nullable();
            $table->text("description")->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('category_posts',function(Blueprint $table){

            $table->unsignedInteger("category_id");
            $table->unsignedInteger("posts_id");

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
        Schema::drop('categories');
        Schema::drop('category_posts');
    }
}
