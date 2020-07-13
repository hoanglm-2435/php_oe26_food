@extends('client.layouts.master')

@section('content')
    <div class="breadcrumb-area gray-bg">
        <div class="container">
            <div class="breadcrumb-content">
                <ul>
                    <li><a href="{{ route('homepage') }}">{{ trans('client.home') }}</a></li>
                    <li class="active"> {{ trans('client.checkout') }}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- checkout-area start -->
    <div class="checkout-area pb-80 pt-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="checkout-wrapper">
                        <div id="faq" class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                        <span>1.</span>
                                        <a data-toggle="collapse"
                                            data-parent="#faq"
                                            href="#payment-1">
                                            {{ trans('client.checkout_method') }}
                                        </a>
                                    </h5>
                                </div>
                                <div id="payment-1" class="panel-collapse collapse show">
                                    <div class="panel-body">
                                        <div class="row">
                                            @if (!Auth::check())
                                                <div class="col-lg-5">
                                                    <div class="checkout-register">
                                                        <h6>{{ trans('client.login_to_pay') }}</h6><br>
                                                        <h6>{{ trans('client.register_and_save_time') }}</h6><br>
                                                        <a href="{{ route('register') }}">{{ trans('client.register_now') }}</a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="checkout-login">
                                                        <div class="title-wrap">
                                                            <h4 class="cart-bottom-title section-bg-white">{{ trans('message.login') }}</h4>
                                                        </div>
                                                        <p>{{ trans('client.have_acc') }} </p>
                                                        <div class="checkout-login-btn">
                                                            <a href="{{ route('login') }}">{{ trans('client.login_now') }}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-12">
                                                    <h5 class="text-center">
                                                        {{ trans('client.complete_payment') }}
                                                    </h5>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="billing-back-btn">
                                            <div class="billing-back">
                                                <a href="#">
                                                    <i class="ion ion-ios-arrow-up"></i>
                                                    {{ trans('client.back') }}
                                                </a>
                                            </div>
                                            <div class="billing-btn">
                                                <button type="submit" data-toggle="collapse"
                                                    data-parent="#faq"
                                                    href="#payment-2">
                                                    {{ trans('client.next') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (Auth::check())
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5 class="panel-title">
                                            <span>2.</span>
                                            <a data-toggle="collapse"
                                                data-parent="#faq"
                                                href="#payment-2">
                                                {{ trans('client.customer_info') }}
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="payment-2" class="panel-collapse collapse ">
                                        <div class="panel-body">
                                            <div class="shipping-information-wrapper">
                                                <div class="shipping-info-2">
                                                    <span>{{ trans('message.name') }}: {{ auth()->user()->name }}</span>
                                                    <span>{{ trans('message.address') }}: {{ auth()->user()->address }}</span>
                                                    <span>{{ trans('message.phone') }}: {{ auth()->user()->phone }}</span>
                                                </div>
                                                <div class="edit-address">
                                                    <h5>{{ trans('client.message_to_us') }}</h5>
                                                    <textarea placeholder="{{ trans('client.message') }}" name="note" class="form-control note" value=""></textarea>
                                                </div>
                                                <div class="billing-back-btn">
                                                    <div class="billing-back">
                                                        <a href="#">
                                                            <i class="ion ion-ios-arrow-up"></i>
                                                            {{ trans('client.back') }}
                                                        </a>
                                                    </div>
                                                    <div class="billing-btn">
                                                        <button type="submit" data-toggle="collapse"
                                                            data-parent="#faq"
                                                            href="#payment-3">
                                                            {{ trans('client.next') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5 class="panel-title">
                                            <span>3.</span>
                                            <a data-toggle="collapse"
                                                data-parent="#faq"
                                                href="#payment-3">
                                                {{ trans('client.payment_method') }}
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="payment-3" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="payment-info-wrapper">
                                                <div class="ship-wrapper">
                                                    <div class="single-ship">
                                                        <input type="radio" name="payment_type" checked
                                                            value="1">
                                                        <label>{{ trans('client.cash_payment') }} </label>
                                                    </div>
                                                    <div class="single-ship">
                                                        <input type="radio" name="payment_type" value="2">
                                                        <label>{{ trans('client.credit_cart') }} </label>
                                                    </div>
                                                    <div class="billing-back-btn">
                                                        <div class="billing-back">
                                                            <a href="#">
                                                                <i class="ion ion-ios-arrow-up"></i>
                                                                {{ trans('client.back') }}
                                                            </a>
                                                        </div>
                                                        <div class="billing-btn">
                                                            <button type="submit" data-toggle="collapse"
                                                                data-parent="#faq"
                                                                href="#payment-4">
                                                                {{ trans('client.next') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5 class="panel-title">
                                            <span>4.</span>
                                            <a data-toggle="collapse"
                                                data-parent="#faq"
                                                href="#payment-4">
                                                {{ trans('client.order_review') }}
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="payment-4" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="order-review-wrapper">
                                                <div class="order-review">
                                                    <div class="table-responsive">
                                                        @if (session('cart'))
                                                            <table class="table">
                                                                <thead>
                                                                <tr>
                                                                    <th class="width-1">{{ trans('message.product_name') }}</th>
                                                                    <th class="width-2">{{ trans('message.price') }}</th>
                                                                    <th class="width-3">{{ trans('message.quantity') }}</th>
                                                                    <th class="width-4">{{ trans('client.grand_total') }}</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach (session('cart') as $cartItem)
                                                                    <tr>
                                                                        <td>
                                                                            <div class="o-pro-dec">
                                                                                <p>{{ $cartItem['name'] }}</p>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="o-pro-price">
                                                                                <p>&#36;{{ $cartItem['price'] }}</p>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="o-pro-qty">
                                                                                <p>{{ $cartItem['quantity'] }}</p>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="o-pro-subtotal">
                                                                                <p>
                                                                                    &#36;{{ $cartItem['quantity'] * $cartItem['price'] }}
                                                                                </p>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                                <tfoot>
                                                                <tr>
                                                                    <td colspan="3">{{ trans('client.total_products') }}</td>
                                                                    <td colspan="1"
                                                                        class="quantity">{{ count(session('cart')) }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="3">{{ trans('client.grand_total') }}</td>
                                                                    <td colspan="1" class="grand-total">
                                                                        &#36;{{ session('totalPrice') }}
                                                                    </td>
                                                                </tr>
                                                                </tfoot>
                                                            </table>
                                                        @else
                                                            <div class="col-12">
                                                                <h5 class="text-center">
                                                                    {{ trans('client.please_add_to_cart') }}
                                                                </h5>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="billing-back-btn">
                                                        <span>
                                                            {{ trans('client.forgot_item') }}
                                                            <a href="{{ route('cart.index') }}"> {{ trans('client.edit_cart') }}</a>
                                                        </span>
                                                        <div class="billing-btn">
                                                            <button type="submit" class="payment">{{ trans('client.checkout') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="checkout-progress">
                        <h4>{{ trans('client.checkout_progress') }}</h4>
                        <ul>
                            <li>{{ trans('client.checkout_method') }}</li>
                            <li>{{ trans('client.customer_info') }}</li>
                            <li>{{ trans('client.payment_method') }}</li>
                            <li>{{ trans('client.order_review') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
