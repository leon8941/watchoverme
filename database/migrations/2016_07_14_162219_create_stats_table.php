<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\Model;

class CreateStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Model::unguard();
        Schema::create('stats',function(Blueprint $table){
            $table->increments("id");
            $table->unsignedInteger("user_id");
            $table->string("mode")->default('competitive');
            $table->unsignedInteger("MeleeFinalBlows");
            $table->unsignedInteger("SoloKills");
            $table->unsignedInteger("ObjectiveKills");
            $table->unsignedInteger("FinalBlows");
            $table->unsignedInteger("DamageDone");
            $table->unsignedInteger("Eliminations");
            $table->unsignedInteger("EnvironmentalKills");
            $table->unsignedInteger("Multikills");
            $table->unsignedInteger("HealingDone");
            $table->unsignedInteger("TeleporterPadsDestroyed");
            $table->unsignedInteger("Eliminations-MostinGame");
            $table->unsignedInteger("FinalBlows-MostinGame");
            $table->unsignedInteger("DamageDone-MostinGame");
            $table->unsignedInteger("HealingDone-MostinGame");
            $table->unsignedInteger("DefensiveAssists-MostinGame");
            $table->unsignedInteger("OffensiveAssists-MostinGame");
            $table->unsignedInteger("ObjectiveKills-MostinGame");
            $table->unsignedInteger("ObjectiveTime-MostinGame");
            $table->unsignedInteger("Multikill-Best");
            $table->unsignedInteger("SoloKills-MostinGame");
            $table->unsignedInteger("TimeSpentonFire-MostinGame");
            $table->unsignedInteger("MeleeFinalBlows-Average");
            $table->unsignedInteger("TimeSpentonFire-Average");
            $table->unsignedInteger("SoloKills-Average");
            $table->unsignedInteger("ObjectiveTime-Average");
            $table->unsignedInteger("ObjectiveKills-Average");
            $table->unsignedInteger("HealingDone-Average");
            $table->unsignedInteger("FinalBlows-Average");
            $table->unsignedInteger("Deaths-Average");
            $table->unsignedInteger("DamageDone-Average");
            $table->unsignedInteger("Eliminations-Average");
            $table->unsignedInteger("Deaths");
            $table->unsignedInteger("EnvironmentalDeaths");
            $table->unsignedInteger("Cards");
            $table->unsignedInteger("Medals");
            $table->unsignedInteger("Medals-Gold");
            $table->unsignedInteger("Medals-Silver");
            $table->unsignedInteger("Medals-Bronze");
            $table->unsignedInteger("GamesWon");
            $table->unsignedInteger("GamesPlayed");
            $table->unsignedInteger("TimeSpentonFire");
            $table->unsignedInteger("ObjectiveTime");
            $table->unsignedInteger("TimePlayed");
            $table->unsignedInteger("MeleeFinalBlow-MostinGame");
            $table->unsignedInteger("DefensiveAssists");
            $table->unsignedInteger("DefensiveAssists-Average");
            $table->unsignedInteger("OffensiveAssists");
            $table->unsignedInteger("OffensiveAssists-Average");

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
        Schema::drop('stats');
    }
}
