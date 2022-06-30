@extends('layouts.admin', [
    'headerTitle' => 'Admin Profile Dashboard',
    'activePage' => 'admin-profile-dashboard',
    'breadcrumbs' => [
        [
        'title' => 'Admin Profile Dashboard'
        ]
    ]
])

@section('content')
@include('partial._messages')
<div class="row mt-5">
    <div class="col-md-12">
        <div class="card ml-5 mr-5 mt-5">
            <div class="card-body">
                <div class="d-flex flex-wrap flex-sm-nowrap">
                    <div class="row">
                       <div class="col-md-6">
                            <div class="position-relative ml-2 mb-3">
                                <img src="{{ $user->profile->file->fileUrl ?? asset('img/blank.png') }}" alt="image" class="w-100"/>
                            </div>
                       </div>
                       <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                            <div class="d-flex flex-column">
                                <div class="fw-bold fs-6 mb-4 pe-2">
                                    <div class="d-flex flex-wrap align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                        <div class="me-5">
                                            Email: <span class="fw-bolder">{{ $user->email ?? '-' }}</span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                        <div class="me-5">
                                            Name: <span class="fw-bolder">{{ $user->name ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       </div>
                    </div>
                    <div class="">
                        <a href="{{ route('admin-profile.edit', $user) }}" class="btn btn-sm btn-light me-2">
                            <i class="fa fa-edit"></i>
                            <span>Edit</span>
                        </a>
                    </div>
                </div>
            </div>
    </div>
    
    </div>
</div>
@endsection
