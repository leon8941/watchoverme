<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Match extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'matchs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'status', 'winner'];

    // Gamer
    public function gamers()
    {
        return $this->belongsToMany('App\Gamer','gamer_match')->withPivot('team');
    }

    // Partidas abertas
    public function scopeOpen($query)
    {
        return $query->where('status','1');
    }

    // Partidas em andamento
    public function scopeRunning($query)
    {
        return $query->where('status','3');
    }

    // Partidas encerradas
    public function scopeClosed($query)
    {
        return $query->where('status','4');
    }

    /**
     * is Match full ?
     *
     * @param $match_id
     * @return bool
     */
    public static function isFull($match_id)
    {
        // conta total de jogadores na partida
        $players = DB::table('gamer_match')
            ->select('id')
            ->where('match_id',$match_id)
            ->count();

        return ($players == 12)? true : false;
    }

    /**
     * Get all players in a match
     *
     * @param $match_id
     */
    public static function getPlayers($match_id)
    {
        return DB::table('gamer_match')
            ->where('match_id', $match_id)
            ->get();
    }

    /**
     * Count players in a match
     *
     * @param $match_id
     * @return mixed
     */
    public static function countPlayers($match_id)
    {
        return DB::table('gamer_match')
            ->where('match_id', $match_id)
            ->count();
    }

    /**
     * Get the lowest player of a match
     *
     * @param $match_id
     * @param bool|false $after
     * @return mixed
     */
    public static function getLowestPlayer($match_id, $after = false)
    {
        // After some rating?
        if (!$after) {
            $player = DB::select(
                    DB::raw("SELECT g.id FROM gamer_match gm
                        JOIN gamers g ON (g.id = gm.gamer_id)
                        JOIN inhousers i ON (i.gamer_id = gm.gamer_id)
                            WHERE i.rating = (
                                SELECT MIN(rating) FROM inhousers i
                                        JOIN gamer_match gm ON (gm.gamer_id = i.gamer_id)
                                        WHERE gm.match_id = '{$match_id}')"));
        }
        else {
            $player = DB::select(
                    DB::raw("SELECT g.id FROM gamer_match gm
                        JOIN gamers g ON (g.id = gm.gamer_id)
                        JOIN inhousers i ON (i.gamer_id = gm.gamer_id)
                            WHERE i.rating = (
                                SELECT MIN(rating) FROM inhousers i
                                        JOIN gamer_match gm ON (gm.gamer_id = i.gamer_id)
                                        WHERE gm.match_id = '{$match_id}' AND i.rating > '{$after}')"));
            }

        return $player;
    }

    /**
     * Get highest player of a match
     *
     * @param $match_id
     * @param $before
     * @return mixed
     */
    public static function getHighestPlayer($match_id, $before = false, $picked = false)
    {
        // After some rating?
        if (!$before) {
            $player = DB::select(
                DB::raw("SELECT g.id FROM gamer_match gm
                        JOIN gamers g ON (g.id = gm.gamer_id)
                        JOIN inhousers i ON (i.gamer_id = gm.gamer_id)
                            WHERE i.rating = (
                                SELECT MAX(rating) FROM inhousers i
                                        JOIN gamer_match gm ON (gm.gamer_id = i.gamer_id)
                                        WHERE gm.match_id = '{$match_id}')"));
        }
        else {
            $already_picked = implode(',',$picked);

            $player = DB::select(
                DB::raw("SELECT g.id FROM gamer_match gm
                        JOIN gamers g ON (g.id = gm.gamer_id)
                        JOIN inhousers i ON (i.gamer_id = gm.gamer_id)
                            WHERE i.rating = (
                                SELECT MAX(rating) FROM inhousers i
                                        JOIN gamer_match gm ON (gm.gamer_id = i.gamer_id)
                                        WHERE gm.match_id = '{$match_id}' AND i.rating <= '{$before}'
                                          AND i.id NOT IN ({$already_picked})
                                        )
                                        AND i.id NOT IN ({$already_picked})"));
        }

        return $player;
    }

    /**
     * Put a player on a team, in a specific match
     *
     * @param $gamer_id
     * @param $match_id
     * @param $team
     * @return mixed
     */
    public static function putPlayerOnTeam($gamer_id, $match_id, $team)
    {
        return DB::table('gamer_match')
            ->where('gamer_id', $gamer_id)
            ->where('match_id', $match_id)
            ->update([
                'team' => $team
            ]);
    }
}
