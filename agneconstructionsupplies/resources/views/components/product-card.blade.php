<div class="product-card col-12 col-sm-6 col-md-4 col-lg-3">
    <div class="card d-flex flex-column h-100 shadow bg-body rounded p-3 mb-2 ">
        <a href="/product_details/{{$product->id}}" class="text-black">
            <img
                src="{{ asset('storage/images/'. $image->file_name) }}"
                class="card-img-top p-2"
                alt="{{ $product->product_name }}"
                style="height: 200px; object-fit: cover"
            />
            <div class="card-body flex-grow-1">
                <div class="text-center">
                    <h5 class="card-title">
                        <b>
                            @if(Auth::id())
                                @php
                                    $isExist = $wishlists->where('user_id', Auth::id())->where('product_id', $product->id)->count();
                                    $wid = $wishlists->where('user_id', Auth::id())->where('product_id', $product->id)->value('id');
                                @endphp
                                @if($isExist == 0)
                                    <a href="/add_to_wishlist/{{$product->id}}">
                                        <i class="fa-regular fa-heart fa-md text-danger"></i>
                                    </a>
                                @else
                                    <i class="fa-solid fa-heart fa-md text-danger"></i>
                                @endif
                            @else
                                <i class="fa-regular fa-heart fa-md text-danger"></i>
                            @endif
                            {{ $product->product_name }}
                        </b>
                    </h5>
                    <p class="text-muted mb-4">
                        {!! Str::limit($product->description, 25) !!}
                    </p>
                </div>
                <div
                    class="d-flex justify-content-between total font-weight-bold mt-4"
                >
                    <span>Price</span>
                    <span
                        >{{ $product->price }} /
                        {{ $product->unit }}</span
                    >
                </div>
                
                <div>
                    <div class="d-flex justify-content-between">
                        <span>Quantity</span>
                        @if($product->quantity > 0)
                        <span>In Stock: {{ $product->quantity }}</span>
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