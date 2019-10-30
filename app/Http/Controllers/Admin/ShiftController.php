<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shift;
use App\Models\EarlyShift;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShiftController extends Controller
{
    /**
     * Display a listing of the Shift and Early Shift.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shifts = Shift::all();

        return view('admin.shift.index')->with([
            'shifts' => $shifts
        ]);
    }

    /**
     * Show the form for creating a new Shift and Early Shift.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.shift.create_shift');
    }

    /**
     * Store a newly created Shift and Early Shift in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'start_time' => ['required'],
                'end_time' => ['required'],
                'minimun_staff' => ['required', 'numeric'],
                'num_early_spot' => ['numeric'],
            ]);

        //Create and instantiate Shift Model to save in database
        $shift = new Shift();
        $shift->name = $validateData['name'];
        $shift->start_time = $validateData['start_time'];
        $shift->end_time = $validateData['end_time'];
        $shift->minimun_staff = $validateData['minimun_staff'];

        $shift->save();

        //Save in Db early shift
        $shift->earlyShift()->create([
                'early_start_time' => request('early_start_time'),
                'early_end_time' => request('early_end_time'),
                'num_early_spot' => request('num_early_spot')
            ]);

        return redirect()->route('admin.shift.index')->with('successful', 'Shift created successfully!');
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
        $shift = Shift::findOrFail($id);

        return view('admin.shift.editshift')->with([
            'shift' => $shift
        ]);
    }

    /**
     * Update the specified Shift and Early Shift in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'start_time' => ['required'],
                'end_time' => ['required'],
                'minimun_staff' => ['required', 'numeric'],
            ]);

        $shift = Shift::findOrFail($id);
        $shift->name = $validateData['name'];
        $shift->start_time = $validateData['start_time'];
        $shift->end_time = $validateData['end_time'];
        $shift->minimun_staff = $validateData['minimun_staff'];

        $shift->update();

        $hasEarlyShift = request('early_shift');
        if($hasEarlyShift == 1)
        {
            $shift->earlyShift->updateOrCreate([
                'early_start_time' => request('early_start_time'),
                'early_end_time' => request('early_end_time'),
                'num_early_spot' => request('num_early_spot')
            ]);
        }

        return redirect()->route('admin.shift.index')->with('updated', 'Shift updated successfully!');
    }

    /**
     * Remove the specified Shift and Early Shift from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shift = Shift::findOrFail($id);
        $earlyShift = $shift->earlyShift;

        $shift->delete();
        $earlyShift->delete();

        return redirect()->route('admin.shift.index')->with('deleted', 'Shift deleted successfully');
    }
}
