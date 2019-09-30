@extends('layouts.app')

@section('content')

<!-- Badge Logo -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <!-- Badge -->
            <img src='img/badge.gif' class="rounded mx-auto d-block img-fluid" alt='Badge' >
                <br>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

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
                                <select id="role" class="form-control" required>
                                    <option value="">Choose...</option>
                                    <option value=1>Admin</option>
                                    <option value=2>Supervisor</option>
                                    <option value=3>Officer</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date-in-position" class="col-md-4 col-form-label text-md-right">{{ __('Date in Position') }}</label>

                            <div class="form-group col-md-6">
                                <input id="date-in-position" class="form-control" type="date" required>

                                @error('date-in-position')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="specialties" class="col-md-4 col-form-label text-md-right">{{ __('Specialties') }}</label>

                            <div class="col-md-6">
                                <input id="specialties" type="text" class="form-control @error('specialties') is-invalid @enderror" name="specialties" value="{{ old('specialties') }}" autocomplete="specialties" autofocus>

                                @error('specialties')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="specialties" class="col-md-4 col-form-label text-md-right">{{ __('Notes') }}</label>

                            <div class="col-md-6">
                                <input id="specialties" type="text" class="form-control @error('notes') is-invalid @enderror" name="notes" value="{{ old('notes') }}" autocomplete="notes" autofocus>

                                @error('Notes')
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
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
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
