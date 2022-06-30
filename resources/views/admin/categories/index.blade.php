@extends('layouts.admin', [
    'headerTitle' => 'Admin Category Dashboard',
    'activePage' => 'category-dashboard',
    'breadcrumbs' => [
        [
        'title' => 'Admin Category Dashboard'
        ]
    ]
])

@section('content')
@include('partial._messages')
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">Category Page</h2>
            <p class="dashboard-subtitle">
              List of Categories
            </p>
        </div>
        <div class="dashboard-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('admin-category.create') }}" class="btn btn-primary mb-3">
                               + Create new category
                            </a>
                            <div class="table-responsive">
                                <table class="table">
                                @foreach ($categories as $category)
                                    <thead>
                                      <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Icon</th>
                                        <th scope="col">Slug</th>
                                        <th scope="col">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>{{ $category->name }}</td>
                                        <td><img src="{{ $category->fileUrl ?? asset('img/blank.png') }}" width="50px" height="50px"/>
                                        </td>
                                        <td>{{ $category->slug }}</td>
                                        <td>
                                            <a href="{{ route('admin-category.edit', $category->id) }}" class="btn btn-success mb-1">
                                                <i class="fa fa-pencil"></i> Edit
                                            </a>
                                            <form action="" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are u sure to delete this?')">Delete</button>
                                            </form>
                                        </td>
                                      </tr>
                                    </tbody>
                                @endforeach
                                  </table>
                                 {{ $categories->links('components.pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- 
    While using DataTables
@section('javascript')
    <script>
        var datatable = $('#crudTable').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '{!! url()->current() !!}'
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'icon', name: 'icon'},
                {data: 'slug', name: 'slug'},
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    width: '15%'
                },

            ]
        })
    </script>
@endsection --}}