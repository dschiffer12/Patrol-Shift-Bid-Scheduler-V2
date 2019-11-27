<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spot extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shift_id', 'qty_available', 'friday_s', 'friday_e',
    ];


    /**
     * Get the Shift that owns the spot.
     */
    public function shift()
    {
        return $this->belongsTo('App\Shift');
    }

    /**
     * Returns the bids associated witht this spot.
     */
    public function bids() {
        return $this->hasMany('App\Models\Bid');
    }
}
