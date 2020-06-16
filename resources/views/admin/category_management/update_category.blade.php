@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-5">
                    <h2><b>{{ trans('message.update_category') }}</b></h2>
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
                    <form action="{{ route('categories.update', $category->id) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="box">
                            <div class="box-body row">
                                <div class="form-group col-md-12">
                                    <label>{{ trans('message.category_parent') }}</label>
                                    <select class="form-control" name="parent_id">

                                        @if($category->parent)
                                            <option value="{{ $category->parent->id }}"
                                                @if ($category->parent_id == $category->parent->id)
                                                    selected
                                                @endif
                                            >{{ $category->parent->name }}</option>
                                        @endif

                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>{{ trans('message.category_name') }}</label>
                                    <input type="text" name="name" class="form-control" value="{{ $category->name }}">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ trans('message.save') }}</button>
                        <a href="{{ route('categories.index') }}" class="btn btn-primary">{{ trans('message.cancel') }}</a>
                    </form>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
