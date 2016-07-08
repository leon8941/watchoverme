<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laraveldaily\Quickadmin\Observers\UserActionsObserver;


use Illuminate\Database\Eloquent\SoftDeletes;

class Posts extends Model {

    use SoftDeletes;

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = ['deleted_at'];

    protected $table    = 'posts';
    
    protected $fillable = [
          'title',
          'image',
          'text',
          'user_id'
    ];
    

    public static function boot()
    {
        parent::boot();

        Posts::observe(new UserActionsObserver);
    }


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