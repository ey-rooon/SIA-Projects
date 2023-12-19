@extends('layouts.app') 

@section('content')
<header style="height: 100svh;">
    <div class="page-header" style="background: url('{{ asset('storage/images/header-img.jpg') }}')">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-caption">
                        <h1 class="page-title">
                            Agne Construction Supplies
                        </h1>
                        <center>
                            <a style="--clr: #7808d0" class="button" href="#see-products">
                                <span class="button__icon-wrapper">
                                    <svg width="10" class="button__icon-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 15">
                                        <path fill="currentColor" d="M13.376 11.552l-.264-10.44-10.44-.24.024 2.28 6.96-.048L.2 12.56l1.488 1.488 9.432-9.432-.048 6.912 2.304.024z"></path>
                                    </svg>
                                    
                                    <svg class="button__icon-svg  button__icon-svg--copy" xmlns="http://www.w3.org/2000/svg" width="10" fill="none" viewBox="0 0 14 15">
                                        <path fill="currentColor" d="M13.376 11.552l-.264-10.44-10.44-.24.024 2.28 6.96-.048L.2 12.56l1.488 1.488 9.432-9.432-.048 6.912 2.304.024z"></path>
                                    </svg>
                                </span>
                                Explore All
                            </a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-section">
        <div class="container">
            <div class="card-block bg-white mb30 shadow">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <!-- section-title -->
                        <div class="section-title mb-0">
                            <h2>Everything You Need to For Construction Supplies</h2>
                            <p>Our approach is very simple: we define your problem and give the best solution. </p>
                        </div>
                        <!-- /.section-title -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<button
        type="button"
        class="btn btn-danger btn-floating btn-lg"
        id="btn-back-to-top"
        >
  <i class="fas fa-arrow-up"></i>
</button>
<div class="container pt-3 mt-0" id="see-products">
    <form action="/home#see-products" method="get">
        <div class="row d-flex flex-row-reverse">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="form-floating mb-3">
                    <select class="form-control form-select" name="filter" id="filter" onchange="this.form.submit()">
                      <option value="">All</option>
                      @forelse($categories as $category)
                        <option value="{{$category->id}}" {{ $request->filter == $category->id ? 'selected' : '' }}>{{$category->category_name}}</option>
                      @empty
                      @endforelse
                    </select>
                    <label for="filter">Filter</label>
                </div>
            </div>
        </div>
    </form>

    @if($request->filter)
    @php
        $cat = $categories->where('id', $request->filter)->first();
    @endphp
        <p>Showing results of {{$cat->category_name}}</p>
    @endif
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4 g-4">
        @forelse($products as $product) 
            @php 
                $image = $photos->where('product_id', $product->id)->first(); 
    
                $avg = $ratings->where('product_id', $product->id)->avg('rating'); 
                $rateCount = $ratings->where('product_id', $product->id)->count(); 
                $wholeStarCount = (int) $avg; 
                $noStarCount = (int) (5 - $avg); 
                $hasHalfStar = $avg - $wholeStarCount > 0; 
                $stars = str_repeat('<i class="fa-solid fa-star"></i>' . PHP_EOL, $wholeStarCount) . ($hasHalfStar ? '<i class="fas fa-star-half-alt "></i>' . PHP_EOL : '') . str_repeat('<i class="fa-regular fa-star"></i>' . PHP_EOL,$noStarCount); 
    
            @endphp
    
            @include('components.product-card')
        @empty
            <div class="col-12 mx-auto text-center align-items-center my-5">
                <img src="{{ asset('storage/images/no-packing.png') }}" class="img img-fluid" alt="">
                <h2>No products available</h2>
            </div>
        @endforelse
    </div>
    
    <div class="">
        {{ $products->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>

<script>
    let mybutton = document.getElementById("btn-back-to-top");

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function () {
    scrollFunction();
    };

    function scrollFunction() {
    if (
        document.body.scrollTop > 20 ||
        document.documentElement.scrollTop > 20
    ) {
        mybutton.style.display = "block";
    } else {
        mybutton.style.display = "none";
    }
    }
    // When the user clicks on the button, scroll to the top of the document
    mybutton.addEventListener("click", backToTop);

    function backToTop() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
    }
</script>

@endsection
