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
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header">{{ __('Add New User') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

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
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>

                            <div class="form-group col-md-6">
                                <select id="role" class="form-control" name="role" required>
                                    <option value="">Choose...</option>

                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}
                                            
                                        </option>
                                        @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date_in_position" class="col-md-4 col-form-label text-md-right">{{ __('Date in Position') }}</label>

                            <div class="form-group col-md-6">
                                <input id="date_in_position" class="form-control @error('date_in_position') is-invalid @enderror" type="date" name="date_in_position" required>

                                @error('date_in_position')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="specialties" class="col-md-4 col-form-label text-md-right">{{ __('Specialties') }}</label>

                            <div class="col-md-6">
                                <!-- <input id="specialties" type="text" class="form-control @error('specialties') is-invalid @enderror" name="specialties" value="{{ old('specialties') }}" autocomplete="specialties" autofocus> -->

                                @foreach($specialties as $specialty)
                                    <div class="form-check">
                                        <input type="checkbox" name="specialtiess[]" value="{{ $specialty->id }}">
                                        <label>{{ $specialty->name }}</label>
                                    </div>

                                @endforeach

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Unit Number') }}</label>

                            <div class="col-md-6">
                                <input id="unit_number" type="number" class="form-control @error('unit_number') is-invalid @enderror" name="unit_number" autocomplete="unit_number" min="0" max="9999" autofocus>

                                @error('unit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Emergency Number') }}</label>

                            <div class="col-md-6">
                                <input id="emergency_number" type="number" class="form-control @error('emergency_number') is-invalid @enderror" name="emergency_number" autocomplete="emergency_number" min="0" max="9999" autofocus>

                                @error('emergency_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Vehicle Number') }}</label>

                            <div class="col-md-6">
                                <input id="vehicle_number" type="number" class="form-control @error('vehicle_number') is-invalid @enderror" name="vehicle_number" autocomplete="vehicle_number" min="0" max="9999" autofocus>

                                @error('vehicle_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="notes" class="col-md-4 col-form-label text-md-right">{{ __('Notes') }}</label>

                            <div class="col-md-6">
                                <textarea class="form-control @error('notes') is-invalid @enderror" name="notes" id="notes" rows="2" autocomplete="notes" autofocus></textarea>
                                @error('notes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-2 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Add') }}
                                </button>
                            </div>
                            <div class="col-md-2 offset-md-1">
                                <a  class="btn btn-secondary" href="{{ route('admin.users.index') }}">
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
