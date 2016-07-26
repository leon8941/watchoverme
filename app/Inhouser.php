<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Inhouser extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gamer_id',
        'status',
        'wins',
        'lost',
        'rating',
        'last_online',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at','created_at','last_online'];

    public function gamer()
    {
        return $this->belongsTo('App\Gamer');
    }

    // Get only whos online
    public function scopeOnline($query)
    {
        $date = new \DateTime();
        $date->modify('-5 minutes');
        $formatted_date = $date->format('Y-m-d H:i:s');

        return $query->where('last_online','>',$formatted_date);
    }

    /**
     * Checks if current user have Inhouse account
     *
     * @return bool
     */
    public static function isInhouser($checksIfCanPlay = false)
    {
        if (!Auth::check())
            return false;

        // does this user have an inhouser?
        $gamer = Gamer::where('user_id',Auth::user()->id)->firstOrFail();

        if (!isset($gamer->inhouser) || $gamer->inhouser == null)
            return false;

        if ($gamer->inhouser) {

            // checks if can play?
            if ($checksIfCanPlay)
                return $gamer->inhouser->canPlay();

            return true;
        }

        return false;
    }

    /**
     * Checks if an inhouse user can play
     */
    public function canPlay()
    {
        // is banned?
        return $this->status != '4';
    }

    /**
     * User goes online on inhouse
     */
    public static function goOnline()
    {
        $gamer = Gamer::where('user_id',Auth::user()->id)->firstOrFail();

        return Inhouser::where('gamer_id',$gamer->id)
                ->update(['last_online' => 'NOW()']);
    }

    public static function getVouchs()
    {
        $gamer = Gamer::get();

        if (!$gamer)
            return 0;

        $inhouser = Inhouser::where('gamer_id',$gamer->id)
            ->first();

        return $inhouser->vouchs;
    }
}
