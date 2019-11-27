<?php

namespace App\Mail;

use App\User;
use App\Schedule;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $biddingSchedule;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Schedule $biddingSchedule)
    {
        $this->user = $user;
        $this->biddingSchedule = $biddingSchedule;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('bidnotification')->with([
            'user' => $this->user,
            'schedule' => $this->biddingSchedule

        ]);
    }
}
