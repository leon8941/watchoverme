<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gamer extends Model
{
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
