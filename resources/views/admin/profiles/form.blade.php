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
                    <div class="">
                        <a href="{{ route('admin-profile', $user) }}" class="btn btn-light btn-sm mb-3">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-sm pull-right mb-3 mr-3">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>