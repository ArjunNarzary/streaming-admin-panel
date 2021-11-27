<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cast extends Model
{
    protected $guarded = [];

    public function movies(){
        return $this->belongsToMany('App\Movies', 'cast_movies')->withPivot(['role'])->withTimestamps();
    }

    public function seasons(){
        return $this->belongsToMany('App\Season', 'season_casts')->withPivot(['role'])->withTimestamps();
    }
}
