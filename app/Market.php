<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    //


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'action', 'team_id', 'user_id', 'description'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Register new team on Market
     *
     * @param $team
     * @return static
     */
    public static function registerTeam($team)
    {
        return Market::create([
            'type' => 'T',
            'action' => 'I',
            'team_id' => $team->id,
            'description' => 'Time ' . $team->title . ' criado'
        ]);
    }

    /**
     * Register player action on team
     * @param $team_id
     * @param $user_id
     * @return static
     */
    public static function registerPlayer($team_id, $user_id, $action = 'I')
    {
        $user = User::where('id',$user_id)->first();

        $team = Team::where('id',$team_id)->first();

        $verbo = $action=='I'? ' entrou no time ' : ' saiu do time ';

        return Market::create([
            'type' => 'P',
            'action' => $action,
            'team_id' => $team_id,
            'user_id' => $user_id,
            'description' => $user->name . $verbo . $team->title
        ]);
    }
}
