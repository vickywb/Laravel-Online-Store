<div class="col-12 mt-5">
    <div class="container">
         <div class="row align-items-center">
            <div class="card col-12">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="d-flex align-items-center mb-2">
                            <span class="required">Email</span>
                        </label>
                        <input type="email" class="form-control form-control-sm" name="email" value="{{ old('email', $user->email) }}" />
                        @if ($errors->has('email'))
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('email') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="d-flex align-items-center mb-2">
                            <span class="required">Name</span>
                        </label>
                        <input type="text" class="form-control form-control-sm" name="name" value="{{ old('name', $user->name) }}" />
                        @if ($errors->has('name'))
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="d-flex align-items-center mb-2">
                            <span>Category</span>
                        </label>
                        <select class="form-select" aria-label="Default select example" data-placeholder="Select an option" name="category_id">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    @if (old('category_id', $user->category_id) == $category->id)
                                        selected
                                    @endif
                                >{{ $category->name }}</option>
                            @endforeach
                          </select>
                        @if ($errors->has('category_id'))
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('category_id') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="d-flex align-items-center mb-2">
                            <span>Address</span>
                        </label>
                        <input type="text" class="form-control form-control-sm" name="address" value="{{ old('address', $user->profile ? $user->profile->address : '') }}" />
                        @if ($errors->has('address'))
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('address') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="d-flex align-items-center mb-2">
                            <span>Address2</span>
                        </label>
                        <input type="text" class="form-control form-control-sm" name="address2" value="{{ old('address2', $user->profile ? $user->profile->address2 : '') }}" />
                        @if ($errors->has('address2'))
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('address2') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="d-flex align-items-center mb-2">
                            <span>Phone Number</span>
                        </label>
                        <input type="number" class="form-control form-control-sm" name="phone_number" value="{{ old('phone_number', $user->profile ? $user->profile->phone_number : '') }}" />
                        @if ($errors->has('phone_number'))
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('phone_number') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="d-flex align-items-center mb-2">
                            <span>Country</span>
                        </label>
                        <input type="text" class="form-control form-control-sm" name="country" value="{{ old('country', $user->profile ? $user->profile->country : '') }}" />
                        @if ($errors->has('country'))
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('country') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="d-flex align-items-center mb-2">
                            <span>Province</span>
                        </label>
                        <input type="text" class="form-control form-control-sm" name="province" value="{{ old('province', $user->profile ? $user->profile->province : '') }}" />
                        @if ($errors->has('province'))
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('province') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="d-flex align-items-center mb-2">
                            <span >City</span>
                        </label>
                        <input type="text" class="form-control form-control-sm" name="city" value="{{ old('city', $user->profile ? $user->profile->city : '') }}" />
                        @if ($errors->has('city'))
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('city') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="d-flex align-items-center mb-2">
                            <span >Post Code</span>
                        </label>
                        <input type="number" class="form-control form-control-sm" name="post_code" value="{{ old('post_code', $user->profile ? $user->profile->post_code : '') }}" />
                        @if ($errors->has('post_code'))
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('post_code') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="d-flex align-items-center mb-2">
                            <span>Store Name</span>
                        </label>
                        <input type="text" class="form-control form-control-sm" name="store_name" value="{{ old('store_name', $user->profile ? $user->profile->store_name : '') }}" />
                        @if ($errors->has('store_name'))
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('store_name') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="formFileSm" class="form-label">Image</label>
                        <input class="form-control form-control-sm" id="formFileSm" type="file" name="image" accept=".png, .jpg, .jpeg">
                        </div>
                        @if ($errors->has('image'))
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('image') }}</div>
                        @endif
                    </div>
                    <div class="mb-3 ml-3">
                        <label class="d-flex align-items-center mb-2">
                            <span>Password</span>
                        </label>
                        <input type="password" class="form-control form-control-sm" name="password">
                        @if ($errors->has('password'))
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('password') }}</div>
                        @endif
                    </div>
                    <div class="mb-3 ml-3">
                        <label class="d-flex align-items-center mb-2">
                            <span>Password confirmation</span>
                        </label>
                        <input type="password" class="form-control form-control-sm" name="password_confirmation">
                    </div>
                    <div class="mb-5 ml-3">
                        <label class="d-flex align-items-center mb-2">
                            <span>Update Notification</span>
                        </label>
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" name="store_status"
                                @if (old('store_status', $user->profile ? $user->profile->store_status : ''))
                                    checked="checked"
                                @endif
                            />
                        </label>
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