@extends('layouts.app')

@section('content')


@isset($schedule)

<div class="container overflow-auto shadow mt-3 p-3">
	@isset($user)	
		<div class="row mt-3">
			<div class="col-auto">
				<h5>Bid of user:</h5>
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
            <h5><strong>{{ $schedule->currently_active == 1 ? "Active" : "Inactive"}}</strong> </h5>
        </div>
    </div>


<!-- Days array -->
@php ($days_s = array("friday_s", "saturday_s", "sunday_s", "monday_s", "tuesday_s", "wednesday_s", "thursday_s"))
@php ($days_e = array("friday_e","saturday_e", "sunday_e", "monday_e", "tuesday_e", "wednesday_e", "thursday_e"))
	
		
		<div class="container border mb-4">
			<div class="row mt-3">
				<div class="col col-12">
					<h3>{{$spot->shift->specialty->name}}</h3>						
						
						<div class="container overflow-auto mb-3">
							<div class="row">
								<div class="col-auto">
									<h5>Shift Name:</h5>
								</div>
								<div class="col-auto">
									<h5><strong>{{ __($spot->shift->name) }}</strong></h5>
								</div>	
							</div>
							
<!-- start of the shifts table -->
							<div class="row">
								<div class="col-md-12">	
										<table class="table text-center table-bordered">
											<thead>
												<tr>
												
												<th style="width: 12.86%" scope="col">Friday</th>
												<th style="width: 12.86%" scope="col">Saturday</th>
												<th style="width: 12.86%" scope="col">Sunday</th>
												<th style="width: 12.86%" scope="col">Monday</th>
												<th style="width: 12.86%" scope="col">Tuesday</th>
												<th style="width: 12.86%" scope="col">Wednesday</th>
												<th style="width: 12.86%" scope="col">Thursday</th>
												<th style="width: 5%" scope="col">Status</th>
												</tr>
											</thead>
											<tbody>
													<tr>
														
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
																	@if($bid->approved == 1)
																		<h5><strong>{{__('Approved')}}</strong></5>
																	@else
																	<h5>{{ __('Pending') }}</5>
																	@endif
																</div>
															</div>
														</td>
														
													</tr>
											
											</tbody>
										</table>
								</div>
							</div>
<!-- users end here -->
						</div>		
						

					
					
				</div>
			</div>
		
<!-- users table -->
			
<!-- End body forlop -->
								

	<!-- end table -->

		</div>				
		

		<div class="form-group row mb-0">
			<div class="col-md-2 ml-4">
				<a  class="btn btn-secondary float-start" href="{{ URL::previous() }}">
					{{ __('< Back') }}
				</a>     
			</div>  
		</div>
</div>


@endisset

@endsection