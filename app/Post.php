<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model implements SluggableInterface {


    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
    ];

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['created_at','updated_at','deleted_at'];

    protected $table    = 'posts';
    
    protected $fillable = [
          'title',
          'author_id',
          'texto'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post image.
     *
     * @param  string  $value
     * @return string
     */
    public function getImageAttribute($value)
    {
        return 'uploads/' . $value;
    }
    
}