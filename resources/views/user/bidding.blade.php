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

@isset($schedules)
    <div class="container">
        <div class="row justify-content-start mt-5">
            <div class="col col-md">
                <h1>{{ __('Bid on Schedule') }}</h1>
                <form action="{{ route('user.biddingschedule.show', 'schedule_id') }}" method="GET" class="form-inline">        
                @csrf
                    <label class="my-1 mr-2" for="bid_id">{{ __('Select a Schedule') }}</label>	
                    <select required class="custom-select mr-sm-2" id="bid_id" name="schedule_id">
                        <option value="">Schedules...</option>
                        @isset($schedules)
                            @foreach ($schedules as $sched)
                            <option value="{{ $sched->id }}">{{ $sched->name }}</option>
                            @endforeach
                        @endisset
                    </select>
                    <div class="col-auto my-1">
                        <button type="submit" class="btn btn-primary">{{ __('Display') }}</button>
                    </div>    
                </form>
            </div>
        </div>
    </div>

@else
    <div class="container overflow-auto shadow mt-3 p-3">
        <div class="row mt-3">
            <div class="col-auto">
                <h5>There is no Bidding Schedule for you to bid on.</h5>   
            </div>
        </div>
    </div>
@endisset

@isset($numInQueue)
    <div class="container overflow-auto shadow mt-3 p-3">
        <div class="row mt-3">
            <div class="col-auto">
            @if($numInQueue > 1)
                <h5>You are number {{ $numInQueue }} in line to bid.</h5>
            @else
                <h5>You are next in line to bid.</h5>
            @endif   
            </div>
        </div>
    </div>
@endisset



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
                    <select required class="custom-select mr-sm-1" id="shift_id" name="shift_id">
                        <option value="">Shift</option>

                        @foreach($shifts as $shift)
                            <option value={{ $shift->shift_id }}>{{ $shift->name }}</option>
                        @endforeach

                    </select>
                </th>
                <td>
                    <div class="form-check">
                        <input class="day form-check-input" type="checkbox" id="friday" name="friday" value="1" onclick="toggleEarly()">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="day form-check-input" type="checkbox" id="saturday" name="saturday" value="1" onclick="toggleEarly()">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="day form-check-input" type="checkbox" id="sunday" name="sunday" value="1" onclick="toggleEarly()">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="day form-check-input" type="checkbox" id="monday" name="monday" value="1" onclick="toggleEarly()">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="day form-check-input" type="checkbox" id="tuesday" name="tuesday" value="1" onclick="toggleEarly()">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="day form-check-input" type="checkbox" id="wednesday" name="wednesday" value="1" onclick="toggleEarly()">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="day form-check-input" type="checkbox" id="thursday" name="thursday" value="1" onclick="toggleEarly()">
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
                        <input class="form-check-input" type="checkbox" id="early_shift" name="early_shift" value="1" onclick="toggleEarly()">
                    </div>
                </th>
                <td>
                    <div class="form-check">
                        <input disabled class="early form-check-input" type="checkbox" id="e_friday" name="e_friday" value="1">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input disabled class="early form-check-input" type="checkbox" id="e_saturday" name="e_saturday" value="1">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input disabled class="early form-check-input" type="checkbox" id="e_sunday" name="e_sunday" value="1">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input disabled class="early form-check-input" type="checkbox" id="e_monday" name="e_monday" value="1">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input disabled class="early form-check-input" type="checkbox" id="e_tuesday" name="e_tuesday" value="1">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input disabled class="early form-check-input" type="checkbox" id="e_wednesday" name="e_wednesday" value="1">
                    </div>
                </td>
                <td>
                    <div class="form-check pb-4">
                        <input disabled class="early form-check-input" type="checkbox" id="e_thursday" name="e_thursday" value="1">
                    </div>
                </td>
                </tr>      
            </tbody>
        </table>
        <div class="col-auto my-1">
            <button type="submit" onclick="return confirm('Submit Bid?')" class="btn btn-primary">Submit</button>
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
            <h5 class="d-inline-block">{{ __('See your bids here: ') }}</h5>
            <button type="button" class="btn ">
                <a href="{{ route('user.biddingschedule.bids') }}"><h5>{{ __('My Bids') }}</h5></a>
            </button>
        </div>
    </div>
</div>

@endisset

<script type="text/javascript">
	function toggleEarly() {
		var early = document.getElementById('early_shift');
		var elems = document.getElementsByClassName('early');
		var days = document.getElementsByClassName('day');
		
		for(i=0; i<elems.length; i++) {
			if(early.checked && days[i].checked) {
				elems[i].disabled = false;
			} else {
				elems[i].disabled = true;
			}
			elems[i].checked = false;
		}	
	}
</script>


<!-- <div style="height: 500px" class="container">
    <div class="row justify-content-center border border-primary h-100">
        <div class="col col-md-8 align-self-center">

        <h5>Select available schedule to bid on.</h5>
        
    </div>
</div> -->
@endsection