<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiddingQueue extends Model
{
    /**
     * Get the users for the bidding queue.
     */
    public function user()
    {
        return $this->hasMany('App\User');
    }

    /**
     * Get the bidding schedule for the bidding queue.
     */
    public function biddingschedure()
    {
        return $this->hasMany('App\Models\BiddingSchedule');
    }
}
