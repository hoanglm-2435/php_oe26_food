@extends('client.layouts.master')

@section('content')
    <div class="breadcrumb-area gray-bg">
        <div class="container">
            <div class="breadcrumb-content">
                <ul>
                    <li><a href="{{ route('homepage') }}">{{ trans('client.home') }}</a></li>
                    <li class="active">{{ trans('client.favourites') }} </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="cart-main-area pt-95 pb-100">
        <div class="container">
            <h2 class="page-title">{{ trans('client.your_favourites') }}</h2>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="table-content table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>{{ trans('client.image') }}</th>
                                <th>{{ trans('message.product_name') }}</th>
                                <th>{{ trans('message.price_sale') }}</th>
                                <th>{{ trans('message.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (session('favourites'))
                                @foreach (session('favourites') as $id => $details)
                                    <tr>
                                        <td class="product-thumbnail">
                                            <a href="{{ route('shopping.show', $id) }}"><img
                                                src="{{ asset(config('filepath.img_product_path') . $details['photo']) }}" height="100"
                                                alt=""></a>
                                        </td>
                                        <td class="product-name"><a
                                            href="{{ route('shopping.show', $id) }}">{{ $details['name'] }}</a></td>
                                        <td class="product-price-cart">
                                            <span>${{ $details['price'] }}</span>
                                        </td>
                                        <td class="product-remove">
                                            <div class="custom-control-inline">
                                                <button title="{{ trans('client.add_to_cart') }}"
                                                    class="btn btn-success add-to-cart"
                                                    data-value="{{ $details['price'] }}"
                                                    data-id="{{ $id }}"
                                                    type="submit">
                                                    <i class="ion-ios-cart"></i>
                                                </button>
                                                <form class="delete"
                                                    action="{{ route('favourites_destroy', $details['id']) }}"
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
                                    <a href="{{ route('clear_favourites') }}">{{ trans('client.clear_favourites') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
