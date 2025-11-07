<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Http\Requests\Library\LanguageRequest;
use App\Models\Language;
use App\Traits\DataTableTrait;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    use DataTableTrait;

    public function index()
    {
        return view('Library.Languages.index');
    }

    public function getLanguages(Request $request)
    {
        $query = Language::latest();

        $result = $this->applyDataTable(
            $request,
            $query,
            ['name']
        );

        $result['data'] = $result['data']->map(function ($language) {
            $language->actions = '
                <div class="dropdown">
                    <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="actionsMenu' . $language->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </button>
                    <div class="dropdown-menu" aria-labelledby="actionsMenu' . $language->id . '">
                        <a class="dropdown-item" href="' . route('library.languages.edit', $language->id) . '">
                            <i class="la la-edit"></i> Edit
                        </a>
                        <hr/>
                        <button class="dropdown-item text-danger btn-delete" data-url="' . route('library.languages.destroy', $language->id) . '">
                            <i class="la la-trash"></i> Delete
                        </button>
                    </div>
                </div>
            ';

            return $language;
        });

        return response()->json($result);
    }

    public function create()
    {
        return view('Library.Languages.create');
    }

    public function store(LanguageRequest $request)
    {
        try {
            Language::create($request->validated());
            return redirect()->route('library.languages.index')->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }

    public function edit(string $id)
    {
        $language = Language::findOrFail($id);
        return view('Library.Languages.edit', compact('language'));
    }

    public function update(LanguageRequest $request, string $id)
    {
        try {
            $language = Language::findOrFail($id);
            $language->update($request->validated());
            return redirect()->route('library.languages.index')->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }

    public function destroy(string $id)
    {
        try {
            $language = Language::findOrFail($id);
            $language->delete();
            return redirect()->back()->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }
}
