<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RentedSeriesBilling extends Model
{
    protected $table = 'rented_series_billings';
    // protected $connection = 'mysql';

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function season(){
        return $this->belongsTo('App\Season', 'season_id');
    }
}
