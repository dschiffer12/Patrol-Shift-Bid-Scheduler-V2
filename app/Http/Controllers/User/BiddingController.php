<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BiddingSchedule;
use App\Models\Shift;
use App\Models\EarlyShift;

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //$schedule = BiddingSchedule::where('id', $request->schedule_id);
        //$user = User::findOrFail($id);
        $schedule = BiddingSchedule::findOrFail($request->schedule_id);
        $shifts = $schedule->shifts()->get();
        $i = 0;
        foreach($shifts as $shift) {
            $shifts[$i]->setAttribute('early_shift', EarlyShift::where('shift_id', $shifts[$i]->schedule_id)->first());
            $i++;
        }

        dd($shifts[0]->early_shift);
        //dd($request->schedule_id);
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
