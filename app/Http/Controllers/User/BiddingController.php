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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BiddingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = BiddingSchedule::all();
        //$schedules = \App\Models\BiddingSchedule::where('currently_active', '1')->orderBy('start_day', 'desc')->get();
        //$schedule1 = $schedules[0]->shift;
        //$shifts = Shift::where('name', 'A')->first();
        // $ar = array();
        // foreach($schedules as $schedule) {
        //     array_push($ar, $schedule->name);      
        // }

        //dd($schedules[0]->shift());

        // return view('user.bidding')->with([
        //     'schedules' => $schedules
        // ]);

        return view('user.bidding', compact('schedules'));
   
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
        ]);

        
        $bid = new Bid;

        $bid->user_id = auth()->user()->id;
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

        //dd($validatedData);
        //dd($bid->id);   
        //dd(auth()->user()->id);
        //$user = User::findOrFail($id);


    }

    /** 
     * 
    */
    public function bids(Request $request) {

        // $bids = Bid::where('user_id', auth()->user()->id)->first();
        // dd($bids->id);

        //$bids = new Bid;

        /**
         * Validate the form data
         */
        $validatedData = $request->validate([
            'bid_id' => ['integer', 'gte:0'],
        ]);


        if($bids = Bid::where('user_id', auth()->user()->id)) {

            //$schedules = BiddingSchedule::where('id', $bids->id);

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

                                //dd($bid_early_shift);

                                // dd($early_shift->early_start);

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
                        }
                    }
                }

            }

            return view('user.bids')->with([
                'schedules' => $schedules,
            ]);
        }


        
        return view('user.bids')->with([
            'bids' => $bids,
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //$schedule = BiddingSchedule::where('id', $request->schedule_id);
        //$user = User::findOrFail($id);

        $schedules = BiddingSchedule::all();
        $schedule = BiddingSchedule::findOrFail($request->schedule_id);

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
}
