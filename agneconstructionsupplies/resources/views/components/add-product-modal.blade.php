<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Add product</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/add_product" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row p-2">
                    <div class="col">
                        <label class="fw-bold">Product Photo</label>
                        <input type="file" name="photo[]" class="form-control @error('photo') is-invalid @enderror" accept="image/png, image/gif, image/jpeg" value="{{@old('photo[]')}}" multiple>
                        @error('photo') 
                            <div class="invalid-feedback">{{$message}}</div> 
                        @enderror
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col">
                        <label class="fw-bold">Product</label>
                        <input type="text" name="prod_name" class="form-control @error('prod_name') is-invalid @enderror" value="{{@old('prod_name')}}">
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
                                <option value="{{$category->id}}" {{ @old('category') == $category->id ? 'selected':'' }}>{{$category->category_name}}</option>
                            @empty
                            @endforelse
                        </select>
                        @error('prod_name') 
                            <div class="invalid-feedback">{{$message}}</div>  
                        @enderror
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col">
                        <label class="fw-bold">Product Unit</label><br>
                        <select name="prod_unit" class="form-select @error('prod_unit') is-invalid @enderror">
                            <option value="" disabled selected>Select Option</option>
                            <option value="KG">KG</option>
                            <option value="PIECES">PIECES</option>
                        </select>
                        @error('prod_unit') 
                            <div class="invalid-feedback">{{$message}}</div>  
                        @enderror
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col">
                        <label class="fw-bold">Product Description</label><br>
                        <textarea name="prod_desc" rows="5" cols="30" class="form-control @error('prod_desc') is-invalid @enderror" id="add-product-textarea">{{@old('prod_desc')}}</textarea>
                        @error('prod_desc') 
                            <div class="invalid-feedback">{{$message}}</div>  
                        @enderror
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col">
                        <label class="fw-bold">Product Price</label>
                        <input type="number" name="prod_price" class="form-control @error('prod_price') is-invalid @enderror" value="{{@old('prod_price')}}"  step=".01">
                        @error('prod_price') 
                            <div class="invalid-feedback">{{$message}}</div> 
                        @enderror
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col">
                        <label class="fw-bold">Product Quantity</label>
                        <input type="number" name="prod_quan" class="form-control @error('prod_quan') is-invalid @enderror" value="{{@old('prod_quan')}}">
                        @error('prod_quan') 
                            <div class="invalid-feedback">{{$message}}</div>  
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-plus"></i> Add Product</button>
                </div>
            </div>
        </form>
    </div>
</div>