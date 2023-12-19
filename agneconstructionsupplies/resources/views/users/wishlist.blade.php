@extends('layouts.app') @section('content')
<div class="container">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4 g-4">
        @forelse($wishlists as $wishlist) 
        @php 
            $image = $photos->where('product_id', $wishlist->pid)->first(); 
            $avg = $ratings->where('product_id', $wishlist->pid)->avg('rating'); 
                $rateCount = $ratings->where('product_id', $wishlist->pid)->count(); 
                $wholeStarCount = (int) $avg; 
                $noStarCount = (int) (5 - $avg); 
                $hasHalfStar = $avg - $wholeStarCount > 0; 
                $stars = str_repeat('<i class="fa-solid fa-star"></i>' . PHP_EOL, $wholeStarCount) . ($hasHalfStar ? '<i class="fas fa-star-half-alt "></i>' . PHP_EOL : '') . str_repeat('<i class="fa-regular fa-star"></i>' . PHP_EOL,$noStarCount); 
        @endphp

        <div class="product-card col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card d-flex flex-column h-100 @if($wishlist->quantity > 0) shadow @else red-shadow  @endif bg-body rounded p-3 mb-2 ">
                <a href="/add_to_wishlist/{{$wishlist->id}}">
                    <i class="fa-regular fa-heart fa-lg pt-4 pb-1 px-3"></i>
                </a>
                <a href="/product_details/{{$wishlist->pid}}" class="text-black">
                    <img
                        src="{{ asset('storage/images/'. $image->file_name) }}"
                        class="card-img-top p-2"
                        alt="{{ $wishlist->product_name }}"
                        style="height: 200px; object-fit: cover"
                    />
                    <div class="card-body flex-grow-1">
                        <div class="text-center">
                            <h5 class="card-title">
                                <b>{{ $wishlist->product_name }}</b>
                            </h5>
                            <p class="text-muted mb-4">
                                {!! Str::limit($wishlist->description, 25) !!}
                            </p>
                        </div>
                        <div
                            class="d-flex justify-content-between total font-weight-bold mt-4"
                        >
                            <span>Price</span>
                            <span
                                >{{ $wishlist->price }} /
                                {{ $wishlist->unit }}</span
                            >
                        </div>
                        
                        <div>
                            <div class="d-flex justify-content-between">
                                <span>Quantity</span>
                                @if($wishlist->quantity > 0)
                                <span>In Stock: {{ $wishlist->quantity }}</span>
                                @else
                                <span>
                                    <b class="text-danger">
                                        OUT OF STOCK
                                    </b>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="d-flex justify-content-between total font-weight-bold mt-4">
                            <span>Ratings: {{ $rateCount }}</span>
                            <span>
                                <div class="d-flex flex-row">
                                    <div class="text-danger mb-1 me-2">
                                        @if($rateCount <= 0) No rating yet @else
                                        {!! $stars !!} 
                                        @endif
                                    </div>
                                    <span>{{ $avg }}</span>
                                </div>
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        @empty
        <div class="col-12 mx-auto text-center">
            <h1>Your wishlist is Empty</h1>
        </div>
        @endforelse
    </div>
</div>
@endsection
