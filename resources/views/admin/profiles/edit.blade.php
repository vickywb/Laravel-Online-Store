@extends('layouts.admin', [
    'headerTitle' => 'Admin Profiles',
    'activePage' => 'admin-profile-edit',
    'breadcrumbs' => [
        [
            'title' => 'Admin Profiles',
            'url' => route('admin-profile', $user)
        ],
        [
            'title' => 'Edit profile: ' . $user->id,
        ]
    ]
])

@section('content')
<form action="{{ route('admin-profile.update', $user) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="col-12">
            <div class="card card-xl-stretch">
                <div class="card-header align-items-center border-0">
                    <h3 class="card-title align-items-start flex-column p-0 m-0">
                        <span class="fw-bolder text-dark">Edit admin profile: {{ $user->name }}</span>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    
    @include('partial._form-errors')
    
    <div class="row mt-8">
        @include('admin.profiles.form', [
            'user' => $user,
        ])
    </div>
</form>
@endsection