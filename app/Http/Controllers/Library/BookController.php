<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Http\Requests\Library\BookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Language;
use App\Models\Publisher;
use App\Traits\DataTableTrait;
use App\Traits\ImageManagerTrait;
use Illuminate\Http\Request;

class BookController extends Controller
{
    use DataTableTrait, ImageManagerTrait;

    public function index()
    {
        return view('Library.Books.index');
    }

    public function getBooks(Request $request)
    {
        $query = Book::latest();

        $result = $this->applyDataTable(
            $request,
            $query,
            ['name', 'price'],
            [
                'category' => ['name'],
                'author'   => ['name'],
            ]
        );

        $result['data'] = $result['data']->map(function ($book) {

            $book->category_name = $book->category?->name;
            $book->author_name = $book->author?->name;

            $book->image = $book->image
                ? '<img src="' . asset($book->image) . '" alt="logo" width="50" height="50">'
                : '<span class="badge badge-secondary">No Image</span>';

            $isAvailable = $book->is_available;

            $book->is_available = $isAvailable
                ? '<span class="badge badge-success">Available</span>'
                : '<span class="badge badge-danger">Unavailable</span>';

            $icon  = $isAvailable ? 'la la-pause' : 'la la-play';
            $label = $isAvailable ? 'Make Unavailable' : 'Make Available';

            $book->actions = '
                <div class="dropdown">
                    <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="actionsMenu' . $book->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </button>
                    <div class="dropdown-menu" aria-labelledby="actionsMenu' . $book->id . '">
                        <a class="dropdown-item" href="' . route('library.books.edit', $book->slug) . '">
                            <i class="la la-edit"></i> Edit
                        </a>
                        <a class="dropdown-item" href="' . route('library.books.show', $book->slug) . '">
                            <i class="la la-eye"></i> Show
                        </a>
                        <button class="dropdown-item btn-status" data-url="' . route('library.books.changeStatus', $book->id) . '">
                            <i class="' . $icon . '"></i> ' . $label . '
                        </button>
                        <hr/>
                        <button class="dropdown-item text-danger btn-delete" data-url="' . route('library.books.destroy', $book->id) . '">
                            <i class="la la-trash"></i> Delete
                        </button>
                    </div>
                </div>
            ';

            return $book;
        });

        return response()->json($result);
    }

    public function create()
    {
        $categories = $this->getAllCategories();
        $languages  = $this->getAllLanguages();
        $authors    = $this->getAllAuthors();
        $publishers = $this->getAllPublishers();
        return view('Library.Books.create', compact('categories', 'languages', 'authors', 'publishers'));
    }

    public function store(BookRequest $request)
    {
        try {
            $data = $this->getRequestExceptImage($request);
            $book = Book::create($data);
            if ($request->hasFile('image')) {
                $this->storeImage($request, $book, 'image');
            }
            return redirect()->route('library.books.index')->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }

    public function show(string $slug)
    {
        $book = Book::whereSlug($slug)->firstOrFail();
        return view('Library.Books.show', compact('book'));
    }

    public function edit(string $slug)
    {
        $book       = Book::whereSlug($slug)->firstOrFail();
        $categories = $this->getAllCategories();
        $languages  = $this->getAllLanguages();
        $authors    = $this->getAllAuthors();
        $publishers = $this->getAllPublishers();
        return view('Library.Books.edit', compact('book', 'categories', 'languages', 'authors', 'publishers'));
    }

    public function update(BookRequest $request, string $id)
    {
        try {
            $book = Book::findOrFail($id);
            $data = $this->getRequestExceptImage($request);
            $book->update($data);
            if ($request->hasFile('image')) {
                $this->deleteImage($book, 'image');
                $this->storeImage($request, $book, 'image');
            }
            return redirect()->route('library.books.index')->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }

    public function destroy(string $id)
    {
        try {
            $book = Book::findOrFail($id);
            $this->deleteImage($book, 'image');
            $book->delete();
            return redirect()->back()->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }

    public function changeStatus(string $id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->update([
                'is_available' => !$book->is_available
            ]);
            return redirect()->back()->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }

    private function getAllCategories()
    {
        return Category::select('id', 'name')->get();
    }

    private function getAllLanguages()
    {
        return Language::select('id', 'name')->get();
    }

    private function getAllAuthors()
    {
        return Author::select('id', 'name')->get();
    }

    private function getAllPublishers()
    {
        return Publisher::select('id', 'name')->get();
    }

    private function getRequestExceptImage($request)
    {
        return collect($request->validated())->except('image')->toArray();
    }
}
