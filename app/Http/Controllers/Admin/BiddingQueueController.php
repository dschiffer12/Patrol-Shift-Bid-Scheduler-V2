<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BiddingSchedule;
use Illuminate\Support\Facades\DB;

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


        // $biddingQueue = DB::table('users')
        //         ->join('bidding_queues', 'users.id', '=', 'bidding_queues.user_id')
        //         ->where('bidding_queues.bidding_schedule_id', '=', $validatedData['schedule_id'])
        //         ->orderBy('bidding_spot', 'asc')
        //         ->get();

        $biddingQueue = User::join('bidding_queues', 'users.id', '=', 'bidding_queues.user_id')
                ->join('role_user', 'role_user.user_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('bidding_queues.bidding_schedule_id', '=', $validatedData['schedule_id'])
                ->orderBy('bidding_spot', 'asc')
                ->select(DB::raw('roles.name as role_name'), 'users.*', 'bidding_queues.*')
                ->get();
        
        // foreach($biddingQueue as $test){
        //     dd(implode(', ', $test->roles()->get()->pluck('name')->toArray()));

        // }
        

        return view('admin.queue')->with([
            'schedules' => $schedules,
            'biddingQueue' => $biddingQueue,
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
}
