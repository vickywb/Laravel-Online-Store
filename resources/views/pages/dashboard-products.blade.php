@extends('layouts.dashboard', [
'headerTitle' => 'Products',
'activePage' => 'products',
'breadcrumbs' => [
[
'title' => 'Products'
]
]
])

@section('content')
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">My Products</h2>
            <p class="dashboard-subtitle">
                Manage it well and get money
            </p>
        </div>
        <div class="dashboard-content">
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('dashboard-product-create') }}" class="btn btn-success">Add New Product</a>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    @foreach ($products as $product)
                        <a class="card card-dashboard-product d-block" href="{{ route('dashboard-product-details', $product) }}">
                            <div class="card-body">
                                <img src="{{ $product->firstImage->file->fileUrl ?? asset('img/blank.png') }}" alt="" class="w-50 mb-2" />
                                <div class="product-title">{{ $product->product_name }}</div>
                                <div class="product-category">{{ $product->category->name }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection