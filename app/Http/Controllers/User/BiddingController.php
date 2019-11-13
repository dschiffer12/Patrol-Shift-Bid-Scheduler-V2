<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BiddingSchedule;
use App\Models\Shift;
use App\Models\EarlyShift;
use App\Models\Bid;
use App\Models\BidEarlyShift;
use App\Models\BidShift;
use App\Models\BiddingQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailNotification;

class BiddingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        if(auth()->user()->hasAnyBiddingQueue()) {
            $schedules = DB::table('bidding_schedules')
                ->join('bidding_queues', 'bidding_schedules.id', '=', 'bidding_queues.bidding_schedule_id')
                ->where('bidding_queues.user_id', '=', auth()->user()->id)
                ->select('bidding_schedules.id', 'bidding_schedules.name')
                ->get();

            return view('user.bidding', compact('schedules'));
        } else {
            return view('user.bidding');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

        //dd($request);
        //$schedule = BiddingSchedule::where('id', $request->schedule_id);
        //$user = User::findOrFail($id);

         /**
         * Validate the form data
         */
        $validatedData = $request->validate([
            'schedule_id' => ['required', 'integer', 'gt:0'],
        ]);

        $schedules = DB::table('bidding_schedules')
                ->join('bidding_queues', 'bidding_schedules.id', '=', 'bidding_queues.bidding_schedule_id')
                ->where('bidding_queues.user_id', '=', auth()->user()->id)
                ->select('bidding_schedules.*')
                ->get();

        $schedule = BiddingSchedule::findOrFail($request->schedule_id);

        $biddingQueue = DB::table('bidding_queues')
            ->where('user_id', auth()->user()->id)
            ->where('bidding_schedule_id', $validatedData['schedule_id'])
            ->first();

        $numInQueue = DB::table('bidding_queues')
            ->where('bidding_schedule_id', $validatedData['schedule_id'])
            ->where('bid_submitted', '<', 1)
            ->where('bidding_spot', '<', $biddingQueue->bidding_spot)
            ->count();


        if($numInQueue > 0) {
            return view('user.bidding')->with([
                'schedules' => $schedules,
                'numInQueue' => $numInQueue,
            ]);
        }


        if(auth()->user()->alreadyBid($request->schedule_id)) {
            return view('user.bidding')->with([
                'schedule' => $schedule,
                'schedules' => $schedules,
                'already_bid' => "true"
            ]);
        }
 
        //$shifts = $schedule->shifts()->get();

        $shifts = DB::table('bidding_schedule_shift')
            ->join('shifts', 'bidding_schedule_shift.shift_id', '=', 'shifts.id')
            ->join('early_shifts', 'shifts.id', '=', 'early_shifts.shift_id')
            ->where('bidding_schedule_id', '=', $request->schedule_id)
            ->get();


        // dd($testShifts);
        return view('user.bidding')->with([
            'schedule' => $schedule,
            'shifts' => $shifts,
            'schedules' => $schedules
        ]);

        //dd($shifts[0]->early_shift);
        //dd($request->schedule_id);
        //dd($request);
        //dd($id);
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

        /**
         * Validate the form data
         */
        $validatedData = $request->validate([
            'shift_id' => ['required', 'integer', 'gte:0'],
            'friday' => ['integer', 'gt:0', 'lt:2'],
            'saturday' => ['integer', 'gt:0', 'lt:2'],
            'sunday' => ['integer', 'gt:0', 'lt:2'],
            'monday' => ['integer', 'gt:0', 'lt:2'],
            'tuesday' => ['integer', 'gt:0', 'lt:2'],
            'wednesday' => ['integer', 'gt:0', 'lt:2'],
            'thursday' => ['integer', 'gt:0', 'lt:2'],
            'early_shift' => ['integer', 'gt:0', 'lt:2'],
            'e_friday' => ['integer', 'gt:0', 'lt:2'],
            'e_saturday' => ['integer', 'gt:0', 'lt:2'],
            'e_sunday' => ['integer', 'gt:0', 'lt:2'],
            'e_monday' => ['integer', 'gt:0', 'lt:2'],
            'e_tuesday' => ['integer', 'gt:0', 'lt:2'],
            'e_wednesday' => ['integer', 'gt:0', 'lt:2'],
            'e_thursday' => ['integer', 'gt:0', 'lt:2'],
            'schedule_id' => ['required', 'integer', 'gt:0'],
            'user_id' => ['integer', 'gt:0'],
        ]);

        
        

        // Get the current user
        $user = Auth::user();

        // if user_id is passed, then an admin is bidding for a user
        if(isset($validatedData['user_id'])) {
            if($user->hasAnyRoles(['root', 'admin'])) {
                $user = User::findOrFail($validatedData['user_id']);
            }
        }

        
        if(isset($validatedData['schedule_id'])) {
            if($user->alreadyBid($validatedData['schedule_id'])) {
                return redirect()->route('user.biddingschedule.index')
                    ->with('warning', 'You already bit on this schedule.');
            }
        }
        
        $bid = new Bid;

        $bid->user_id = $user->id;
        $bid->bidding_schedule_id = $validatedData['schedule_id'];
        $bid->shift_id = $validatedData['shift_id'];
        $bid->friday = isset($validatedData['friday']) ? $validatedData['friday'] : 0;
        $bid->saturday = isset($validatedData['saturday']) ? $validatedData['saturday'] : 0;
        $bid->sunday = isset($validatedData['sunday']) ? $validatedData['sunday'] : 0;
        $bid->monday = isset($validatedData['monday']) ? $validatedData['monday'] : 0;
        $bid->tuesday = isset($validatedData['tuesday']) ? $validatedData['tuesday'] : 0;
        $bid->wednesday = isset($validatedData['wednesday']) ? $validatedData['wednesday'] : 0;
        $bid->thursday = isset($validatedData['thursday']) ? $validatedData['thursday'] : 0;

        $bid->save();

        if(isset($validatedData['early_shift'])) {

            $bid_early_shift = new BidEarlyShift;

            $bid_early_shift->bid_id = $bid->id;
            $bid_early_shift->friday = isset($validatedData['e_friday']) ? $validatedData['e_friday'] : 0;
            $bid_early_shift->saturday = isset($validatedData['e_saturday']) ? $validatedData['e_saturday'] : 0;
            $bid_early_shift->sunday = isset($validatedData['e_sunday']) ? $validatedData['e_sunday'] : 0;
            $bid_early_shift->monday = isset($validatedData['e_monday']) ? $validatedData['e_monday'] : 0;
            $bid_early_shift->tuesday = isset($validatedData['e_tuesday']) ? $validatedData['e_tuesday'] : 0;
            $bid_early_shift->wednesday = isset($validatedData['e_wednesday']) ? $validatedData['e_wednesday'] : 0;
            $bid_early_shift->thursday = isset($validatedData['e_thursday']) ? $validatedData['e_thursday'] : 0;

            $bid_early_shift->save();
        }


        if($user->hasBiddingQueue($validatedData['schedule_id'])) {
            $affected = DB::table('bidding_queues')
              ->where('user_id', $user->id)
              ->where('bidding_schedule_id', $validatedData['schedule_id'])
              ->update([
                  'waiting_to_bid' => 0,
                  'bidding' => 0,
                  'bid_submitted' => 1,
                ]);

            $nextQueue = DB::table('bidding_queues')
                ->where('bidding_schedule_id', $validatedData['schedule_id'])
                ->where('bid_submitted', 0)
                ->orderBy('bidding_spot', 'asc')
                ->limit(1)
                ->update([
                    'waiting_to_bid' => 0,
                    'bidding' => 1,
                    'bid_submitted' => 0,
                ]);
        }


        $next = BiddingQueue::where('bidding_schedule_id', $validatedData['schedule_id'])
            ->where('bidding', 1)
            ->orderBy('bidding_spot', 'asc')
            ->first();
        
        if($next) {
            $nextUserToBid = $next->user;
            $schedule = BiddingSchedule::where(['id' => $validatedData['schedule_id']])->first();
            $emailSend = $this->sendEmail($nextUserToBid, $schedule);
        }

        // if($nextUserToBid) {
        //     $schedule = BiddingSchedule::where(['id' => $validatedData['schedule_id']])->first();
        //     $emailSend = $this->sendEmail($nextUserToBid, $schedule);
        // }

        // if it's an admin bidding for user, redirect back admin controls
        if(isset($validatedData['user_id'])) {
            return redirect()->route('admin.bidding-queue.index')->with('success', 'The bid for user: ' . $user->name . ' successfully submitted.');
        } else {
            return redirect()->route('user.biddingschedule.bids')->with('success', 'Your bit has been submitted');
        }

    }

    /** 
     * 
    */
    public function bids(Request $request) {

        /**
         * Validate the form data
         */
        $validatedData = $request->validate([
            'bid_id' => ['integer', 'gte:0'],
        ]);

      
        if(auth()->user()->hasAnyBids()) {

            // $bids = Bid::where('user_id', auth()->user()->id);

            $schedules = DB::table('bids')
                ->join('bidding_schedules', 'bids.bidding_schedule_id', '=', 'bidding_schedules.id')
                ->where('bids.user_id', '=', auth()->user()->id)
                ->select('bids.id', 'bidding_schedules.name')
                ->get();

            if(isset($validatedData['bid_id'])) {
                if($bid = Bid::where('id', $validatedData['bid_id'])->first()) {
                    if($schedule = BiddingSchedule::where('id', $bid->bidding_schedule_id)->first()) {
                        if($shift = Shift::where('id', $bid->shift_id)->first()) {
                            if($bid_early_shift = BidEarlyShift::where('bid_id', $bid->id)->first()) {   
                                $early_shift = EarlyShift::where('shift_id', $shift->id)->first();
                                return view('user.bids')->with([
                                    'schedules' => $schedules,
                                    'bid' => $bid,
                                    'schedule' => $schedule,
                                    'shift' => $shift,
                                    'bid_early_shift' => $bid_early_shift,
                                    'early_shift' => $early_shift,
                                ]);
                            } else {
                                return view('user.bids')->with([
                                    'schedules' => $schedules,
                                    'bid' => $bid,
                                    'schedule' => $schedule,
                                    'shift' => $shift,
                                ]);
                            }
                        } else {
                            return view('user.bids')->with([
                                'schedules' => $schedules,
                            ])->with('warning', 'There was an error retrieving the Shift information');
                        }
                    } else {
                        return view('user.bids')->with([
                            'schedules' => $schedules,
                        ])->with('warning', 'There was an error retrieving the Schedule information');
                    }
                }
            }

        } else {

            return view('user.bids')->with([
                'warning' => "You have no active Bids",
            ]);           
            
        }

        return view('user.bids')->with([
            'schedules' => $schedules,
        ]);

    }

    

  
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
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
