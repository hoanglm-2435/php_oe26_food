@extends('client.layouts.master')

@section('content')
    <div class="slider-area-2">
        <div class="slider-active owl-dot-style owl-carousel">
            <div class="single-slider pt-210 pb-220 bg-img"
                style="background-image:url({{ asset(config('filepath.slider-1')) }})">
                <div class="container">
                    <div class="slider-content slider-animated-2 text-center">
                        <h1 class="animated">{{ trans('client.slide_title') }}</h1>
                        <h3 class="animated">{{ trans('client.slide_description') }}</h3>
                        <div class="slider-btn mt-90">
                            <a class="animated" href="{{ route('shopping.index') }}"><b>{{ trans('client.order') }}</b></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single-slider pt-210 pb-220 bg-img"
                style="background-image:url({{ asset(config('filepath.slider-1')) }})">
                <div class="container">
                    <div class="slider-content slider-animated-2 text-center">
                        <h1 class="animated">{{ trans('client.slide_title') }}</h1>
                        <h3 class="animated">{{ trans('client.slide_description') }}</h3>
                        <div class="slider-btn mt-90">
                            <a class="animated" href="{{ route('shopping.index') }}">{{ trans('client.order') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="product-area pt-95 pb-70">
        <div class="custom-container">
            <div class="product-tab-list-wrap text-center mb-40 yellow-color">
                <div class="product-tab-list nav">
                    <a href="#tab1" data-toggle="tab" class="active">
                        <h4><b>{{ trans('client.all') }}</b></h4>
                    </a>
                    <a href="#tab2" data-toggle="tab">
                        <h4><b>{{ trans('client.food') }}</b></h4>
                    </a>
                    <a href="#tab3" data-toggle="tab">
                        <h4><b>{{ trans('client.drink') }}</b></h4>
                    </a>
                </div>
                <p class="text-lg">{{ trans('client.choose_item') }}</p>
            </div>
            <div class="tab-content jump yellow-color">
                <div id="tab1" class="tab-pane active fadeIn">
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="custom-col-5">
                                <div class="product-wrapper mb-25">
                                    <div class="product-img">
                                        <a href="{{ route('shopping.show', $product->id) }}">
                                            <img
                                                src="{{ asset(config('filepath.img_product_path') . $product->images->first()->image_path) }}"
                                                alt="">
                                        </a>
                                        <div class="product-action">
                                            <div class="pro-action-left">
                                                <button title="Add To Cart"
                                                    class="btn add-to-cart"
                                                    data-value="{{ $product->price_sale }}"
                                                    data-id="{{ $product->id }}"
                                                    type="submit">
                                                    <i class="ion-ios-cart"></i>
                                                    <b>{{ trans('client.add_to_cart') }}</b>
                                                </button>
                                            </div>
                                            <div class="pro-action-right">
                                                <button title="Favourite"
                                                    class="btn add-to-favourites"
                                                    data-id="{{ $product->id }}"
                                                    type="submit">
                                                    <i class="ion-md-heart"></i>
                                                    {{ trans('client.like') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h4>
                                            <a href="{{ route('shopping.show', $product->id) }}">{{ $product->name }} </a>
                                        </h4>
                                        <div class="product-price-wrapper">
                                            <span>&#36;{{ $product->price_sale }}</span>
                                            <span class="product-price-old">&#36;{{ $product->price }} </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div id="tab2" class="tab-pane fadeIn">
                    <div class="row">
                        @foreach ($food as $product)
                            <div class="custom-col-5">
                                <div class="product-wrapper mb-25">
                                    <div class="product-img">
                                        <a href="{{ route('shopping.show', $product->id) }}">
                                            <img
                                                src="{{ asset(config('filepath.img_product_path') . $product->images->first()->image_path) }}"
                                                alt="">
                                        </a>
                                        <div class="product-action">
                                            <div class="pro-action-left">
                                                <button title="Add To Cart"
                                                    class="btn add-to-cart"
                                                    data-id="{{ $product->id }}"
                                                    type="submit">
                                                    <i class="ion-ios-cart"></i>
                                                    <b>{{ trans('client.add_to_cart') }}</b>
                                                </button>
                                            </div>
                                            <div class="pro-action-right">
                                                <button title="Favourite"
                                                    class="btn add-to-favourites"
                                                    data-id="{{ $product->id }}"
                                                    type="submit">
                                                    <i class="ion-md-heart"></i>
                                                    {{ trans('client.like') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h4>
                                            <a href="{{ route('shopping.show', $product->id) }}">{{ $product->name }} </a>
                                        </h4>
                                        <div class="product-price-wrapper">
                                            <span>&#36;{{ $product->price_sale }}</span>
                                            <span class="product-price-old">&#36;{{ $product->price }} </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div id="tab3" class="tab-pane fadeIn">
                    <div class="row">
                        @foreach ($drink as $product)
                            <div class="custom-col-5">
                                <div class="product-wrapper mb-25">
                                    <div class="product-img">
                                        <a href="{{ route('shopping.show', $product->id) }}">
                                            <img
                                                src="{{ asset(config('filepath.img_product_path') . $product->images->first()->image_path) }}"
                                                alt="">
                                        </a>
                                        <div class="product-action">
                                            <div class="pro-action-left">
                                                <button title="Add To Cart"
                                                    class="btn add-to-cart"
                                                    data-id="{{ $product->id }}"
                                                    type="submit">
                                                    <i class="ion-ios-cart"></i>
                                                    <b>{{ trans('client.add_to_cart') }}</b>
                                                </button>
                                            </div>
                                            <div class="pro-action-right">
                                                <button title="Favourite"
                                                    class="btn add-to-favourites"
                                                    data-id="{{ $product->id }}"
                                                    type="submit">
                                                    <i class="ion-md-heart"></i>
                                                    {{ trans('client.like') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h4>
                                            <a href="{{ route('shopping.show', $product->id) }}">{{ $product->name }}</a>
                                        </h4>
                                        <div class="product-price-wrapper">
                                            <span>&#36;{{ $product->price_sale }}</span>
                                            <span class="product-price-old">&#36;{{ $product->price }} </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="banner-area row-col-decrease pb-75 clearfix">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="single-banner mb-30">
                        <div class="hover-style">
                            <a href="#"><img src="{{ asset(config('filepath.banner-1')) }}" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="single-banner mb-30">
                        <div class="hover-style">
                            <a href="#"><img src="{{ asset(config('filepath.banner-2')) }}" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="best-food-area pb-95">
        <div class="custom-container">
            <div class="row">
                <div class="best-food-width-1">
                    <div class="single-banner">
                        <div class="hover-style">
                            <a href="#"><img src="{{ asset(config('filepath.banner-3')) }}" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="best-food-width-2">
                    <div class="product-top-bar section-border mb-25 yellow-color">
                        <div class="section-title-wrap">
                            <h3 class="section-title section-bg-white">{{ trans('client.best_fd_in_our_shop') }}</h3>
                        </div>
                    </div>
                    <div class="tab-content jump yellow-color">
                        <div id="tab4" class="tab-pane active">
                            <div class="product-slider-active owl-carousel product-nav">
                                @foreach ($bestProducts as $productItem)
                                    <div class="product-wrapper">
                                        <div class="product-img">
                                            <a href="{{ route('shopping.show', $productItem->id) }}">
                                                <img src="{{ asset(config('filepath.img_product_path') . $productItem->images->first()->image_path) }}"
                                                     alt="">
                                            </a>
                                            <div class="product-action">
                                                <div class="pro-action-left">
                                                    <button title="Add To Cart"
                                                            class="btn add-to-cart"
                                                            data-id="{{ $productItem->id }}"
                                                            type="submit">
                                                        <i class="ion-ios-cart"></i>
                                                        <b>{{ trans('client.add_to_cart') }}</b>
                                                    </button>
                                                </div>
                                                <div class="pro-action-right">
                                                    <button title="Favourite"
                                                            class="btn add-to-favourites"
                                                            data-id="{{ $productItem->id }}"
                                                            type="submit">
                                                        <i class="ion-md-heart"></i>
                                                        {{ trans('client.like') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-content">
                                            <h4>
                                                <a href="{{ route('shopping.show', $productItem->id) }}">{{ $productItem->name }}</a>
                                            </h4>
                                            <div class="product-price-wrapper">
                                                <span>&#36;{{ $productItem->price_sale }}</span>
                                                <span class="product-price-old">&#36;{{ $productItem->price }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="best-food-width-1">
                    <div class="single-banner">
                        <div class="hover-style">
                            <a href="#"><img src="{{ asset(config('filepath.banner-4')) }}" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="banner-area">
        <div class="container">
            <div class="discount-overlay bg-img pt-130 pb-130"
                style="background-image:url({{ asset(config('filepath.banner-5')) }});">
                <div class="discount-content text-center">
                    <h3>{{ trans('client.title_banner') }} <br>{{ trans('client.description_banner') }}</h3>
                    <p>{{ trans('client.offer_banner') }}</p>
                    <div class="banner-btn">
                        <a href="{{ route('shopping.index') }}"><b>{{ trans('client.order') }}</b></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="brand-logo-area pt-100 pb-100">
        <div class="container">
            <div class="brand-logo-active owl-carousel">
                <div class="single-brand-logo">
                    <img alt="" src="{{ asset(config('filepath.brand-logo-1')) }}">
                </div>
                <div class="single-brand-logo">
                    <img alt="" src="{{ asset(config('filepath.brand-logo-2')) }}">
                </div>
                <div class="single-brand-logo">
                    <img alt="" src="{{ asset(config('filepath.brand-logo-3')) }}">
                </div>
                <div class="single-brand-logo">
                    <img alt="" src="{{ asset(config('filepath.brand-logo-4')) }}">
                </div>
                <div class="single-brand-logo">
                    <img alt="" src="{{ asset(config('filepath.brand-logo-5')) }}">
                </div>
            </div>
        </div>
    </div>
@endsection
