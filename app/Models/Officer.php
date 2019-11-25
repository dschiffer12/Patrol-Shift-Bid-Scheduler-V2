<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'unit_number', 'emergency_number', 'vehicle_number', 'zone'
    ];

    /**
     * One to One relation with User Model
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
