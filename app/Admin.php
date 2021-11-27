<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasRoles;

    protected $guarded = [];
    protected $connection = 'mysql2';

    public function distributor(){
        return $this->hasOne('App\Distributor', 'user_id');
    }

    public function moviesAdded(){
        return $this->hasMany('App\Movie', 'getthrills_streaming.distributors', 'distributor_id');
    }

    public function seasonsAdded(){
        return $this->hasMany('App\Season', 'getthrills_streaming.distributors', 'distributor_id');
    }
}
