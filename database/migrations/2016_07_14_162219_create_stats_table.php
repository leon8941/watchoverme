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
            $table->string("MeleeFinalBlows");
            $table->string("SoloKills");
            $table->string("ObjectiveKills");
            $table->string("FinalBlows");
            $table->string("DamageDone");
            $table->string("Eliminations");
            $table->string("EnvironmentalKills");
            $table->string("Multikills");
            $table->string("HealingDone");
            $table->string("TeleporterPadsDestroyed");
            $table->string("Eliminations_MostinGame");
            $table->string("FinalBlows_MostinGame");
            $table->string("DamageDone_MostinGame");
            $table->string("HealingDone_MostinGame");
            $table->string("DefensiveAssists_MostinGame");
            $table->string("OffensiveAssists_MostinGame");
            $table->string("ObjectiveKills_MostinGame");
            $table->string("ObjectiveTime_MostinGame");
            $table->string("Multikill_Best");
            $table->string("SoloKills_MostinGame");
            $table->string("TimeSpentonFire_MostinGame");
            $table->string("MeleeFinalBlows_Average");
            $table->string("TimeSpentonFire_Average");
            $table->string("SoloKills_Average");
            $table->string("ObjectiveTime_Average");
            $table->string("ObjectiveKills_Average");
            $table->string("HealingDone_Average");
            $table->string("FinalBlows_Average");
            $table->string("Deaths_Average");
            $table->string("DamageDone_Average");
            $table->string("Eliminations_Average");
            $table->string("Deaths");
            $table->string("EnvironmentalDeaths");
            $table->string("Cards");
            $table->string("Medals");
            $table->string("Medals_Gold");
            $table->string("Medals_Silver");
            $table->string("Medals_Bronze");
            $table->string("GamesWon");
            $table->string("GamesPlayed");
            $table->string("TimeSpentonFire");
            $table->string("ObjectiveTime");
            $table->string("TimePlayed");
            $table->string("MeleeFinalBlow_MostinGame");
            $table->string("DefensiveAssists");
            $table->string("DefensiveAssists_Average");
            $table->string("OffensiveAssists");
            $table->string("OffensiveAssists_Average");

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
