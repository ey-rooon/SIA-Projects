<div class="modal fade" id="editProductModal{{$product->id}}" tabindex="-1" aria-labelledby="editModalLabel{{$product->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="editModalLabel{{$product->id}}">{{ $product->product_name}}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/edit_product/{{$product->id}}" method="post">
            @csrf
            <div class="modal-body">
                <div class="row p-2">
                    <div class="col">
                        <label class="fw-bold">Product</label>
                        <input type="text" name="prod_name" class="form-control @error('prod_name') is-invalid @enderror" value="{{ $product->product_name}}">
                        @error('prod_name') 
                            <div class="invalid-feedback">{{$message}}</div>  
                        @enderror
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col">
                        <label class="fw-bold">Category</label>
                        <select name="category" class="form-control @error('category') is-invalid @enderror">
                            <option value="" disabled selected>Select Option</option>
                            @forelse($categories as $category)
                                <option value="{{$category->id}}" {{ $product->category->id == $category->id ? 'selected':'' }}>{{$category->category_name}}</option>
                            @empty
                            @endforelse
                        </select>
                        @error('category') 
                            <div class="invalid-feedback">{{$message}}</div>  
                        @enderror
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col">
                        <label class="fw-bold">Product Unit</label><br>
                        <select name="prod_unit" class="form-select @error('prod_unit') is-invalid @enderror">
                            <option value="" disabled selected>Select Option</option>
                            <option value="KG" {{ $product->unit == 'KG' ? 'selected' : ''}} >KG</option>
                            <option value="PIECES" {{ $product->unit == 'PIECES' ? 'selected' : ''}} >PIECES</option>
                        </select>
                        @error('prod_unit') 
                            <div class="invalid-feedback">{{$message}}</div>  
                        @enderror
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col">
                        <label class="fw-bold">Product Description</label><br>
                        <textarea name="prod_desc" rows="5" cols="30" class="form-control @error('prod_desc') is-invalid @enderror" id="product-textarea{{$product->id}}">{{$product->description}}</textarea>
                        @error('prod_desc') 
                            <div class="invalid-feedback">{{$message}}</div>  
                        @enderror
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col">
                        <label class="fw-bold">Product Price</label>
                        <input type="number" name="prod_price" class="form-control @error('prod_price') is-invalid @enderror" value="{{$product->price}}" step=".01">
                        @error('prod_price') 
                            <div class="invalid-feedback">{{$message}}</div> 
                        @enderror
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col">
                        <label class="fw-bold">Product Quantity</label>
                        <input type="number" name="prod_quan" class="form-control @error('prod_quan') is-invalid @enderror" value="{{$product->quantity}}">
                        @error('prod_quan') 
                            <div class="invalid-feedback">{{$message}}</div>  
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning text-light"><i class="fa-solid fa-save"></i> Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>