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
use App\Shift;
use App\Spot;
use DateTime;


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

        $bidding_queues = $user->biddingQueues;
                    
        foreach($bidding_queues as $queue) {
            if($queue->bid_submitted > 0) {
                $bid = Bid::where('user_id', auth()->user()->id)
                    ->where('bidding_queue_id', $queue->id)
                    ->first();
                $queue->bid_id = $bid->id;
            }
        }

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


    public function bid($id) {

        $user = Auth::user();
        $specialties = $user->specialties;
        $schedule = Schedule::find($id);

        $shifts = $schedule->shifts;

        // $bidding_queues = BiddingQueue::where('user_id', $user->id)
        //     ->where('schedule_id', $schedule->id)
        //     ->get();

        foreach($specialties as $key => $specialty) {
            $shifts = Shift::where('schedule_id', $id)
                ->where('specialty_id', $specialty->id)
                ->get();
            $i = 0;
            foreach($shifts as $shift) {
                $spots = $shift->spots;
                $shift->push($spots);
                $i++;
            }

            // remove the specialty if there are no shits available
            if($i < 1) {
                $specialties->forget($key);
            }     
        } 

        return view('user.schedules.bid')->with([
            'specialties'=> $specialties,
            'schedule'=> $schedule,
        ]);

       
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $spot = Spot::find($request->spot_id);
        if($spot->qty_available < 1) {
            // redirect out with an error.
            return back()->withInput();
        }

        // dd($request);
        $bid = new Bid;
        $user = auth()->user();

        //need to fix this
        $shift = Shift::find($request->shift_id);
        $bidding_queue = BiddingQueue::where('user_id', $user->id)->where('schedule_id', $shift->schedule_id)->first();

        $date = new DateTime();
        // store the bid
        $bid->user_id = $user->id;
        $bid->spot_id = $request->spot_id;
        $bid->approved = false;
        $bid->created_at = $date;
        $bid->bidding_queue_id = $bidding_queue->id;
        $bid->save();

        $spot->decrement('qty_available');

        // update the bidding queue
        
        $bidding_queue->bidding = false;
        $bidding_queue->bid_submitted = true;
        $bidding_queue->save();


        // update the next user to bid
        $next_queues = BiddingQueue::where('schedule_id', $shift->schedule_id)
            ->where('bidding_spot', '>', $bidding_queue->bidding_spot)
            ->where('waiting_to_bid', true)
            ->orderBy('bidding_spot', 'asc')
            ->get();
        
        
        // find if there is another user waiting to bid on the same specialty
        foreach($next_queues as $queue) {
            $specialties = $queue->user->specialties;
            $i=0;
            foreach($specialties as $specialty) {
                if($specialty->id == $spot->shift->specialty_id) {
                    $queue->waiting_to_bid = false;
                    $queue->bidding = true;
                    $queue->start_time_bidding = $date;
                    $queue->save();

                    // // notify my email - disabled for now
                    // $user = $queue->user;
                    // $schedule = $queue->schedule;
                    // $emailSend = $this->sendEmail($user, $schedule);
                    $i++;
                    break;
                }
            } 

            if($i > 0) {
                break;
            }  
        }

        // echo('bid submitted');

        return view('user.schedules.index')->with('success', 'Bid submitted!!');

    }


    /**
     * View the bid
     */
    public function viewBid($id) {

        // dd($id);

        $bid = Bid::find($id);

        // dd($bid);

        $spot = $bid->spot;
        // dd($spot);
        $schedule = $spot->shift->schedule;

        return view('user.schedules.viewbid')->with([
            'schedule'=> $schedule,
            'spot'=> $spot,
            'bid'=> $bid,
        ]);
    }




    /**
     * Send Email to an user
     *
     * @param int $id User Id
     * @return boolean email sent result
    **/
    public function sendEmail(User $user, Schedule $schedule)
    {
        Mail::to($user)->send(new EmailNotification($user, $schedule));

        if (Mail::failures()) {
            return false;
        }else{
            return true;
        }
    }
}
