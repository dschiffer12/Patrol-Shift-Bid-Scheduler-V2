@extends('layouts.app')

@section('content')


@isset($shifts)

<div class="container">
    <div class="row justify-content-start mt-5">
        <div class="col col-md">
            <h2>You are bidding for: <strong>{{ $user->name }} </strong></h2>     
        </div>
    </div>
</div>

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
@csrf

    <input type="hidden" id="schedule" name="schedule_id" value={{ $schedule->id }}>
	<input type="hidden" name="user_id" value={{ $user->id }}>
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

@endsection