@extends('layouts.dashboard', [
    'headerTitle' => 'Create Products ',
    'activePage' => 'create-products',
    'breadcrumbs' => [
        [
        'title' => 'Create Products'
        ]
    ]
])

@section('content')
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">Add New Product</h2>
            <p class="dashboard-subtitle">
                Create your own product
            </p>
        </div>
        <div class="dashboard-content">
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('dashboard-product-store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="required">Product Name</label>
                                            <input type="text" class="form-control" id="name" aria-describedby="name"
                                                name="product_name" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="price" class="required">Price</label>
                                            <input type="number" class="form-control" id="price"
                                                aria-describedby="price" name="price" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="thumbnails" class="required">Category</label>
                                            <select name="category_id" class="form-select" required>
                                                <option></option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">
                                                    {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="formFileSm" class="form-label">Image</label>
                                        <input class="form-control form-control-sm" id="formFileSm" type="file" multiple name="product_images[]" accept=".png, .jpg, .jpeg">
                                        <p class="text-muted">You Can Add Multiple Images with extension png, jpg, jpeg max: 2Mb</p>
                                        @if ($errors->has('product_images'))
                                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('product_images') }}</div>
                                        @endif
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="editor" cols="30" rows="4" class="form-control">
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <button type="submit" class="btn btn-success btn-block px-5">
                                    Save Now
                                </button>
                            </div>
                        </div>
                    </form>
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