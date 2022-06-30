@extends('layouts.app', [
'headerTitle' => 'Cart',
'activePage' => 'cart',
'breadcrumbs' => [
[
'title' => 'Cart'
]
]
])

@section('content')
<div class="page-content page-cart">
    <section class="store-breadcrumbs" data-aos="fade-down" data-aos-delay="100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Cart
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="store-cart">
        <div class="container">
            <div class="row" data-aos="fade-up" data-aos-delay="100">
                <div class="col-12 table-responsive">
                    <table class="table table-borderless table-cart" aria-describedby="Cart">
                        <thead>
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Product Name &amp; Seller</th>
                                <th scope="col">Price</th>
                                <th scope="col">Menu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $totalPrice = 0;
                            @endphp
                            @foreach($carts as $cart)
                            <tr>
                                <td style="width: 25%;">
                                    @if ($cart->product->productImages)
                                    <img src="{{ $cart->product->firstImage->file->fileUrl }}" class="cart-image" />
                                    @endif
                                </td>
                                <td style="width: 35%;">
                                    <div class="product-title">{{ $cart->product->product_name }}</div>
                                    <div class="product-subtitle">by {{ $cart->product->user->profile->store_name }}
                                    </div>
                                </td>
                                <td style="width: 35%;">
                                    <div class="product-title">Rp.{{ number_format($cart->product->price) }}</div>
                                    <div class="product-subtitle">Rupiah</div>
                                </td>
                                <td style="width: 20%;">
                                    <form action="{{ route('cart-delete', $cart) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-remove-cart">
                                            Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @php
                            $totalPrice += $cart->product->price;
                            @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row" data-aos="fade-up" data-aos-delay="150">
                <div class="col-12">
                    <hr />
                </div>
                <div class="col-12">
                    <h2 class="mb-4">Shipping Details</h2>
                </div>
            </div>
            <form action="{{ route('checkout') }}" method="POST" id="locations" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="total_price" id="totalPrice" value="{{ $totalPrice }}">
                <div class="row mb-2" data-aos="fade-up" data-aos-delay="200">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" aria-describedby="emailHelp"
                                name="address" value="Setra Duta Cemara" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="addressTwo">Address 2</label>
                            <input type="text" class="form-control" id="address2" aria-describedby="emailHelp"
                                name="address2" value="Blok B2 No. 34" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="provices_id">Province</label>
                            <select name="provices_id" id="provices_id" class="form-control" v-if="provinces" v-model="provinces_id">
                                <option v-for="province in provinces" :value="province.id">@{{ province.name }}</option>
                            </select>
                            <select v-else class="form-control"></select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="regencies_id">City</label>
                            <select name="regencies_id" id="regencies_id" class="form-control" v-if="regencies" v-model="regencies_id">
                                <option v-for="regency in regencies" :value="regency.id">@{{ regency.name }}</option>
                            </select>
                            <select v-else class="form-control"></select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="post_code">Post Code</label>
                            <input type="text" class="form-control" id="post_code" name="post_code" value="40512" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" id="country" name="country" value="Indonesia" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number"
                                value="+62" />
                        </div>
                    </div>
                </div>
                <div class="row" data-aos="fade-up" data-aos-delay="150">
                    <div class="col-12">
                        <hr />
                    </div>
                    <div class="col-12">
                        <h2>Payment Informations</h2>
                    </div>
                </div>
                <div class="row" data-aos="fade-up" data-aos-delay="200">
                    <div class="col-4 col-md-2">
                        <div class="product-title" id="insurance_price">Rp. 0</div>
                        <div class="product-subtitle">Insurance Price</div>
                    </div>
                    <div class="col-4 col-md-2">
                        <div class="product-title" id="shipping_price">Rp. 0</div>
                        <div class="product-subtitle">Shipping Price</div>
                    </div>
                    {{-- <div class="col-4 col-md-3">
                        <div class="product-title">
                            <select class="form-select" name="promo_code" id="select_discount">
                                @foreach ($promoCodes as $promo)
                                    <option value="{{ $promo->type }}"
                                    @if (old('promo_code', $promo->type ?? null) == $promo)
                                        selected
                                    @endif
                                    >
                                    {{ $promo->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="product-subtitle">Discount</div>
                    </div> --}}
                    <div class="col-4 col-md-2">
                        <div class="product-title" id="total_price">Rp. {{ number_format($totalPrice ?? 0) }}</div>
                        <div class="product-subtitle">Total Price</div>
                    </div>
                    <div class="col-8 col-md-3">
                        <button type="submit" class="btn btn-success mt-4 px-4 btn-block">
                            Checkout Now
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </section>
</div>
@endsection

@section('javascript')
<script src="{{ asset('vendor/vue/vue.js') }}"></script>
<script src="https://unpkg.com/vue-toasted"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    var locations = new Vue({
      el: "#locations",
      mounted() {
        AOS.init();
       this.getProvincesData();
      },
      data() {
        return {
        provinces: null,
        regencies: null,
        provinces_id: null,
        regencies_id: null,
        }
      },
      methods: {
       getProvincesData() {
        var self = this;
        axios.get('{{ url('api/provinces') }}')
            .then(function(response) {
                self.provinces = response.data;
            })
       },
       getRegenciesData() {
        var self = this;
        axios.get('{{ url('api/regencies/') }}/' + self.provinces_id)
            .then(function(response) {
                self.regencies = response.data;
            })
       },
      },
      watch: {
          provinces_id: function(val, oldVal) {
              this.regencies_id = null;
              this.getRegenciesData();
          },
      },
    });
</script>
@endsection