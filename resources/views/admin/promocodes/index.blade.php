@extends('layouts.admin', [
    'headerTitle' => 'Admin Promotion Code Dashboard',
    'activePage' => 'promotion-code-dashboard',
    'breadcrumbs' => [
        [
        'title' => 'Admin Promotion Code Dashboard'
        ]
    ]
])

@section('content')
@include('partial._messages')
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">Promotion Code Page</h2>
            <p class="dashboard-subtitle">
              List of Promotion Codes
            </p>
        </div>
        <div class="dashboard-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('admin-promocode.create') }}" class="btn btn-primary mb-3">
                                + Create new promotion code
                             </a>
                            <div class="table-responsive">
                                <table class="table">
                                @foreach ($promotionCodes as $promotionCode)
                                    <thead>
                                      <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>{{ $promotionCode->name }}</td>
                                        <td>{{ $promotionCode->code }}</td>
                                        <td>{{ $promotionCode->type }}</td>
                                        <td>{{ $promotionCode->amount }}</td>
                                        <td>
                                            <a href="{{ route('admin-promocode.edit', $promotionCode->id) }}" class="btn btn-success btn-sm mb-1">
                                                <i class="fa fa-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('admin-promocode.delete', $promotionCode->id) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are u sure delete this?')"> <i class="fa fa-trash"></i> Delete</button>
                                            </form>
                                        </td>
                                      </tr>
                                    </tbody>
                                @endforeach
                                  </table>
                                 {{ $promotionCodes->links('components.pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection