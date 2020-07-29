@component('mail::message')
    # {{ trans('message.mail.hello') }}, {{ $user->name }}!
    {{ trans('message.mail.promotions_content') }}
@component('mail::button', ['url' => route('homepage')])
    {{ trans('message.mail.shop_now') }}
@endcomponent
    {{ trans('message.mail.thanks') }}
    <br>
    {{ trans('message.fudink') }}!
@endcomponent
