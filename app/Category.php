<?php

namespace App;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

class Category extends Model implements SluggableInterface
{
    use SluggableTrait;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at','created_at','updated_at'];

    protected $sluggable = array(
        'build_from' => 'title',
        'save_to'    => 'slug',
    );

    //
    public static $image_dir = 'uploads/';

    protected $fillable = [
        'title',
        'slug',
        'user_id',
        'description',
        'image'
    ];

    public function posts()
    {
        return $this->belongsToMany('App\Post');
    }

    public static function getList()
    {
        return Category::get();
        //return Category::lists('title','id');
    }
}
