<div class="col-12 mt-5">
    <div class="container">
         <div class="row align-items-center">
            <div class="card col-12">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="d-flex align-items-center mb-2">
                            <span class="required">Name</span>
                        </label>
                        <input type="text" class="form-control form-control-sm" name="name" value="{{ old('name', $promotionCode->name) }}" />
                        @if ($errors->has('name'))
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="d-flex align-items-center mb-2">
                            <span class="required">Code</span>
                        </label>
                        <input type="text" class="form-control form-control-sm" name="code" value="{{ old('code', $promotionCode->code) }}" />
                        @if ($errors->has('code'))
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('code') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="d-flex align-items-center mb-2">
                            <span>Category</span>
                        </label>
                        <select class="form-select" aria-label="Default select example" data-placeholder="Select an option" name="type">
                            <option></option>
                            @foreach ($typeMaps as $key => $type)
                                <option value="{{ $key }}"
                                    @if (old('type', $promotionCode->type ?? '' ) == $key)
                                        selected
                                    @endif
                                >{{ $type }}</option>
                            @endforeach
                          </select>
                        @if ($errors->has('type'))
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('type') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="d-flex align-items-center mb-2">
                            <span>Amount</span>
                        </label>
                        <input type="text" class="form-control form-control-sm" name="amount" value="{{ old('amount', $promotionCode->amount) }}" />
                        @if ($errors->has('amount'))
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('amount') }}</div>
                        @endif
                    </div>
                    <div class="">
                        <a href="{{ route('admin-user.index') }}" class="btn btn-light btn-sm mb-3">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-sm pull-right mb-3 mr-3">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>