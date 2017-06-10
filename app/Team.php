<?php

namespace App;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

class Team extends Model implements SluggableInterface
{
    use SluggableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'slug', 'description', 'image','owner_id'];


    protected $sluggable = array(
        'build_from' => 'title',
        'save_to'    => 'slug',
    );

    // Avatar images dir
    public static $avatar_dir = 'uploads/teams/';

    public function users()
    {
        return $this->belongsToMany(User::class, 'team_user');
    }

    public function requests()
    {
        return $this->hasMany(Request::class)->orderBy('created_at','DESC');
    }
/*
    public function getImageAttribute($value)
    {
        return asset(Team::$avatar_dir . $value);
    }*/
}
