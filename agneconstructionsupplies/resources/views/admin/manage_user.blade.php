@extends('layouts.app') 
@section('content')

<div class="container py-5">
    @if(session('success'))
    <div class="alert alert-success">
        <i class="fa-solid fa-circle-check"></i> {{ session("success") }}
    </div>
    @endif 

    @if(session('info'))
    <div class="alert alert-info">
        <i class="fa-solid fa-circle-info"></i> {{ session("info") }}
    </div>
    @endif 
    @if(session('error'))
    <div class="alert alert-danger">
        <i class="fa-solid fa-triangle-exclamation"></i> {{ session("error") }}
    </div>
    @endif

    <div class="row align-items-center mb-4 p-4 border-bottom border-dark border-2">
        <div class="col-12 col-md-3 border-end border-dark">
            <h3>Manage Users</h3>
        </div>
    </div>

    <table class="table display">
        <thead>
            <tr>
                <th>Lastname</th>
                <th>Firstname</th>
                <th>Email</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{$user->lastname}}</td>
                <td>{{$user->firstname}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->created_at}}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4">No Users Yet</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection