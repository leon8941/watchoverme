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
          'author_id',
          'texto'
    ];
    

    public static function boot()
    {
        parent::boot();

        Posts::observe(new UserActionsObserver);
    }
    
    
    
    
}