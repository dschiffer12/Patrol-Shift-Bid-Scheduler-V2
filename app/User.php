<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'role', 'date_in_position', 'specialties', 'notes', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * For the User/Roles relation.
     * Returns the roles associated witht this user.
     */
    public function roles() {
        return $this->belongsToMany('App\Role');
    }

    /**
     * To calidating user/roles level.
     * Returns the first role associated witht this user, or null if none.
     */
    public function hasAnyRoles($roles) {
        return null !== $this->roles()->whereIn('name', $roles)->first();
    }

    /**
     * To validate user/roles level
     */
    public function hasAnyRole($role) {
        return null !== $this->roles()->where('name', $role)->first();
    }

    /**
     * For the User/Specialty relation (user belongs to many roles)
     */
    public function specialties() {
        return $this->belongsToMany('App\Specialty');
    }

    /**
     * To validate user/specialty level
     */
    public function hasAnySpecialty($specialty) {
        return null !== $this->specialties()->where('name', $specialty)->first();
    }

    /**
     * For the User/Bid relationship
     */
    public function bids() {
        return $this->hasMany('App\Models\Bid');
    }

    /**
     * To test if User has any bids
     */
    public function hasAnyBids() {
        return null !== $this->bids()->first();
    }

    /**
     * To test if User has a specific bid
     */
    public function alreadyBid($schedule_id) {
        return null !== $this->bids()->where('bidding_schedule_id', $schedule_id)->first();
    }

    /**
     * For the User/BiddingQueue relationship
     */
    public function biddingQueue() {
        return $this->hasMany('App\Models\BiddingQueue');
    }
    
    /**
     * For the User/BiddingQueue relationship
     */
    public function biddingQueues() {
        return $this->hasMany('App\Models\BiddingQueue');
    }

    /**
     * To test if User has any BiddingQueue
     */
    public function hasAnyBiddingQueue() {
        return null !== $this->biddingQueue()->first();
    }

    /**
     * To test if User has a specific Schedule in the BiddingQueue
     */
    public function hasBiddingQueue($schedule_id) {
        return null !== $this->biddingQueue()->where('bidding_schedule_id', $schedule_id)->first();
    }

    /**
     * For the User/Officer relation (officer belongs to one user)
     */
    public function officer()
    {
        return $this->hasOne('App\Models\Officer');
    }

    /**
     * Get the bidding queue that owns the user.
     */
    public function bidding_queue()
    {
        return $this->hasMany('App\Models\BiddingQueue');
    }

}
