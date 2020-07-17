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
                                            @if ($order->payment_type == config('payment_type.card_payment'))
                                                {{ trans('message.card_payment') }}
                                            @else
                                                {{ trans('message.cash_payment') }}
                                            @endif
                                        </td>
                                        <td class="product-name">
                                            @switch ($order->status)
                                                @case (config('status.pending'))
                                                    <span class="badge badge-warning order-status-badge
                                                        badge{{ $order->id }}">
                                                        {{ trans('message.pending') }}
                                                    </span>
                                                @break
                                                @case (config('status.approved'))
                                                    <span class="badge badge-success order-status-badge
                                                        badge{{ $order->id }}">
                                                        {{ trans('message.delivered') }}
                                                    </span>
                                                @break
                                                @case (config('status.canceled'))
                                                    <span class="badge badge-secondary order-status-badge
                                                        badge{{ $order->id }}">
                                                        {{ trans('message.canceled') }}
                                                    </span>
                                                @break
                                            @endswitch
                                        </td>
                                        <td class="product-remove">
                                            <button title="Quick View" data-toggle="modal"
                                                class="btn btn-sm btn-default order-infor"
                                                data-id="{{ $order->id }}"
                                                data-target="#exampleModal" href="#">
                                                <i class="ion ion-md-eye"></i>
                                            </button>
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
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>{{ trans('client.order_details') }}</h2>
                    <button type="button" class="close"
                        data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="order-review-wrapper">
                        <div class="order-review">
                            <div class="table-responsive">
                                <table id="details-table" class="table">
                                    <thead>
                                    <tr>
                                        <th class="width-1">
                                            {{ trans('message.product_name') }}
                                        </th>
                                        <th class="width-2">
                                            {{ trans('message.price') }}
                                        </th>
                                        <th class="width-3">
                                            {{ trans('message.quantity') }}
                                        </th>
                                        <th class="width-4">
                                            {{ trans('client.total_price') }}
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="3">{{ trans('client.grand_total') }}</td>
                                        <td colspan="1" class="grand-total"></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
