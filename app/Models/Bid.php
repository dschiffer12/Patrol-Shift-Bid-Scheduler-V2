<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    //
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function bidEarlyShift() {
        return $this->hasOne('App\Models\BidEarlyShift');
    }

    public function hasAnyBidEarlyShift() {
        return null !== $this->bidEarlyShift()->first();
    }

    public function biddingSchedule() {
        return $this->hasOne('App\Models\BiddingSchedule');
    }

    public function shift() {
        return $this->hasOne('App\Models\Shift');
    }
}
