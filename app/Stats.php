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
        "competitive",
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
        "Eliminations-MostinGame",
        "FinalBlows-MostinGame",
        "DamageDone-MostinGame",
        "HealingDone-MostinGame",
        "DefensiveAssists-MostinGame",
        "OffensiveAssists-MostinGame",
        "ObjectiveKills-MostinGame",
        "ObjectiveTime-MostinGame",
        "Multikill-Best",
        "SoloKills-MostinGame",
        "TimeSpentonFire-MostinGame",
        "MeleeFinalBlows-Average",
        "TimeSpentonFire-Average",
        "SoloKills-Average",
        "ObjectiveTime-Average",
        "ObjectiveKills-Average",
        "HealingDone-Average",
        "FinalBlows-Average",
        "Deaths-Average",
        "DamageDone-Average",
        "Eliminations-Average",
        "Deaths",
        "EnvironmentalDeaths",
        "Cards",
        "Medals",
        "Medals-Gold",
        "Medals-Silver",
        "Medals-Bronze",
        "GamesWon",
        "GamesPlayed",
        "TimeSpentonFire",
        "ObjectiveTime",
        "TimePlayed",
        "MeleeFinalBlow-MostinGame",
        "DefensiveAssists",
        "DefensiveAssists-Average",
        "OffensiveAssists",
        "OffensiveAssists-Average",
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
