<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Gamer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'battletag',
        'win_percentage',
        'wins',
        'lost',
        'played',
        'playtime',
        'avatar',
        'username',
        'level',
        'quick_wins',
        'quick_lost',
        'quick_played',
        'competitive_wins',
        'competitive_lost',
        'competitive_played',
        'competitive_playtime',
        'quick_playtime',
        'avatar',
        'competitive_rank',
        'competitive_rank_img',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function inhouser()
    {
        return $this->hasOne('App\Inhouser');
    }

    // Matchs
    public function matchs()
    {
        return $this->belongsToMany('App\Match','gamer_match')->withPivot('team');
    }

    /**
     * Get users ranking of RH Staff
     */
    public static function getRanking()
    {
        return Gamer::orderBy('points', 'DESC')->get()->lists('points');
    }

    /**
     * Get a user rank position
     *
     * @param $user_id
     * @return bool
     */
    public static function getRankingPosition($user_id)
    {
        $user = Gamer::where('id', $user_id)->first();

        if (!$user->staff)
            return false;

        $users = Gamer::getRanking();

        // Search for his points in the ranking
        $key = $users->search( $user->points );

        return $key + 1;
    }

    // Get the current user gamer
    public static function getGamer()
    {
        $gamer = Gamer::where('user_id',Auth::user()->id)->first();

        if (!$gamer || $gamer->count() <= 0)
            return false;

        return $gamer;
    }

    /**
     * Is gamer in a match?
     *
     * @param $match_id
     * @param $gamer_id
     * @return mixed
     */
    public static function isOnMatch($match_id, $gamer_id)
    {
        $exists = DB::table("gamer_match")
            ->where("match_id",$match_id)
            ->where('gamer_id', $gamer_id)
            ->first();

        return $exists? true : false;
    }
}
