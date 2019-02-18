<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // Indicate table to use (Indicar que tabla se usa de la base de datos)
    protected $table = 'comments';

    /*
     * Relation Many to One "Users" (muchos a uno)
     */
    public function user()
    {
        // Course: return $this->belongsTo('App\User');
        return $this->belongsTo(User::class, 'user_id');
    }

    /*
     * Relation Many to One "Users" (muchos a uno)
     */
    public function image()
    {
        // Course: return $this->belongsTo('App\Image');
        return $this->belongsTo(Image::class, 'image_id');
    }
}
