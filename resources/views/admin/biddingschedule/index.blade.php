@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-start mt-3 mb-3">
        <div class="col-md">
            <h3>List of all Actice Schedules</h3>
        </div>
    </div>
</div>

<!--If no record of schedules were found show warning and show button to Create New Schedule-->
@if (count($biddingschedulesactive) <= 0)
    <div class="container">
        <div class="row justify-content-start mt-3 mb-3">
            <div class="col-md">
                <div class="alert alert-warning" role="alert">
                    No Record for Schedules were found.
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mt-3 mb-3 d-flex justify-content-end">
            <div class="col-md-4 d-flex justify-content-end">
                <a href="{{ route('register') }}"><button type="button" class="btn btn-success">Create New Schedule</button></a>
            </div>
        </div>
    </div>


<!--If record of schedules were found show button to Create New Schedule and show the list of schedules-->
@else
    <div class="container">
        <div class="row mt-3 mb-3 d-flex justify-content-end">
            <div class="col-md-4 d-flex justify-content-end">
                <a href="{{ route('register') }}"><button type="button" class="btn btn-success">Create New Schedule</button></a>
            </div>
        </div>
    </div>

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
                            <th class="text-center" scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($biddingschedulesactive as $biddingschedules)
                                <tr>
                                    <td class="text-center">{{ $biddingschedules->name }}</td>
                                    <td class="text-center">{{ date('m-d-Y', strtotime($biddingschedules->start_day)) }}</td>
                                    <td class="text-center">{{ date('m-d-Y', strtotime($biddingschedules->end_day)) }}</td>
                                    <td class="text-center">{{ $biddingschedules->response_time }}</td>
                                    <td class="text-center">@if ($biddingschedules->currently_active == 1)
                                                                Active
                                                            @else I
                                                                nactive
                                                            @endif
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col">
                                                <a href="{{ route('admin.bidding-schedule.show', $biddingschedules) }}"><button type="button" class="btn btn-primary float-left">View</button></a>
                                            </div>
                                        </div>
                                    <td>
                                    <td>
                                        <div class="row">
                                            <div class="col">
                                                <form action="{{ route('admin.bidding-schedule.destroy', $user) }}" method="POST" class="delete">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    @csrf
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" onclick="return confirm('Delete {{$biddingschedules->name}}?')" class="btn btn-danger">Diactivate</button>
                                                </form>
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
@endif

@endsection
