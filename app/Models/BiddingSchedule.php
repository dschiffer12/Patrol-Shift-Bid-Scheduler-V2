<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiddingSchedule extends Model
{
    /**
     * The shift that belong to the bidding schedule.
     */
    public function shift()
    {
        $this->belongsToMany('App\Models\Shift');
    }

    /**
     * Get the bidding queue that owns the bidding schedule.
     */
    public function post()
    {
        return $this->belongsTo('App\Models\BiddingQueue');
    }
}
