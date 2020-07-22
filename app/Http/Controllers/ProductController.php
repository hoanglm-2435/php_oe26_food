<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Image\ImageRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Size\SizeRepositoryInterface;

class ProductController extends Controller
{
    protected $productRepo;
    protected $imageRepo;
    protected $categoryRepo;
    protected $sizeRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        ImageRepositoryInterface $imageRepo,
        CategoryRepositoryInterface $categoryRepo,
        SizeRepositoryInterface $sizeRepo
    )
    {
        $this->productRepo = $productRepo;
        $this->imageRepo = $imageRepo;
        $this->categoryRepo = $categoryRepo;
        $this->sizeRepo = $sizeRepo;
    }

    public function index()
    {
        $products = $this->productRepo->showList(
            'created_at',
            'DESC',
            config('paginates.pagination')
        );

        return view('admin.product_management.show_product', compact('products'));
    }

    public function create()
    {
        $categories = $this->categoryRepo->getAll();
        $sizes = $this->sizeRepo->getAll();

        return view('admin.product_management.create_product', compact('categories', 'sizes'));
    }

    public function store(ProductRequest $request)
    {
        $data = $request->all();
        $product = $this->productRepo->create($data);

        if ($request->hasFile('image_path')) {
            foreach ($request->file('image_path') as $file) {
                $filename = $file->getClientOriginalName();
                $image = [
                    'product_id' => $product->id,
                    'image_path' => $filename
                ];
                $this->imageRepo->create($image);
                $file->move(config('filepath.img_product_path'), $filename);
            }
        }
        else {
            return redirect()->back()->with('error', trans('message.upload_file_failed'));
        }

        return redirect()->route('products.index')->with('success', trans('message.created'));
    }

    public function edit($id)
    {
        $product = $this->productRepo->getById($id);
        $categories = $this->categoryRepo->getAll();
        $sizes = $this->sizeRepo->getAll();

        return view('admin.product_management.update_product', compact('product', 'categories', 'sizes'));
    }

    public function update(ProductRequest $request, $id)
    {
        $product = $this->productRepo->getById($id);
        $data = $request->all();

        if ($request->hasFile('image_path')) {
            foreach ($product->images as $oldImage) {
                $this->imageRepo->delete($oldImage->id);
            }
            foreach ($request->file('image_path') as $file) {
                $filename = $file->getClientOriginalName();
                $path = public_path(config('filepath.img_product_path') . $filename);

                if (file_exists($path)) {
                    unlink($path);
                }
                $image = [
                    'product_id' => $product->id,
                    'image_path' => $filename
                ];
                $this->imageRepo->create($image);
                $file->move(config('filepath.img_product_path'), $filename);
            }
        }
        $this->productRepo->update($id, $data);

        return redirect()->route('products.index')->with('success', trans('message.updated'));
    }

    public function destroy($id)
    {
        $this->productRepo->delete($id);

        return redirect()->route('products.index')->with('success', trans('message.deleted'));
    }
}
