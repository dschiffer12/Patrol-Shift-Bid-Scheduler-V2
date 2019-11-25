@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-start mt-5">
        <div class="col col-md">
            <h1>{{ __('Roles')}}</h1>     
        </div>
    </div>
</div>


<div class="container overflow-auto shadow mt-3 p-3">
     
	<div class="row mt-3 ml-2 mr-2">
        <table class="table text-center table-bordered">
            <thead>
                <tr>
                <th scope="col col-auto">Line</th>
                <th class="text-center" scope="col">Name</th>
                <th style="width: 20%" class="text-center" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @php($i=0)
				@foreach($roles as $role)
                <tr>
                <th scope="row"><h5><strong>{{$loop->iteration}}</strong></h5></th>
                <td>{{$role->name}}</td>
				<td>
                    
                    <a href="#"><button type="button" class="btn btn-primary float-left">Edit</button></a>
                    <form action="{{ route('admin.roles.delete', $role->id) }}" method="GET" class="delete">
                        <button type="submit" onclick="return confirm('Delete?')" class="btn btn-danger">Delete</button>
                    </form>
                         
				</td>
                </tr>
                @php($i++)
				@endforeach
                <form action="{{ route('admin.roles.add') }}" method="POST">
                @csrf
                <tr>
                    <th scope="row"><h5><strong>{{$i+1}}</strong></h5></th>
                    <td>
                    <div class="cotainer">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div> 
                    </td>
                    <td>
                    <div class="cotainer">
                        <div class="row">
                            <div class="col">
                                <button type="submit"  class="btn btn-success">Add</button>     
                            </div>
                        </div>
                    </div>
                    </td>
                </tr>
                </form>
            </tbody>
        </table>
		<a href="{{ URL::previous() }}" class="btn btn-secondary">{{__('< Back')}}</a>
    </div>
</div>


@endsection