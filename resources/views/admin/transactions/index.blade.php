@extends('layouts.admin', [
    'headerTitle' => 'Admin Transaction Dashboard',
    'activePage' => 'transaction-dashboard',
    'breadcrumbs' => [
        [
        'title' => 'Admin Transaction Dashboard'
        ]
    ]
])

@section('content')
@include('partial._messages')
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">Transaction Page</h2>
            <p class="dashboard-subtitle">
              List of Transactions
            </p>
        </div>
        <div class="dashboard-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                @foreach ($transactions as $transaction)
                                    <thead>
                                      <tr>
                                        <th scope="col">User Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date of Transaction</th>
                                        <th scope="col">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>{{ $transaction->user->name }}</td>
                                        <td>{{ $transaction->total_price }}</td>
                                        <td>{{ $transaction->transaction_status }}</td>
                                        <td>{{ $transaction->date_of_transaction->format('F j Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin-transaction.edit', $transaction->id) }}" class="btn btn-success btn-sm mb-1">
                                                <i class="fa fa-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('admin-transaction.delete', $transaction->id) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are u sure delete this?')"> <i class="fa fa-trash"></i> Delete</button>
                                            </form>
                                        </td>
                                      </tr>
                                    </tbody>
                                @endforeach
                                  </table>
                                 {{ $transactions->links('components.pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection