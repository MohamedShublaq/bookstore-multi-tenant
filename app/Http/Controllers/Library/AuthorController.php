<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Http\Requests\Library\AuthorRequest;
use App\Models\Author;
use App\Traits\DataTableTrait;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    use DataTableTrait;

    public function index()
    {
        return view('Library.Authors.index');
    }

    public function getAuthors(Request $request)
    {
        $query = Author::latest();

        $result = $this->applyDataTable(
            $request,
            $query,
            ['name']
        );

        $result['data'] = $result['data']->map(function ($author) {
            $author->actions = '
                <div class="dropdown">
                    <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="actionsMenu' . $author->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </button>
                    <div class="dropdown-menu" aria-labelledby="actionsMenu' . $author->id . '">
                        <a class="dropdown-item" href="' . route('library.authors.edit', $author->id) . '">
                            <i class="la la-edit"></i> Edit
                        </a>
                        <hr/>
                        <button class="dropdown-item text-danger btn-delete" data-url="' . route('library.authors.destroy', $author->id) . '">
                            <i class="la la-trash"></i> Delete
                        </button>
                    </div>
                </div>
            ';

            return $author;
        });

        return response()->json($result);
    }

    public function create()
    {
        return view('Library.Authors.create');
    }

    public function store(AuthorRequest $request)
    {
        try {
            Author::create($request->validated());
            return redirect()->route('library.authors.index')->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }

    public function edit(string $id)
    {
        $author = Author::findOrFail($id);
        return view('Library.Authors.edit', compact('author'));
    }

    public function update(AuthorRequest $request, string $id)
    {
        try {
            $author = Author::findOrFail($id);
            $author->update($request->validated());
            return redirect()->route('library.authors.index')->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }

    public function destroy(string $id)
    {
        try {
            $author = Author::findOrFail($id);
            $author->delete();
            return redirect()->back()->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }
}
