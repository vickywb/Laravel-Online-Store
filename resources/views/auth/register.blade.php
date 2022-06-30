@extends('layouts.auth')

@section('content')

<div class="page-content page-auth mt-5" id="register">
    <div class="section-store-auth" data-aos="fade-up">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <h2>
                        Memulai untuk jual beli <br />
                        dengan cara terbaru
                    </h2>
                    <form class="mt-3" method="POST" action="{{ route('register-user-store') }}">
                        @csrf
                        <div class="form-group">
                            <label class="required">Full Name</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                v-model="name">

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="required">Email</label>
                            <input id="email" @change="checkEmailAvailable()" type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                :class="{ 'is-invalid' : this.email_unavailable }" value="{{ old('email') }}" required
                                autocomplete="email" v-model="email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" required autocomplete="new-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="required">Password Confirm</label>
                            <input type="password"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                name="password_confirmation" required autocomplete="password_confirmation">

                            @error('password_confirm')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="required">Store</label>
                            <p class="text-muted">
                                Apakah anda juga ingin membuka toko?
                            </p>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input class="custom-control-input" type="radio" name="is_store_open" id="openStoreTrue"
                                    v-model="is_store_open" value="true" />
                                <label class="custom-control-label" for="openStoreTrue">Iya, boleh</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input class="custom-control-input" type="radio" name="is_store_open"
                                    id="openStoreFalse" v-model="is_store_open" value="false" />
                                <label class="custom-control-label" for="openStoreFalse">Enggak, makasih</label>
                            </div>
                        </div>
                        <div class="form-group" v-if="is_store_open">
                            <label>Nama Toko</label>
                            <input type="text" v-model="store_name" id="store_name" name="store_name"
                                class="form-control @error('store_name') is-invalid @enderror" autocomplete="store_name"
                                autofocus aria-describedby="storeHelp" />

                            @error('store_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group" v-if="is_store_open">
                            <label>Category</label>
                            <select class="form-control" aria-label="Default select example"
                                data-placeholder="Select an option" name="category_id">
                                <option></option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    >{{ $category->name }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('category_id'))
                            <div class="fv-plugins-message-container invalid-feedback">{{ $errors->first('category_id')
                                }}</div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-success btn-block mt-4" :disabled="this.email_unavailabe">
                            Sign Up Now
                        </button>
                        <a href="{{ route('login') }}" type="submit" class="btn btn-signup btn-block mt-2">
                            Back to Sign In
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('addon-script')
<script src="{{ asset('vendor/vue/vue.js') }}"></script>
<script src="https://unpkg.com/vue-toasted"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    Vue.use(Toasted);

    var register = new Vue({
      el: "#register",
      mounted() {
        AOS.init();
        // this.$toasted.error(
        //   "Maaf, tampaknya email sudah terdaftar pada sistem kami.",
        //   {
        //     position: "top-center",
        //     className: "rounded",
        //     duration: 1000,
        //   }
        // );
      },
      methods: {
        checkEmailAvailable: function() {
            var self = this;
            axios.get('{{ route('user-check') }}', {
                params: {
                    email: this.email
                }
            })
                .then(function  (response){
                    //handle success
                    if (response.data == 'Available') {
                        self.$toasted.show(
                            "Your email is Available to use.",
                            {
                                position: "top-center",
                                className: "rounded",
                                duration: 1000,
                            }
                        );

                        self.email_unavailable = false;

                    }else {
                        self.$toasted.error(
                            "Sorry, Your email has been taken.",
                            {
                                position: "top-center",
                                className: "rounded",
                                duration: 1000,
                            }
                        );

                        self.email_unavailable = true;
                    }

                    console.log(response);
                });
            }
      },
      data() {
        return {
        name: "Test",
        email: "test@gmail.com",
        is_store_open: true,
        store_name: "",
        email_unavailable: false
        }
      },
    });
</script>
@endpush