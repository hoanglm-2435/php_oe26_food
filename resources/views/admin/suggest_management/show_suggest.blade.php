@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-5">
                    <h2>{{ trans('message.suggest_management') }}</h2>
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
                <td>{{ trans('message.customer') }}</td>
                <td>{{ trans('client.suggest') }}</td>
                <td>{{ trans('client.status') }}</td>
                <td colspan="2">{{ trans('message.action') }}</td>
            </tr>
            </thead>
            <tbody>
            @foreach ($suggests as $key => $suggest)
                <tr class="text-center">
                    <td>{{ $key = $key + 1 }}</td>
                    <td>{{ $suggest->user->name }}</td>
                    <td>{{ $suggest->suggest }}</td>
                    <td>
                        @switch ($suggest->status)
                            @case (config('status.pending'))
                                <span class="badge badge-warning suggest-status-badge
                                    badge{{ $suggest->id }}">
                                    {{ trans('message.pending') }}
                                </span>
                                @break
                            @case (config('status.approved'))
                                <span class="badge badge-success suggest-status-badge
                                    badge{{ $suggest->id }}">
                                    {{ trans('message.approved') }}
                                </span>
                                @break
                            @case (config('status.canceled'))
                                <span class="badge badge-secondary suggest-status-badge
                                    badge{{ $suggest->id }}">
                                    {{ trans('message.canceled') }}
                                </span>
                                @break
                        @endswitch
                    </td>
                    <td>
                        <div class="custom-control-inline">
                            @if ($suggest->status != config('status.canceled'))
                                @if ($suggest->status == config('status.pending'))
                                    <button type="button" data-id="{{ $suggest->id }}" data-status="1"
                                        title="{{ trans('message.approve') }}"
                                        class="btn btn-sm btn-success approve-suggest">
                                        <i class="suggest-status fas fa-check-circle"></i>
                                    </button>
                                @else
                                    <button type="button" data-id="{{ $suggest->id }}" data-status="0"
                                            title="{{ trans('message.cancel') }}"
                                            class="btn btn-sm btn-default cancel-suggest">
                                        <i class="suggest-status fas fa-times-circle"></i>
                                    </button>
                                @endif
                                <form class="delete" method="post"
                                    action="{{ route('suggests.destroy', $suggest->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="clearfix">
            <div class="hint-text">
                <h6>
                    {{ trans('message.showing') }}
                    <b>
                        @if (isset($key))
                            {{ $key }}
                        @else
                            {{ config('numbers.zero') }}
                        @endif
                    </b>
                    {{ trans('message.out_of') }}
                    <b>
                        @if (isset($suggest))
                            {{ $suggest->count() }}
                        @else
                            {{ config('numbers.zero') }}
                        @endif
                    </b>
                    {{ trans('message.entries') }}
                </h6>
            </div>
            <ul class="pagination">
                {{ $suggests->render() }}
            </ul>
        </div>
    </div>
@endsection
