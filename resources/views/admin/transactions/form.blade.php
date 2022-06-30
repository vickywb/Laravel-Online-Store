<div class="col-12 mt-5">
    <div class="container">
         <div class="row align-items-center">
            <div class="card col-12">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="d-flex align-items-center mb-2">
                            <span>Transaction Status</span>
                        </label>
                        <select class="form-select" aria-label="Default select example" data-placeholder="Select an option" name="transaction_status">
                            @foreach ($transactionStatuses as $status)
                                <option value="{{ $status }}"
                                @if (old('transaction_status', $transaction->transaction_status) == $status) 
                                    selected
                                @endif
                                >
                                {{ $status }}
                                </option>
                            @endforeach
                          </select>
                        @if ($errors->has('transaction_status'))
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('transaction_status') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="d-flex align-items-center mb-2">
                            <span>Total Price Transaction</span>
                        </label>
                        <input type="text" class="form-control form-control-sm" name="total_price" value="{{ old('total_price', $transaction->total_price) }}" />
                        @if ($errors->has('total_price'))
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('total_price') }}</div>
                        @endif
                    </div>
                    <div class="">
                        <a href="{{ route('admin-transaction.index') }}" class="btn btn-light btn-sm mb-3">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-sm pull-right mb-3 mr-3">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>