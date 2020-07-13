<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ trans('message.register') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet"
          href="{{ asset('bower_components/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <b>{{ trans('message.register') }}</b>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">

            @if (count($errors) >0)
                <ul>
                    @foreach($errors->all() as $error)
                        <li class="text-danger"> {{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form action="{{ route('register') }}" method="post">
                {{ csrf_field() }}
                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control" placeholder="{{ trans('message.name') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="{{ trans('message.email') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="{{ trans('message.password') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password_confirmation" class="form-control"
                        placeholder="{{ trans('message.password_confirm') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="address" class="form-control"
                        placeholder="{{ trans('message.address') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-address-card"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="phone" class="form-control" placeholder="{{ trans('message.phone') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-phone"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <button type="submit" class="btn btn-primary btn-block">{{ trans('message.register') }}</button>
                </div>
            </form>
            <p class="mb-1 text-center">
                <a href="{{ route('login') }}">{{ trans('message.return_login') }}</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('public/bower_components/admin-lte/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('public/bower_components/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/bower_components/admin-lte/dist/js/adminlte.min.js') }}"></script>

</body>
</html>
