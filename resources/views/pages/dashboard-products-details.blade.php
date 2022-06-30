@extends('layouts.dashboard', [
'headerTitle' => 'Detail Products',
'activePage' => 'detail-products',
'breadcrumbs' => [
[
'title' => 'Detail Products'
]
]
])

@section('content')
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">{{ $product->product_name }}</h2>
            <p class="dashboard-subtitle">
                Product Details
            </p>
        </div>
        <div class="dashboard-content">
            <div class="row">
                <div class="col-12">

                    @include('partial._form-errors')
                    <form action="{{ route('dashboard-product-update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name">Product Name</label>
                                            <input type="text" class="form-control" id="name" aria-describedby="name"
                                                name="product_name" value="{{ $product->product_name }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="price">Price</label>
                                            <input type="number" class="form-control" id="price"
                                                aria-describedby="price" name="price" value="{{ $product->price }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="quantity">Stock</label>
                                            <input type="number" class="form-control" id="quantity"
                                                aria-describedby="quantity" name="quantity" value="{{ $product->quantity }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="required">Category</label>
                                            <select name="category_id" class="form-select" required>
                                                <option></option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" 
                                                    @if (old('category_id', $product->category ? $product->category->id : null) == $category->id)
                                                        selected
                                                    @endif>
                                                    {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" rows="3" class="form-control">
                                                {!! $product->description !!}
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="btn btn-success btn-block px-5">
                                            Update Product
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                @foreach ($product->productImages as $image)
                                <div class="col-md-4">
                                    <div class="gallery-container">
                                        <img src="{{ $image->file->fileUrl }}" alt="" class="w-50" />
                                        <a class="delete-gallery" href="{{ route('dashboard-product-delete-image', $image->id) }}">
                                            <img src="/images/icon-delete.svg" alt="" />
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                                <div class="col-mt-3">
                                  <form action="{{ route('dashboard-product-upload-image') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="file" id="file" style="display: none;" multiple name="product_images[]" onchange="form.submit()"/>
                                    <button type="button" class="btn btn-secondary btn-block" onclick="thisFileUpload();">
                                        Add Photo
                                    </button>
                                  </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
        });
</script>
<script>
    function thisFileUpload() {
        document.getElementById("file").click();
        }
</script>
@endsection