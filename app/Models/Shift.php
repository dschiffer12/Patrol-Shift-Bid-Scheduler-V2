<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'minimun_staff'
    ];

    /**
     * EarlyShift belongs to Shift
     */
    public function early_shift()
    {
        return $this->hasOne('App\Models\EarlyShift');
    }

    /**
     * The bidding schedule that belong to the shift.
     */
    public function biddingschedules()
    {
        return $this->belongsToMany('App\Models\BiddingSchedule');
    }
}
