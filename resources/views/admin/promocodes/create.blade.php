@extends('layouts.admin', [
    'headerTitle' => 'Admin Promotion Code Create Dashboard',
    'activePage' => 'promotion-code-create',
    'breadcrumbs' => [
        [
            'title' => 'Admin Promotion Code Create Dashboard',
            'url' => route('admin-promocode.index')
        ],
        [
            'title' => 'Create new promotion code',
        ]
    ]
])

@section('content')
<form action="{{ route('admin-promocode.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card card-xl-stretch">
                <div class="card-header align-items-center border-0">
                    <h3 class="card-title align-items-start flex-column p-0 m-0">
                        <span class="fw-bolder text-dark">Create new promotion code</span>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    
    @include('partial._form-errors')

    <div class="row mt-8">
        @include('admin.promocodes.form', [
            'promotionCode' => $promotionCode,
            'typeMaps' => $typeMaps
        ])
    </div>
</form>
@endsection