<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Movie extends Model
{

    protected $guarded = [];

    public function path()
    {
        return url("/movies/{$this->id}" . Str::slug($this->title));
    }

    public function casts(){
        return $this->belongsToMany('App\Cast', 'cast_movies')->withPivot(['role'])->withTimestamps();
    }
    public function crews(){
        return $this->belongsToMany('App\Crew', 'crew_movies')->withPivot(['designation'])->withTimestamps();
    }

    public function genres(){
        return $this->belongsToMany('App\Genre', 'genre_movies')->withTimestamps();
    }

    public function posters(){
        return $this->hasMany('App\MoviePoster', 'movie_id');
    }

    public function iframes(){
        return $this->hasMany('App\Iframe', 'movie_id');
    }

    public function distributor(){
        return $this->belongsTo('App\Distributor', 'distributor_id');
    }

    public function rentedBillings(){
        return $this->hasMany('App\RentedMovieBilling', 'movie_id');
    }
}
