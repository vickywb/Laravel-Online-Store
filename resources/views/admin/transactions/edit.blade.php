@extends('layouts.admin', [
    'headerTitle' => 'Transactions',
    'activePage' => 'transaction-edit',
    'breadcrumbs' => [
        [
            'title' => 'Transactions',
            'url' => route('admin-transaction.index')
        ],
        [
            'title' => 'Edit transaction: ' . $transaction->id,
        ]
    ]
])

@section('content')
<form action="{{ route('admin-transaction.update', $transaction) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="row">
        <div class="col-12">
            <div class="card card-xl-stretch">
                <div class="card-header align-items-center border-0">
                    <h3 class="card-title align-items-start flex-column p-0 m-0">
                        <span class="fw-bolder text-dark">Edit transaction: {{ $transaction->id }}</span>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    
    @include('partial._form-errors')
    
    <div class="row mt-8">
        @include('admin.transactions.form', [
            'transaction' => $transaction,
        ])
    </div>
</form>
@endsection