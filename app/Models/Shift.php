<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    /**
     * EarlyShift belongs to Shift
     */
    public function earlyshift()
    {
        return $this->belongsTo('App\Models\EarlyShift');
    }

    /**
     * The bidding schedule that belong to the shift.
     */
    public function shift()
    {
        return $this->belongsToMany('App\Models\BiddingSchedule');
    }
}
