@extends('layouts.app', [
    'headerTitle' => 'Store Category',
    'activePage' => 'store-category',
    'breadcrumbs' => [
        [
        'title' => 'Store Category'
        ]
    ]
])

@section('content')
<div class="page-content page-categories">
    <section class="store-trend-categories">
        <div class="container">
            <div class="row">
                <div class="col-12" data-aos="fade-up">
                    <h5>All Categories</h5>
                </div>
            </div>
            <div class="row">
                @php
                    $incrementCategory = 0
                @endphp
                @foreach ($categories as $category)
                    <div class="col-6 col-md-3 col-lg-2" data-aos="fade-up" data-aos-delay="{{ $incrementCategory+= 100 }}">
                        <a href="{{ route('categories-show', $category->slug) }}" class="component-categories d-block">
                            <div class="categories-image">
                                <img src="{{ $category->fileUrl ?? asset('img/blank.png') }}" class="w-100" />
                            </div>
                            <p class="categories-text">
                                {{ $category->name }}
                            </p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="store-new-products">
        <div class="container">
            <div class="row">
                <div class="col-12" data-aos="fade-up">
                    <h5>All Products</h5>
                </div>
            </div>
            <div class="row">
                 @php
                $incrementProduct = 0
                @endphp
                @foreach ($products as $product)
                <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $incrementProduct+= 100 }}">
                    <a class="component-products d-block" href="{{ route('detail', $product->slug) }}">
                        <div class="products-thumbnail">
                            <div class="products-image"   
                            @if ((($product->firstImage->file->fileUrl)) && !empty($product->firstImage->file->fileUrl))
                            style="background-image: url({{ $product->firstImage->file->fileUrl }})"
                            @else
                            style="background-image: url({{ asset('img/blank.png') }})"
                            @endif>
                            </div>
                        </div>
                        <div class="products-text">
                            {{ $product->product_name }}
                        </div>
                        <div class="products-price">
                           Rp.{{ $product->price }}
                        </div>
                    </a>
                </div>
                @endforeach
                 {{ $products->links('components.pagination') }}
            </div>
        </div>
    </section>
</div>

</body>
@endsection