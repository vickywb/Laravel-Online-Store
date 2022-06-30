@extends('layouts.admin', [
    'headerTitle' => 'Categories',
    'activePage' => 'category-edit',
    'breadcrumbs' => [
        [
            'title' => 'Categories',
            'url' => route('admin-category.index')
        ],
        [
            'title' => 'Edit Category: ' . $category->id,
        ]
    ]
])

@section('content')
<form action="{{ route('admin-category.update', $category) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="col-12">
            <div class="card card-xl-stretch">
                <div class="card-header align-items-center border-0">
                    <h3 class="card-title align-items-start flex-column p-0 m-0">
                        <span class="fw-bolder text-dark">Edit category: {{ $category->id }}</span>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    
    @include('partial._form-errors')
    
    <div class="row mt-8">
        @include('admin.categories.form', [
            'category' => $category
        ])
    </div>
</form>
@endsection