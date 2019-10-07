@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create New Schedule</div>

                <div class="card-body">
                    <form action="bidding-schedule/store" method="POST">
                        @method('POST')
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Schedule Nme</label>

                            <div class="col-md-6">

                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="" required autocomplete="name" autofocus>

                            </div>
                        </div>

                        <div class="form-group row">

                            <label for="start_date" class="col-md-4 col-form-label text-md-right">Schedule Start Date</label>

                            <div class="col-md-6">

                                <input id="start_date" type="date" class="form-control" name="start_date" value="" required>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="end_date" class="col-md-4 col-form-label text-md-right">Schedule End Date</label>

                            <div class="col-md-6">

                                <input id="end_date" type="date" class="form-control" name="end_date" value="" required>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="response_time" class="col-md-4 col-form-label text-md-right">Response Time</label>

                            <div class="col-md-6">

                                <input id="response_time" type="text" class="form-control" name="response_time" required>

                            </div>
                        </div>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" style="margin-left: 240px; margin-bottom: 10px;" data-toggle="modal" data-target="#shiftModalCenter">
                            Add Shifts
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="shiftModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Select or add Shifts</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table" id="shiftTable" data-rs-selectable>
                                            <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Shift Name</th>
                                                <th scope="col">Start Time</th>
                                                <th scope="col">End Time</th>
                                                <th scope="col">Early Start Time</th>
                                                <th scope="col">Early End Time</th>
                                                <th scope="col">Early Sports</th>
                                                <th scope="col">Minimum Staffing</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($shifts as $shift)
                                                    <tr id = $index>
                                                        <td>{{ $shift->name }}</td>
                                                        <td>{{ $shift->start_time }}</td>
                                                        <td>{{ $shift->end_time }}</td>
                                                        <td>{{ $shift->early_shift->early_start_time }}</td>
                                                        <td>{{ $shift->early_shift->early_end_time }}</td>
                                                        <td>{{ $shift->early_shift->num_early_spot }}</td>
                                                        <td>{{ $shift->minimun_staff }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-warning lef">Create New Shift</button>
                                        <button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary ">Add Shift Selected</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h4>All Users, ordered by date in position.</h4>

                        <div class="form-group row">

                            <div class="col-md-6">
                                <table class="table" id="shiftTable" data-rs-selectable>
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Line</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Specialty</th>
                                            <th scope="col">Date in Position</th>
                                            <th scope="col">Bidding Order</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $index => $user)
                                            <tr id = $index>
                                                <td>{{ $index }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->specialties->name }}</td>
                                                <td>{{ $user->date_in_position }}</td>
                                                <td><input id="queue_position" type="number" class="form-control" name="queue_position"></td>
                                            </tr>
                                            $index = $index + 1
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-2 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create') }}
                                </button>
                            </div>
                            <div class="col-md-2 offset-md-1">

                                <a  class="btn btn-secondary" href="{{ route('admin.bidding-schedule.index') }}">
                                    {{ __('Cancel') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
