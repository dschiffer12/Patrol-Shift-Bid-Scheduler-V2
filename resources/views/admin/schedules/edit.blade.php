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
    <div class="container">
		@foreach($specialties as $specialty)
			<div class="row mt-3">
				<div class="col col-12 border border-info">
					<h3>{{$specialty->name}}</h3>
					
						@foreach($specialty->shifts as $shift)
						@if($shift->schedule_id == $schedule->id)
						<form action="{{ route('admin.schedules.deleteShift', $schedule->id) }}" method="POST" class="delete">
						@csrf
						<input type="hidden" id="shift" name="shift_id" value={{ $shift->id }}>
						<div class="container overflow-auto mb-3">
							<div class="row">
								<div class="col-auto">
									<h5>Shift Name:</h5>
								</div>
								<div class="col-auto">
									<h5><strong>{{ __($shift->name) }}</strong></h5>
								</div>
								<div class="col-auto">
									<button type="submit"  class="btn btn-outline-danger mb-3">Delete Shift</button>
								</div>
								
							</div>
							</form>
<!-- start of the shifts table -->
							<div class="row">
								<div class="col-auto">	
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
													<form action="{{ route('admin.schedules.deleteSpot', $schedule->id) }}" method="POST" class="delete">
													@csrf
													<input type="hidden" id="shift" name="shift_id" value={{ $shift->id }}>
													<tr>
													@php ($i = $loop->iteration)
													@php ($spot_id[$i] = $spot->id)
														<th scope="row">{{ $loop->iteration }}</th>
														
														@foreach($days_s as $start_time)
															<td>
																<div class="row">
																@isset($spot->$start_time)
																@php($end_time = $days_e[$loop->index])
																	<div class="col">
																		{{ $spot->$start_time }}
																	</div>
																	<div class="col">
																		{{ $spot->$end_time }}
																	</div>
																@else
																	<div class="col">
																		<h5><strong>OFF</strong></h5>
																	</div>
																@endif
																</div>
															</td>

														@endforeach
														
														<td>
															<div class="row">
																<div class="col">
																	<h6>{{$spot->qty_available }}
																</div>
															</div>
														</td>
														<td>
															<div class="row">
																<div class="col">
																	<input type="hidden" id="spot_id" name="spot_id" value={{ $spot->id }}>
																	<button type="submit"  class="btn btn-danger">Delete</button>
																</div>
															</div>
														</td>

													</tr>
												</form>
												@endforeach
												@endisset
	
												<form action="{{ route('admin.schedules.addSpot', $schedule->id) }}" method="POST" class="delete">
												@csrf
													<input type="hidden" id="shift_id" name="shift_id" value={{ $shift->id }}>
													<tr>
														<th scope="row">{{ $i + 1}}</th>
														
														@for ($n = 0; $n < sizeof($days_s); $n++)
														<td>
														<div class="row">
															<div class="col">
																<select class="custom-select mr-sm-2" id={{$days_s[$n]}} name={{$days_s[$n]}}>
																	<option value="">OFF</option>
																		{{ $time = strtotime("+0 minutes", strtotime("00:00:00")) }}
																																		
																		@for ($j = 0; $j < 24; $j++)
																			<option value="{{ date('H:i:s', $time) }}">{{ date('H:i:s', $time) }}</option>	
																			{{ $time += 3600}}
																		@endfor
																</select>
															</div>
															<div class="col">
																<select class="custom-select mr-sm-2" id={{$days_e[$n]}} name={{$days_e[$n]}}>
																	<option value="">OFF</option>
																		{{ $time = strtotime("+0 minutes", strtotime("00:00:00")) }}
																																		
																		@for ($j = 0; $j < 24; $j++)
																			<option value="{{ date('H:i:s', $time) }}">{{ date('H:i:s', $time) }}</option>	
																			{{ $time += 3600}}
																		@endfor
																</select>
															</div>
														</div>	
														</td>
														@endfor
<!-- availanility set -->
														<td>
															<div class="row">
																<div class="col">
																	<select required class="custom-select mr-sm-2" id="qty_available" name="qty_available">																
																		@for ($m = 1; $m < 10; $m++)
																			<option value="{{ $m }}">{{ __($m) }}</option>
																		@endfor
																	</select>
																</div>
															</div>
														</td>
														<td>
															<button type="submit"  class="btn btn-info">Add</button>
														</td>
													</tr>
												</form>
												
											</tbody>
										</table>
								</div>
							</div>			
						</div>
						@endif
						@endforeach
					
					<form action="{{ route('admin.schedules.addShift', $schedule->id) }}" method="POST" class="delete">
					@csrf
					<div class="row mt-3">
						<div class="col-auto ml-2">
							<div class="btn-group">							
								<label for="shift_name" class="col-md-4 col-form-label text-md-right"><h5>{{ __('Shift Name:') }}</h5></label>
								<div class="col-md-6">
									<input id="shift_name" type="text" class="form-control @error('shift_name') is-invalid @enderror" name="shift_name" value="{{ old('shift_name') ? old('shift_name') : ''}}" autocomplete="shift_name" autofocus>

									@error('shift_name')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
								<div class="col-md-6">
									<input type="hidden" id="specialty_id" name="specialty_id" value={{ $specialty->id }}>
									<input type="hidden" id="schedule_id" name="schedule_id" value={{ $schedule->id }}>
									<button type="submit"  class="btn btn-success">Add Shift</button>
								</div>
                        	</div>
						</form>
					</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>

	<div class="row mt-3">
		<div class="col ml-3">
			<form action="{{ route('admin.schedules.addUsers', $schedule->id) }}" method="GET" class="delete">	
				<button type="submit"  class="btn btn-primary float-right">Add Users ></button>
			</form>
		</div>
	</div>
</div>

@endisset

<!-- <script type="text/javascript">
	$(window).scroll(function() {
		sessionStorage.scrollTop = $(this).scrollTop();
	});

	$(document).ready(function() {
		if (sessionStorage.scrollTop != "undefined") {
			$(window).scrollTop(sessionStorage.scrollTop);
		}
	});
</script> -->

@endsection