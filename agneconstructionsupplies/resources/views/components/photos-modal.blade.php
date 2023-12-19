<div class="modal fade" id="productPhotosModal{{$product->id}}" tabindex="-1" aria-labelledby="productPhotosLabel{{$product->id}}" aria-hidden="true"> 
    <div class="modal-dialog"> 
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="productPhotosLabel{{$product->id}}">{{$product->product_name}}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="carouselExampleControls{{$product->id}}" class="carousel carousel-dark slide" data-bs-ride="carousel">
                    <div class="carousel-inner" style="height: 400px; overflow: hidden;"> <!-- Adjust the height as needed -->
                        @php
                            $images = $photos->where('product_id', $product->id);
                            $first = true;
                        @endphp
                        @forelse($images as $photo)
                            <div class="carousel-item {{ $first ? 'active' : '' }}">
                                <a href="/remove_image/{{$photo->id}}" class="btn btn-outline-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                                <img src="{{ asset('storage/images/'. $photo->file_name) }}" class="d-block w-100 img-fluid" style="object-fit: cover; height: 100%;" alt="{{ $photo->file_name }}">
                            </div>
                            @php $first = false; @endphp
                        @empty
                            <div class="carousel-item">
                                <center><h3><i class="fa-solid fa-image-slash"></i> No Photo/s</h3></center>
                            </div>
                        @endforelse
                    
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls{{$product->id}}" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls{{$product->id}}" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
