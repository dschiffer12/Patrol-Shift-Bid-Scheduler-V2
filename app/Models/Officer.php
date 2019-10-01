<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{

    /**
     * One to One relation with User Model
     */
    public function user()
    {
        $this->hasOne('App\User');
    }
}
