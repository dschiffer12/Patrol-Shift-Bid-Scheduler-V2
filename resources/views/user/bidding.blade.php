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
        <div class="col col-md">
            <h1>Bid on Schedule </h1>
            <form>
                <div class="form-row align-items-center mt-5">
                    <div class="col-auto my-1">
                        <label class="mr-sm-2 sr-only" for="selectSchedule">Select Schedule</label>
                        <select class="custom-select mr-sm-2" id="selectSchedule">
                            <option selected>Select a Schedule</option>
                            <option value="1">Schedule 1</option>
                            <option value="2">Schedule 2</option>
                            <option value="3">...</option>
                        </select>
                    </div>
                    <div class="col-auto my-1">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="container overflow-auto shadow mt-3 p-3">
    <div class="row mt-3">
        <div class="col-auto">
            <h5>Schedule Name:</h5>
        </div>
        <div class="col-auto">
            <h5>Schedule 1</h5>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-auto">
            <h5>Start Date:</h5>
        </div>
        <div class="col-auto">
            <h5>01/01/2020</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-auto">
            <h5>End Date:</h5>
        </div>
        <div class="col-auto">
            <h5>03/31/2020</h5>
        </div>
    </div>
    <div class="row mt-3 ml-2 mr-2">
        <table class="table text-center table-bordered">
            <thead>
                <tr>
                <th scope="col">Shift</th>
                <th scope="col">Start Time</th>
                <th scope="col">End Time</th>
                <th scope="col">Early Start</th>
                <th scope="col">Early Ends</th>
                <th scope="col">Num. Early Spots</th>
                <th scope="col">Minimum Stsffing</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <th scope="row">A</th>
                <td>6:00</td>
                <td>14:00</td>
                <td>5:00</td>
                <td>13:00</td>
                <td>3</td>
                <td>5</td>
                </tr>
                <tr>
                <th scope="row">B</th>
                <td>14:00</td>
                <td>22:00</td>
                <td>13:00</td>
                <td>21:00</td>
                <td>3</td>
                <td>5</td>
                </tr>
                <tr>
                <th scope="row">C</th>
                <td>22:00</td>
                <td>6:00</td>
                <td>21:00</td>
                <td>5:00</td>
                <td>3</td>
                <td>5</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row mt-3 ml-2 mr-2">
        <table class="table text-center table-bordered">
            <thead>
                <tr>
                <th style="width: 10%" scope="col">Select Shift</th>
                <th scope="col">Friday</th>
                <th scope="col">Saturday</th>
                <th scope="col">Sunday</th>
                <th scope="col">Monday</th>
                <th scope="col">Tuestday</th>
                <th scope="col">Wednesday</th>
                <th scope="col">Thursday</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <th scope="row"> 
                    <select class="custom-select mr-sm-1" id="selectSchedule2">
                        <option selected>Shift</option>
                        <option value="1">A</option>
                        <option value="2">B</option>
                        <option value="3">C</option>
                    </select>
                </th>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="friday">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="saturday">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="sunday">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="monday">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="tuesday">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="wednesday">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="thursday">
                    </div>
                </td>
                </tr>
                <tr>
            </tbody>
        </table>
    </div>
    <div class="row mt-3 ml-2 mr-2">
        <table class="table text-center table-bordered">
            <thead>
                <tr>
                <th style="width: 10%" scope="col">Early Shift?</th>
                <th scope="col">Friday</th>
                <th scope="col">Saturday</th>
                <th scope="col">Sunday</th>
                <th scope="col">Monday</th>
                <th scope="col">Tuestday</th>
                <th scope="col">Wednesday</th>
                <th scope="col">Thursday</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <th scope="row">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="friday">
                    </div>
                </th>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="friday">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="saturday">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="sunday">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="monday">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="tuesday">
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="wednesday">
                    </div>
                </td>
                <td>
                    <div class="form-check pb-4">
                        <input class="form-check-input" type="checkbox" id="thursday">
                    </div>
                </td>
                </tr>      
            </tbody>
        </table>
        <div class="col-auto my-1">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</div>




<!-- <div style="height: 500px" class="container">
    <div class="row justify-content-center border border-primary h-100">
        <div class="col col-md-8 align-self-center">

        <h5>Select available schedule to bid on.</h5>
        
    </div>
</div> -->
@endsection