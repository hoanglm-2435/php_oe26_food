@component('mail::layout')
@slot('header')
@component('mail::header', ['url' => route('homepage')])
    {{ trans('message.fudink') }}
@endcomponent
@endslot
    {{ $slot }}
@slot('footer')
@component('mail::footer')
    © {{ date('Y') }} {{ trans('message.fudink') }}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
