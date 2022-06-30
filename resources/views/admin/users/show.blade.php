@extends('layouts.admin', [
    'headerTitle' => 'Users',
    'activePage' => 'users-show',
    'breadcrumbs' => [
        [
            'title' => 'Users',
            'url' => route('admin-user.index')
        ],
        [
            'title' => 'Viewing user: ' . $user->id,
        ]
    ]
])

@section('content')
@include('partial._messages')
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card ml-4 mr-4 mt-5">
                <div class="card-body">
                    <div class="d-flex flex-wrap flex-sm-nowrap">
                        <div class="">
                            <div class="position-relative ml-2 mb-3">
                                <img src="{{ $user->profile->fileUrl ?? asset('img/blank.png') }}" alt="image" width="100px" height="100px"/>
                            </div>
                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                <div class="d-flex flex-column">
                                    <div class="fw-bold fs-6 mb-4 pe-2">
                                        <div class="d-flex flex-wrap align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                            <div class="me-5">
                                                Email: <span class="fw-bolder">{{ $user->profile ? $user->email : '-' }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                            <div class="me-5">
                                                Name: <span class="fw-bolder">{{ $user->profile ? $user->name : '-' }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                            <div class="me-5">
                                                Category: <span class="fw-bolder">{{ $user->profile ? $user->profile->category->name : '-' }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                            <div class="me-5">
                                                Address: <span class="fw-bolder">{{ $user->profile ? $user->profile->address : '-' }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                            <div class="me-5">
                                                Adddress2: <span class="fw-bolder">{{ $user->profile ? $user->profile->address2 : '-' }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                            <div class="me-5">
                                                Phone Number: <span class="fw-bolder">{{ $user->profile ? $user->profile->phone_number : '-' }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                            <div class="me-5">
                                                Country: <span class="fw-bolder">{{ $user->profile ? $user->profile->country : '-' }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                            <div class="me-5">
                                                Province: <span class="fw-bolder">{{ $user->profile ? $user->profile->province->name : '-' }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                            <div class="me-5">
                                                City: <span class="fw-bolder">{{ $user->profile ? $user->profile->regency->name : '-' }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                            <div class="me-5">
                                                Post Code: <span class="fw-bolder">{{ $user->profile ? $user->profile->post_code : '-' }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                            <div class="me-5">
                                                Store Name: <span class="fw-bolder">{{ $user->profile ? $user->profile->store_name : '-' }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                            <div class="me-5">
                                              Store Status: <span class="fw-bolder">{{ $user->profile->store_status ? 'Active' : 'Unactive' }}</span>
                                            </div>
                                        </div>
                                        
                                       
                                    </div>
                                </div>
                        </div>
                        {{-- <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                <div class="d-flex flex-column">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="text-gray-900 text-hover-primary fs-2 fw-bolder me-1">{{ $user->name ? $user->name : '-' }}</span>
                                    </div>
                                    <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                                        <span class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                            <i class="fas fa-envelope me-2"></i>
                                            {{ $user->email }}
                                        </span>
                                        <span class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                            <i class="fas fa-phone me-2"></i>
                                            {{ $user->profile->phone }}
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex my-4">
                                    <a href="{{ route('admin-user.edit', $user) }}" class="btn btn-sm btn-light me-2">
                                        <i class="fas fa-edit"></i>
                                        <span>Edit</span>
                                    </a>
                                    <form action="{{ route('admin-user.delete', $user) }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-sm btn-danger me-2 delete-button">
                                            <i class="fas fa-trash"></i>
                                            <span>Delete</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
        </div>
        
        </div>
    </div>

@endsection