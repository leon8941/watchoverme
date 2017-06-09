<?php

namespace App;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use App\Role;
use Illuminate\Support\Facades\Auth;
use Laraveldaily\Quickadmin\Observers\UserActionsObserver;
use Laraveldaily\Quickadmin\Traits\AdminPermissionsTrait;

class User extends Model implements AuthenticatableContract, SluggableInterface,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, AdminPermissionsTrait, SluggableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'role_id','twitch','twitch_followers','twitch_views',
        'twitch_status','twitch_logo','twitch_banner','twitch_title'];

    protected $sluggable = array(
        'build_from' => 'name',
        'save_to'    => 'slug',
    );

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public static function boot()
    {
        parent::boot();

        User::observe(new UserActionsObserver);
    }

    // Avatar images dir
    public static $avatar_dir = 'uploads/users/';

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the comments for the blog post.
     */
    public function gamer()
    {
        return $this->hasOne('App\Gamer');
    }

    /**
     * Get the comments for the blog post.
     */
    public function stats()
    {
        return $this->hasOne('App\Stats');
    }

    /**
     * Get the comments for the blog post.
     */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function team()
    {
        return $this->belongsToMany(Team::class,'team_user');
    }

    public function request()
    {
        return $this->hasMany(Request::class);
    }

    public function scopeColaborator($query)
    {
        return $query->where('role_id','>','1');
    }

    /*
    * Is this logged user on this team?
    */
    public static function isOnTeam($team_id)
    {
        if (!Auth::check())
            return false;

        foreach(Auth::user()->team()->get() as $team) {

            if ($team->id == $team_id)
                return true;
        }

        return false;
    }

    ////
}
