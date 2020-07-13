@extends('client.layouts.master')

@section('content')
    <div class="breadcrumb-area gray-bg">
        <div class="container">
            <div class="breadcrumb-content">
                <ul>
                    <li><a href="{{ route('homepage') }}">{{ trans('client.home') }}</a></li>
                    <li class="active">{{ trans('client.product_details') }} </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="product-details pt-100 pb-90">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">

                    <div class="product-details-img">
                        <img class="zoompro" src="{{ asset(config('filepath.img_product_path') . $product->images->first()->image_path) }}"
                            data-zoom-image="{{ asset(config('filepath.img_product_path') . $product->images->first()->image_path) }}" alt="zoom"/>
                        <div id="gallery" class="mt-20 product-dec-slider owl-carousel">
                            @foreach ($product->images as $image)
                            <a data-image="{{ asset(config('filepath.img_product_path') . $image->image_path) }}"
                                data-zoom-image="{{ asset(config('filepath.img_product_path') . $image->image_path) }}">
                                <img height="100" src="{{ asset(config('filepath.img_product_path') . $image->image_path) }}" alt="">
                            </a>
                            @endforeach
                        </div>
                        <span>&#45;{{ round(100 - $product->price_sale/$product->price * 100, 2) }}&#37;</span>
                    </div>

                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="product-details-content">
                        <h4><b>{{ $product->name }}</b></h4>
                        <div class="rating-review">
                            <div class="pro-dec-rating">
                                <div class="rateit" data-rateit-value="{{ $ratingAverage }}" data-rateit-readonly="true"></div>
                                <span class="small">({{ $ratingAverage }})</span>
                            </div>
                            <div class="pro-dec-review">
                                <ul>
                                    <li>{{ $countRate }} {{ trans('client.reviews') }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="product-price-wrapper">
                            <span>&#36;{{ $product->price_sale }}</span>
                            <span class="product-price-old">&#36;{{ $product->price }}</span>
                        </div>
                        @if ($product->quantity < 1)
                            <div class="in-stock">
                                <p>{{ trans('client.available') }}</b>
                                    <span><i class="fas fa-times-circle"></i> {{ trans('client.out_of_stock') }}</span>
                                </p>
                            </div>
                        @else
                            <div class="in-stock">
                                <p>{{ trans('client.available') }}
                                    <span><i class="fa fa-check"></i> {{ trans('client.in_stock') }}</span>
                                </p>
                            </div>
                            <p>{{ $product->description }}</p>
                            <div class="pro-details-cart-wrap">
                                <div class="shop-list-cart-wishlist">
                                    <button title="Add To Cart"
                                        class="btn btn-primary add-to-cart"
                                        data-value="{{ $product->price_sale }}"
                                        data-id="{{ $product->id }}"
                                        type="submit">
                                        <i class="ion-ios-cart"></i>
                                        <b>{{ trans('client.add_to_cart') }}</b>
                                    </button>
                                    <button title="Favourite"
                                        class="btn btn-danger add-to-favourites"
                                        data-id="{{ $product->id }}"
                                        type="submit">
                                        <i class="ion-md-heart"></i>
                                        {{ trans('client.like') }}
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="description-review-area pb-100">
        <div class="container">
            <div class="description-review-wrapper">
                <div class="description-review-topbar nav text-center">
                    <a class="active" data-toggle="tab" href="#des-details1">{{ trans('message.product_description') }}</a>
                    <a data-toggle="tab" href="#des-details3">{{ trans('client.reviews') }}</a>
                </div>
                <div class="tab-content description-review-bottom">
                    <div id="des-details1" class="tab-pane active">
                        <div class="product-description-wrapper">
                            <p>{{ $product->description }}</p>
                        </div>
                    </div>
                    <div id="des-details3" class="tab-pane">
                        <div class="rattings-wrapper">
                            <div class="sin-rattings">
                                @foreach($ratings as $rating)
                                <div class="star-author-all">
                                    <div class="ratting-author f-left">
                                        <div class="rateit" data-rateit-value="{{ $rating->rating }}" data-rateit-readonly="true"></div>
                                    </div>
                                    <div class="ratting-author f-right">
                                        <h3>{{ $rating->user->name }},</h3>
                                        <span>{{ $rating->created_at }}</span>
                                    </div>
                                </div>
                                <p1>{{ $rating->comment }}</p1>
                                @endforeach
                            </div>
                        </div>
                        <div class="ratting-form-wrapper">
                            <h2>{{ trans('client.add_your_reviews') }} :</h2>
                            <div class="ratting-form">
                                <div class="star-box">
                                    <h4>{{ trans('client.rating') }}:</h4>
                                    <div id="rating-star" data-id="{{ $product->id }}" class="rateit"
                                         data-rateit-readonly="false"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="rating-form-style form-submit">
                                            <textarea class="comment" name="comment"
                                                placeholder="{{ trans('client.message') }}"></textarea>
                                            <input class="rating-product" type="submit"
                                                value="{{ trans('client.add_review') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="product-area pb-95">
        <div class="container">
            <div class="product-top-bar section-border mb-25">
                <div class="section-title-wrap">
                    <h3 class="section-title section-bg-white">{{ trans('client.related_products') }}</h3>
                </div>
            </div>
            <div class="related-product-active owl-carousel product-nav">
                @foreach ($products as $productItem)
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
                            <span>&#36;{{ $productItem->price }}</span>
                            <span class="product-price-old">&#36;{{ $productItem->price_sale }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
