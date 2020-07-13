@extends('client.layouts.master')

@section('content')
    <div class="breadcrumb-area gray-bg">
        <div class="container">
            <div class="breadcrumb-content">
                <ul>
                    <li><a href="{{ route('homepage') }}">{{ trans('client.home') }}</a></li>
                    <li class="active">{{ trans('client.contact') }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="contact-area pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="contact-info-wrapper text-center mb-30">
                        <div class="contact-info-icon">
                            <i class="fas fa-street-view"></i>
                        </div>
                        <div class="contact-info-content">
                            <h4>{{ trans('client.our_location') }}</h4>
                            <p>{{ config('footer.address') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="contact-info-wrapper text-center mb-30">
                        <div class="contact-info-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-info-content">
                            <h4>{{ trans('client.contact_us_anytime') }}</h4>
                            <p>{{ trans('message.phone') }}: {{ config('footer.phone') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="contact-info-wrapper text-center mb-30">
                        <div class="contact-info-icon">
                            <i class="far fa-envelope"></i>
                        </div>
                        <div class="contact-info-content">
                            <h4>{{ trans('client.send_email_for_us') }}</h4>
                            <p><a href="#">{{ config('footer.email') }}</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="contact-message-wrapper">
                        <h4 class="contact-title">{{ trans('client.if_you_have_suggestions') }}</h4>
                        <div class="contact-message">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="contact-form-style">
                                        <textarea name="suggest" class="suggest" placeholder="{{ trans('client.suggest') }}"></textarea>
                                        <button class="submit btn-style send-suggest" type="submit">
                                            {{ trans('client.send_suggest') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
