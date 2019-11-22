@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-start mt-3 mb-3">
        <div class="col-md">
            <h3>{{ __('Schedules') }}</h3>
        </div>
    </div>
</div>


<!--If no record of schedules were found show warning and show button to Create New Schedule-->

@isset($bidding_queues)

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
                            @foreach($bidding_queues as $queue)
                                <tr>
                                    <td class="text-center">{{ $queue->schedule->name }}</td>
                                    <td class="text-center">{{ date('m-d-Y', strtotime($queue->schedule->start_date)) }}</td>
									<td class="text-center">{{ date('m-d-Y', strtotime($queue->schedule->end_date)) }}</td>  
                                    <td class="text-center">{{ $queue->schedule->response_time }} hours</td>
                                    <td class="text-center">@if ($queue->schedule->currently_active == 1)
                                                                Active
                                                            @else
                                                                Inactive
                                                            @endif
                                    </td>
                                    <td>
										<div class="row">
											<div class="col text-center">
												@if ($queue->waiting_to_bid == 1)
													{{__('Waiting to bid')}}
                                                @elseif ($queue->bidding == 1)
                                                    <a href="{{ route('user.schedules.bid', $queue->schedule->id) }}" ><button type="button" class="btn btn-primary">Bid</button></a>
                                                @elseif ($queue->bid_submitted == 1) 
                                                    <form action="{{ route('user.schedules.viewbid', $queue->bid_id) }}" method="GET">
                                                        <button type="submit" class="btn btn-primary">{{ __('View Bid') }}</button>
                                                    </form>
													
                                                @endif
                                            </div>		
                                        </div>
                                    </td>
                                    
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
					
                </div>
            </div>
        </div>
    </div>
@else
	<div class="container overflow-auto shadow mt-3 p-3">
        <div class="row mt-3">
            <div class="col-auto">
                <h5>There is no Schedule available.</h5>   
            </div>
        </div>
    </div>
@endisset


@endsection