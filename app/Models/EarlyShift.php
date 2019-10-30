<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EarlyShift extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
    **/
    protected $fillable = [
        'early_start_time', 'early_end_time', 'num_early_spot'
    ];

    /**
     * One to One with Shift Model
     */
    public function shift()
    {
        return $this->belongsTo('App\Models\Shift');
    }
}
