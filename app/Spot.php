<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spot extends Model
{
    /**
     * Get the Shift that owns the spot.
     */
    public function shift()
    {
        return $this->belongsTo('App\Shift');
    }
}
