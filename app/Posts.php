<?php

namespace App;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;
use Laraveldaily\Quickadmin\Observers\UserActionsObserver;


use Illuminate\Database\Eloquent\SoftDeletes;

class Posts extends Model implements SluggableInterface {

    use SoftDeletes;
    use SluggableTrait;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at','created_at','updated_at'];

    protected $table    = 'posts';

    public static $image_dir = 'uploads/';

    protected $fillable = [
          'title',
          'image',
          'text',
          'user_id',
        'description'
    ];

    protected $sluggable = array(
        'build_from' => 'title',
        'save_to'    => 'slug',
    );

    public static function boot()
    {
        parent::boot();

        Posts::observe(new UserActionsObserver);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    /**
     * Get the post image.
     *
     * @param  string  $value
     * @return string

    public function getImageAttribute($value)
    {
        return $value;
    }*/
    
    
    
}