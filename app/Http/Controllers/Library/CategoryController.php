<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Http\Requests\Library\CategoryRequest;
use App\Models\Category;
use App\Traits\DataTableTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use DataTableTrait;

    public function index()
    {
        return view('Library.Categories.index');
    }

    public function getCategories(Request $request)
    {
        $query = Category::latest();

        $result = $this->applyDataTable(
            $request,
            $query,
            ['name']
        );

        $result['data'] = $result['data']->map(function ($category) {

            $category->num_of_books = $category->books()->count();

            $category->actions = '
                <div class="dropdown">
                    <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="actionsMenu' . $category->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </button>
                    <div class="dropdown-menu" aria-labelledby="actionsMenu' . $category->id . '">
                        <a class="dropdown-item" href="' . route('library.categories.edit', $category->id) . '">
                            <i class="la la-edit"></i> Edit
                        </a>
                        <hr/>
                        <button class="dropdown-item text-danger btn-delete" data-url="' . route('library.categories.destroy', $category->id) . '">
                            <i class="la la-trash"></i> Delete
                        </button>
                    </div>
                </div>
            ';

            return $category;
        });

        return response()->json($result);
    }

    public function create()
    {
        return view('Library.Categories.create');
    }

    public function store(CategoryRequest $request)
    {
        try {
            Category::create($request->validated());
            return redirect()->route('library.categories.index')->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }

    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('Library.Categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, string $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->update($request->validated());
            return redirect()->route('library.categories.index')->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }

    public function destroy(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return redirect()->back()->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }
}
