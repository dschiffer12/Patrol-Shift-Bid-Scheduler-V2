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

    
}
