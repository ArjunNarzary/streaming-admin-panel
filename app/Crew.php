<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Crew extends Model
{
    protected $guarded = [];

    public function movies(){
        $this->belongsToMany('App\Movie', 'crew_movies')->withPivot(['designation'])->withTimestamps();
    }

    public function series(){
        $this->belongsToMany('App\Series', 'series_crews')->withPivot(['designation'])->withTimestamps();
    }
}
