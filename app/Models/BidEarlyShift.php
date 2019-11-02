<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidEarlyShift extends Model
{
    
    //
    public function bid() {
        return $this->belongsTo('App\Models\Bid');
    }
}
