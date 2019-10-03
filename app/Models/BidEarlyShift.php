<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidEarlyShift extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'friday', 'saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday'
    ];

    /**
     * Get bid that owns the bid early shift.
     */
    public function bid()
    {
        return $this->belongsTo('App\Models\Bid');
    }
}
