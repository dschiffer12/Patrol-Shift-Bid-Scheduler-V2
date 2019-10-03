<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiddingQueue extends Model
{
    /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
    protected $fillable = [
        'bidding_spot', 'waiting_to_bid', 'bidding', 'bid_submitted', 'start_time_bidding', 'end_time_bidding'
    ];

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
