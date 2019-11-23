<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Schedule;
use App\Specialty;
use App\Shift;
use App\Spot;
use App\User;
use App\Models\BiddingQueue;
use DateTime;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailNotification;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       /**
        * Return the index view with all the schedules
        */

        $schedules = Schedule::paginate(7);

        // dd($schedules);
        if($schedules) {
            return view('admin.schedules.index')->with([
                'schedules'=> $schedules,
            ]);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        return view('admin.schedules.create');
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
         * Validate the request
         */
        $validatedData = $request->validate([
            'schedule_name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'after:yesterday'],
            'end_date' => ['required', 'after:yesterday'],
            'response_time' => ['required', 'integer', 'gt:0', 'lt:100'],
        ]);

        $schedule = new Schedule;

        $schedule->name = $request->schedule_name;
        $schedule->start_date = $request->start_date;
        $schedule->end_date = $request->end_date;
        $schedule->response_time = $request->response_time;

        $schedule->save();
      
        
        return redirect('/admin/schedules/'. $schedule->id . '/edit/');

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
        
        $schedule = Schedule::findOrFail($id);
        $specialties = Specialty::all();

     
        $shifts = $schedule->shifts;

        // foreach($specialties as $specialty) {
        //     foreach($shifts as $shift){
        //         $spots = $shift->spots;
        //         $shift->push($spots);
        //         $specialty->push($shift);   
        //     }    
        // }


        /**
         * Return view with the new schedule.
         */
        return view('admin.schedules.edit')->with([
            'schedule'=> $schedule,
            'specialties'=> $specialties,
        ]);
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
        Schedule::destroy($id);

        return redirect('/admin/schedules/')->with('success', 'Schedule deleted.');

    }


    public function addShift(Request $request, $id) {
        
        /**
         * Validate the request
         */
        $validatedData = $request->validate([
            'shift_name' => ['required', 'string', 'max:255'],
            'schedule_id' => ['required', 'integer'],
            'specialty_id' => ['required', 'integer'],
        ]);

        $shift = new Shift;

        $shift->name = $request->shift_name;
        $shift->schedule_id = $request->schedule_id;
        $shift->specialty_id = $request->specialty_id;

        $shift->save();

        return redirect('/admin/schedules/'. $id . '/edit/');

    }


    public function addSpot(Request $request, $id) {
        
        // dd($request);
        // $schedule = Schedule::findOrFail($id);

        /**
         * Validate the request
         */

    
        $spot = new Spot;

        $spot->shift_id = $request->shift_id;
        $spot->qty_available = $request->qty_available;
        $spot->friday_s = $request->friday_s;
        $spot->friday_e = $request->friday_e;
        $spot->saturday_s = $request->saturday_s;
        $spot->saturday_e = $request->saturday_e;
        $spot->sunday_s = $request->sunday_s;
        $spot->sunday_e = $request->sunday_e;
        $spot->monday_s = $request->monday_s;
        $spot->monday_e = $request->monday_e;
        $spot->tuesday_s = $request->tuesday_s;
        $spot->tuesday_e = $request->tuesday_e;
        $spot->wednesday_s = $request->wednesday_s;
        $spot->wednesday_e = $request->wednesday_e;
        $spot->thursday_s = $request->thursday_s;
        $spot->thursday_e = $request->thursday_e;

        $spot->save();

        return redirect('/admin/schedules/'. $id . '/edit/');

    }


    public function deleteSpot(Request $request, $id) {

        // dd($request->spot_id);
        Spot::destroy($request->spot_id);

        return redirect('/admin/schedules/'. $id . '/edit/');

    }


    public function deleteShift(Request $request, $id) {
        Shift::destroy($request->shift_id);
        return redirect('/admin/schedules/'. $id . '/edit/');
    }


    public function addUsers($id) {
        
        $schedule = Schedule::find($id);

        $users = User::orderBy('date_in_position', 'asc')
            ->get();

        foreach($users as $user) {
            $specialties = $user->specialties;
            $user->push($specialties);
        }

        $bidding_queue = $schedule->biddingQueues;
        // Remove any bidding queue in case user is comming back, prevent suplicate
        foreach($bidding_queue as $queue) {
            BiddingQueue::destroy($queue->id);
        }
        
        $specialties = Specialty::all();

        return view('admin.schedules.addusers')->with([
            'users'=> $users,
            'specialties'=> $specialties,
            'schedule'=> $schedule,
        ]);       

    }

    /**
     * Store the user bidding queues
     */
    public function storeQueue(Request $request, $id) {

        $input = $request->all();
        // dd($input);

        foreach($input['allSpecialties'] as $specialtyID => $userID) {
            asort($input['allSpecialties'][$specialtyID]);
        }

        // foreach($input['allSpecialties'] as $specialtyID => $userID) {
            
        //     echo ("specialty id: ". $specialtyID);
        //     echo "<br>";
        //     foreach($userID as $id => $order) {
        //         echo (".     .".$id . " - " . $order);
        //         echo "<br>";
        //     }
        //     // dd($key);
        // }
        // // dd($input);


        foreach($input['allSpecialties'] as $specialtyID => $userID) {
            $i = 1;
            foreach($userID as $user_ID => $order) {
                if($order > 0) {
                    $bidingQueue = new BiddingQueue;
                    $bidingQueue->user_id = $user_ID;
                    $bidingQueue->schedule_id = $id;
                    $bidingQueue->bidding_spot = $i;
                    $bidingQueue->waiting_to_bid = true;
                    $bidingQueue->bidding = false;
                    $bidingQueue->bid_submitted = false;

                    if($i == 1) {
                        $bidingQueue->bidding = true;
                    }

                    $bidingQueue->save();
                    $i++;
                }
            }
        }

        return redirect('/admin/schedules/'. $id . '/reviewSchedule/');

    }


    public function reviewSchedule($id) { 

        $schedule = Schedule::find($id);
        $bidding_queue = $schedule->biddingQueues;
        $shifts = $schedule->shifts;

        // dd($shifts);

        $specialties = Specialty::all();

        // remove all the specialties that do not have a shift
        foreach($specialties as $key => $specialty) {
            $j = 0;
            foreach($shifts as $shift) {
                if($shift->specialty_id == $specialty->id) {
                    $j++;
                }
            }
            if($j < 1) {
                $specialties->forget($key);
            }
            $j=0;
        }

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

        
        // dd($specialties);

        return view('admin.schedules.reviewschedule')->with([
            'bidding_queue'=> $bidding_queue,
            'specialties'=> $specialties,
            'schedule'=> $schedule,
        ]);

    }



    /**
     * set schedule to active
     */
    public function activateSchedule($id) {

        $schedule = Schedule::find($id);
        $schedule->currently_active = true;
        $schedule->save();
        
        $bidding_queue = $schedule->biddingQueues;

        foreach($bidding_queue as $queue) {
            if($queue->waiting_to_bid == $queue->bidding) {
                $date = new DateTime();
                $queue->waiting_to_bid = 0;
                $queue->start_time_bidding = $date;
                $queue->save();

                // // notify my email - disables for now
                // $user = $queue->user;
                // $emailSend = $this->sendEmail($user, $schedule);
                
                // // sleep for 1 seconds for mailtrap limitations
                //  sleep(1);
            }
        }

        return redirect('/admin/schedules/')->with('successful', 'Schedule activated!');

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
