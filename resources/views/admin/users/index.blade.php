@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-start mt-3 mb-3">
        <div class="col-md">
            <h3>List of all Users</h3>
        </div>
    </div>
</div>

<div class="container">
    <div class="row mt-3 mb-3 d-flex justify-content-end">
        <div class="col-md-4 d-flex justify-content-end">
            <a href="{{ route('register') }}"><button type="button" class="btn btn-success">Add New User</button></a>
        </div>
    </div>
</div>

<div class="container shadow">
    <div class="row justify-content-center">
        <div class="col-md-12"> 
            <div class="table-responsive-md">      
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th class="text-center" scope="col">Name</th>
                        <th class="text-center" scope="col">Email</th>
                        <th class="text-center" scope="col">Role</th>
                        <th class="text-center" scope="col">Date in Position</th>
                        <th class="text-center" scope="col">Specialties</th>
                        <th class="text-center" scope="col">Notes</th>
                        <th class="text-center" scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                            <th scope="row">{{ $user->id }}</th>
                            <td class="text-center">{{ $user->name }}</td>
                            <td class="text-center">{{ $user->email }}</td>
                            <td class="text-center">{{ implode(', ', $user->roles()->get()->pluck('name')->toArray()) }}</td>
                            <td class="text-center">{{ date('m-d-Y', strtotime($user->date_in_position)) }}</td>
                            <td class="text-center">{{ implode(', ', $user->specialties()->get()->pluck('name')->toArray()) }}</td>
                            <td>{{ $user->notes }}</td>
                            <td>
                                <div class="row">
                                    <div class="col">
                                        <a href="{{ route('admin.users.edit', $user) }}"><button type="button" class="btn btn-primary float-left">Edit</button></a>
                                    </div>
                                    <div class="col">
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="delete">
                                            <input type="hidden" name="_method" value="DELETE">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <button type="submit" onclick="return confirm('Delete {{$user->name}}?')" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>        
                            </td>
                            </tr>
                            
                            @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
    </div>   
</div>

@endsection