<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInhousersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inhousers',function(Blueprint $table){
            $table->increments("id");
            $table->unsignedInteger("gamer_id"); // Criador
            $table->smallInteger("status"); // 1 - jogador, 4 - ban
            $table->smallInteger("wins")->nullable()->default('0');
            $table->smallInteger("lost")->nullable()->default('0');
            $table->unsignedInteger("rating")->default('1500');

            $table->unsignedInteger("voucher_id")->default('2'); // who vouched him?
            $table->smallInteger("vouchs")->default('1'); // vouchs to give

            $table->dateTime("last_online"); // user online?

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
        Schema::drop('inhousers');
    }
}
