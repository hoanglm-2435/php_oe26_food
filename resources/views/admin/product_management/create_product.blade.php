@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-5">
                    <h2><b>{{ trans('message.add_product') }}</b></h2>
                </div>
            </div>
        </div>
        <table class="table table-striped">
            <tbody>
            <tr>
                <td colspan="1">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="box">
                            <div class="box-body row">
                                <div class="form-group col-md-12">
                                    <label>{{ trans('message.product_name') }}</label>
                                    <input type="text" name="name" class="form-control" value="">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">
                                            @foreach ($errors->get('name') as $errormessage)
                                                {{ $errormessage }}<br>
                                            @endforeach
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label>{{ trans('message.product_description') }}</label>
                                    <textarea type="text" name="description" class="form-control" value=""></textarea>
                                    @if ($errors->has('description'))
                                        <span class="text-danger">
                                            @foreach ($errors->get('description') as $errormessage)
                                                {{ $errormessage }}<br>
                                            @endforeach
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label>{{ trans('message.product_category') }}</label>
                                    <select class="form-control" name="category_id">
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
                                    <label>{{ trans('message.product_size') }}</label>
                                    <select class="form-control" name="size_id">
                                        <option value="0">---</option>

                                        @foreach ($sizes as $size)
                                            <option value="{{ $size->id }}">{{ $size->size }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>{{ trans('message.quantity') }}</label>
                                    <input type="text" name="quantity" class="form-control" value="">
                                    @if ($errors->has('quantity'))
                                        <span class="text-danger">
                                            @foreach ($errors->get('quantity') as $errormessage)
                                                {{ $errormessage }}<br>
                                            @endforeach
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label>{{ trans('message.price') }}</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                        <input type="text" name="price" class="form-control" value="">
                                    </div>
                                    @if ($errors->has('price'))
                                        <span class="text-danger">
                                            @foreach ($errors->get('price') as $errormessage)
                                                {{ $errormessage }}<br>
                                            @endforeach
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label>{{ trans('message.price_sale') }}</label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                        <input type="text" name="price_sale" class="form-control" value="">
                                    </div>
                                    @if ($errors->has('price_sale'))
                                        <span class="text-danger">
                                            @foreach ($errors->get('price_sale') as $errormessage)
                                                {{ $errormessage }}<br>
                                            @endforeach
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="control-label">{{ trans('message.product_image') }}</label>
                                    <input name="image_path[]" class="form-control-file" data-icon="true" type="file" multiple>
                                    @if ($errors->has('image_path'))
                                        <span class="text-danger">
                                            @foreach ($errors->get('image_path') as $errormessage)
                                                {{ $errormessage }}<br>
                                            @endforeach
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ trans('message.add_product') }}</button>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">{{ trans('message.cancel') }}</a>
                    </form>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
