@component('mail::message')
    # {{ trans('message.mail.hello') }}, {{ $user->name }}!
    {{ trans('message.mail.title') }}
@component('mail::table')
|       #       |{{ trans('message.product_name') }}| {{ trans('message.price') }} |  {{ trans('message.quantity') }} |  {{ trans('client.total_price') }}  |
| :-----------: | :-------------------------------: | :--------------------------: | :------------------------------: | :---------------------------------: |
@foreach ($orderDetails->orderDetails as $key => $item)
|{{ $key + 1  }}|      {{ $item->productName }}     |&#36;{{ $item->productPrice }}|   {{ $item->productQuantity }}   |    &#36;{{ $item->totalPrice }}     |
@endforeach
|               |                                   |                              |{{ trans('client.grand_total') }}:| &#36;{{ $orderDetails->grandTotal }}|
@endcomponent
@component('mail::button', ['url' => route('history_order')])
    {{ trans('message.mail.check_now') }}
@endcomponent
    {{ trans('message.mail.thanks') }}
    <br>
    {{ trans('message.fudink') }}!
@endcomponent
