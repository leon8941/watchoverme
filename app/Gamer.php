<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsTo(User::class);
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
}
