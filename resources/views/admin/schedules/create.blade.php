@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header">{{__('Create New Schedule')}}</b></div>
                <div class="card-body">
                    <form action="{{ route('admin.schedules.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group row">
                            <label for="schedule_name" class="col-md-4 col-form-label text-md-right">{{ __('Schedule Name') }}</label>

                            <div class="col-md-6">
                                <input id="schedule_name" type="text" class="form-control @error('schedule_name') is-invalid @enderror" name="schedule_name" value="{{ old('schedule_name') ? old('schedule_name') : ''}}" required autocomplete="schedule_name" autofocus>

                                @error('schedule_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="start_date" class="col-md-4 col-form-label text-md-right">{{ __('Start Date') }}</label>

                            <div class="form-group col-md-6">
                                <input id="start_date" class="form-control @error('start_date') is-invalid @enderror" type="date" name="start_date" value="{{ old('start_date') ? old('start_date') : ''}}" required>

                                @error('start_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

						<div class="form-group row">
                            <label for="end_date" class="col-md-4 col-form-label text-md-right">{{ __('End Date') }}</label>

                            <div class="form-group col-md-6">
                                <input id="end_date" class="form-control @error('end_date') is-invalid @enderror" type="date" name="end_date" value="{{ old('end_date') ? old('end_date') : ''}}" required>

                                @error('end_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

						<div class="form-group row">
                            <label for="response_time" class="col-md-4 col-form-label text-md-right">{{ __('Response Time (hours)') }}</label>

                            <div class="form-group col-md-6">
                                <input id="response_time" class="form-control @error('response_time') is-invalid @enderror" type="number" name="response_time" value="{{ old('response_time') ? old('response_time') : ''}}" required>

                                @error('response_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                                                
                        <div class="form-group row mb-0">
							<div class="col-md-2 offset-md-1">
								<a  class="btn btn-secondary float-start" href="{{ URL::previous() }}">
									{{ __('Cancel') }}
								</a>     
							</div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary float-right">
                                    {{ __('Next >') }}
                                </button>
                            </div>   
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection