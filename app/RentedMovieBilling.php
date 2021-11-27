<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RentedMovieBilling extends Model
{
    protected $table = 'rented_movie_billings';

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function movie(){
        return $this->belongsTo('App\Movie', 'movie_id');
    }
}
