@php 
    $avg = $ratings->avg('rating'); 
    $rateCount = $ratings->count(); 
    $wholeStarCount = (int) $avg; 
    $noStarCount = (int) (5 - $avg); 
    $hasHalfStar = $avg - $wholeStarCount > 0; 
    $stars = str_repeat('<i class="fa-solid fa-star"></i>' . PHP_EOL, $wholeStarCount) . ($hasHalfStar ? '<i class="fas fa-star-half-alt "></i>' . PHP_EOL : '') . str_repeat('<i class="fa-regular fa-star"></i>' . PHP_EOL,$noStarCount); 
@endphp
<div class="container px-4 px-lg-5 my-5">
    <div class="row gx-4 gx-lg-5 align-items-center">
        <div class="col-md-6">
            <div class="bg-image hover-overlay ripple ripple-surface ripple-surface-light" data-mdb-ripple-color="light">
                <div id="photoControls{{$product->id}}" class="carousel carousel-dark slide p-2" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @php
                            $first = true;
                        @endphp
                        @forelse($photos as $photo)
                            <div class="carousel-item {{ $first ? 'active' : '' }}">
                                <img src="{{ asset('storage/images/'. $photo->file_name) }}" class="card-img-top mb-5 mb-md-0" alt="{{ $photo->file_name }}">
                            </div>
                        @php $first = false; @endphp
                        @empty
                            <div class="carousel-item">
                                <img class="card-img-top mb-5 mb-md-0" src="{{ asset('storage/images/no-image.jpg') }}" alt="..." />
                            </div>
                        @endforelse
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#photoControls{{$product->id}}" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#photoControls{{$product->id}}"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="medium mb-1">
                <div class="row justify-content-center text-center">
                    <div class="col-3 border-dark">
                        CAT: {{ $product->category->category_name }} 
                    </div>
                
                    <div class="col-3 border-dark border-start">
                        <u>Ratings: {{ $rateCount }}</u>
                    </div>
                    
                    <div class="col-3 border-dark border-start">
                        <span class="text-danger">
                            @if($rateCount <= 0) No rating yet @else
                            {!! $stars !!} 
                            @endif
                            <span>{{ $avg }}</span>
                        </span>
                    </div>
                </div>
                
            </div>
            <h1 class="display-5 fw-bolder">
                @if(Auth::id())
                    @php
                        $isExist = $wishlists->where('user_id', Auth::id())->count();
                        $wid = $wishlists->where('user_id', Auth::id())->value('id');
                    @endphp
                    @if($isExist == 0)
                        <i class="fa-regular fa-heart fa-sm text-danger wishlist-btn" data-id="{{$product->id}}" style="cursor: pointer;"></i>
                    @else
                        <i class="fa-solid fa-heart fa-sm text-danger wishlist-btn-remove" data-id="{{$wid}}" style="cursor: pointer;"></i>
                    @endif
                @else
                    <i class="fa-regular fa-heart fa-sm text-danger"></i>
                @endif
                <span>{{ $product->product_name }}</span>
            </h1>
            <div class="fs-5 mb-5">
                <span>
                    Php {{ $product->price }} / {{ $product->unit }}
                    <br>
                    @if($product->quantity > 0)
                        <span class="text-dark">Quantity: {{ $product->quantity }}</span>
                    @else
                        <span class="text-danger fs-6">OUT OF STOCK</span>
                    @endif</span>
            </div>
            <p class="lead p-0 mb-3">DESCRIPTION: {!! $product->description !!}</p>

            @if($product->quantity > 0)
                <form action="/add_cart/{{$product->id}}" method="post">
            @else
                <form action="/add_wishlist/{{$product->id}}" method="post">
            @endif
                @csrf
                <div class="d-flex my-3">
                    @if($product->quantity > 0)
                        <input type="number" class="form-control text-center me-3 @error('quantity') is-invalid @enderror" style="max-width: 7rem"  min="1" value="{{old('quantity')}}" name="quantity" id="quantity" required>
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <button class="btn btn-outline-dark flex-shrink-0" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                            Add to cart
                        </button>
                    @else
                        <input type="submit" value="Add to Wishlist" class="btn btn-outline-danger flex-shrink-0">
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('.wishlist-btn').on('click', function(e){
        let id = $(this).data('id');
        console.log(id);
        e.preventDefault();
            $.ajax({
                url: "/addWishlist/" + id,
                type: "GET",
                success: function (result) {
                    toastr.info("Item added to wishlist");
                    getDetails();
                },
                error: function (xhr, status, error) {
                    console.error(xhr, status, error);
                    alert("Error adding to wishlist");

                },
            });
    });

    $('.wishlist-btn-remove').on('click', function(e){
        let id = $(this).data('id');
        console.log(id);
        e.preventDefault();
            $.ajax({
                url: "/removeWishlist/" + id,
                type: "GET",
                success: function (result) {
                    toastr.info("Item Removed to wishlist");
                    getDetails();
                },
                error: function (xhr, status, error) {
                    console.error(xhr, status, error);
                    alert("Error to remove in wishlist");

                },
            });
    });

</script>