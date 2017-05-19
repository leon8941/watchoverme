<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stats extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'stats';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "user_id",
        "mode",
        "MeleeFinalBlows",
        "SoloKills",
        "ObjectiveKills",
        "FinalBlows",
        "DamageDone",
        "Eliminations",
        "EnvironmentalKills",
        "Multikills",
        "HealingDone",
        "TeleporterPadsDestroyed",
        "Eliminations_MostinGame",
        "FinalBlows_MostinGame",
        "DamageDone_MostinGame",
        "HealingDone_MostinGame",
        "DefensiveAssists_MostinGame",
        "OffensiveAssists_MostinGame",
        "ObjectiveKills_MostinGame",
        "ObjectiveTime_MostinGame",
        "Multikill_Best",
        "SoloKills_MostinGame",
        "TimeSpentonFire_MostinGame",
        "MeleeFinalBlows_Average",
        "TimeSpentonFire_Average",
        "SoloKills_Average",
        "ObjectiveTime_Average",
        "ObjectiveKills_Average",
        "HealingDone_Average",
        "FinalBlows_Average",
        "Deaths_Average",
        "DamageDone_Average",
        "Eliminations_Average",
        "Deaths",
        "EnvironmentalDeaths",
        "Cards",
        "Medals",
        "Medals_Gold",
        "Medals_Silver",
        "Medals_Bronze",
        "GamesWon",
        "GamesPlayed",
        "TimeSpentonFire",
        "ObjectiveTime",
        "TimePlayed",
        "MeleeFinalBlow_MostinGame",
        "DefensiveAssists",
        "DefensiveAssists_Average",
        "OffensiveAssists",
        "OffensiveAssists_Average",
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
