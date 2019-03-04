<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role', 'name', 'surname', 'nick', 'email', 'password', 'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
      * Relation One to Many "Images"
      */
    public function images()
    {
        // Course: return $this->hasMany('App\Image');
        return $this->hasMany(Image::class);
    }

    /**
     * Relation One to Many "likes"
     */
    public function likes()
    {
        // Course: return $this->hasMany('App\Like');
        return $this->hasMany(Like::class);
    }

    /**
     * Relation One to Many "comments"
     */
    public function comments()
    {
        // Course: return $this->hasMany('App\Comment');
        return $this->hasMany(Comment::class);
    }

}
