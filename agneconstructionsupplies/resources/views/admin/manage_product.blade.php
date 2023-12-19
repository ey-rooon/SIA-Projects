@extends('layouts.app') 
@section('content')

<div class="container py-5">
    @if(session('success'))
    <div class="alert alert-success">
        <i class="fa-solid fa-circle-check"></i> {{ session("success") }}
    </div>
    @endif 

    @if(session('info'))
    <div class="alert alert-info">
        <i class="fa-solid fa-circle-info"></i> {{ session("info") }}
    </div>
    @endif 
    @if(session('error'))
    <div class="alert alert-danger">
        <i class="fa-solid fa-triangle-exclamation"></i> {{ session("error") }}
    </div>
    @endif
    <div class="row align-items-center mb-4 p-4 border-bottom border-dark border-2">
        <div class="col-12 col-md-3 border-end border-dark">
            <h3>Manage Products</h3>
        </div>
        <div class="col-12 col-md-9">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">
               <i class="fa-solid fa-circle-plus"></i> Add Product
            </button>
        </div>
    </div>

    <table class="display">
        <thead>
            <tr>
                <th>Product</th>
                <th>Category</th>
                <th>Unit</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>
                    {{$product->product_name}}
                </td>
                <td>{{$product->category->category_name}}</td>
                <td>{{$product->unit}}</td>
                <td>{!! Str::limit($product->description, 20)!!}</td>
                <td>Php {{$product->price}}</td>
                <td>
                    {{$product->quantity}} 
                    @if($product->quantity == 0) 
                    <a href="" data-bs-toggle="tooltip" data-bs-title="Out of stock">
                        <i class="fa-solid fa-circle-exclamation text-danger"></i>
                    </a>
                    @endif 
                </td>
                <td>
                    <div class="row-9">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productPhotosModal{{$product->id}}">
                            <i class="fa-solid fa-images"></i> Image/s
                        </button>
                    
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editProductModal{{$product->id}}">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </button>
                    
                        <a href="{{ route('product.delete', $product->id) }}" class="btn btn-danger" data-confirm-delete="true">
                            <i class="fa-solid fa-trash"></i> Delete
                        </a>
                        
                        <!-- Edit Product Modal -->
                        @include('components.edit-product-modal')
                    </div>
                    
                </td>
            </tr>


            <script>
                ClassicEditor
                    .create( document.querySelector( '#product-textarea{{$product->id}}' ) )
                    .catch( error => {
                        console.error( error );
                    } );
            </script>



            @empty
            <tr>
                <td colspan="7">No data yet</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Photos Modals -->
    @forelse($products as $product)
        @include('components.photos-modal', ['productId' =>$product->id])
    @empty
    @endforelse

    <!-- Add product Modal -->
    @include('components.add-product-modal')
</div>
<script type="module">
    $(document).ready(function(){
        @if($errors->any())
            $('#addProductModal').modal('show');
        @endif

        @if ($errors->any())
            $('#editProductModal').modal('show');
        @endif
    });
</script>
@endsection

@section('ckeditor')
<script>
    ClassicEditor
        .create( document.querySelector( '#add-product-textarea' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
@endsection


