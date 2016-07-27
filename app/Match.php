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
}
