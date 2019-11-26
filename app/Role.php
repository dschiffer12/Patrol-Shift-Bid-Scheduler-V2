<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * Returns the users associated witht this role.
     */
    public function users() {
        return $this->belongsToMany('App\User');
    }
}
