@extends('layouts.app')

@section('content')


@isset($schedule)

<div class="container overflow-auto shadow mt-3 p-4">
	@isset($user)	
		<div class="row mt-3">
			<div class="col-auto">
				<h5>Bidding for user:</h5>
			</div>
			<div class="col-auto">
				<h2></strong>{{ $user->name }}</strong></h2>
			</div>
		</div>
	@endisset

    <div class="row mt-3">
        <div class="col-auto">
            <h5>Schedule Name:</h5>
        </div>
        <div class="col-auto">
            <h5><strong>{{ $schedule->name }}</strong></h5>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-auto">
            <h5>Start Date:</h5>
        </div>
        <div class="col-auto">
            <h5><strong>{{ $schedule->start_date }}</strong></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-auto">
            <h5>End Date:</h5>
        </div>
        <div class="col-auto">
            <h5><strong>{{ $schedule->end_date }}</strong></h5>
        </div>
    </div>
	<div class="row">
        <div class="col-auto">
            <h5>Response Time (hours):</h5>
        </div>
        <div class="col-auto">
            <h5><strong>{{ $schedule->response_time }}</strong></h5>
        </div>
    </div>
	<div class="row">
        <div class="col-auto">
            <h5>Status:</h5>
        </div>
        <div class="col-auto">
            <h5><strong>{{ $schedule->currently_active == 1 ? "Active" : "Inactive"}} </strong></h5>
        </div>
    </div>


<!-- Days array -->
@php ($days_s = array("friday_s", "saturday_s", "sunday_s", "monday_s", "tuesday_s", "wednesday_s", "thursday_s"))
@php ($days_e = array("friday_e","saturday_e", "sunday_e", "monday_e", "tuesday_e", "wednesday_e", "thursday_e"))
	<div class="row mt-3">
        <div class="col-auto">
            <h3>All Specialties</h3>
        </div>
    </div>
		@php ($i=0)
		@php ($allSpecialties = array('specialties'))
		@isset($user)
		<form action="{{ route('admin.schedules.bidforuser') }}" method="POST">
		<input type="hidden" id="shift" name="user_id" value={{ $user->id }}>
		@endisset
		<form action="{{ route('user.schedules.store') }}" method="POST">
		
		@csrf
		@foreach($specialties as $specialty)
		<div class="container border mb-4">
			<div class="row mt-3">
				<div class="col col-12">
					<h3>{{$specialty->name}}</h3>

<!-- start here -->
						@foreach($specialty->shifts as $shift)
						@if($shift->schedule_id == $schedule->id)
						
						<input type="hidden" id="shift" name="shift_id" value={{ $shift->id }}>
						<div class="container overflow-auto mb-3">
							<div class="row">
								<div class="col-auto">
									<h5>Shift Name:</h5>
								</div>
								<div class="col-auto">
									<h5><strong>{{ __($shift->name) }}</strong></h5>
								</div>		
							</div>
							
<!-- start of the shifts table -->
							<div class="row">
								<div class="col-md-12">	
										<table class="table text-center table-bordered">
											<thead>
												<tr>
												<th style="width: 5%" scope="col">Spot</th>
												<th style="width: 12.86%" scope="col">Friday</th>
												<th style="width: 12.86%" scope="col">Saturday</th>
												<th style="width: 12.86%" scope="col">Sunday</th>
												<th style="width: 12.86%" scope="col">Monday</th>
												<th style="width: 12.86%" scope="col">Tuesday</th>
												<th style="width: 12.86%" scope="col">Wednesday</th>
												<th style="width: 12.86%" scope="col">Thursday</th>
												<th style="width: 5%" scope="col">Available</th>
												<th style="width: 5%" scope="col">Select</th>
												</tr>
											</thead>
											<tbody>
												@php ($i = 0)
												@php ($spot_id = array())
												@isset($shift->spots)
												@foreach($shift->spots as $spot)
													<tr>
													@php ($i = $loop->iteration)
													@php ($spot_id[$i] = $spot->id)
														<th scope="row">{{ $loop->iteration }}</th>
														<td>
															<div class="row">
															@isset($spot->friday_s)
																<div class="col">
																	{{ $spot->friday_s }}
																</div>
																<div class="col">
																	{{ $spot->friday_e }}
																</div>
															@else
																<div class="col">
																	<h5><strong>OFF</strong></h5>
																</div>
															@endif
															</div>
														</td>
														<td>
															<div class="row">
															@isset($spot->saturday_s)
																<div class="col">
																	{{$spot->saturday_s }}
																</div>
																<div class="col">
																	{{$spot->saturday_e }}
																</div>
															@else
																<div class="col">
																	<h5><strong>OFF</strong></h5>
																</div>
															@endif
															</div>
														</td>
														<td>
															<div class="row">
															@isset($spot->sunday_s)
																<div class="col">
																	<h6>{{$spot->sunday_s }}
																</div>
																<div class="col">
																	<h6>{{$spot->sunday_e }}
																</div>
															@else
																<div class="col">
																	<h5><strong>OFF</strong></h5>
																</div>
															@endif
															</div>
														</td>
														<td>
															<div class="row">
															@isset($spot->monday_s)
																<div class="col">
																	<h6>{{$spot->monday_s }}
																</div>
																<div class="col">
																	<h6>{{$spot->monday_e }}
																</div>
															@else
																<div class="col">
																	<h5><strong>OFF</strong></h5>
																</div>
															@endif
															</div>
														</td>
														<td>
															<div class="row">
															@isset($spot->tuesday_s)
																<div class="col">
																	<h6>{{$spot->tuesday_s }}
																</div>
																<div class="col">
																	<h6>{{$spot->tuesday_e }}
																</div>
															@else
																<div class="col">
																	<h5><strong>OFF</strong></h5>
																</div>
															@endif
															</div>
														</td>
														<td>
															<div class="row">
															@isset($spot->wednesday_s)
																<div class="col">
																	<h6>{{$spot->wednesday_s }}
																</div>
																<div class="col">
																	<h6>{{$spot->wednesday_e }}
																</div>
															@else
																<div class="col">
																	<h5><strong>OFF</strong></h5>
																</div>
															@endif
															</div>
														</td>
														<td>
															<div class="row">
															@isset($spot->thursday_s)
																<div class="col">
																	<h6>{{$spot->thursday_s }}
																</div>
																<div class="col">
																	<h6>{{$spot->thursday_e }}
																</div>
															@else
																<div class="col">
																	<h5><strong>OFF</strong></h5>
																</div>
															@endif
															</div>
														</td>
														<td>
															<div class="row">
																<div class="col">
																	<h6>{{$spot->qty_available }}
																</div>
															</div>
														</td>
														<td>
															@if ($spot->qty_available > 0)
																<div class="form-check">
																	<input class="form-check-input" type="radio" id="spot_id" name="spot_id" onclick="toggleSubmit()" value={{$spot->id}}>
																</div>
															@else
																<div class="form-check">
																	<input class="form-check-input" disabled type="radio" id="spot_id" name="spot_id" value=0>
																</div>
															@endif
														</td>	
													</tr>
												
												@endforeach
												@endisset
	
											</tbody>
										</table>
								</div>
							</div>
<!-- users end here -->
						</div>		
						
						@endif
						@endforeach
					
				</div>
			</div>
		
<!-- users table -->
			
<!-- End body forlop -->
								

	<!-- end table -->

		</div>				
		@endforeach
		

		<div class="form-group row mb-0">
			<div class="col-md-2 offset-md-1">
				<a  class="btn btn-secondary float-start" href="{{ URL::previous() }}">
					{{ __('< Back') }}
				</a>     
			</div>
			<div class="col">
				<button type="submit" disabled id="submit_btn" class="btn btn-primary float-right">
					{{ __('Submit') }}
				</button>
			</div>   
		</div>
	</form>
</div>


@endisset

<script type="text/javascript">
	function toggleSubmit() {
		var button = document.getElementById('submit_btn');
		button.disabled = false;	
	}
</script>

@endsection