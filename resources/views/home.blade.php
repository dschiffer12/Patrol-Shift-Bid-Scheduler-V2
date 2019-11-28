@extends('layouts.app')

@section('content')
<?php
phpinfo();
?>

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
        <div class="col col-md-8">

            <h1>This is the homepage. </h1>

        </div>
    </div>

    <div class="row justify-content-start mt-3">
        <div class="col col-md-8">
            <form method="GET" action="{{ route('home') }}">
                    
            </form>

        </div>
    </div>
</div>

<div style="height: 500px" class="container">
    <div class="row justify-content-center border border-primary h-100">
        <div class="col col-md-8 align-self-center">

        <h5>Welcome message, make selection where to navigate to. </h5>
        
    </div>
</div>
@endsection
