<?php

namespace App\Http\Controllers\User;

use App\User;
use App\Spot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class PSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $weekMap = [
            0 => 'sunday',
            1 => 'monday',
            2 => 'tuesday',
            3 => 'wednesday',
            4 => 'thursday',
            5 => 'friday',
            6 => 'saturday',
        ];
        $dayOfTheWeek = Carbon::now()->dayOfWeek;
        $weekday = $weekMap[$dayOfTheWeek];
        $daySelected = Carbon::now();

        $spots = Spot::join('shifts', 'spots.shift_id', '=', 'shifts.id')
            ->join('schedules', 'shifts.schedule_id', '=', 'schedules.id')
            ->join('bids', 'spots.id', '=', 'bids.spot_id')
            ->where([['schedules.start_date', '<=', date('Y-m-d')], ['schedules.end_date', '>=', date('Y-m-d')], ['bids.approved', '=', 1], ['spots.'.$weekday.'_s', '<>', null], ['spots.'.$weekday.'_e', '<>', null]])
            ->groupBy('shift_id')
            ->get();

        $shifts = array();
        foreach ($spots as $spot){
                if(!in_array($spot->shift->name, $shifts)){
                    array_push($shifts, $spot->shift->name);
                }
            }

        $user = Auth::user();
        if($user->hasAnyRoles(['root', 'admin'])){
            return view('user.psheet')->with([
                'editable' => true,
                'spots' => $spots,
                'weekday' => $weekday,
                'shifts' => $shifts,
                'daySelected' => $daySelected
            ]);
        }

        return view('user.psheet')->with([
            'spots' => $spots,
            'weekday' => $weekday,
            'shifts' => $shifts,
            'daySelected' => $daySelected
        ]);
    }

    /**
     * Return the schedule for an specific date coming for the view.
     *
     * @param \http\Env\Request
     * @return view with the list for that specific date
    **/
    public function date(Request $request)
    {
        $dataValidated = $request->validate([
            'calendar_date' => ['required', 'date']
        ]);

        $dayofweek = date('w', strtotime($dataValidated['calendar_date']));

        $weekMap = [
            0 => 'sunday',
            1 => 'monday',
            2 => 'tuesday',
            3 => 'wednesday',
            4 => 'thursday',
            5 => 'friday',
            6 => 'saturday',
        ];
        $weekday = $weekMap[$dayofweek];

        $spots = Spot::join('shifts', 'spots.shift_id', '=', 'shifts.id')
            ->join('schedules', 'shifts.schedule_id', '=', 'schedules.id')
            ->join('bids', 'spots.id', '=', 'bids.spot_id')
            ->where([['schedules.start_date', '<=', $dataValidated['calendar_date']], ['schedules.end_date', '>=', $dataValidated['calendar_date']], ['bids.approved', '=', 1], ['spots.'.$weekday.'_s', '<>', null], ['spots.'.$weekday.'_e', '<>', null]])
            ->groupBy('shift_id')
            ->get();

        $shifts = array();
        foreach ($spots as $spot){
            if(!in_array($spot->shift->name, $shifts)){
                array_push($shifts, $spot->shift->name);
            }
        }

        $spotsItemsLenght = sizeof($spots);

        if($spotsItemsLenght == 0){
            $user = Auth::user();
            if($user->hasAnyRoles(['root', 'admin'])){
                return view('user.psheet')->with([
                    'editable' => true,
                    'spots' => $spots,
                    'weekday' => $weekday,
                    'shifts' => $shifts,
                    'daySelected' => $dataValidated['calendar_date'],
                    'noSpots' => 'No schedule available for this date'
                ]);
            }

            return view('user.psheet')->with([
                'spots' => $spots,
                'weekday' => $weekday,
                'shifts' => $shifts,
                'daySelected' => $dataValidated['calendar_date'],
                'noSpots' => 'No schedule available for this date'
            ]);
        }

        $user = Auth::user();
        if($user->hasAnyRoles(['root', 'admin'])){
            return view('user.psheet')->with([
                'editable' => true,
                'spots' => $spots,
                'weekday' => $weekday,
                'shifts' => $shifts,
                'daySelected' => $dataValidated['calendar_date']
            ]);
        }

        return view('user.psheet')->with([
            'spots' => $spots,
            'weekday' => $weekday,
            'shifts' => $shifts,
            'daySelected' => $dataValidated['calendar_date']
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
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
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
