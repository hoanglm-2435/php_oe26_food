@extends('client.layouts.master')

@section('content')
    <div class="breadcrumb-area gray-bg">
        <div class="container">
            <div class="breadcrumb-content">
                <ul>
                    <li><a href="i{{ route('homepage') }}">{{ trans('client.home') }}</a></li>
                    <li class="active">{{ trans('client.my_acc') }}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- my account start -->
    <div class="myaccount-area pb-80 pt-100">
        <div class="container">
            <div class="row">
                <div class="ml-auto mr-auto col-lg-9">
                    <div class="checkout-wrapper">
                        <div id="faq" class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                        <span>1</span>
                                        <a data-toggle="collapse" data-parent="#faq" href="#my-account-1">
                                            {{ trans('client.your_information') }}
                                        </a>
                                    </h5>
                                </div>
                                <div id="my-account-1" class="panel-collapse collapse show">
                                    <div class="panel-body">
                                        <div class="billing-information-wrapper">
                                            <div class="account-info-wrapper text-center">
                                                <h4>{{ trans('client.your_information') }}</h4>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="entries-info">
                                                        <h6>{{ trans('message.name') }}: {{ auth()->user()->name }}</h6>
                                                        <h6>{{ trans('message.email') }}: {{ auth()->user()->email }}</h6>
                                                        <h6>{{ trans('message.address') }}: {{ auth()->user()->address }}</h6>
                                                        <h6>{{ trans('message.phone') }}: {{ auth()->user()->phone }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="billing-back-btn">
                                                <div class="billing-back">
                                                    <a href="#">
                                                        <i class="ion ion-ios-arrow-up"></i>
                                                        {{ trans('client.back') }}
                                                    </a>
                                                </div>
                                                <div class="billing-btn">
                                                    <button class="edit" data-toggle="collapse" data-parent="#faq" href="#my-account-2">
                                                        {{ trans('message.edit') }}
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
                                        <span>2</span>
                                        <a data-toggle="collapse" data-parent="#faq" href="#my-account-2">
                                            {{ trans('client.edit_my_acc') }}
                                        </a>
                                    </h5>
                                </div>
                                <div id="my-account-2" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <form action="{{ route('profile.update', auth()->user()->id) }}" method="post">
                                            @csrf
                                            @method('PATCH')
                                            <div class="billing-information-wrapper">
                                                <div class="account-info-wrapper text-center">
                                                    <h4>{{ trans('client.edit_my_acc') }}</h4>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="billing-info">
                                                            <label>{{ trans('message.name') }}</label>
                                                            <input type="text" name="name">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="billing-info">
                                                            <label>{{ trans('message.address') }}</label>
                                                            <input type="text" name="address">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="billing-info">
                                                            <label>{{ trans('message.phone') }}</label>
                                                            <input id="phone" type="text" name="phone">
                                                            <span id="message-phone"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="billing-back-btn">
                                                    <div class="billing-back">
                                                        <a href="#">
                                                            <i class="ion ion-ios-arrow-up"></i>
                                                            {{ trans('client.back') }}
                                                        </a>
                                                    </div>
                                                    <div class="billing-btn">
                                                        <button type="submit">{{ trans('message.save') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                        <span>3</span>
                                        <a data-toggle="collapse" data-parent="#faq" href="#my-account-3">
                                            {{ trans('client.change_your_password') }}
                                        </a>
                                    </h5>
                                </div>
                                <div id="my-account-3" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <form action="{{ route('profile.update', auth()->user()->id) }}" method="post">
                                            @csrf
                                            @method('PATCH')
                                            <div class="billing-information-wrapper">
                                                <div class="account-info-wrapper text-center">
                                                    <h4>{{ trans('client.change_your_password') }}</h4>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="billing-info">
                                                            <label>{{ trans('client.old_pass') }}</label>
                                                            <input id="password" type="password" name="oldPassword" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="billing-info">
                                                            <label>{{ trans('client.new_pass') }}</label>
                                                            <input id="new-password" type="password" name="newPassword" required>
                                                            <span id="message-newpass"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="billing-info">
                                                            <label>{{ trans('client.confirm_pass') }}</label>
                                                            <input id="confirm-password" type="password" name="confirmPassword" required>
                                                            <span id="message-confirm"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="billing-back-btn">
                                                    <div class="billing-back">
                                                        <a href="#">
                                                            <i class="ion ion-ios-arrow-up"></i>
                                                            {{ trans('client.back') }}
                                                        </a>
                                                    </div>
                                                    <div class="billing-btn">
                                                        <button type="submit">{{ trans('message.save') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                        <span>4</span>
                                        <a href="{{ route('favourites') }}">
                                            {{ trans('client.modify_favourites') }}
                                        </a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
