<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SeasonCast extends Pivot
{
    protected $table = 'season_casts';
    public $incrementing =  true;

    public function cast(){
        return $this->belongsTo('App\Cast', 'cast_id');
    }

    public function season(){
        return $this->belongsTo('App\Season', 'season_id');
    }

    public function rentedBillings(){
        return $this->hasMany('App\RentedSeriesBilling', 'season_id');
    }

}
