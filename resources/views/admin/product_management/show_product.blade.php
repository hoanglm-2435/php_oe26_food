@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-5">
                    <h2>{{ trans('message.product_management') }}</h2>
                </div>
                <div class="col-sm-7">
                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i>
                        <span>{{ trans('message.add_product') }}</span>
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
                <td>{{ trans('message.product_name') }}</td>
                <td>{{ trans('message.product_description') }}</td>
                <td>{{ trans('message.product_category') }}</td>
                <td>{{ trans('message.product_size') }}</td>
                <td>{{ trans('message.quantity') }}</td>
                <td>{{ trans('message.price') }}</td>
                <td>{{ trans('message.price_sale') }}</td>
                <td>{{ trans('message.product_image') }}</td>
                <td colspan="2">{{ trans('message.action') }}</td>
            </tr>
            </thead>
            <tbody>
            @foreach ($products as $key => $product)
                <tr class="text-center">
                    <td>{{ $key = $key + 1 }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->category_id }}</td>
                    <td>{{ $product->size_id }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->price_sale }}</td>
                    <td>
                        @foreach ($product->images as $image)
                            <img class="img-size-64" src="{{ asset(config('filepath.img_product_path') . $image->image_path) }}">
                        @endforeach
                    </td>
                    <td>
                        <div class="custom-control-inline">
                            <a href="{{ route('products.edit', $product->id) }}"
                               class="btn btn-primary">
                                <i class="fas fa-user-edit"></i>
                                {{ trans('message.edit') }}
                            </a>
                            <form class="delete" action="{{ route('products.destroy', $product->id) }}" class="delete"
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
                    <b>
                        @if (isset($key))
                            {{ $key }}
                        @else
                            {{ config('numbers.zero') }}
                        @endif
                    </b>
                    {{ trans('message.out_of') }}
                    <b>
                        @if (isset($product))
                            {{ $product->count() }}
                        @else
                            {{ config('numbers.zero') }}
                        @endif
                    </b>
                    {{ trans('message.entries') }}
                </h6>
            </div>
            <ul class="pagination">
                {{ $products->render() }}
            </ul>
        </div>
    </div>
@endsection
