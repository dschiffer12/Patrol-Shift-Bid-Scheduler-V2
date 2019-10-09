@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create New Schedule</div>

                <div class="card-body">
                    <form action={{ route('admin.bidding-schedule.store') }} method="POST">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Schedule Nme</label>

                            <div class="col-md-6">

                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            </div>
                        </div>

                        <div class="form-group row">

                            <label for="start_date" class="col-md-4 col-form-label text-md-right">Schedule Start Date</label>

                            <div class="col-md-6">

                                <input id="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="" required>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="end_date" class="col-md-4 col-form-label text-md-right">Schedule End Date</label>

                            <div class="col-md-6">

                                <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="" required>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="response_time" class="col-md-4 col-form-label text-md-right">Response Time</label>

                            <div class="col-md-6">

                                <input id="response_time" type="text" class="form-control @error('response_time') is-invalid @enderror"  name="response_time" required>

                            </div>
                        </div>

                        <!--Shift Table-->
                        <div class="form-group row">
                            <div class="table-wrapper-scroll-y my-custom-scrollbar">

                                <table class="table table-bordered table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Shift Name</th>
                                            <th scope="col">Start Time</th>
                                            <th scope="col">End Time</th>
                                            <th scope="col">Early Start Time</th>
                                            <th scope="col">Early End Time</th>
                                            <th scope="col">Early Sports</th>
                                            <th scope="col">Minimum Staffing</th>
                                            <th scope="col">Select</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($shifts as $shift)
                                        <tr>
                                            <td>{{ $shift->name }}</td>
                                            <td>{{ $shift->start_time }}</td>
                                            <td>{{ $shift->end_time }}</td>
                                            <td>{{ $shift->early_shift->early_start_time }}</td>
                                            <td>{{ $shift->early_shift->early_end_time }}</td>
                                            <td>{{ $shift->early_shift->num_early_spot }}</td>
                                            <td>{{ $shift->minimun_staff }}</td>
                                            <td><input id="shift_{{ $shift->id }}" type="checkbox" class="form-control" name="shift.{{ $shift->id }}" /></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--End Shift Table-->

                        <h4 style="margin-top: 10%;">All Users, ordered by date in position.</h4>

                        <div class="form-group row">


                            <div class="table-wrapper-scroll-y my-custom-scrollbar" >

                                <table class="table table-bordered table-striped mb-0">
                                    <thead>
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
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ implode(', ', $user->specialties()->get()->pluck('name')->toArray()) }}</td>
                                                <td>{{ $user->date_in_position }}</td>
                                                <td><input id="queue_position_{{ $index + 1 }}" type="number" class="form-control" name="queue_position_{{ $index + 1 }}" value={{ $index + 1 }}></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6" style="margin-left: 5%;">
                                <input id="seve_as_template" type="checkbox" class=" form-check-input" name="seve_as_template" >
                                <label for="seve_as_template" class="l text-md-right">Save as a Template</label>
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
