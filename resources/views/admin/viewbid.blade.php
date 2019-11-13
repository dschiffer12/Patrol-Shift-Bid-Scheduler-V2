@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-start mt-5">
        <div class="col col-md">
            <h1>Bid of user: {{ $user->name }} </h1>     
        </div>
    </div>
</div>

@isset($schedule)

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
	<div class="row">
        <div class="col-auto">
            <h5>Shift Name:</h5>
        </div>
        <div class="col-auto">
            <h5>{{ $shift->name }}</h5>
        </div>
    </div>
	<div class="row">
        <div class="col-auto">
            <h5>Early Shift?:</h5>
        </div>
        <div class="col-auto">
            <h5>{{ isset($bid_early_shift) ? "Yes" : "No"}} </h5>
        </div>
    </div>
    


	<div class="row mt-3 ml-2 mr-2">
        <table class="table text-center table-bordered">
            <thead>
                <tr>
                <th style="width: 10%" scope="col"></th>
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
                    <h6><strong>Shift Starts</strong></h6>
                </th>

                <td>
					@if($bid->friday > 0)
						<h6>
						@if(isset($bid_early_shift) && $bid_early_shift->friday > 0)
							{{$early_shift->early_start_time}}
						@else
							{{$shift->start_time}}
						@endif
						</h6>
					@endif
                </td>
                <td>
					@if($bid->saturday > 0)
						<h6>
						@if(isset($bid_early_shift) && $bid_early_shift->saturday > 0)
							{{$early_shift->early_start_time}}
						@else
							{{$shift->start_time}}
						@endif
						</h6>
					@endif
                </td>
                <td>
					@if($bid->sunday > 0)
						<h6>
						@if(isset($bid_early_shift) && $bid_early_shift->sunday > 0)
							{{$early_shift->early_start_time}}
						@else
							{{$shift->start_time}}
						@endif
						</h6>
					@endif
                </td>
                <td>
					@if($bid->monday > 0)
						<h6>
						@if(isset($bid_early_shift) && $bid_early_shift->monday > 0)
							{{$early_shift->early_start_time}}
						@else
							{{$shift->start_time}}
						@endif
						</h6>
					@endif
                </td>
                <td>
					@if($bid->tuesday > 0)
						<h6>
						@if(isset($bid_early_shift) && $bid_early_shift->tuesday > 0)
							{{$early_shift->early_start_time}}
						@else
							{{$shift->start_time}}
						@endif
						</h6>
					@endif
                </td>
                <td>
					@if($bid->wednesday > 0)
						<h6>
						@if(isset($bid_early_shift) && $bid_early_shift->wednesday > 0)
							{{$early_shift->early_start_time}}
						@else
							{{$shift->start_time}}
						@endif
						</h6>
					@endif
                </td>
                <td>
					@if($bid->thursday > 0)
						<h6>
						@if(isset($bid_early_shift) && $bid_early_shift->thursday > 0)
							{{$early_shift->early_start_time}}
						@else
							{{$shift->start_time}}
						@endif
						</h6>
					@endif
                </td>
                </tr>
				<tr>
                <th scope="row">
                    <h6><strong>Shift Ends</strong></h6>
                </th>
                <td>
					@if($bid->friday > 0)
						<h6>
						@if(isset($bid_early_shift) && $bid_early_shift->friday > 0)
							{{$early_shift->early_end_time}}
						@else
							{{$shift->end_time}}
						@endif
						</h6>
					@endif
                </td>
                <td>
					@if($bid->saturday > 0)
						<h6>
						@if(isset($bid_early_shift) && $bid_early_shift->saturday > 0)
							{{$early_shift->early_end_time}}
						@else
							{{$shift->end_time}}
						@endif
						</h6>
					@endif
                </td>
                <td>
					@if($bid->sunday > 0)
						<h6>
						@if(isset($bid_early_shift) && $bid_early_shift->sunday > 0)
							{{$early_shift->early_end_time}}
						@else
							{{$shift->end_time}}
						@endif
						</h6>
					@endif
                </td>
                <td>
					@if($bid->monday > 0)
						<h6>
						@if(isset($bid_early_shift) && $bid_early_shift->monday > 0)
							{{$early_shift->early_end_time}}
						@else
							{{$shift->end_time}}
						@endif
						</h6>
					@endif
                </td>
                <td>
					@if($bid->tuesday > 0)
						<h6>
						@if(isset($bid_early_shift) && $bid_early_shift->tuesday > 0)
							{{$early_shift->early_end_time}}
						@else
							{{$shift->end_time}}
						@endif
						</h6>
					@endif
                </td>
                <td>
					@if($bid->wednesday > 0)
						<h6>
						@if(isset($bid_early_shift) && $bid_early_shift->wednesday > 0)
							{{$early_shift->early_end_time}}
						@else
							{{$shift->end_time}}
						@endif
						</h6>
					@endif
                </td>
                <td>
					@if($bid->thursday > 0)
						<h6>
						@if(isset($bid_early_shift) && $bid_early_shift->thursday > 0)
							{{$early_shift->early_end_time}}
						@else
							{{$shift->end_time}}
						@endif
						</h6>
					@endif
                </td>
                </tr>    
            </tbody>
        </table>
		<a href="{{ URL::previous() }}" class="btn btn-secondary">{{__('< Back')}}</a>
    </div>
</div>

@endisset

@endsection