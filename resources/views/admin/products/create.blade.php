@extends('layouts.admin', [
    'headerTitle' => 'Admin Product Create Dashboard',
    'activePage' => 'product-create',
    'breadcrumbs' => [
        [
            'title' => 'Admin Product Create Dashboard',
            'url' => route('admin-product.index')
        ],
        [
            'title' => 'Create new product',
        ]
    ]
])

@section('content')
<form action="{{ route('admin-product.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card card-xl-stretch">
                <div class="card-header align-items-center border-0">
                    <h3 class="card-title align-items-start flex-column p-0 m-0">
                        <span class="fw-bolder text-dark">Create new product</span>
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