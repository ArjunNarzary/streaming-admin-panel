<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $guarded = [];
    protected $connection = 'mysql';

    public function series(){
        return $this->belongsTo('App\Series', 'series_id');
    }

    public function casts(){
        return $this->belongsToMany('App\Cast', 'season_casts')->withPivot(['role'])->withTimestamps();
    }

    public function episodes(){
        return $this->hasMany('App\Episode', 'season_id');
    }

    public function rentedBillings(){
        return $this->hasMany('App\RentedSeriesBilling', 'season_id');
    }
}
