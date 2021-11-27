<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoviePoster extends Model
{
    protected $guarded = [];

    public function ofMovie(){
        return $this->belongsTo('App\Movie', 'movie_id');
    }
}
