<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'start_date', 'end_date', 'response_time', 'currently_active', 'template',
    ];


    /**
     * Schedule / Shift relationship: One to Many
     * Get the shifts that belong to this schedule.
     */
    public function shifts() {
        return $this->hasMany('App\Shift');
    }

    /**
     * Schedule / Bidding_Queues relationship: One to Many
     * Get the queues that belong to this schedule.
     */
    public function biddingQueues() {
        return $this->hasMany('App\Models\BiddingQueue');
    }
}
