<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SeriesGenre extends Pivot
{
    protected $table = 'series_genres';
    public $incrementing = true;

    public function genre(){
        return $this->belongsTo('App\Genre', 'genre_id');
    }
}
