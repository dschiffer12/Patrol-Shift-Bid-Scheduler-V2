<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    //
    public function user() {
        return $this->belongsTo('App\User');
    }

    
    public function schedule() {
        return $this->belongsTo('App\Schedule');
    }

    public function spot() {
        return $this->belongsTo('App\Spot');
    }

    public function biddingQueue() {
        return $this->belongsTo('App\BiddingQueue');
    }
    
}
