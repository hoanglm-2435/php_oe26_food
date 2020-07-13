@extends('client.layouts.master')

@section('content')
    <div class="breadcrumb-area gray-bg">
        <div class="container">
            <div class="breadcrumb-content">
                <ul>
                    <li><a href="{{ route('homepage') }}">{{ trans('client.home') }}</a></li>
                    <li class="active">{{ trans('client.cart') }} </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="cart-main-area pt-95 pb-100">
        <div class="container">
            <h2 class="page-title">{{ trans('client.your_cart_items') }}</h2>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="table-content table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>{{ trans('client.image') }}</th>
                                <th>{{ trans('message.product_name') }}</th>
                                <th>{{ trans('message.price') }}</th>
                                <th>{{ trans('message.quantity') }}</th>
                                <th>{{ trans('client.total_price') }}</th>
                                <th>{{ trans('message.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $total = 0 @endphp
                            @if (session('cart'))
                                @foreach (session('cart') as $id => $details)
                                @php $total += $details['price'] * $details['quantity'] @endphp
                                    <tr>
                                        <td class="product-thumbnail">
                                            <a href="{{ route('shopping.show', $id) }}"><img
                                                src="{{ asset(config('filepath.img_product_path') . $details['photo']) }}" height="100"
                                                alt="">
                                            </a>
                                        </td>
                                        <td class="product-name"><a
                                            href="{{ route('shopping.show', $id) }}">{{ $details['name'] }}</a></td>
                                        <td class="product-price-cart">
                                            <span class="amount" id="price-{{ $id }}" data-value="{{ $details['price'] }}">&#36;{{ $details['price'] }}</span></td>
                                        <td class="product-quantity">
                                            <div class="cart-plus-minus">
                                                <input type="number" name="quantity" value="{{ $details['quantity'] }}"
                                                    min="{{ config('attribute_product.quantity_min') }}"
                                                    class="form-control text-center quantity" data-id="{{ $id }}"/>
                                            </div>
                                        </td>
                                        <td class="product-subtotal" id="total-price-item-{{ $id }}">
                                            &#36;{{ $details['price'] * $details['quantity'] }}
                                        </td>
                                        <td class="product-remove">
                                            <div class="custom-control-inline">
                                                <form class="delete"
                                                    action="{{ route('cart.destroy', $details['id']) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button title="{{ trans('message.delete') }}" class="btn btn-danger" type="submit">
                                                        <i class="ion-ios-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @php session()->put('totalPrice', $total) @endphp
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="cart-shiping-update-wrapper">
                                <div class="cart-shiping-update">
                                    <a href="{{ route('shopping.index') }}">{{ trans('client.continue_shopping') }}</a>
                                </div>
                                <div class="cart-clear">
                                    <a href="{{ route('clear_cart') }}">{{ trans('client.clear_cart') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (session('cart'))
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="grand-totall">
                                    <div class="title-wrap">
                                        <h4 class="cart-bottom-title section-bg-gary-cart">{{ trans('client.cart_total') }}</h4>
                                    </div>
                                    <h5>
                                        {{ trans('client.total_products') }}
                                        <span>
                                            @if (session('cart'))
                                                {{ count(session('cart')) }}
                                            @endif
                                        </span>
                                    </h5>
                                    <h4 class="grand-totall-title">{{ trans('client.grand_total') }}
                                        <span id="grand-total" data-value="{{ $total }}">&#36;{{ $total }}</span></h4>
                                    <a href="{{ route('checkout.index') }}">{{ trans('client.proceed_to_checkout') }}</a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
