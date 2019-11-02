@extends('layouts.app')

@section('content')


<!-- Badge Logo -->
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col">
            
            <img src='img/badge.gif' class="rounded mx-auto d-block img-fluid" alt='Badge' >
                <br>
        </div>
    </div>
</div> -->

<div class="container">
    <div class="row justify-content-start">
        <div class="col col-md">
            <h1>Bid on Schedule </h1>
            <form action="{{ route('user.biddingschedule.show', 'schedule_id') }}" method="GET" class="delete">
           
            @csrf
                <div class="form-row align-items-center mt-5">
                    <div class="col-auto my-1">
                        <label class="mr-sm-2 sr-only" for="schedule_id">Select Schedule</label>
                        <select class="custom-select mr-sm-2" id="schedule_id" name="schedule_id">
                            <!-- <option selected>Select a Schedule</option> -->
                            @isset($schedules)
                                @foreach ($schedules as $sched)
                                <option value="{{ $sched->id }}">{{ $sched->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div class="col-auto my-1">
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@isset($shifts)

<div class="container overflow-auto shadow mt-3 p-3">
    <div class="row mt-3">
        <div class="col-auto">
            <h5>Schedule Name:</h5>
        </div>
        <div class="col-auto">
            <h5>{{ $schedule->name }}</h5>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-auto">
            <h5>Start Date:</h5>
        </div>
        <div class="col-auto">
            <h5>{{ $schedule->start_day }}</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-auto">
            <h5>End Date:</h5>
        </div>
        <div class="col-auto">
            <h5>{{ $schedule->end_day }}</h5>
        </div>
    </div>
    <div class="row mt-3 ml-2 mr-2">
        <table class="table text-center table-bordered">
            <thead>
                <tr>
                <th scope="col">Shift</th>
                <th scope="col">Start Time</th>
                <th scope="col">End Time</th>
                <th scope="col">Early Start</th>
                <th scope="col">Early Ends</th>
                <th scope="col">Num. Early Spots</th>
                <th scope="col">Minimum Staffing</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach($shifts as $shift)
                <tr>
                    <th scope="row">{{ $shift->name }}</th>
                    <td>{{ $shift->start_time }}</td>
                    <td>{{ $shift->end_time }}</td>
                    <td>{{ $shift->early_start_time }}</td>
                    <td>{{ $shift->early_end_time }}</td>
                    <td>{{ $shift->num_early_spot }}</td>
                    <td>{{ $shift->minimun_staff }}</td>
                    </tr>
                @endforeach

                <tr>
                </tr>
            </tbody>
        </table>
    </div>
<form action="{{ route('user.biddingschedule.store') }}" method="POST" class="delete">
<!-- <form action="#" method="POST" class="delete"> -->
@csrf

    <input type="hidden" id="schedule" name="schedule_id" value={{ $schedule->id }}>
    <div class="row mt-3 ml-2 mr-2">
        <table class="table text-center table-bordered">
            <thead>
                <tr>
                <th style="width: 10%" scope="col">Select Shift</th>
                <th scope="col">Friday</th>
                <th scope="col">Saturday</th>
                <th scope="col">Sunday</th>
                <th scope="col">Monday</th>
                <th scope="col">Tuesday</th>
                <th scope="col">Wednesday</th>
                <th scope="col">Thursday</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <th scope="row"> 
                    <select class="custom-select mr-sm-1" id="shift_id" name="shift_id">
                        <option selected>Shift</option>

                        @foreach($shifts as $shift)
                            <option value={{ $shift->shift_id }}>{{ $shift->name }}</option>
                        @endforeach

                    </select>
                </th>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="friday" name="friday" value="1">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="saturday" name="saturday" value="1">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="sunday" name="sunday" value="1">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="monday" name="monday" value="1">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="tuesday" name="tuesday" value="1">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="wednesday" name="wednesday" value="1">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="thursday" name="thursday" value="1">
                    </div>
                </td>
                </tr>
                <tr>
            </tbody>
        </table>
    </div>
    <div class="row mt-3 ml-2 mr-2">
        <table class="table text-center table-bordered">
            <thead>
                <tr>
                <th style="width: 10%" scope="col">Early Shift?</th>
                <th scope="col">Friday</th>
                <th scope="col">Saturday</th>
                <th scope="col">Sunday</th>
                <th scope="col">Monday</th>
                <th scope="col">Tuestday</th>
                <th scope="col">Wednesday</th>
                <th scope="col">Thursday</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <th scope="row">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="early_shift" name="early_shift" value="1">
                    </div>
                </th>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="friday" name="e_friday" value="1">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="saturday" name="e_saturday" value="1">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="sunday" name="e_sunday" value="1">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="monday" name="e_monday" value="1">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="tuesday" name="e_tuesday" value="1">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="wednesday" name="e_wednesday" value="1">
                    </div>
                </td>
                <td>
                    <div class="form-check pb-4">
                        <input class="form-check-input" type="checkbox" id="thursday" name="e_thursday" value="1">
                    </div>
                </td>
                </tr>      
            </tbody>
        </table>
        <div class="col-auto my-1">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>
</div>

@endisset

@isset($already_bid)
<div class="container overflow-auto shadow mt-3 p-3">
    <div class="row mt-3">
        <div class="col-auto">
            <h5>You already bid on <strong>{{ $schedule->name }}</strong></h5>   
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-auto">
            <h5>See your bid? </strong></h5>   
        </div>
    </div>
</div>

@endisset


<!-- <div style="height: 500px" class="container">
    <div class="row justify-content-center border border-primary h-100">
        <div class="col col-md-8 align-self-center">

        <h5>Select available schedule to bid on.</h5>
        
    </div>
</div> -->
@endsection