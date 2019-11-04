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
<!-- <div class="row mt-3 ml-2 mr-2"> -->
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

				@foreach($biddingQueue as $queue)
					<tr>
						<th scope="row"><h6><strong>{{ $loop->iteration }}</strong></h6></th>
						<td>{{ $queue->name }}</td>
						<td>{{ $queue-> role_name}}</td>
						<td>
							@if($queue->bid_submitted == 1)
								Submitted
							@elseif($queue->bidding == 1)
								Bidding
							@else
								Waiting to Bid
							@endif
						</td>
						<td>Action goes here</td>
					</tr>
				@endforeach
            </tbody>
        </table>
    </div>

@endisset


@endsection