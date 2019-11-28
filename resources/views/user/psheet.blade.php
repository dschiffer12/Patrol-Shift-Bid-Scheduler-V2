@extends('layouts.app')

@section('content')


<!-- Badge Logo -->
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col">

            <img src='img/badge.gif' class="rounded mx-auto d-block img-fluid" alt='Badge' >
                <br>
        </div>
    </div>
</div> -->

<div class="container">
    <div class="row justify-content-start">
        <div class="col col-md-8">

            <h1>Daily Roster Page. </h1>

        </div>
    </div>

    <div class="row justify-content-start mt-3">
        <div class="col col-md-8">
            <form method="POST" action="/user/psheet/date">
                @csrf

                <div class="form-group row">
                    <label for="calendar_date" class="col-md-2 col-form-label ">{{ __('Select Date') }}</label>

                    <div class="form-group col-md-4">
                        <input id="calendar_date" class="form-control" type="date" name="calendar_date" value={{ $daySelected }} required>

                        @error('date-in-position')
                            <span class="calendar_date" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-grup col-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Submit') }}
                        </button>
                    </div>
                </div>
            </form>

        </div>

        @if ( $editable ?? ''  )
            <div class="col col-md-2"></div>
            <div class="col col-md-2">
                <button class="btn btn-primary float-right">Edit</button>
            </div>
        @endif
    </div>
</div>

<div style="height: 500px" class="container">
    <div class="row border border-primary ">
        <div class="col col-md-12 p-2">
            @if ($noSpots ?? '')
                <div class="alert alert-warning" role="alert">
                    {{ $noSpots }}
                </div>
            @endif
            @foreach( $shifts as $shift )
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 8%" scope="col">{{ $shift }}</th>
                            <th style="width: 7%" scope="col">Unit #</th>
                            <th style="width: 9%" scope="col">Emgcy #</th>
                            <th style="width: 20%" scope="col">Name</th>
                            <th style="width: 7%" scope="col">Shift Start</th>
                            <th style="width: 7%" scope="col">Shift End</th>
                            <th style="width: 7%" scope="col">Zone</th>
                            <th style="width: 7%" scope="col">Specialties</th>
                            <th style="width: 7%" scope="col">Vehicle</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach( $spots as $index => $spot)
                            @if($spot->spot->shift->name == $shift)
                            <tr>
                                <td>{{ implode(', ', $spot->user->roles()->get()->pluck('name')->toArray()) }}</td>
                                <td>{{ !empty($spot->user->officer) ? $spot->user->officer->unit_number:'' }}</td>
                                <td>{{ !empty($spot->user->officer) ? $spot->user->officer->emergency_number:'' }}</td>
                                <td>{{ !empty($spot->user) ? $spot->user->name:'' }}</td>
                                <td>{{ $spot->spot->{$weekday.'_s'} }}</td>
                                <td>{{ $spot->spot->{$weekday.'_e'} }}</td>
                                <td></td>
                                <td>{{ implode(', ', $spot->user->specialties()->get()->pluck('name')->toArray()) }}</td>
                                <td>{{ !empty($spot->user->officer) ? $spot->user->officer->vehicle_number:'' }}</td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        </div>
    </div>
</div>
@endsection
