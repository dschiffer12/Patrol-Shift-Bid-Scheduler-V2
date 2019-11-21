<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailNotification;
use App\Schedule;
use App\Models\BiddingQueue;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Bid;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all schedules
        $user = Auth::user();
        $bids = $user->bids;

        // $schedules = new Schedule;

        // foreach($bids as $bid) {
        //     $sche = $bid->schedule;
        //     $sche->already_bid = true;
        //     $schedules->push($sche);      
        // }
        
        
        // $bidding_queues = $user->biddingQueues;

        // $bidding_queues = BiddingQueue::where('user_id', $user->id)
        //     ->where('bid_submitted', '<', 1)
        //     ->get();

        $bidding_queues = $user->biddingQueues;
                    
        // foreach($bidding_queues as $queue) {
        //     // dd($queue->schedule->name);
        //     // $sche = $queue->schedule;
        //     // $sche->queue = $queue;
        //     // $sche->test = true;
        //     // // $schedules->push($sche);
        //     // $schedules->ok = $sche;
        //     // dd($schedules);    
        // }

        // dd($bidding_queues);
        
        // dd($schedules);

        // foreach($schedules as $schedule) {
        //     dd($schedule);
        // }

    

        return view('user.schedules.index')->with([
            'bidding_queues' => $bidding_queues,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function bid($schedule) {

        $next = BiddingQueue::where('bidding_schedule_id', $validatedData['schedule_id'])
            ->where('bidding', 1)
            ->orderBy('bidding_spot', 'asc')
            ->first();
        
        if($next) {
            $nextUserToBid = $next->user;
            $schedule = BiddingSchedule::where(['id' => $validatedData['schedule_id']])->first();
            $emailSend = $this->sendEmail($nextUserToBid, $schedule);
        }
    }


    /**
     * Send Email to an user
     *
     * @param int $id User Id
     * @return boolean email sent result
    **/
    public function sendEmail(User $user, BiddingSchedule $schedule)
    {
        Mail::to($user)->send(new EmailNotification($user, $schedule));

        if (Mail::failures()) {
            return false;
        }else{
            return true;
        }
    }
}
