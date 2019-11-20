@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-start mt-3 mb-3">
        <div class="col-md">
            <h3>{{ __('Schedules') }}</h3>
        </div>
    </div>
</div>

<div class="container">
	<div class="row mt-3 mb-3 d-flex justify-content-end">
		<div class="col-md-4 d-flex justify-content-end">
			<a href="{{ route('admin.schedules.create') }}"><button type="button" class="btn btn-success">Create New Schedule</button></a>
		</div>
	</div>
</div>


<!--If no record of schedules were found show warning and show button to Create New Schedule-->

@isset($schedules)

<!--If record of schedules were found show button to Create New Schedule and show the list of schedules-->

    <div class="container shadow">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="table-responsive-md">
                    <table class="table">
                        <thead>
                            <tr>
                            <th class="text-center" scope="col">Name</th>
                            <th class="text-center" scope="col">Start Date</th>
                            <th class="text-center" scope="col">End Date</th>
                            <th class="text-center" scope="col">Response Time</th>
                            <th class="text-center" scope="col">Satatus</th>
                            <th class="text-center" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedules as $schedule)
                                <tr>
                                    <td class="text-center">{{ $schedule->name }}</td>
                                    <td class="text-center">{{ date('m-d-Y', strtotime($schedule->start_date)) }}</td>
									<td class="text-center">{{ date('m-d-Y', strtotime($schedule->end_date)) }}</td>  
                                    <td class="text-center">{{ $schedule->response_time }} hours</td>
                                    <td class="text-center">@if ($schedule->currently_active == 1)
                                                                Active
                                                            @else
                                                                Inactive
                                                            @endif
                                    </td>
                                    <td>
										<div class="row">
											<div class="col text-center">
                                                @if ($schedule->currently_active == 1)
                                                    <a href="{{ route('admin.schedules.biddingQueue', $schedule->id) }}"><button type="button" class="btn btn-primary">Queue</button></a>
                                                @else
                                                    <a href="{{ route('admin.schedules.edit', $schedule->id) }}"><button type="button" class="btn btn-primary">Edit</button></a>
                                                @endif
                                            </div>

											@if($schedule->active == 0)
												<div class="col text-center">
													<form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" class="delete">
														<input type="hidden" name="_method" value="DELETE">
														@csrf
														@method("DELETE")
														<button type="submit" onclick="return confirm('Delete {{$schedule->name}}?')" class="btn btn-danger">Delete</button>
													</form>
												</div>
											@endif
                                        </div>
                                    </td>
                                    
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
					{{$schedules->links()}}
                </div>
            </div>
        </div>
    </div>
@else
<div class="container">
	<div class="row mt-3 mb-3 d-flex justify-content-end">
		<div class="col-md-4 d-flex justify-content-end">
			<a href="{{ route('admin.schedules.create') }}"><button type="button" class="btn btn-success">Create New Schedule</button></a>
		</div>
	</div>
</div>
@endisset


@endsection