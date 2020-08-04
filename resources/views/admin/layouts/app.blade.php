<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ trans('message.admin') }} | {{ trans('message.dashboard') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/ionicons/docs/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/sweetalert/docs/assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/chart.js/dist/Chart.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/toastr/toastr.min.css') }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('homepage') }}" class="nav-link">{{ trans('message.home') }}</a>
            </li>
        </ul>
        <form class="form-inline ml-3">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="{{ trans('message.search') }}" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    @if (isset($notifyUnread))
                        <span class="badge badge-danger navbar-badge count-notify">
                            {{ $notifyUnread }}
                        </span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">
                        {{ trans('message.new_orders') }}
                    </span>
                    @if (isset($notifications))
                        <div id="notify">
                            @foreach ($getLimitNotify as $notification)
                                <div class="dropdown-divider"></div>
                                <div>
                                    <a href="#" class="show-order dropdown-item{{ $notification->pivot->status ? '' : ' bg-light' }}"
                                        data-toggle="modal" data-target="#notiModal"
                                        data-id="{{ $notification->id }}"
                                        data-order="{{ json_decode($notification->notification)->order_id }}">
                                        <i class="fas fa-envelope{{ $notification->pivot->status ? '-open' : ' text-danger' }} mr-2"></i>
                                        {{ trans('message.title_notify') }}
                                        {{ json_decode($notification->notification)->user }}
                                    </a>
                                    <span id="time-notify">
                                        {{ trans('message.created_at') . ' ' . $notification->created_at->translatedFormat('h:i A, d-m-Y') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-notify">
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item text-center">
                                {{ trans('message.empty_notify') }}
                            </a>
                        </div>
                    @endif
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('orders.index') }}" class="dropdown-item dropdown-footer">
                        {{ trans('message.view_orders') }}
                    </a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">{{ trans('client.language') }}</a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right text-center">
                    <a href="{{ route('lang',['lang' => 'vi']) }}" class="dropdown-item">
                        {{ trans('message.vn') }}
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('lang',['lang' => 'en' ]) }}" class="dropdown-item">
                        {{ trans('message.en') }}
                    </a>
                </div>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a class="nav-link" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    {{ trans('message.logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </nav>
    <div class="modal fade" id="notiModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>{{ trans('client.order_details') }}</h2>
                    <button type="button" class="close"
                        data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body notify-content">
                    <div class="order-review-wrapper">
                        <div class="order-review">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr class="text-center">
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
                                    <tbody id="details-table">
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
                <div class="modal-footer">
                    <a href="{{ route('orders.index') }}" class="btn btn-primary">
                        {{ trans('message.view_orders') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    <article id="notify-message" data-user="{{ Auth::id() }}" data-message="{{ trans('message.notification_alert') }}">
    </article>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ route('dashboard') }}" class="brand-link">
            <img src="{{ asset('bower_components/admin-lte/dist/img/AdminLTELogo.png') }}" alt="Admin Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">{{ trans('message.fudink') }} | {{ trans('message.admin') }}</span>
        </a>
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('bower_components/admin-lte/dist/img/avatar5.png') }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ trans('message.admin') }}</a>
                </div>
            </div>
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item has-treeview">
                        <a href="{{ route('dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>{{ trans('message.dashboard') }}</p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="{{ route('users.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>{{ trans('message.user') }}</p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="{{ route('orders.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>{{ trans('message.orders') }}</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('categories.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-bookmark"></i>
                            <p>{{ trans('message.categories') }}</p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="{{ route('products.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>{{ trans('message.products') }}</p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="{{ route('suggests.index') }}" class="nav-link">
                            <i class="nav-icon far fa-plus-square"></i>
                            <p>{{ trans('message.suggests') }}</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
    @yield('content');
    <aside class="control-sidebar control-sidebar-dark"></aside>
</div>
<script src="{{ asset('bower_components/admin-lte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/dist/js/adminlte.js') }}"></script>
<script src="{{ mix('js/confirm_delete.js') }}"></script>
<script src="{{ asset('bower_components/sweetalert/docs/assets/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ mix('js/suggest_status.js') }}"></script>
<script src="{{ mix('js/order_status.js') }}"></script>
<script src="{{ asset('bower_components/chart.js/dist/Chart.min.js') }}"></script>
<script src="{{ mix('js/chart.js') }}"></script>
<script src="{{ asset('bower_components/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('bower_components/pusher-js/dist/web/pusher.min.js') }}"></script>
<script src="{{ mix('js/pusher.js') }}"></script>
</body>
</html>
