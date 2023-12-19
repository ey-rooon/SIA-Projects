@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="p-4">
        <!-- Button trigger modal -->
        <form action="/add_category" method="post">
            @csrf
             <div class="row p-2 d-flex align-items-center">
                <div class="col-md-4">
                    <label class="fw-bold">Category</label>
                    <input type="text" name="category_name" class="form-control @error('category') is-invalid @enderror" value="{{@old('category')}}">
                    @error('category') 
                        <div class="invalid-feedback">{{$message}}</div>  
                    @enderror
                </div>
                <div class="col-2 ">
                    <button type="submit" class="btn btn-success">Add Category</button>
                </div>
            </div>
        </form>
        <table class="display">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{$category->category_name}}</td>
                        <td>
                            <div class="row">
                                <div class="col">
                                    <button class="btn btn-outline-success">Edit</button>
                                </div>
                                <div class="col">
                                    <button class="btn btn-outline-danger">Delete</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
