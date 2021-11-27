<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $guarded = [];

    public function crews(){
        return $this->belongsToMany('App\Crew', 'series_crews')->withPivot(['designation'])->withTimestamps();
    }

    public function genres(){
        return $this->belongsToMany('App\Genre', 'series_genres')->withTimestamps();
    }

    public function posters(){
        return $this->hasMany('App\SeriesPoster', 'series_id');
    }

    public function seasons(){
        return $this->hasMany('App\Season', 'series_id');
    }
}
