@extends('layouts.app') @section('content')
<div class="container">
    <div class="row-12 col-md-9">
        <a href="/orders" class="btn btn-secondary mb-3">
            <i class="fa-solid fa-angle-left"></i> Go back
        </a>

        
        @php 
        
        
        $image = $photos->first(); 
        $avg = $ratings->where('product_id', $order->product_id)->avg('rating'); 

        $rateCount = $ratings->where('product_id', $order->product_id)->count();

        $wholeStarCount = (int) $avg; 
        
        $noStarCount = (int) (5 -$avg);
        $hasHalfStar = $avg - $wholeStarCount > 0; 
        
        $stars = str_repeat('<i class="fa-solid fa-star"></i>' . PHP_EOL, $wholeStarCount) . ($hasHalfStar ? '<i class="fas fa-star-half-alt "></i>' . PHP_EOL : '') . str_repeat('<i class="fa-regular fa-star"></i>' . PHP_EOL,$noStarCount); 

        @endphp

        <div class="row justify-content-center">
            <div class="col-md-12 col-xl-10">
                <div
                    class="card shadow rounded p-3 mb-2"
                    id="card_{{$order->pid}}"
                >
                    <div class="card-body">
                        <div class="row">
                            <div
                                class="col-md-12 col-lg-3 col-xl-3 mb-4 mb-lg-0"
                            >
                                <div
                                    class="bg-image hover-zoom ripple rounded ripple-surface"
                                >
                                    <img
                                        src="{{ asset('storage/images/'. $image->file_name) }}"
                                        class="w-100"
                                        style="height: 200px; object-fit: cover"
                                    />
                                    <a href="#!">
                                        <div class="hover-overlay">
                                            <div
                                                class="mask"
                                                style="
                                                    background-color: rgba(
                                                        253,
                                                        253,
                                                        253,
                                                        0.15
                                                    );
                                                "
                                            ></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-6">
                                <h5>
                                    {{ $product->product_name }} | rating:
                                    {{ $rateCount }}
                                </h5>
                                <div class="d-flex flex-row">
                                    <div class="text-danger mb-1 me-2">
                                        @if($rateCount <= 0) 
                                            No rating yet 
                                        @else
                                            {!! $stars !!} 
                                        @endif
                                    </div>
                                    <span>{{ $avg }}</span>
                                </div>
                                <p class="text-truncate mb-4 mb-md-0">
                                    {!!  $product->description !!}
                                </p>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <h5><i class="fa-solid fa-location-dot"></i> Delivery Address</h5>
                                        <p class="mb-0">
                                            {{$address->firstname}} {{$address->lastname}}
                                        </p>
                                        <p class="mb-0">
                                            {{$address->contact}} 
                                        </p>
                                        <p class="mb-0">
                                            {{$address->street}}
                                        </p>
                                        <p class="mb-0">
                                            {{$address->barangay}}, {{$address->town}},
                                            {{$address->postal_code}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="col-md-6 col-lg-3 col-xl-3 border-sm-start-none border-start"
                            >
                                <div
                                    class="d-flex flex-row align-items-center mb-1"
                                >
                                    <h4 class="mb-1 me-1">
                                        Php {{ $order->amount }}
                                    </h4>
                                    <span class="text-danger"><s></s></span>
                                </div>
                                <h6 class="text-success">
                                    <label for="quantity" class="form-label"
                                        >Quantity: {{$order->quantity}}
                                    </label>
                                </h6>
                                <div class="d-flex flex-column mt-4">
                                    <a
                                        href="/product_details/{{$order->product_id}}"
                                        class="btn btn-primary btn-sm"
                                        type="button"
                                    >
                                        See Product
                                    </a>
                                    @if($order->status_id == 3)
                                        @if($order->isRated == 'yes')
                                        <button
                                            disabled
                                            class="btn btn-outline-danger btn-sm mt-2 rating-btn"
                                        >
                                            Rated
                                        </button>
                                        @else
                                        <a
                                            data-id="{{$order->id}}"
                                            data-prodid="{{$order->product_id}}"
                                            data-prod="{{ $product->product_name }}"
                                            class="btn btn-danger btn-sm mt-2 rating-btn"
                                        >
                                            Rate
                                        </a>
                                        @endif
                                    @endif
                                    @if($order->status_id == 4)
                                        <button
                                            disabled
                                            class="btn btn-outline-secondary btn-sm mt-2"
                                        >
                                            Cancelled
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="modal fade"
            id="ratingModal"
            tabindex="-1"
            aria-labelledby="ratingModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="ratingModalLabel">
                            
                        </h1>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <form method="post" id="form-rate" action="/rate">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <input type="hidden" name="product_id" id="product_id" value="">
                                <input type="hidden" name="id" id="id" value="">
                            </div>
                            <div class="mb-3 d-flex flex-row align-items-center">
                                <label class="form-label">Rate:</label>
                                <div class="rate">
                                    <input type="radio" id="star5" name="rate" value="5" />
                                    <label for="star5" title="text">5 stars</label>
                                    <input type="radio" id="star4" name="rate" value="4" />
                                    <label for="star4" title="text">4 stars</label>
                                    <input type="radio" id="star3" name="rate" value="3" />
                                    <label for="star3" title="text">3 stars</label>
                                    <input type="radio" id="star2" name="rate" value="2" />
                                    <label for="star2" title="text">2 stars</label>
                                    <input type="radio" id="star1" name="rate" value="1" />
                                    <label for="star1" title="text">1 star</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="feedback" class="form-label"
                                    >Feedback(optional):</label
                                >
                                <textarea
                                class="form-control"
                                name="feedback"
                                id="feedback"
                                maxlength="100"
                                onkeyup="updateCharacterCount()"
                            ></textarea>
                            <small id="characterCount" class="form-text text-muted">0/100 characters</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal"
                            >
                                Close
                            </button>
                            <button type="button" id="rate-submit" class="btn btn-primary">
                                Rate
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function updateCharacterCount() {
        var textarea = document.getElementById('feedback');
        var characterCountElement = document.getElementById('characterCount');
        
        var remainingCharacters = 100 - textarea.value.length;
        characterCountElement.textContent = remainingCharacters + '/100 characters';
    }
    $(document).ready(function () {

        $(".rating-btn").on("click", function (e) {
            e.preventDefault();

            let prod_id = $(this).data("prodid");
            let prod = $(this).data("prod");
            let id = $(this).data("id");

            // Set the product name in the modal header
            $("#ratingModalLabel").html(prod);

            // Set other values or perform other actions based on prod_id if needed
            $("#product_id").val(prod_id);
            $("#id").val(id);

            // Show the modal
            $("#ratingModal").modal("show");
        });

        $("#rate-submit").on("click", function () {
            $("#form-rate").submit();
        });

    });
</script>
@endsection
