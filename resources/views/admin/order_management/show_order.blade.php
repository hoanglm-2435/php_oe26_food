@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-5">
                    <h2>{{ trans('message.order_management') }}</h2>
                </div>
            </div>
        </div>

        @if (session()->get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success') }}
            </div>
        @endif

        <table class="table table-striped table-hover">
            <thead>
            <tr class="text-center">
                <td>#</td>
                <td>{{ trans('message.customer') }}</td>
                <td>{{ trans('client.payment_type') }}</td>
                <td>{{ trans('client.note') }}</td>
                <td>{{ trans('message.quantity') }}</td>
                <td>{{ trans('client.total_price') }}</td>
                <td>{{ trans('message.created_at') }}</td>
                <td>{{ trans('message.updated_at') }}</td>
                <td>{{ trans('message.status') }}</td>
                <td colspan="2">{{ trans('message.action') }}</td>
            </tr>
            </thead>
            <tbody>
            @foreach ($orders as $key => $order)
                <tr class="text-center">
                    <td>{{ $key = $key + 1 }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>
                        @if ($order->payment_type == config('payment_type.card_payment'))
                            {{ trans('message.card_payment') }}
                        @else
                            {{ trans('message.cash_payment') }}
                        @endif
                    </td>
                    <td>{{ $order->note }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ $order->total_price }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>{{ $order->updated_at }}</td>
                    <td>
                        @switch ($order->status)
                            @case (config('status.pending'))
                                <span class="badge badge-warning order-status-badge badge{{ $order->id }}">
                                    {{ trans('message.pending') }}
                                </span>
                                @break
                            @case (config('status.approved'))
                                <span class="badge badge-success order-status-badge badge{{ $order->id }}">
                                    {{ trans('message.approved') }}
                                </span>
                                @break
                            @case (config('status.delivered'))
                                <span class="badge badge-info order-status-badge badge{{ $order->id }}">
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
                    <td>
                        <div class="custom-control-inline">
                            @if ($order->status != config('status.canceled'))
                                @if ($order->status == config('status.pending'))
                                    <button type="button" data-id="{{ $order->id }}" data-status="1"
                                        title="{{ trans('message.approve') }}"
                                        class="btn btn-sm btn-success approve-order">
                                        <i class="order-status fas fa-check-circle"></i>
                                    </button>
                                @elseif ($order->status == config('status.approved'))
                                    <button type="button" data-id="{{ $order->id }}" data-status="0"
                                        title="{{ trans('message.cancel') }}"
                                        class="btn btn-sm btn-default unapproved-order">
                                        <i class="order-status fas fa-times-circle"></i>
                                    </button>
                                @endif
                                <form class="delete" action="{{ route('orders.destroy', $order->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="clearfix">
            <div class="hint-text">
                <h6>
                    {{ trans('message.showing') }}
                    <b>
                        @if (isset($key))
                            {{ $key }}
                        @else
                            {{ config('numbers.zero') }}
                        @endif
                    </b>
                    {{ trans('message.out_of') }}
                    <b>
                        @if (isset($order))
                            {{ $order->count() }}
                        @else
                            {{ config('numbers.zero') }}
                        @endif
                    </b>
                    {{ trans('message.entries') }}
                </h6>
            </div>
            <ul class="pagination">
                {{ $orders->render() }}
            </ul>
        </div>
    </div>
@endsection
