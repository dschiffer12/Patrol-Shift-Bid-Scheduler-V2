@extends('layouts.app')

@section('content')

    <div class='container'>
        <div class="row justify-content-md-center">
            <div class="col">



            <div>
        </div>
    </div>


<div class="container">
    <div class="row justify-content-center">
        <div class="col col-md-8">

            <!-- <h1>Personal information </h1> -->

        </div>
    </div>

    
</div>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col col-md-8">
            <div class="card shadow">
                <div class="card-header">
                    <h5>Personal information</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group row">
                            <label for="staticName" class="col-md-3 col-form-label"><h5>Name:</h5></label>
                            <div class="col-md-auto">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $user->name }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-md-3 col-form-label"><h5>Email:</h5></label>
                            <div class="col-md-auto">
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $user->email }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticPassword" class="col-sm-3 col-form-label"><h5>Password:</h5></label>
                            <div class="col-md-auto">
                                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="******">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-2 offset-md-4">
                                <a  class="btn btn-primary" href="{{ route('user.profile.edit', $user) }}">
                                    {{ __('Edit') }}
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