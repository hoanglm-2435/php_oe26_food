@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-5">
                    <h2>{{ trans('message.category_management') }}</h2>
                </div>
                <div class="col-sm-7">
                    <a href="{{ route('categories.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i>
                        <span>{{ trans('message.add_category') }}</span>
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
                <td>{{ trans('message.category_parent') }}</td>
                <td>{{ trans('message.category_name') }}</td>
                <td colspan="2">{{ trans('message.action') }}</td>
            </tr>
            </thead>
            <tbody>
            @foreach ($categories as $key => $cate)
                <tr class="text-center">
                    <td>{{ $key = $key + 1 }}</td>
                    <td>
                        @if ($cate->parent)
                            {{ $cate->parent->name }}
                        @else
                            {{ $cate->name }}
                        @endif
                    </td>
                    <td>{{ $cate->name }}</td>
                    <td>
                        <div class="custom-control-inline">
                            <a href="{{ route('categories.edit', $cate->id) }}"
                                class="btn btn-primary">
                                <i class="fas fa-user-edit"></i>
                                {{ trans('message.edit') }}
                            </a>
                            <form class="delete" action="{{ route('categories.destroy', $cate->id) }}" class="delete"
                                method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">
                                    <i class="fas fa-trash"></i>
                                    {{ trans('message.delete') }}
                                </button>
                            </form>
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
                    <b>{{ $key }}</b>
                    {{ trans('message.out_of') }}
                    <b>{{ $categories->count() }}</b>
                    {{ trans('message.entries') }}
                </h6>
            </div>
            <ul class="pagination">
                {{ $categories->render() }}
            </ul>
        </div>
    </div>
@endsection
