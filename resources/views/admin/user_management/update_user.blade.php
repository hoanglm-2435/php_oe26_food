@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-5">
                    <h2>{{ trans('message.update') }} <b>{{ trans('message.user') }}</b></h2>
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
                    <form class="well form-horizontal" method="post"
                          action="{{ route('users.update', $user->id) }}">
                        @method('PATCH')
                        @csrf
                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ trans('message.name') }}</label>
                            <div class="col-md-8 inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-user"></i>
                                    </span>
                                    <h5>{{ $user->name }}</h5>
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
                                    <h5>{{ $user->email }}</h5>
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
                                    <h5>{{ $user->address }}</h5>
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
                                    <h5>{{ $user->phone }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="role_id" class="col-sm-2 control-label">{{ trans('message.role') }}</label>
                            <div class="col-sm-5">
                                <select name="role_id" class="form-control role">

                                    @foreach (config('roles') as $key => $role)
                                        <option value="{{ $role }}"
                                                @if ($role == $user->role_id)
                                                    selected
                                                @endif
                                        >{{ trans('message.' . $key) }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ trans('message.save') }}</button>
                        <a href="{{ route('users.index') }}" class="btn btn-primary">{{ trans('message.cancel') }}</a>
                    </form>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
