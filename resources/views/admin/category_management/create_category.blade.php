@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-5">
                    <h2><b>{{ trans('message.add_category') }}</b></h2>
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
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        <div class="box">
                            <div class="box-body row">
                                <div class="form-group col-md-12">
                                    <label>{{ trans('message.category_parent') }}</label>
                                    <select class="form-control" name="parent_id">
                                        <option value="0">---</option>

                                        @foreach ($categories->where('parent_id', null) as $cate)
                                            <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                                            @foreach ($categories->where('parent_id', $cate->id) as $child)
                                                @include('admin.category_management.child_tree', ['child_category' => $child, 'level' => '--'])
                                            @endforeach
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>{{ trans('message.category_name') }}</label>
                                    <input type="text" name="name" class="form-control" value="">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ trans('message.add_category') }}</button>
                        <a href="{{ route('categories.index') }}" class="btn btn-primary">{{ trans('message.cancel') }}</a>
                    </form>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
