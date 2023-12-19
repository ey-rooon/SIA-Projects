@forelse($carts as $cart) 

@php 

$image = $photos->where('product_id', $cart->pid)->first(); 
$avg = $ratings->where('product_id', $cart->pid)->avg('rating'); 
$rateCount = $ratings->where('product_id', $cart->pid)->count(); 
$wholeStarCount = (int) $avg; 
$noStarCount = (int) (5 - $avg); 
$hasHalfStar = $avg - $wholeStarCount > 0; 
$stars = str_repeat('<i class="fa-solid fa-star"></i>' . PHP_EOL, $wholeStarCount) . ($hasHalfStar ? '<i class="fas fa-star-half-alt "></i>' . PHP_EOL : '') . str_repeat('<i class="fa-regular fa-star"></i>' . PHP_EOL,$noStarCount); 


@endphp

<a href="/product_details/{{$cart->pid}}" style="text-decoration: none">
    <div class="row justify-content-center">
        <div class="col-md-12 col-xl-10">
            <div class="card shadow rounded p-3 mb-2" id="card_{{$cart->pid}}">
                <div class="card-body">
                    <div class="row">
                        <div class="col py-2">
                            <div class="form-check checkbox-xl">
                                <input
                                    type="checkbox"
                                    name="carts[]"
                                    class="form-check-input"
                                    id="cart_{{$cart->pid}}"
                                    data-amount="{{ $cart -> amount }}"
                                    value="{{$cart->cid}}"
                                />
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-3 col-xl-3 mb-4 mb-lg-0">
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
                                {{ $cart->product_name }} | rating:
                                {{ $rateCount }}
                            </h5>
                            <div class="d-flex flex-row">
                                <div class="text-danger mb-1 me-2">
                                    @if($rateCount <= 0) No rating yet @else {!!
                                    $stars !!} @endif
                                </div>
                                <span>{{ $avg }}</span>
                            </div>
                            <p class="text-truncate mb-4 mb-md-0">
                                {!! $cart->description !!}
                            </p>
                        </div>
                        <div
                            class="col-md-6 col-lg-3 col-xl-3 border-sm-start-none border-start"
                        >
                            <div
                                class="d-flex flex-row align-items-center mb-1"
                            >
                                <h4 class="mb-1 me-1">
                                    Php {{ $cart->amount }}
                                </h4>
                                <span class="text-danger"><s></s></span>
                            </div>
                            <h6 class="text-success">
                                <label for="quantity" class="form-label"
                                    >Quantity:
                                </label>
                                <div class="input-group px-3">
                                    <button
                                        class="btn btn-outline-secondary"
                                        type="button"
                                        aria-label="decreaseQuan"
                                        onclick="decreaseQuan('{{$cart->cid}}')"
                                    >
                                        -
                                    </button>
                                    <input
                                        type="number"
                                        class="form-control text-center"
                                        value="{{$cart->quantity}}"
                                    />
                                    <button
                                        class="btn btn-outline-secondary"
                                        type="button"
                                        aria-label="increaseQuan"
                                        onclick="increaseQuan('{{$cart->cid}}')"
                                    >
                                        +
                                    </button>
                                </div>
                            </h6>
                            <div class="d-flex flex-column mt-4">
                                <a
                                    href="/product_details/{{$cart->pid}}"
                                    class="btn btn-success btn-sm"
                                >
                                    Details
                                </a>
                                <a
                                    href="remove_cart/{{$cart->cid}}"
                                    class="btn btn-outline-danger btn-sm mt-2"
                                >
                                    Remove
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</a>
<script>
    $(document).ready(function () {
        var checkbox = $("#cart_{{$cart->pid}}");
        var card = $("#card_{{$cart->pid}}");

        // Check the checkbox's initial state
        if (checkbox.is(":checked")) {
            card.addClass("bg-primary bg-opacity-25");
        }

        checkbox.change(function () {
            if (checkbox.is(":checked")) {
                card.addClass("bg-primary bg-opacity-25");
            } else {
                card.removeClass("bg-primary bg-opacity-25");
            }
            updateCheckoutTotal();
        });
    });
</script>

@empty
<div class="col-12 mx-auto text-center">
    <img
        src="{{ asset('storage/images/empty-cart.png') }}"
        alt=""
        class="img-fluid"
    />
    <h2>Your Cart is Empty</h2>
</div>
@endforelse
