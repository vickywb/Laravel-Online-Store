@extends('layouts.admin', [
    'headerTitle' => 'Admin User Create Dashboard',
    'activePage' => 'user-create',
    'breadcrumbs' => [
        [
            'title' => 'Admin User Create Dashboard',
            'url' => route('admin-user.index')
        ],
        [
            'title' => 'Create new user',
        ]
    ]
])

@section('content')
<form action="{{ route('admin-user.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card card-xl-stretch">
                <div class="card-header align-items-center border-0">
                    <h3 class="card-title align-items-start flex-column p-0 m-0">
                        <span class="fw-bolder text-dark">Create new user</span>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    
    @include('partial._form-errors')

    <div class="row mt-8">
        @include('admin.users.form', [
            'user' => $user,
            'categories' => $categories
        ])
    </div>
</form>
@endsection