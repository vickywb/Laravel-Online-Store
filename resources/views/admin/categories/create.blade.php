@extends('layouts.admin', [
    'headerTitle' => 'Admin Category Create Dashboard',
    'activePage' => 'category-create',
    'breadcrumbs' => [
        [
            'title' => 'Admin Category Create Dashboard',
            'url' => route('admin-category.index')
        ],
        [
            'title' => 'Create new category',
        ]
    ]
])

@section('content')
<form action="{{ route('admin-category.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card card-xl-stretch">
                <div class="card-header align-items-center border-0">
                    <h3 class="card-title align-items-start flex-column p-0 m-0">
                        <span class="fw-bolder text-dark">Create new category</span>
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