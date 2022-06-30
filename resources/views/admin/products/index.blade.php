@extends('layouts.admin', [
    'headerTitle' => 'Admin Product Dashboard',
    'activePage' => 'product-dashboard',
    'breadcrumbs' => [
        [
        'title' => 'Admin Product Dashboard'
        ]
    ]
])

@section('content')
@include('partial._messages')
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">Product Page</h2>
            <p class="dashboard-subtitle">
              List of Products
            </p>
        </div>
        <div class="dashboard-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('admin-product.create') }}" class="btn btn-primary mb-3">
                               + Create new product
                            </a>
                            <div class="table-responsive">
                                <table class="table">
                                @foreach ($products as $product)
                                    <thead>
                                      <tr>
                                        <th scope="col">User</th>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Slug</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Product Image</th>
                                        <th scope="col">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>{{ $product->user->name }}</td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->slug }}</td>
                                        <td>{{ $product->category->name }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->description }}</td>
                                        {{-- @foreach ($product->productImages as $productImage)
                                            <td><img src="{{ $productImage->file->fileUrl ?? asset('img/blank.png') }}" width="50px" height="50px"/>
                                            </td>
                                        @endforeach --}}
                                        <td>
                                            {{-- <a href="{{ route('admin-user.show', $product->id) }}" class="btn btn-success btn-sm mb-1">
                                                <i class="fa fa-eye"></i> Show
                                            </a> --}}
                                            <a href="{{ route('admin-product.edit', $product->id) }}" class="btn btn-success btn-sm mb-1">
                                                <i class="fa fa-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('admin-product.delete', $product->id) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are u sure delete this?')"> <i class="fa fa-trash"></i> Delete</button>
                                            </form>
                                        </td>
                                      </tr>
                                    </tbody>
                                @endforeach
                                  </table>
                                 {{ $products->links('components.pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection