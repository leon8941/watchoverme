<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Request extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'request_team';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'team_id', 'aproved'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /*
     * Checks if a user has made a request on this team
     */
    public static function userCanRequest($team_id)
    {
        if (!Auth::check())
            return false;

        $request = Request::where('user_id',Auth::user()->id)
            ->where('team_id',$team_id)
            ->where('aproved','<>','1')
            ->first();

        if ($request)
            return false;

        return true;
    }
}
