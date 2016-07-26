<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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


}
