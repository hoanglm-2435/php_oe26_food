<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ trans('message.fudink') }}</title>
    <meta name="description" content="">
    <meta name="robots" content="noindex, follow"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset(config('filepath.logo-web')) }}">

    <!-- all css here -->
    <link rel="stylesheet" href="{{ asset('bower_components/style-template/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/style-template/css/chosen.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/style-template/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/style-template/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/style-template/css/meanmenu.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/style-template/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/style-template/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/style-template/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/style-template/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/ionicons/docs/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/sweetalert/docs/assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/toastr/toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/jquery.rateit/scripts/rateit.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/elevatezoom/jquery-1.8.3.min.js') }}">
    <script src="{{ asset('bower_components/style-template/js/modernizr-2.8.3.min.js') }}"></script>
</head>
<body>
<!-- header start -->
<header class="header-area">
    <div class="header-top black-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-12 col-sm-4">
                    <div class="welcome-area">
                        @if (Auth::check())
                            <p>{{ trans('client.welcome') }} <b>{{ auth()->user()->name }}!</b></p>
                        @endif
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-12 col-sm-8">
                    <div class="account-curr-lang-wrap f-right">
                        <ul>
                            <li class="top-hover">
                                <a href="#">
                                    {{ trans('client.language') }}
                                    <i class="ion-md-arrow-round-down"></i>
                                </a>
                                <ul>
                                    <li><a href="{{ route('lang',['lang' => 'en']) }}">{{ trans('message.en') }}</a>
                                    </li>
                                    <li><a href="{{ route('lang',['lang' => 'vi']) }}">{{ trans('message.vn') }}</a>
                                    </li>
                                </ul>
                            </li>
                            @if (Auth::check())
                                <li class="top-hover">
                                    <a href="#">
                                        {{ trans('client.setting') }}
                                        <i class="ion-md-arrow-round-down"></i>
                                    </a>
                                    <ul>
                                        <li><a href="{{ route('profile.index') }}">{{ trans('client.my_acc') }}</a></li>
                                        <li><a href="{{ route('history_order') }}">{{ trans('client.history_order') }}</a></li>
                                    </ul>
                                </li>
                                <li class="top-hover">
                                    <a href="#"
                                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        {{ trans('message.logout') }}
                                        <i class="icon-logout"></i>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-middle">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-12 col-sm-4">
                    <div class="logo">
                        <a href="{{ route('homepage') }}">
                            <img class="img-sm" alt="" src="{{ asset(config('filepath.logo-fudink')) }}">
                        </a>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 col-12 col-sm-8">
                    <div class="header-middle-right f-right">
                        <div class="header-login">
                            @if (!Auth::check())
                                <a href="{{ route('login') }}">
                                    <div class="header-icon-style">
                                        <i class="icon-user icons"></i>
                                    </div>
                                    <div class="login-text-content">
                                        <p>{{ trans('message.register') }} <br>
                                            <span>{{ trans('message.login') }} </span></p>
                                    </div>
                                </a>
                            @endif
                        </div>
                        <div class="header-wishlist">
                            <a href="{{ route('favourites') }}">
                                <div class="header-icon-style">
                                    <i class="icon-heart icons"></i>
                                    <span id="count-favourites" class="count-style">
                                        @if (session('favourites'))
                                            {{ count(session('favourites')) }}
                                        @else
                                            {{ config('numbers.zero') }}
                                        @endif
                                    </span>
                                </div>
                                <div class="wishlist-text">
                                    <p><span>{{ trans('client.favourites') }}</span> <br>{{ trans('client.your') }}</p>
                                </div>
                            </a>
                        </div>
                        <div class="header-cart">
                            <a href="{{ route('cart.index') }}">
                                <div class="header-icon-style">
                                    <i class="icon-handbag icons"></i>
                                    <span id="count-cart" class="count-style">
                                        @if (session('cart'))
                                            {{ count(session('cart')) }}
                                        @else
                                            {{ config('numbers.zero') }}
                                        @endif
                                    </span>
                                </div>
                                <div class="cart-text">
                                    <span class="digit">{{ trans('client.cart') }}</span>
                                    <span class="cart-digit-bold total-price">
                                        @if (session('cart'))
                                            &#36;{{ session('total_price') }}
                                        @else
                                            &#36;{{ config('numbers.zero') }}
                                        @endif
                                    </span>
                                </div>
                            </a>
                            @if(session('cart'))
                                <div class="shopping-cart-content">
                                    <ul>
                                        <?php $limit = 0 ?>
                                        @foreach(session('cart') as $id => $details)
                                            @if ($limit < 3)
                                                <li class="single-shopping-cart">
                                                    <div class="shopping-cart-img">
                                                        <a href="{{ route('cart.show', $id) }}"><img
                                                            src="{{ asset(config('filepath.img_product_path') . $details['photo']) }}"
                                                            height="100"
                                                            alt="">
                                                        </a>
                                                    </div>
                                                    <div class="shopping-cart-title">
                                                        <h4>
                                                            <a href="{{ route('cart.show', $id) }}">{{ $details['name'] }}</a>
                                                        </h4>
                                                        <h6>{{ trans('message.quantity') }}
                                                            : {{ $details['quantity'] }}</h6>
                                                        <h6>{{ trans('message.price_sale') }}:
                                                            <span>&#36;{{ $details['price'] }}</span></h6>
                                                    </div>
                                                    <div class="shopping-cart-delete">
                                                        <form class="delete"
                                                            action="{{ route('cart.destroy', $details['id']) }}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button title="{{ trans('message.delete') }}"
                                                                class="btn btn-danger" type="submit">
                                                                <i class="ion ion-ios-close"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </li>
                                            @endif
                                            <?php $limit++ ?>
                                        @endforeach
                                    </ul>
                                    <div class="shopping-cart-total">
                                        <h4>{{ trans('client.total_price') }} :
                                            <span class="shop-total total-price">&#36;{{ session('total_price') }}
                                            </span>
                                        </h4>
                                    </div>
                                    <div class="shopping-cart-btn">
                                        <a href="{{ route('cart.index') }}">{{ trans('client.cart') }}</a>
                                        <a href="{{ route('checkout.index') }}">{{ trans('client.checkout') }}</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-boTom transparent-bar black-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="main-menu">
                        <nav>
                            <ul>
                                <li><a href="{{ route('homepage') }}"><b>{{ trans('client.home') }}</b></a></li>
                                <li><a href="{{ route('shopping.index') }}"><b>{{ trans('client.shop') }}</b></a></li>
                                <li><a href="{{ route('cart.index') }}"><b>{{ trans('client.cart') }}</b></a>
                                <li><a href="{{ route('checkout.index') }}"><b>{{ trans('client.checkout') }}</b></a>
                                <li><a href="{{ route('contact_us') }}"><b>{{ trans('client.contact') }}</b></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
@yield('content')
<div class="footer-area black-bg-2 pt-70">
    <div class="footer-top-area pb-18">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="footer-about mb-40">
                        <div class="footer-logo">
                            <a href="{{ route('homepage') }}">
                                <img src="{{ asset(config('filepath.footer-logo')) }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="footer-widget mb-40">
                        <div class="footer-title mb-22">
                            <h4><b>{{ trans('client.information') }}</b></h4>
                        </div>
                        <div class="footer-content">
                            <ul>
                                <li><a href="#">{{ trans('client.about_us') }}</a></li>
                                <li><a href="#">{{ trans('client.delivery_infor') }}</a></li>
                                <li><a href="#">{{ trans('client.privacy_policy') }}</a></li>
                                <li><a href="#">{{ trans('client.term_condition') }}</a></li>
                                <li><a href="#">{{ trans('client.customer_service') }}</a></li>
                                <li><a href="#">{{ trans('client.return_policy') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="footer-widget mb-40">
                        <div class="footer-title mb-22">
                            <h4><b>{{ trans('client.my_acc') }}</b></h4>
                        </div>
                        <div class="footer-content">
                            <ul>
                                <li><a href="#">{{ trans('client.cart') }}</a></li>
                                <li><a href="#">{{ trans('client.favourites') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="footer-widget mb-40">
                        <div class="footer-title mb-22">
                            <h4><b>{{ trans('client.get_in_touch') }}</b></h4>
                        </div>
                        <div class="footer-contact">
                            <ul>
                                <li>{{ trans('message.address') }}: {{ config('footer.address') }}</li>
                                <li>{{ trans('message.phone') }}: {{ config('footer.phone') }}</li>
                                <li>{{ trans('message.email') }}: {{ config('footer.email') }}</li>
                            </ul>
                        </div>
                        <div class="mt-35 footer-title mb-22">
                            <h4><b>{{ trans('client.get_in_touch') }}</b></h4>
                        </div>
                        <div class="footer-time">
                            <ul>
                                <li>{{ trans('client.open') }}: <span>{{ config('footer.open_time') }}</span>
                                    - {{ trans('client.close') }}: <span>{{ config('footer.close_time') }}</span></li>
                                <li>{{ config('footer.open_day') }}: <span>{{ trans('client.close') }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- all js here -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('bower_components/style-template/js/popper.js') }}"></script>
<script src="{{ asset('bower_components/style-template/js/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('bower_components/style-template/js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('bower_components/style-template/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('bower_components/style-template/js/plugins.js') }}"></script>
<script src="{{ asset('bower_components/elevatezoom/jquery.elevateZoom-2.2.3.min.js') }}"></script>
<script src="{{ asset('bower_components/style-template/js/main.js') }}"></script>
<script src="{{ asset('bower_components/sweetalert/docs/assets/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('bower_components/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('bower_components/jquery.rateit/scripts/jquery.rateit.min.js') }}"></script>
<script src="{{ mix('js/confirm_delete.js') }}"></script>
<script>
    function messageSuccess($message) {
        toastr.success($message, 'Notification', {timeOut: 5000});
    }
    function messageError($message) {
        toastr.error($message, 'Notification', {timeOut: 5000});
    }
</script>
@if (session('result'))
    <script type="text/javascript">
        messageSuccess('{{ session('result') }}');
    </script>
@endif

@if (session('error'))
    <script type="text/javascript">
        messageError('{{ session('error') }}');
    </script>
@endif
</body>
</html>
