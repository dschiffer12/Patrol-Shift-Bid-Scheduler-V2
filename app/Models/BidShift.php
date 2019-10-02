<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidShift extends Model
{
    /**
     * Get bid that owns the bid shift.
     */
    public function bid()
    {
        return $this->belongsTo('App\Models\Bid');
    }
}
