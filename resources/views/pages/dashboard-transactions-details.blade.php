@extends('layouts.dashboard', [
    'headerTitle' => 'Transaction Details Products',
    'activePage' => 'transaction-detail-products',
    'breadcrumbs' => [
        [
        'title' => 'Transaction Detail Products'
        ]
    ]
])

@section('content')
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">{{ $transaction->transaction_code }}</h2>
            <p class="dashboard-subtitle">
                Transaction Details
            </p>
        </div>
        <div class="dashboard-content" id="transactionDetails">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <img src="{{ $transaction->product->firstImage->file->fileUrl ?? asset('img/blank.png') }}" alt="" class="w-100 mb-3" />
                                </div>
                                <div class="col-12 col-md-8">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="product-title">Customer Name</div>
                                            <div class="product-subtitle">{{ $transaction->transaction->user->name }}</div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="product-title">Product Name</div>
                                            <div class="product-subtitle">
                                                {{ $transaction->product->product_name }}
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="product-title">
                                                Date of Transaction
                                            </div>
                                            <div class="product-subtitle">
                                                {{ $transaction->transaction->date_of_transaction }}
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="product-title">Payment Status</div>
                                            <div class="product-subtitle text-danger">
                                                {{ $transaction->transaction->transaction_status }}
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="product-title">Total Amount</div>
                                            <div class="product-subtitle">Rp. {{ $transaction->transaction->total_price }}</div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="product-title">Mobile</div>
                                            <div class="product-subtitle">
                                                {{ $transaction->transaction->user->profile->phone_number }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('dashboard-transactions-update', $transaction) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12 mt-4">
                                        <h5>
                                            Shipping Informations
                                        </h5>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Address 1</div>
                                                <div class="product-subtitle">
                                                    {{ $transaction->transaction->user->profile->address }}
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Address 2</div>
                                                <div class="product-subtitle">
                                                    {{ $transaction->transaction->user->profile->address2 ?? '-'}}
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">
                                                    Province
                                                </div>
                                                <div class="product-subtitle">
                                                    {{ $transaction->transaction->user->profile->province->name }}
                                                    {{-- {{ App\Models\Province::find($transaction->transaction->user->profile->provinces_id)->name }} --}}
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">City</div>
                                                <div class="product-subtitle">
                                                    {{ $transaction->transaction->user->profile->regency->name }}
                                                    {{-- {{ App\Models\Regency::find($transaction->transaction->user->profile->regencies_id)->name }} --}}
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Postal Code</div>
                                                <div class="product-subtitle">{{ $transaction->transaction->user->profile->post_code }}</div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="product-title">Country</div>
                                                <div class="product-subtitle">
                                                    {{ $transaction->transaction->user->profile->country }}
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="product-title">Shipping Status</div>
                                                        <select name="shipping_status" id="status" class="form-select"
                                                            v-model="status">
                                                            <option value="PENDING">Pending</option>
                                                            <option value="SHIPPING">Shipping</option>
                                                            <option value="SUCCESS">Success</option>
                                                        </select>
                                                    </div>
                                                    <template v-if="status == 'SHIPPING'">
                                                        <div class="col-md-3">
                                                            <div class="product-title">
                                                                Input Resi
                                                            </div>
                                                            <input class="form-control" type="text" name="receipt_number"
                                                                id="openStoreTrue" v-model="resi" />
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="submit" class="btn btn-success btn-block mt-4">
                                                                Update Resi
                                                            </button>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-12 text-right">
                                                <button type="submit" class="btn btn-success btn-lg mt-4">Save Now</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
<script src="/vendor/vue/vue.js"></script>
<script>
    var transactionDetails = new Vue({
      el: "#transactionDetails",
      data: {
        status: "{{ $transaction->shipping_status }}",
        resi: "{{ $transaction->receipt_number }}",
      },
    });
</script>
@endsection