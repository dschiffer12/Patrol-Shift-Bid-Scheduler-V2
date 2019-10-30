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
            <form method="GET" action="{{ route('home') }}">
                
                <div class="form-group row">
                    <label for="calendar_date" class="col-md-2 col-form-label ">{{ __('Select Date') }}</label>

                    <div class="form-group col-md-4">
                        <input id="calendar_date" class="form-control" type="date" name="calendar_date" value={{date((now()))}} required>

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
    </div>
</div>

<div style="height: 500px" class="container">
    <div class="row justify-content-center border border-primary h-100">
        <div class="col col-md-8 align-self-center">

        <h5>The Daily Roster will be displayed here</h5>
        
    </div>
</div>
@endsection