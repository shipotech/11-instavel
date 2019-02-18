<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    // Indicate table to use (Indicar que tabla se usa de la base de datos)
    protected $table = 'images';

    /*
     * Relation One to Many "Comments" (uno a muchos)
     */
    public function comments()
    {
        // Course: return $this->hasMany('App\Comment');
        return $this->hasMany(Comment::class);
    }

    /*
     * Relation One to Many "Likes"
     */
    public function likes()
    {
        // Course: return $this->hasMany('App\Like');
        return $this->hasMany(Like::class);
    }
    
    /*
     * Relation Many to One "Users" (muchos a uno)
     */
    public function user()
    {
        // Course: return $this->belongsTo('App\User');
        return $this->belongsTo(User::class, 'user_id');
    }
}
