<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(config('paginates.pagination'));

        return view('admin.product_management.show_product', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $sizes = Size::all();

        return view('admin.product_management.create_product', compact('categories', 'sizes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = Product::create($request->all());
        if ($request->hasFile('image_path')) {
            foreach ($request->file('image_path') as $file) {
                $filename = $file->getClientOriginalName();
                $image = new Image();
                $image->product_id = $product->id;
                $image->image_path = $filename;
                $image->save();
                $file->move(config('filepath.img_product_path'), $filename);
            }
        }
        else {
            return redirect()->back()->with('error', trans('message.upload_file_failed'));
        }

        return redirect()->route('products.index')->with('success', trans('message.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $sizes = Size::all();

        return view('admin.product_management.update_product', compact('product', 'categories', 'sizes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($request->hasFile('image_path')) {
            foreach ($request->file('image_path') as $file)
            {
                $filename = $file->getClientOriginalName();
                $path = public_path(config('filepath.img_product_path') . $filename);
                if (file_exists($path)) {
                    unlink($path);
                }
                foreach ($product->images as $oldImage)
                {
                    $oldImage->delete();
                }
                $image = new Image();
                $image->product_id = $product->id;
                $image->image_path = $filename;
                $image->save();
                $file->move(config('filepath.img_product_path'), $filename);
            }
        }
        $product->update($request->all());

        return redirect()->route('products.index')->with('success', trans('message.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', trans('message.deleted'));
    }
}
