<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    protected $guarded = [];
    protected $connection = 'mysql';

    public function adminTable(){
        return $this->belongsTo('App\Admin', 'user_id');
    }

    public function moviesDistributed(){
        return $this->hasMany('App\Movie', 'distributor_id');
    }

    public function seasonsDistributed(){
        return $this->hasMany('App\Seasn', 'distributor_id');
    }
}
