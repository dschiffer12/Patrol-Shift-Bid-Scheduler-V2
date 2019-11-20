<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Schedule;
use App\Specialty;

class BidQueueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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


    public function view($id)
    {
        
        $schedule = Schedule::find($id);
        $bidding_queue = $schedule->biddingQueues;
        $shifts = $schedule->shifts;

        // dd($shifts);

        $specialties = Specialty::all();

        foreach($shifts as $shift) {
            $spots = $shift->spots;
            $shift->push($spots);
        }

        // dd($specialties2->shift);
        // dd($bidding_queue);

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


        // dd($bidding_queue);

        return view('admin.schedules.biddingqueue')->with([
            'bidding_queue'=> $bidding_queue,
            'specialties'=> $specialties,
            'schedule'=> $schedule,
        ]);
    }
}
