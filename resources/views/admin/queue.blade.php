@extends('layouts.app')

@section('content')

@isset($schedules)
    <div class="container">
        <div class="row justify-content-start mt-5">
            <div class="col col-md">
                <h1>{{ __('Avtive Bidding Queue') }}</h1>
                <form action="{{ route('admin.bidding-queue.show', 'schedule_id') }}" method="GET" class="form-inline">        
                @csrf
                    <label class="my-1 mr-2" for="bid_id">{{ __('Select an active Schedule') }}</label>	
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
                <h5>There is no active Bidding Schedule.</h5>   
            </div>
        </div>
    </div>
@endisset

@isset($biddingQueue)
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
    <div class="row mb-3">
        <div class="col-auto">
            <h5>End Date:</h5>
        </div>
        <div class="col-auto">
            <h5>{{ $schedule->end_day }}</h5>
        </div>
    </div>

<!-- <div class="row mt-3 ml-2 mr-2"> -->

    <div class="table-responsive-md"> 
        <table class="table text-center table-bordered">
            <thead>
                <tr>
					<th style="width: 10%" scope="col">Line</th>
					<th scope="col">Name</th>
					<th scope="col">Role</th>
					<th scope="col">Bid Status</th>
					<th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1; ?>
				@foreach($biddingQueue as $queue)
					<tr>
						<th scope="row"><h6><strong>
                            {{$biddingQueue ->perPage()*($biddingQueue->currentPage()-1)+$count}}
                        </strong></h6></th>
						<td>{{ $queue->name }}</td>
						<td>{{ $queue->role_name}}</td>
						<td>
							@if($queue->bid_submitted == 1)
								Submitted
							@elseif($queue->bidding == 1)
								Bidding
							@else
								Waiting to Bid
							@endif
						</td>
						<td>
                            <div class="row text-center">
                                @if($queue->bid_submitted == 1)
                                <div class="col">
                                    <form action="{{ route('admin.bidding-queue.view', $queue->user_id) }}" method="GET">
                                        <input type="hidden" name="user_id" value={{ $queue->user_id }}>
                                        <input type="hidden" name="bidding_schedule_id" value={{ $queue->bidding_schedule_id }}>
                                        <button type="submit" class="btn btn-success">{{ __('View') }}</button>
                                    </form>
                                </div>

                                @elseif($queue->bidding == 1)
                                    <div class="col">
                                    <form action="{{ route('admin.bidding-queue.bid', $queue->user_id) }}" method="GET">
                                        <input type="hidden" name="user_id" value={{ $queue->user_id }}>
                                        <input type="hidden" name="bidding_schedule_id" value={{ $queue->bidding_schedule_id }}>
                                        <button type="submit" class="btn btn-primary">{{ __('Bid for user') }}</button>
                                    </form>
                                    </div>
                                @else
                                    <div class="col">
                                        {{ __('No action available')}}
                                    </div>
                                @endif
                            </div>
                        </td>
					</tr>
                    <?php $count++; ?>
				@endforeach
                </div>
            </tbody>
        </table>
    </div> 
       
        {{ $biddingQueue->appends(Request::all())->links() }}
            
</div>
    

@endisset


@endsection