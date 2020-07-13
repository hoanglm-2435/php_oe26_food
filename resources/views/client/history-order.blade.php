@extends('client.layouts.master')

@section('content')
    <div class="breadcrumb-area gray-bg">
        <div class="container">
            <div class="breadcrumb-content">
                <ul>
                    <li><a href="{{ route('homepage') }}">{{ trans('client.home') }}</a></li>
                    <li class="active">{{ trans('client.history_order') }} </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="cart-main-area pt-95 pb-100">
        <div class="container">
            <h2 class="page-title">{{ trans('client.history_order') }}</h2>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="table-content table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>{{ trans('client.code_order') }}</th>
                                <th>{{ trans('client.order_invoiced_date') }}</th>
                                <th>{{ trans('client.payment_type') }}</th>
                                <th>{{ trans('client.status') }}</th>
                                <th>{{ trans('message.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $id => $order)
                                    <tr>
                                        <td class="product-thumbnail">
                                            {{ $order->id }}
                                        </td>
                                        <td class="product-name">{{ $order->created_at }}</td>
                                        <td class="product-price-cart">
                                            {{ trans('message.' . config('payment_type.' . $order->payment_type )) }}
                                        </td>
                                        <td class="product-name">
                                            @switch ($order->status)
                                                @case (config('status.pending'))
                                                    <span class="badge badge-warning order-status-badge badge{{ $order->id }}">
                                                        {{ trans('message.pending') }}
                                                    </span>
                                                @break
                                                @case (config('status.approved'))
                                                    <span class="badge badge-success order-status-badge badge{{ $order->id }}">
                                                        {{ trans('message.delivered') }}
                                                    </span>
                                                @break
                                                @case (config('status.canceled'))
                                                    <span class="badge badge-secondary order-status-badge badge{{ $order->id }}">
                                                        {{ trans('message.canceled') }}
                                                    </span>
                                                @break
                                            @endswitch
                                        </td>
                                        <td class="product-remove">
                                            @if ($order->status != config('status.canceled'))
                                                @if ($order->status == config('status.pending'))
                                                    <button type="button" data-id="{{ $order->id }}" data-status="3"
                                                            title="{{ trans('message.cancel') }}"
                                                            class="btn btn-sm btn-default cancel-order">
                                                        <i class="order-status fas fa-times-circle"></i>
                                                    </button>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-total-pages">
                            <div class="pagination-style">
                                {{ $orders->render('paginations', compact(['paginator' => 'orders'])) }}
                            </div>
                            <div class="total-pages">
                                <p>
                                    {{ trans('message.showing') }}
                                    <b>
                                        @if (isset($id))
                                            {{ $id + 1 }}
                                        @else
                                            {{ config('numbers.zero') }}
                                        @endif
                                    </b>
                                    {{ trans('message.out_of') }}
                                    <b>
                                        @if (isset($orders))
                                            {{ $orders->count() }}
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
            </div>
        </div>
    </div>
@endsection
