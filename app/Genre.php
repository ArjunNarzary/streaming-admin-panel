<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $guarded = [];

    public function movies(){
        return $this->belongsToMany('App\Movie', 'genre_movies')->withTimestamps();
    }

    public function series(){
        return $this->belongsToMany('App\Series', 'series_genres')->withTimestamps();
    }
}
