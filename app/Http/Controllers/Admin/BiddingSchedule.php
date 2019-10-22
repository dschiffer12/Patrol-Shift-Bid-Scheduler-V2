<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Shift;
use App\Models\EarlyShift;
use Illuminate\Http\Request;
use App\Models\BiddingQueue;
use App\Mail\EmailNotification;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\BiddingSchedule as NewBiddingSchedule;

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
        $users = User::orderby('date_in_position')->get();
        $shifts = Shift::all();


        return view('admin.biddingschedule.createbiddingschedule')->with([
            'users' => $users,
            'shifts' => $shifts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Definition of the Model to store in the data base.

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'after:today'],
            'end_date' => ['required', 'after:today'],
            'response_time' => ['required', 'numeric'],
            'shiftQueue' => ['array'],
            'officerQueue' => ['array']
        ]);

        $bidding_schedule = new NewBiddingSchedule();

        $bidding_schedule->name = $validatedData['name'];
        $bidding_schedule->start_day = $validatedData['start_date'];
        $bidding_schedule->end_day = $validatedData['end_date'];
        $bidding_schedule->response_time = $validatedData['response_time'];
        $scheduleTemplate = request('seve_as_template');
        if ($scheduleTemplate == "on"){
            $bidding_schedule->save_as_template = true;
        }
        else{
            $bidding_schedule->save_as_template = false;
        }
        $bidding_schedule->currently_active = true;

        $bidding_schedule->save();

        $biddingID = $bidding_schedule->id;
        $biddingObject = NewBiddingSchedule::where(['id'=>$biddingID])->firstOrFail();

        foreach ($validatedData['shiftQueue'] as $shift){
            $arrayString = explode(":", $shift);
            if ($arrayString[1] == "on")
            {
                $shiftID = (int)$arrayString[0];
                $biddingObject->shift()->attach($shiftID);
            }

        }

        $bidding_spot_index = 1;  //Index to define the position in the bidding user queue.

        foreach ($validatedData['officerQueue'] as $officer){

            $arrayString = explode(":", $officer);

            if (!$arrayString[1] == "" || !$arrayString[1] == "0"){

                $officerIDInt = (int)$arrayString[0];

                $bidding_queue = new BiddingQueue();
                $officerObject = User::where(['id'=>$officerIDInt])->firstOrFail();
                $bidding_queue->user_id = $officerIDInt;
                $bidding_queue->bidding_schedule_id = $biddingID;
                $bidding_queue->bidding_spot = $bidding_spot_index;
                $bidding_spot_index = $bidding_spot_index + 1;
                if ($arrayString[1] == 1){
                    $bidding_queue->bidding = true;
                    $bidding_queue->waiting_to_bid = false;
                    $bidding_queue->bid_submitted = false;
                    $bidding_queue->start_time_bidding = null;
                    $bidding_queue->end_time_bidding = null;
                }
                else{
                    $bidding_queue->bidding = false;
                    $bidding_queue->waiting_to_bid = true;
                    $bidding_queue->bid_submitted = false;
                    $bidding_queue->start_time_bidding = null;
                    $bidding_queue->end_time_bidding = null;
                }
                $bidding_queue->save();
            }
        }

        $firstUser = BiddingQueue::where('bidding_schedule_id', $biddingID)->first()->user;
        $emailSend = $this->sendEmail($firstUser, $biddingObject);

        return redirect()->route('admin.bidding-schedule.index')->with('successful', 'Bidding Schedule created successfully!');

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
        $biddingschedule = NewBiddingSchedule::find($id);
        $shifts = $biddingschedule->shift;
        $users = BiddingQueue::where('bidding_schedule_id', $id)->get();

        return view('admin.biddingschedule.editbiddingschedule')->with([
            'biddingschedule' => $biddingschedule,
            'shifts' => $shifts,
            'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Bidding Schedule int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'after:today'],
            'end_date' => ['required', 'after:today'],
            'response_time' => ['required', 'numeric'],
            'shiftQueue' => ['array'],
            'officerQueue' => ['array']
        ]);

        $bidding_schedule = NewBiddingSchedule::find($id);

        $bidding_schedule->name = $validatedData['name'];
        $bidding_schedule->start_day = $validatedData['start_date'];
        $bidding_schedule->end_day = $validatedData['end_date'];
        $bidding_schedule->response_time = $validatedData['response_time'];
        $scheduleTemplate = request('seve_as_template');
        if ($scheduleTemplate == "on"){
            $bidding_schedule->save_as_template = true;
        }
        else{
            $bidding_schedule->save_as_template = false;
        }
        $bidding_schedule->currently_active = true;

        $bidding_schedule->update();

        foreach ($validatedData['shiftQueue'] as $shift){
            $arrayString = explode(":", $shift);
            if ($arrayString[1] == "on")
            {
                $shiftID = (int)$arrayString[0];
                $bidding_schedule->shift()->attach($shiftID);
            }

        }

        BiddingQueue::where('bidding_schedule_id', $id)->delete(); //Delete all the rows beloging to a Schedule created in the Queue

        $bidding_spot_index = 1;  //Index to define the position in the bidding user queue.

        foreach ($validatedData['officerQueue'] as $officer){

            $arrayString = explode(":", $officer);

            if (!$arrayString[1] == "" || !$arrayString[1] == "0"){

                $officerIDInt = (int)$arrayString[0];

                $bidding_queue = new BiddingQueue();
                $officerObject = User::where(['id'=>$officerIDInt])->firstOrFail();
                $bidding_queue->user_id = $officerIDInt;
                $bidding_queue->bidding_schedule_id = $id;
                $bidding_queue->bidding_spot = $bidding_spot_index;
                $bidding_spot_index = $bidding_spot_index + 1;
                if ($arrayString[1] == 1){
                    $bidding_queue->bidding = true;
                    $bidding_queue->waiting_to_bid = false;
                    $bidding_queue->bid_submitted = false;
                    $bidding_queue->start_time_bidding = null;
                    $bidding_queue->end_time_bidding = null;
                }
                else{
                    $bidding_queue->bidding = false;
                    $bidding_queue->waiting_to_bid = true;
                    $bidding_queue->bid_submitted = false;
                    $bidding_queue->start_time_bidding = null;
                    $bidding_queue->end_time_bidding = null;
                }
                $bidding_queue->save();
            }
        }

        return redirect()->route('admin.bidding-schedule.index')->with('updated', 'Bidding Schedule updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(NewBiddingSchedule $biddingSchedule)
    {
        $biddingSchedule->delete();

        return redirect()->route('admin.bidding-schedule.index')->with('deleted', 'Bidding Schedule deleted successfully!');
    }

    /**
     * Send Email to an user
     *
     * @param int $id User Id
     * @return boolean email sent result
    **/
    public function sendEmail(User $user, NewBiddingSchedule $schedule)
    {
        /*$data['title'] = "Hello {$user->name},
                            You are next to bid in the schedule {$schedule->name}.
                            You have only {$schedule->response_time} hours to bid.";
        Mail::send(['text'=>'mail'], $data, function($message) use ($user) {

            $message->to($user->email, $user->name)

                ->subject('Bid on Schedule');
        });*/
        Mail::to($user)->send(new EmailNotification($user, $schedule));

        if (Mail::failures()) {
            //return response()->Fail('Sorry! Please try again latter');
            return false;
        }else{
            //return response()->success('Great! Successfully send in your mail');
            return true;
        }
    }
}
