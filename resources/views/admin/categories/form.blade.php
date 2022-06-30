<div class="col-12 mt-5">
    <div class="container">
         <div class="row align-items-center">
            <div class="card col-12">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="d-flex align-items-center mb-2">
                            <span class="required">Name</span>
                        </label>
                        <input type="text" class="form-control form-control-sm" name="name" value="{{ old('name', $category->name) }}" />
                        @if ($errors->has('name'))
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="formFileSm" class="form-label">Image</label>
                        <input class="form-control form-control-sm" id="formFileSm" type="file" name="image" accept=".png, .jpg, .jpeg, .svg">
                        </div>
                        @if ($errors->has('image'))
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('image') }}</div>
                        @endif
                    </div>
                    <div class="">
                        <a href="{{ route('admin-category.index') }}" class="btn btn-light btn-sm mb-3">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-sm pull-right mb-3 mr-3">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

       {{-- <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                <label class="d-flex align-items-center mb-2">
                    <span>Image</span>
                </label>
                <div class="image-input image-input-empty w-125px" data-kt-image-input="true" 
                    @if ($category->fileUrl && !empty($category->fileUrl))
                        style="background-image: url({{ $category->fileUrl }})"
                    @else
                        style="background-image: url({{ asset('img/blank.png') }})"
                    @endif
                >
                    <div class="image-input-wrapper w-125px h-125px"></div>
                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                        data-kt-image-input-action="change"
                        data-bs-toggle="tooltip"
                        data-bs-dismiss="click"
                        title="Change image"
                    >
                        <i class="bi bi-pencil-fill fs-7"></i>
                        <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                    </label>
            
                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
                        data-kt-image-input-action="cancel"
                        data-bs-toggle="tooltip"
                        data-bs-dismiss="click"
                        title="Cancel image"
                    >
                        <i class="bi bi-x fs-2"></i>
                    </span>
                </div> --}}