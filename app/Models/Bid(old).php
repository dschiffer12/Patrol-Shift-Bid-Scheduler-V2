<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidOld extends Model
{
    //Model Bid has a bid schedule
    public function bidingschedule()
    {
        return $this->hasOne('App\Models\BiddingSchedule');
    }

    //Model Bid has a bid shift
    public function bidshift()
    {
        return $this->hasOne('App\Models\BidShift');
    }

    //Model Bid has a bid early shift
    public function bidearlyshift()
    {
        return $this->hasOne('App\Models\BidEarlyShift');
    }
}
