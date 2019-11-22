<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    /**
     * User / specialty relationship: Many to Many
     * Get the users with this specialty.
     */
    public function users() {
        return $this->belongsToMany('App\User');
    }

    /**
     * Specialty / Shift relationship: One to Many
     * Get the shifts that belong to this specialty.
     */
    public function shifts() {
        return $this->hasMany('App\Shift');
    }


}
