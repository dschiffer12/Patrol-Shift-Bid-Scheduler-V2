<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiddingSchedule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start_day', 'end_day', 'response_time', 'save_as_template', 'currently_active'
    ];

    /**
     * The shift that belong to the bidding schedule.
     */
    public function shift()
    {
        return $this->belongsToMany('App\Models\Shift')->withPivot('bidding_schedule_id', 'shift_id')->withTimestamps();
    }

    public function shifts()
    {
        return $this->belongsToMany('App\Models\Shift');
    }

    /**
     * Get the bidding queue that owns the bidding schedule.
     */
    public function biddingqueue()
    {
        return $this->belongsTo('App\Models\BiddingQueue');
    }

    /**
     * Get the bidding queue that owns the bidding schedule.
     */
    public function bid()
    {
        return $this->belongsTo('App\Models\Bid');
    }
}
