<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'spot_id', 'approved', 'bidding_queue_id'
    ];

    /**
     * Returns the user associated witht this bid.
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Returns the schedule associated witht this bid.
     */
    public function schedule() {
        return $this->belongsTo('App\Schedule');
    }

    /**
     * Returns the spot associated witht this bid.
     */
    public function spot() {
        return $this->belongsTo('App\Spot');
    }

    /**
     * Returns the queue associated witht this bid.
     */
    public function biddingQueue() {
        return $this->belongsTo('App\BiddingQueue');
    }
    
}
