@extends('layouts.app')

@section('content')

<div class="container py-4">
    <div class="px-4 ">
        <a href="/home" class="back-button">
            <div class="back-button-box">
              <span class="back-button-elem">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 46 40">
                  <path d="M46 20.038c0-.7-.3-1.5-.8-2.1l-16-17c-1.1-1-3.2-1.4-4.4-.3-1.2 1.1-1.2 3.3 0 4.4l11.3 11.9H3c-1.7 0-3 1.3-3 3s1.3 3 3 3h33.1l-11.3 11.9c-1 1-1.2 3.3 0 4.4 1.2 1.1 3.3.8 4.4-.3l16-17c.5-.5.8-1.1.8-1.9z"></path>
                </svg>
              </span>
              <span class="back-button-elem">
                <svg viewBox="0 0 46 40">
                  <path d="M46 20.038c0-.7-.3-1.5-.8-2.1l-16-17c-1.1-1-3.2-1.4-4.4-.3-1.2 1.1-1.2 3.3 0 4.4l11.3 11.9H3c-1.7 0-3 1.3-3 3s1.3 3 3 3h33.1l-11.3 11.9c-1 1-1.2 3.3 0 4.4 1.2 1.1 3.3.8 4.4-.3l16-17c.5-.5.8-1.1.8-1.9z"></path>
                </svg>
              </span>
            </div>
        </a>
    </div>
    <section class="">
        <div id="details-card">
            <center>
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </center>
        </div>
    </section>
    <div class="row py-5 bg-body rounded-3 shadow-lg">
        <h3>Reviews & Rating</h3>
        @forelse($ratings as $rating)
            @php
                $user = $users->where('id', $rating->user_id)->first();
            @endphp
            <div class="row mb-2">
                <div class="col-12 col-md-6">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="row d-flex justify-content-between align-items-center mb-2">
                                <div class="col-2  col-md-2 border-end">
                                    <div class="d-flex justify-content-center align-items-center bg-secondary text-white rounded-circle" style="width: 10vw; height: 10vw; max-width: 50px; max-height: 50px;">
                                        <span class="fs-5">{{ strtoupper($user->firstname[0]) }} {{ strtoupper($user->lastname[0]) }}</span>
                                    </div>
                                    
                                </div>
                                <div class="col-10 col-md-10">
                                    <p class="fs-5">{{$rating->review}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="text-danger">
                                        @for ($i = 0; $i < 5; $i++) 
                                            @if($i < $rating->rating)
                                            <i class="fa fa-star"></i>
                                            @else
                                            <i class="fa-regular fa-star"></i>
                                            @endif 
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <footer class="blockquote-footer">{{\Carbon\Carbon::parse($rating->created_at)->diffForHumans()}}</footer>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <center>No Reviews Yet</center>
        @endforelse
    </div>
</div>

<script>
    function getDetails() {
        $("#spinner").show();
        $.ajax({
            url: "{{ route('get.details', ['id' => $product->id]) }}",
            type: "GET",
            success: function (data) {
                $("#details-card").html(data);
                $("#spinner").hide();
            },
            error: function (xhr, status, error) {
                console.log(error);
                alert("error fetching data");
                $("#spinner").hide();
            },
        });
    }

    $(document).ready(function () {
        getDetails();
    });

</script>
@endsection

