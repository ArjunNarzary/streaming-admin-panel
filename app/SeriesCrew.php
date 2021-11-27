<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SeriesCrew extends Pivot
{
    protected $table = 'series_crews';
    public $incrementing = true;

    public function crew(){
        return $this->belongsTo('App\Crew', 'crew_id');
    }
}
