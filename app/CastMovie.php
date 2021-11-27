<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CastMovie extends Pivot
{
    protected $table = 'cast_movies';
    public $incrementing = true;

    public function cast(){
        return $this->belongsTo('App\Cast', 'cast_id');
    }
}
