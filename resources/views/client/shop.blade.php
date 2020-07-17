@extends('client.layouts.master')

@section('content')
    <div class="breadcrumb-area gray-bg">
        <div class="container">
            <div class="breadcrumb-content">
                <ul>
                    <li><a href="{{ route('homepage') }}">{{ trans('client.home') }}</a></li>
                    <li class="active">{{ trans('client.shop') }} </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="shop-page-area pt-100 pb-100">
        <div class="container">
            <div class="row flex-row-reverse">
                <div class="col-lg-9">
                    <div class="banner-area pb-30">
                        <a href="#"><img alt="" src="{{ asset(config('filepath.banner-6')) }}"></a>
                    </div>
                    <div class="shop-topbar-wrapper">
                        <div class="shop-topbar-left">
                            <ul class="view-mode">
                                <li class="active">
                                    <a href="#" data-view="product-grid">
                                        <i class="fa fa-th"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="product-sorting-wrapper">
                            <form id="form-sort" method="get">
                                <div class="product-show shorting-style">
                                    <label>
                                        <b><i class="fas fa-sort"></i> {{ trans('client.sort_by') }}:</b>
                                    </label>
                                    <label>
                                        <select class="sort-by" name="sortBy">
                                            <option value="default"
                                                {{ Request::get('sortBy') == 'default'
                                                    || !Request::get('sortBy') ? "selected='selected'" : "" }}
                                            >{{ trans('client.default') }}</option>
                                            <option value="desc"
                                                {{ Request::get('sortBy') == 'desc' ? "selected='selected'" : "" }}
                                            >{{ trans('client.lasted') }}</option>
                                            <option value="asc"
                                                {{ Request::get('sortBy') == 'asc' ? "selected='selected'" : "" }}
                                            >{{ trans('client.old_products') }}</option>
                                            <option value="price_asc"
                                                {{ Request::get('sortBy') == 'price_asc' ? "selected='selected'" : "" }}
                                            >{{ trans('client.price_increase') }}</option>
                                            <option value="price_desc"
                                                {{ Request::get('sortBy') == 'price_desc' ? "selected='selected'" : "" }}
                                            >{{ trans('client.price_descending') }}</option>
                                            <option value="rating_desc"
                                                {{ Request::get('sortBy') == 'rating_desc' ? "selected='selected'" : "" }}
                                            >{{ trans('client.rating_desc') }}</option>
                                        </select>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="grid-list-product-wrapper">
                        <div class="product-grid product-view pb-20">
                            <div class="row">
                                @foreach ($products as $key => $product)
                                    <div class="product-width col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-30">
                                        <div class="product-wrapper">
                                            <div class="product-img">
                                                <a href="{{ route('shopping.show', $product->id) }}">
                                                    <img
                                                        src="{{ asset(config('filepath.img_product_path')
                                                            . $product->images->first()->image_path) }}"
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
                                                    <a href="{{ route('shopping.show', $product->id) }}">
                                                        {{ $product->name }}
                                                    </a>
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
                        <div class="pagination-total-pages">
                            <div class="pagination-style">
                                {{ $products->render('paginations', compact(['paginator' => 'products'])) }}
                            </div>
                            <div class="total-pages">
                                <p>
                                    {{ trans('message.showing') }}
                                    <b>
                                        @if (isset($key))
                                            {{ $key + 1 }}
                                        @else
                                            {{ config('numbers.zero') }}
                                        @endif
                                    </b>
                                    {{ trans('message.out_of') }}
                                    <b>
                                        @if (isset($product))
                                            {{ $product->count() }}
                                        @else
                                            {{ config('numbers.zero') }}
                                        @endif
                                    </b>
                                    {{ trans('message.entries') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="shop-sidebar-wrapper gray-bg-7 shop-sidebar-mrg">
                        <form id="form-filter" method="get">
                            <div class="shop-widget">
                                <h4 class="shop-sidebar-title">
                                    <i class="fas fa-sort"></i> {{ trans('client.shop_by_categories') }}
                                </h4>
                                <div class="shop-catigory">
                                    <ul id="faq">
                                        @foreach ($categories as $cate)
                                            <li>
                                                <a href="?filterBy={{ $cate->name }}">
                                                    <span class="{{ Request::get('filterBy') == $cate->name ? "active" : "" }}">
                                                        {{ $cate->name }}
                                                    </span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="shop-widget mt-40 shop-sidebar-border pt-35">
                                <h4 class="shop-sidebar-title">
                                    <i class="fas fa-sort"></i> {{ trans('client.by_size') }}
                                </h4>
                                <div class="shop-tags mt-25">
                                    <ul>
                                        @foreach ($sizes as $size)
                                            <li>
                                                <a class="{{ Request::get('filterBy') == $size->size ? "active" : "" }}"
                                                    href="?filterBy={{ $size->size }}">
                                                    {{ trans('client.size') }} {{ $size->size }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
