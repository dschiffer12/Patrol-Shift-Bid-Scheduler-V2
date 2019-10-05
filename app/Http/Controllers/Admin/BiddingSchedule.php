<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BiddingSchedule extends Controller
{
    /**
     * Display a listing of the Bidding Schedule resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $biddingScheduleActive = \App\Models\BiddingSchedule::where('currently_active', '1')->orderBy('start_day', 'desc')->get();

        $biddingScheduleTemplates = \App\Models\BiddingSchedule::where('save_as_template', '1')->orderBy('start_day', 'desc')->get();

        return view('admin.biddingschedule.index')->with([
            'biddingschedulesactive' => $biddingScheduleActive,
            'biddingschedulestemplates' => $biddingScheduleTemplates
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
}
