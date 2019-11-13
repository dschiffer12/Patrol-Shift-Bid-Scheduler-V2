<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BiddingSchedule;
use Illuminate\Support\Facades\DB;
use App\Models\BiddingQueue;
use App\Models\Bid;

class BiddingQueueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = BiddingSchedule::where('currently_active', 1)->get();
        
        return view('admin.queue')->with([
            'schedules' => $schedules,
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
    public function show(Request $request, $id)
    {

        
        //
        $schedules = BiddingSchedule::where('currently_active', 1)->get();

        /**
         * Validate the form data
         */
        $validatedData = $request->validate([
            'schedule_id' => ['required', 'integer', 'gt:0'],
        ]);

        $schedule = BiddingSchedule::where('id', $validatedData['schedule_id'])->first();


        // $biddingQueue = DB::table('users')
        //         ->join('bidding_queues', 'users.id', '=', 'bidding_queues.user_id')
        //         ->where('bidding_queues.bidding_schedule_id', '=', $validatedData['schedule_id'])
        //         ->orderBy('bidding_spot', 'asc')
        //         ->get();

        $biddingQueue = BiddingQueue::join('users', 'users.id', '=', 'bidding_queues.user_id')
                ->join('role_user', 'role_user.user_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('bidding_queues.bidding_schedule_id', '=', $validatedData['schedule_id'])
                ->orderBy('bidding_spot', 'asc')
                ->select(DB::raw('roles.name as role_name'), 'users.*', 'bidding_queues.*')
                ->paginate(6);
        

        return view('admin.queue')->with([
            'schedules' => $schedules,
            'biddingQueue' => $biddingQueue,
            'schedule' => $schedule,
        ]);
   
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


    /**
     * View user bid.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request, $id)
    {

        $validatedData = $request->validate([
            'user_id' => ['required', 'integer', 'gt:0'],
            'bidding_schedule_id' => ['required', 'integer', 'gt:0'],
        ]);

        // $schedule = BiddingSchedule::findOrFail($validatedData['bidding_schedule_id']);

        $bid = Bid::where('user_id', $validatedData['user_id'])
            ->where('bidding_schedule_id', $validatedData['bidding_schedule_id'])
            ->first();
        
        $schedule = $bid->biddingSchedule;
        $user = $bid->user;
        $shift = $bid->shift;

        $bidEarlyShift = $bid->hasAnyBidEarlyShift();


        if($bidEarlyShift) {
            $earlyShift = $shift->earlyShift;

            return view('admin.viewbid')->with([
                'bid' => $bid,
                'schedule' => $schedule,
                'user' => $user,
                'shift' => $shift,
                'bidEarlyShift' => $bidEarlyShift,
                'earlyShift' => $earlyShift
            ]);
        }

        return view('admin.viewbid')->with([
            'bid' => $bid,
            'schedule' => $schedule,
            'user' => $user,
            'shift' => $shift,
        ]);
    }



    /**
     * Admin bid for user
     */
    public function bid(Request $request, $id)
    {
        $validatedData = $request->validate([
            'user_id' => ['required', 'integer', 'gt:0'],
            'bidding_schedule_id' => ['required', 'integer', 'gt:0'],
        ]);

    
        $shifts = DB::table('bidding_schedule_shift')
            ->join('shifts', 'bidding_schedule_shift.shift_id', '=', 'shifts.id')
            ->join('early_shifts', 'shifts.id', '=', 'early_shifts.shift_id')
            ->where('bidding_schedule_id', '=', $validatedData['bidding_schedule_id'])
            ->get();

        $schedule = BiddingSchedule::where('id', $validatedData['bidding_schedule_id'])->first();

        $user = User::findOrFail($validatedData['user_id']);

        return view('admin.bidforuser')->with([
            'schedule' => $schedule,
            'user' => $user,
            'shifts' => $shifts,
        ]);

    }
}
