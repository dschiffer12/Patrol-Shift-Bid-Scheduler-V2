@extends('layouts.app')

@section('content')


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
            <h5>{{ $schedule->start_date }}</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-auto">
            <h5>End Date:</h5>
        </div>
        <div class="col-auto">
            <h5>{{ $schedule->end_date }}</h5>
        </div>
    </div>
	<div class="row">
        <div class="col-auto">
            <h5>Response Time (hours):</h5>
        </div>
        <div class="col-auto">
            <h5>{{ $schedule->response_time }}</h5>
        </div>
    </div>
	<div class="row">
        <div class="col-auto">
            <h5>Status:</h5>
        </div>
        <div class="col-auto">
            <h5>{{ $schedule->active == 1 ? "Active" : "Inactive"}} </h5>
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
		<form action="{{ route('admin.schedules.storeQueue', $schedule->id) }}" method="POST" class="delete">
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


						<!-- users start here -->
					<div class="container">
						<div class="row justify-content-center">
									<div class="col-md-12"> 
										<div class="table-responsive-md">      
											<table class="table">
												<thead>
													<tr>
													<th style="width: 5%" scope="col">Line</th>
													<th style="width: 18%" class="text-center" scope="col">Name</th>
													<th style="width: 18%" class="text-center" scope="col">Email</th>
													<th style="width: 18%" class="text-center" scope="col">Role</th>
													<th style="width: 18%" class="text-center" scope="col">Date in Position</th>
													<th style="width: 18%" class="text-center" scope="col">Specialties</th>
													<th style="width: 15%" class="text-center" scope="col">Order</th>
													</tr>
												</thead>
												<tbody>
													@php ($j = 0)
													@foreach($bidding_queue as $queue)
														@php ($user = $queue->user)
														@foreach($user->specialties as $userSpecialty)
															@if ($userSpecialty->id == $specialty->id)
															@php ($j++)
																<tr>
																<th scope="row">{{$j}}</th>
																<td class="text-center">{{ $user->name }}</td>
																<td class="text-center">{{ $user->email }}</td>
																<td class="text-center">{{ implode(', ', $user->roles()->get()->pluck('name')->toArray()) }}</td>
																<td class="text-center">{{ date('m-d-Y', strtotime($user->date_in_position)) }}</td>
																<td class="text-center">{{ implode(', ', $user->specialties->pluck('name')->toArray()) }}</td>
																<td class="text-center">{{ $queue->bidding_spot }}</td>
																
																<td>     
																</td>
																</tr>
															@endif
														@endforeach
														@endforeach
													@php ($i=0)					
												</tbody>
											</table>
											
										</div>
									</div>
								</div>
					</div>



					
				</div>
			</div>
		
<!-- users table -->
			
<!-- End body forlop -->
								

	<!-- end table -->

		</div>				
		@endforeach
		
	<div class="row mt-3">
		<div class="col ml-3">
			<a  class="btn btn-primary float-right mb-3" href="{{ route('admin.schedules.activateSchedule', $schedule->id) }}">
				{{ __('Activate Schedule') }}
			</a>  	
			<!-- <button type="submit"  class="btn btn-primary float-right">Approve</button>	 -->
		</div>
	</div>
	</form>
</div>


@endisset

@endsection