<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EarlyShift extends Model
{
    /**
     * One to One with Shift Model
     */
    public function shift()
    {
        return $this->hasOne('App\Models\Shift');
    }
}
