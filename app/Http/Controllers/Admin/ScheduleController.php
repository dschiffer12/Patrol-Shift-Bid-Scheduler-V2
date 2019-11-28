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
        // Return the index view with all the schedules
        $schedules = Schedule::paginate(7);

        if($schedules) {
            return view('admin.schedules.index')->with([
                'schedules'=> $schedules,
            ]);
        } else {
            return redirect('/')->with('warning', 'Can\'t find schedule');
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
            'start_date' => ['required'],
            'end_date' => ['required'],
            'response_time' => ['required', 'integer', 'gt:0', 'lt:100'],
        ]);

        // store the schedule parameters
        $schedule = new Schedule;
        $schedule->name = $request->schedule_name;
        $schedule->start_date = $request->start_date;
        $schedule->end_date = $request->end_date;
        $schedule->response_time = $request->response_time;
        $schedule->currently_active = false;
        $schedule->template = false;
        $schedule->save();
        

        // $schedule = Schedule::create([
        //     'schedule_name' => $validatedData['schedule_name'],
        //     'start_date' => $validatedData['start_date'],
        //     'end_date' => $validatedData['end_date'],
        //     'response_time' => $validatedData['response_time'],
        // ]);
      
        return redirect('/admin/schedules/'. $schedule->id . '/edit/');
    }

   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {        
        // find the schedule, specialties, and shifts
        $schedule = Schedule::findOrFail($id);
        $specialties = Specialty::all();
        $shifts = $schedule->shifts;
 
        /**
         * Return view with the new schedule.
         */
        return view('admin.schedules.edit')->with([
            'schedule'=> $schedule,
            'specialties'=> $specialties,
        ]);
    }

   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id : schedule id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Schedule::destroy($id);
        return redirect('/admin/schedules/')->with('success', 'Schedule deleted.');
    }


    /**
     * Add shifts to the schedule
     * 
     * @param  int  $id the schedule id
     */
    public function addShift(Request $request, $id) {
        
        // validate the request
        $validatedData = $request->validate([
            'shift_name' => ['required', 'string', 'max:255'],
            'schedule_id' => ['required', 'integer'],
            'specialty_id' => ['required', 'integer'],
        ]);

        // store the shift parameters
        $shift = new Shift;
        $shift->name = $request->shift_name;
        $shift->schedule_id = $request->schedule_id;
        $shift->specialty_id = $request->specialty_id;
        $shift->save();

        return redirect('/admin/schedules/'. $id . '/edit/');
    }


    /**
     * Add spots to shifts
     * 
     * @param  int  $id
     */
    public function addSpot(Request $request, $id) {

        // remove the null argunements form the request
        foreach($request->request as $key => $value) {
            if(!$value) {
                $request->offsetUnset($key);
            }
        }

        // validate the request
        $validatedData = $request->validate([
            'shift_id' => ['required', 'integer'],
            'qty_available' => ['required', 'integer'],
            'friday_s' => ['nullable', 'date_format:H:i:s'],
            'friday_e' => ['required_with:friday_s', 'date_format:H:i:s', 'different:friday_s'],
            'saturday_s' => ['nullable', 'date_format:H:i:s'],
            'saturday_e' => ['required_with:saturday_s', 'date_format:H:i:s', 'different:saturday_s'],
            'sunday_s' => ['nullable', 'date_format:H:i:s'],
            'sunday_e' => ['required_with:sunday_s', 'date_format:H:i:s', 'different:sunday_s'],
            'monday_s' => ['nullable', 'date_format:H:i:s'],
            'monday_e' => ['required_with:monday_s', 'date_format:H:i:s', 'different:monday_s'],
            'tuesday_s' => ['nullable', 'date_format:H:i:s'],
            'tuesday_e' => ['required_with:tuesday_s', 'date_format:H:i:s', 'different:tuesday_s'],
            'wednesday_s' => ['nullable', 'date_format:H:i:s'],
            'wednesday_e' => ['required_with:wednesday_s', 'date_format:H:i:s', 'different:wednesday_s'],
            'thursday_s' => ['nullable', 'date_format:H:i:s'],
            'thursday_e' => ['required_with:thursday_s', 'date_format:H:i:s', 'different:thursday_s'],     
        ]);
        
        // store the parameters ot the new request
        $spot = new Spot;
        foreach($validatedData as $key => $data) {    
            $spot->$key = $data;
        }

        $spot->save();

        return redirect('/admin/schedules/'. $id . '/edit/');
    }


    /**
     * Delete a spot
     */
    public function deleteSpot(Request $request, $id) {

        $validatedData = $request->validate([
            'spot_id' => ['required', 'integer'],    
        ]);

        Spot::destroy($validatedData['spot_id']);
        return redirect('/admin/schedules/'. $id . '/edit/');
    }


    /**
     * Delete a shift
     */
    public function deleteShift(Request $request, $id) {

        $validatedData = $request->validate([
            'shift_id' => ['required', 'integer'],    
        ]);
        Shift::destroy($validatedData['shift_id']);
        return redirect('/admin/schedules/'. $id . '/edit/');
    }

    /**
     * Add an user
     */
    public function addUsers($id) {
        
        $schedule = Schedule::find($id);

        // get all the shidts for this schedule
        $shifts = $schedule->shifts;
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

        $users = User::orderBy('date_in_position', 'asc')
            ->get();

        // attach the specialties to the users
        foreach($users as $user) {
            $specialtiesU = $user->specialties;
            $user->push($specialtiesU);
        }

        $bidding_queue = $schedule->biddingQueues;
        // Remove any bidding queue in case user is comming back, prevent suplicate
        foreach($bidding_queue as $queue) {
            BiddingQueue::destroy($queue->id);
        }
        
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

        foreach($input['allSpecialties'] as $specialtyID => $userID) {
            asort($input['allSpecialties'][$specialtyID]);
        }

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

    /**
     * Admin review the schedule
     */
    public function reviewSchedule($id) { 

        $schedule = Schedule::find($id);
        $bidding_queue = $schedule->biddingQueues;
        $shifts = $schedule->shifts;

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

        foreach($bidding_queue as $queue) {
            $user = $queue->user;
            $specialties2 = $user->specialties;
            $user->push($specialties2);
            $queue->push($user);
        }

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
            }
        }

        return redirect('/admin/schedules/')->with('successful', 'Schedule activated!');
    }


    /**
     * Approve the schedule/bids after all bids
     */
    public function approveSchedule($id) {

        $schedule = Schedule::find($id);
        $shifts = $schedule->shifts;
        $specialties = Specialty::all();
        
        foreach($shifts as $shift) {
            $spots = $shift->spots;
            foreach($spots as $spot) {
                $bids = $spot->bids;
                foreach($bids as $bid) {
                    $user = $bid->user;
                    $bid->push($user);
                    $spot->push($bid);
                }
                
            }
            $shift->push($spots);
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

        return view('admin.schedules.approveschedule')->with([
            'specialties'=> $specialties,
            'schedule'=> $schedule,
        ]);
    }

    /**
     * store the appproval schedule
     */
    public function saveApproval(Request $request) {

        /**
         * Validate the request
         */
        $validatedData = $request->validate([
            'schedule_id' => ['required', 'integer'],
        ]);

        $schedule = Schedule::find($validatedData['schedule_id']);
        $schedule->approved = true;
        $schedule->currently_active = false;
        $schedule->save();

        $shifts = $schedule->shifts;
        
        foreach($shifts as $shift) {
            $spots = $shift->spots;
            foreach($spots as $spot) {
                $bids = $spot->bids;
                foreach($bids as $bid) {
                    $bid->approved = true;
                    $bid->save();
                }   
            }
        }

        return redirect('/admin/schedules/')->with('successful', 'Schedule approved!!');        
    }


    /**
     * View appred schedule
     */
    public function viewApproved($id) {
        $schedule = Schedule::find($id);
        $shifts = $schedule->shifts;
        $specialties = Specialty::all();
        
        foreach($shifts as $shift) {
            $spots = $shift->spots;
            foreach($spots as $spot) {
                $bids = $spot->bids;
                foreach($bids as $bid) {
                    $user = $bid->user;
                    $bid->push($user);
                    $spot->push($bid);
                }
                
            }
            $shift->push($spots);
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

        return view('admin.schedules.approveschedule')->with([
            'specialties'=> $specialties,
            'schedule'=> $schedule,
            'view_approval'=> true,
        ]);
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
