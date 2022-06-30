@extends('layouts.admin', [
    'headerTitle' => 'Products',
    'activePage' => 'product-edit',
    'breadcrumbs' => [
        [
            'title' => 'Products',
            'url' => route('admin-product.index')
        ],
        [
            'title' => 'Edit Product: ' . $product->id,
        ]
    ]
])

@section('content')
<form action="{{ route('admin-product.update', $product) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="col-12">
            <div class="card card-xl-stretch">
                <div class="card-header align-items-center border-0">
                    <h3 class="card-title align-items-start flex-column p-0 m-0">
                        <span class="fw-bolder text-dark">Edit product: {{ $product->id }}</span>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    
    @include('partial._form-errors')
    
    <div class="row mt-8">
        @include('admin.products.form', [
            'product' => $product,
            'categories' => $categories,
            'users' => $users
        ])
    </div>
</form>
@endsection