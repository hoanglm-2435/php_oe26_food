<?php

namespace App\Http\Controllers;

use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryRepo;

    public function __construct(CategoryRepositoryInterface $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function index()
    {
        $categories =  $this->categoryRepo->showList(
            'created_at',
            'DESC',
            config('paginates.pagination')
        );

        return view('admin.category_management.show_category', compact('categories'));
    }

    public function create()
    {
        $categories = $this->categoryRepo->getAll();

        return view('admin.category_management.create_category', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->categoryRepo->create($request->all());

        return redirect()->route('categories.index')->with('success', trans('message.created'));
    }

    public function edit($id)
    {
        $category = $this->categoryRepo->getById($id);

        return view('admin.category_management.update_category', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $this->categoryRepo->update($id, $request->all());

        return redirect()->route('categories.index')->with('success', trans('message.updated'));
    }

    public function destroy($id)
    {
        $this->categoryRepo->delete($id);

        return redirect()->route('categories.index')->with('success', trans('message.deleted'));
    }
}
