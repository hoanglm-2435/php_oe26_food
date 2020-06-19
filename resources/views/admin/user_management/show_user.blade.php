@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-5">
                    <h2>{{ trans('message.users') }}</h2>
                </div>
                <div class="col-sm-7">
                    <a href="{{ route('users.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i>
                        <span>{{ trans('message.add_user') }}</span>
                    </a>
                </div>
            </div>
        </div>

        @if (session()->get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success') }}
            </div>
        @endif

        <table class="table table-striped table-hover">
            <thead>
            <tr class="text-center">
                <td>#</td>
                <td>{{ trans('message.name') }}</td>
                <td>{{ trans('message.email') }}</td>
                <td>{{ trans('message.address') }}</td>
                <td>{{ trans('message.phone') }}</td>
                <td>{{ trans('message.role') }}</td>
                <td colspan="2">{{ trans('message.action') }}</td>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $key => $user)
                <tr class="text-center">
                    <td>{{ $key = $key + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->address }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ trans('message.' . $user->role->role) }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}"
                           class="btn btn-primary">
                            <i class="fas fa-user-edit"></i>
                            {{ trans('message.edit') }}
                        </a>
                        <form class="delete" action="{{ route('users.destroy', $user->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">
                                <i class="fas fa-trash"></i>
                                {{ trans('message.delete') }}
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="clearfix">
            <div class="hint-text">
                <h6>
                    {{ trans('message.showing') }}
                    <b>{{ $key }}</b>
                    {{ trans('message.out_of') }}
                    <b>{{ $users->count() }}</b>
                    {{ trans('message.entries') }}
                </h6>
            </div>
            <ul class="pagination">
                {{ $users->render() }}
            </ul>
        </div>
    </div>
@endsection
