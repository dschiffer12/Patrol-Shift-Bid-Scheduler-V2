@extends('layouts.app')

@section('content')

@if (session('successful'))
    <div class="alert alert-success" role="alert">
        {{ session('successful') }}
    </div>
@endif

@if (session('updated'))
    <div class="alert alert-success" role="alert">
        {{ session('updated') }}
    </div>
@endif

@if (session('deleted'))
    <div class="alert alert-warning" role="alert">
        {{ session('deleted') }}
    </div>
@endif

<div class="container">
    <div class="row justify-content-start mt-3 mb-3">
        <div class="col-md">
            <h3>List of all Shift with Early Shift</h3>
        </div>
    </div>
</div>

<!--If no record of schedules were found show warning and show button to Create New Schedule-->
@if (count($shifts) <= 0)
    <div class="container">
        <div class="row justify-content-start mt-3 mb-3">
            <div class="col-md">
                <div class="alert alert-warning" role="alert">
                    No Record for Shift were found.
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mt-3 mb-3 d-flex justify-content-end">
            <div class="col-md-4 d-flex justify-content-end">
                <a href="shift/create"><button type="button" class="btn btn-success">Create New Shift</button></a>
            </div>
        </div>
    </div>


<!--If record of schedules were found show button to Create New Schedule and show the list of schedules-->
@else
    <div class="container">
        <div class="row mt-3 mb-3 d-flex justify-content-end">
            <div class="col-md-4 d-flex justify-content-end">
                <a href="shift/create"><button type="button" class="btn btn-success">Create New Shift</button></a>
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
                            <th class="text-center" scope="col">Start Time</th>
                            <th class="text-center" scope="col">End Time</th>
                            <th class="text-center" scope="col">Early Start Time</th>
                            <th class="text-center" scope="col">Early End Time</th>
                            <th class="text-center" scope="col">Minimum Staff</th>
                            <th class="text-center" scope="col">Minimum Early Spot</th>
                            <th class="text-center" scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shifts as $shift)
                                <tr>
                                    <td class="text-center">{{ $shift->name }}</td>
                                    <td class="text-center">{{ $shift->start_time }}</td>
                                    <td class="text-center">{{ $shift->end_time }}</td>
                                    <td>{{ !empty($shift->earlyShift) ?  $shift->earlyShift->early_start_time:'' }}</td>
                                    <td>{{ !empty($shift->earlyShift) ? $shift->earlyShift->early_end_time:'' }}</td>
                                    <td class="text-center">{{ $shift->minimun_staff }}</td>
                                    <td>{{ !empty($shift->earlyShift) ? $shift->earlyShift->num_early_spot:'' }}</td>

                                    <td>
                                        <div class="row">
                                            <div class="col">
                                                <a href="{{ route('admin.shift.edit', $shift->id) }}"><button type="button" class="btn btn-primary float-left">View</button></a>
                                            </div>
                                        </div>
                                    <td>
                                    <td>
                                        <div class="row">
                                            <div class="col">
                                                <form action="{{ route('admin.shift.destroy', $shift->id) }}" method="POST" class="delete">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Delete {{$shift->name}}?')" class="btn btn-danger">Diactivate</button>
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
