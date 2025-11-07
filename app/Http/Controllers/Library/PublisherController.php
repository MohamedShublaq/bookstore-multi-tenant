<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Http\Requests\Library\PublisherRequest;
use App\Models\Publisher;
use App\Traits\DataTableTrait;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    use DataTableTrait;

    public function index()
    {
        return view('Library.Publishers.index');
    }

    public function getPublishers(Request $request)
    {
        $query = Publisher::latest();

        $result = $this->applyDataTable(
            $request,
            $query,
            ['name']
        );

        $result['data'] = $result['data']->map(function ($publisher) {
            $publisher->actions = '
                <div class="dropdown">
                    <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="actionsMenu' . $publisher->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </button>
                    <div class="dropdown-menu" aria-labelledby="actionsMenu' . $publisher->id . '">
                        <a class="dropdown-item" href="' . route('library.publishers.edit', $publisher->id) . '">
                            <i class="la la-edit"></i> Edit
                        </a>
                        <hr/>
                        <button class="dropdown-item text-danger btn-delete" data-url="' . route('library.publishers.destroy', $publisher->id) . '">
                            <i class="la la-trash"></i> Delete
                        </button>
                    </div>
                </div>
            ';

            return $publisher;
        });

        return response()->json($result);
    }

    public function create()
    {
        return view('Library.Publishers.create');
    }

    public function store(PublisherRequest $request)
    {
        try {
            Publisher::create($request->validated());
            return redirect()->route('library.publishers.index')->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }

    public function edit(string $id)
    {
        $publisher = Publisher::findOrFail($id);
        return view('Library.Publishers.edit', compact('publisher'));
    }

    public function update(PublisherRequest $request, string $id)
    {
        try {
            $publisher = Publisher::findOrFail($id);
            $publisher->update($request->validated());
            return redirect()->route('library.publishers.index')->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }

    public function destroy(string $id)
    {
        try {
            $publisher = Publisher::findOrFail($id);
            $publisher->delete();
            return redirect()->back()->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }
}
