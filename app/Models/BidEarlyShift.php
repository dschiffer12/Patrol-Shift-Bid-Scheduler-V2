<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidEarlyShift extends Model
{
    /**
     * Get bid that owns the bid early shift.
     */
    public function bid()
    {
        return $this->belongsTo('App\Models\Bid');
    }
}
