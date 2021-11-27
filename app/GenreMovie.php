<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GenreMovie extends Pivot
{
    protected $table = 'genre_movies';
    public $incrementing = true;

    public function genre(){
        return $this->belongsTo('App\Genre', 'genre_id');
    }

}
