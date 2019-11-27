<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Schedule;
use App\Specialty;
use App\Models\Bid;
use App\User;
use App\Shift;
use App\Spot;
use App\Models\BiddingQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailNotification;
use DateTime;

class BidQueueController extends Controller
{
    /**
     * to view the bidding queue
     */
    public function view($id)
    {
        
        $schedule = Schedule::find($id);
        $bidding_queue = $schedule->biddingQueues;
        $shifts = $schedule->shifts;

        $specialties = Specialty::all();

        foreach($shifts as $shift) {
            $spots = $shift->spots;
            $shift->push($spots);
        }

        foreach($bidding_queue as $queue) {
            $user = $queue->user;
            $specialties2 = $user->specialties;
            $user->push($specialties2);
            $queue->push($user);
        }

        // remove all the specialties that do not have a shift
        foreach($specialties as $specialty) {
            $i = 0;
            foreach($shifts as $shift) {
                if($shift->specialty_id == $specialty->id) {
                    $i++;
                }
            }
            if($i < 1) {
                $specialties->pop($specialty);
            }
            $i=0;
        }

        return view('admin.schedules.biddingqueue')->with([
            'bidding_queue'=> $bidding_queue,
            'specialties'=> $specialties,
            'schedule'=> $schedule,
        ]);
    }


    /**
     * View the bid
     */
    public function viewBid($id) {
        
        $bid = Bid::where('bidding_queue_id', $id)->first();
        $user = User::where('id', $bid->user_id)->first();
        
        $spot = $bid->spot;
        $schedule = $spot->shift->schedule;

        return view('user.schedules.viewbid')->with([
            'schedule'=> $schedule,
            'spot'=> $spot,
            'bid'=> $bid,
            'user'=> $user,
        ]);

    }

    /**
     * Show bidding schedule for user
     */
    public function bid(Request $request, $id) {

        $validatedData = $request->validate([
            'user_id' => ['required', 'integer'],    
        ]);
 
        $user = User::find($validatedData['user_id']);
        $specialties = $user->specialties;
        $schedule = Schedule::find($id);

        $shifts = $schedule->shifts;

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
            'user'=> $user,
        ]);
       
    }

    /**
     * admin bid for user
     */
    public function bidForUser(Request $request) {

        $validatedData = $request->validate([
            'spot_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
            'shift_id' => ['required', 'integer'],  
        ]);

        $spot = Spot::find($validatedData['spot_id']);
        if($spot->qty_available < 1) {
            // redirect out with an error.
            return back()->withInput();
        }

        $bid = new Bid;
        $user = User::find($validatedData['user_id']);

        //need to fix this
        $shift = Shift::find($request->shift_id);
        $bidding_queue = BiddingQueue::where('user_id', $user->id)
            ->where('schedule_id', $shift->schedule_id)
            ->first();

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
        $bidding_queue->end_time_bidding = $date;
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
            $i = 0;
            foreach($specialties as $specialty) {
                if($specialty->id == $spot->shift->specialty_id) {
                    $queue->waiting_to_bid = false;
                    $queue->bidding = true;
                    $queue->start_time_bidding = $date;
                    $queue->save();
                    $i++;
                    break;
                }
            }

            if($i > 0) {
                break;
            } 
        }

        return redirect('/admin/schedule/'. $shift->schedule_id . '/biddingQueue/')->with('success', 'Bid submitted!!');
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
