@extends('layouts.app') @section('content')
<center>
    <div class="container p-4">
        <div
            class="card p-4 w-50 bg-gradient bg-opacity-75 shadow rounded-5"
            style="background-color: #91091e"
        >
            <div class="row mb-5">
                <div class="col">
                    <img
                        src="{{ asset('storage/images/checked.png') }}"
                        alt=""
                        class="img-fluid"
                    />
                </div>
                <h1 class="">Order successfully place</h1>
            </div>
            <div class="row">
                <a href="/">
                    <button class="btn-back">
                        <span class="button_top"> Go back </span>
                    </button>
                </a>
            </div>
        </div>
    </div>
</center>
@endsection
