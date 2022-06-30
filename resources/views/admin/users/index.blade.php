@extends('layouts.admin', [
    'headerTitle' => 'Admin User Dashboard',
    'activePage' => 'category-dashboard',
    'breadcrumbs' => [
        [
        'title' => 'Admin User Dashboard'
        ]
    ]
])

@section('content')
@include('partial._messages')
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">User Page</h2>
            <p class="dashboard-subtitle">
              List of Users
            </p>
        </div>
        <div class="dashboard-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('admin-user.create') }}" class="btn btn-primary mb-3">
                               + Create new user
                            </a>
                            <div class="table-responsive">
                                <table class="table">
                                @foreach ($users as $user)
                                    <thead>
                                      <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Icon</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Store Name</th>
                                        <th scope="col">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>{{ $user->name }}</td>
                                        <td><img src="{{ $user->profile->file->fileUrl ?? asset('img/blank.png') }}" width="50px" height="50px"/>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->profile->store_name ?? '' }}</td>
                                        <td>
                                            <a href="{{ route('admin-user.show', $user->id) }}" class="btn btn-success btn-sm mb-1">
                                                <i class="fa fa-eye"></i> Show
                                            </a>
                                            <a href="{{ route('admin-user.edit', $user->id) }}" class="btn btn-success btn-sm mb-1">
                                                <i class="fa fa-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('admin-user.delete', $user->id) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are u sure delete this?')"> <i class="fa fa-trash"></i> Delete</button>
                                            </form>
                                        </td>
                                      </tr>
                                    </tbody>
                                @endforeach
                                  </table>
                                 {{ $users->links('components.pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection