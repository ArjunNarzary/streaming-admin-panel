<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CrewMovie extends Pivot
{
    protected $table = 'crew_movies';
    public $incrementing = true;

    public function crew(){
        return $this->belongsTo('App\Crew', 'crew_id');
    }
}
