<div class="col-12 mt-5">
    <div class="container">
         <div class="row align-items-center">
            <div class="card col-12">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="d-flex align-items-center mb-2">
                            <span>Owner</span>
                        </label>
                        <select class="form-select" aria-label="Default select example" data-placeholder="Select an option" name="user_id">
                            <option></option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    @if (old('user_id', $product->user_id) == $user->id)
                                        selected
                                    @endif
                                >{{ $user->name }}</option>
                            @endforeach
                          </select>
                        @if ($errors->has('user_id'))
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('user_id') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="d-flex align-items-center mb-2">
                            <span>Category</span>
                        </label>
                        <select class="form-select" aria-label="Default select example" data-placeholder="Select an option" name="category_id">
                            <option></option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    @if (old('category_id', $product->category_id) == $category->id)
                                        selected
                                    @endif
                                >{{ $category->name }}</option>
                            @endforeach
                          </select>
                        @if ($errors->has('category_id'))
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('category_id') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="d-flex align-items-center mb-2">
                            <span class="required">Product Name</span>
                        </label>
                        <input type="text" class="form-control form-control-sm" name="product_name" value="{{ old('product_name', $product->product_name) }}" />
                        @if ($errors->has('product_name'))
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('product_name') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="d-flex align-items-center mb-2">
                            <span>Price</span>
                        </label>
                        <input type="text" class="form-control form-control-sm" name="price" value="{{ old('price', $product->price) }}" />
                        @if ($errors->has('price'))
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('price') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="d-flex align-items-center mb-2">
                            <span>Description</span>
                        </label>
                        <textarea name="description" id="description" cols="74" rows="5" >{{ old('description', $product->description) }}</textarea>
                        @if ($errors->has('description'))
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('description') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="formFileSm" class="form-label">Image</label>
                        <input class="form-control" id="formFileSm" type="file" multiple name="product_images[]" accept=".png, .jpg, .jpeg">
                        <p class="text-muted">You Can Add Multiple Images with extension png, jpg, jpeg max: 2Mb</p>
                        @if ($errors->has('product_images'))
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('product_images') }}</div>
                        @endif
                    </div>
                    <div class="">
                        <a href="{{ route('admin-user.index') }}" class="btn btn-light btn-sm mb-3">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-sm pull-right mb-3 mr-3">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>