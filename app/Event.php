<?php

namespace App;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

class Event extends Model implements SluggableInterface
{
    use SluggableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'url',
        'from',
        'streamer',
        'cover',
        'description',
        'streamer',
        'starts',
        'checkin',
        'spots',
        'image'
    ];

    public static $regions = [
        'USA',
        'South America',
        'Brasil',
        'Europe',
        'Asia'
    ];

    public static $flags = [
        'flag-icon-us',
        'South America',
        'flag-icon-br',
        'Europe',
        'flag-icon-kr'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at','updated_at','deleted_at', 'starts'];

    protected $sluggable = array(
        'build_from' => 'title',
        'save_to'    => 'slug',
    );
}
