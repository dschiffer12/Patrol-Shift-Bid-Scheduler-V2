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
				</div>
			</div>
<!-- users table -->
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
									@foreach($users as $user)
									@foreach($user->specialties as $userSpecialty)
									@if ($userSpecialty->name == $specialty->name)
									@php ($i++)
										<tr>
										<th scope="row">{{$i}}</th>
										<td class="text-center">{{ $user->name }}</td>
										<td class="text-center">{{ $user->email }}</td>
										<td class="text-center">{{ implode(', ', $user->roles()->get()->pluck('name')->toArray()) }}</td>
										<td class="text-center">{{ date('m-d-Y', strtotime($user->date_in_position)) }}</td>
										<td class="text-center">{{ implode(', ', $user->specialties()->get()->pluck('name')->toArray()) }}</td>
										
										<td>
										<div class="input-group mb-3">
											<div class="row">
												<div class="col"> 
													<!-- <input type="hidden" name="allSpecialties[{{$specialty->id}}][{{$user->id}}]" id="{{ $specialty->id }}"/> -->
													<!-- <input type="hidden" name="specialties[]" id="{{ $specialty->id }}" value="{{ $specialty->id }}" /> -->
													<input type="number" name="allSpecialties[{{$specialty->id}}][{{$user->id}}]" id="{{ $specialty->id }}"  min="0" max="9999" value=0>
												</div>	
											</div>

										</div>     
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

	<!-- end table -->

		</div>				
		@endforeach
	
	

	<div class="row mt-3">
		<div class="col ml-3">
				
				<button type="submit"  class="btn btn-primary float-right">Add Users ></button>
			
		</div>
	</div>
	</form>
</div>


@endisset

@endsection