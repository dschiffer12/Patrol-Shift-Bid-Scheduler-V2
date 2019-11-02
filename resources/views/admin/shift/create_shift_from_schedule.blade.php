@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create New Shift</div>

                <div class="card-body">
                    <form action={{ route('admin.shift.storeFromSchedule') }} method="POST">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Shift Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group row">

                            <label for="start_time" class="col-md-4 col-form-label text-md-right">Start Time</label>

                            <div class="col-md-6">
                                <input id="start_time" type="time" class="form-control @error('start_time') is-invalid @enderror" name="start_time" value="" required>

                                @error('start_time')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="end_time" class="col-md-4 col-form-label text-md-right">End Time</label>

                            <div class="col-md-6">
                                <input id="end_time" type="time" class="form-control @error('end_time') is-invalid @enderror" name="end_time" value="" required>

                                @error('end_time')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="early_start_time" class="col-md-4 col-form-label text-md-right">Early Start Time</label>

                            <div class="col-md-6">
                                <input id="early_start_time" type="time" class="form-control @error('early_start_time') is-invalid @enderror" name="early_start_time" value="" required>

                                @error('early_start_time')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="early_end_time" class="col-md-4 col-form-label text-md-right">Early End Time</label>

                            <div class="col-md-6">
                                <input id="early_end_time" type="time" class="form-control @error('early_end_time') is-invalid @enderror" name="early_end_time" value="" required>

                                @error('early_end_time')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="minimun_staff" class="col-md-4 col-form-label text-md-right">Minimum Staff</label>

                            <div class="col-md-6">
                                <input id="minimun_staff" type="number" class="form-control @error('minimun_staff') is-invalid @enderror" name="minimun_staff" value="" required>

                                @error('minimun_staff')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="num_early_spot" class="col-md-4 col-form-label text-md-right">Minimum Early Spot</label>

                            <div class="col-md-6">
                                <input id="num_early_spot" type="number" class="form-control @error('num_early_spot') is-invalid @enderror" name="num_early_spot" value="" required>

                                @error('num_early_spot')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-2 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="shift-send-btn">
                                    {{ __('Create') }}
                                </button>
                            </div>
                            <div class="col-md-2 offset-md-1">

                                <a  class="btn btn-secondary" href="{{ route('admin.bidding-schedule.create') }}">
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
