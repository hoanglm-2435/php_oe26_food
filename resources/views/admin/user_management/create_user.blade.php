@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-5">
                    <h2><b>{{ trans('message.create_user') }}</b></h2>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div><br/>
        @endif

        <table class="table table-striped">
            <tbody>
            <tr>
                <td colspan="1">
                    <form class="well form-horizontal" method="post" action="{{ route('users.store') }}">
                        @csrf
                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ trans('message.name') }}</label>
                            <div class="col-md-8 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-user"></i>
                                    </span>
                                    <input id="name"
                                           name="name"
                                           placeholder="{{ trans('message.name') }}"
                                           class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ trans('message.email') }}</label>
                            <div class="col-md-8 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-home"></i>
                                    </span>
                                    <input id="email"
                                           name="email"
                                           placeholder="{{ trans('message.email') }}"
                                           class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ trans('message.password') }}</label>
                            <div class="col-md-8 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-home"></i>
                                    </span>
                                    <input id="email"
                                           name="password"
                                           placeholder="{{ trans('message.password') }}"
                                           class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ trans('message.address') }}</label>
                            <div class="col-md-8 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-home"></i>
                                    </span>
                                    <input id="address"
                                           name="address"
                                           placeholder="{{ trans('message.address') }}"
                                           class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ trans('message.phone') }}</label>
                            <div class="col-md-8 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-home"></i>
                                    </span>
                                    <input id="phone"
                                           name="phone"
                                           placeholder="{{ trans('message.phone') }}"
                                           class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="role" class="col-sm-2 control-label">{{ trans('message.role') }}</label>
                            <div class="col-sm-5">
                                <select name="role_id" class="form-control role">
                                    <option value="{{ config('roles.admin') }}">{{ trans('message.admin') }}</option>
                                    <option value="{{ config('roles.customer') }}">{{ trans('message.customer') }}</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ trans('message.add_user') }}</button>
                        <a href="{{ route('users.index') }}" class="btn btn-primary">{{ trans('message.cancel') }}</a>
                    </form>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
