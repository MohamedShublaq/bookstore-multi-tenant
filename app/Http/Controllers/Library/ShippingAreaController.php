<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Http\Requests\Library\ShippingAreaRequest;
use App\Models\ShippingArea;
use App\Traits\DataTableTrait;
use Illuminate\Http\Request;

class ShippingAreaController extends Controller
{
    use DataTableTrait;

    public function index()
    {
        return view('Library.ShippingAreas.index');
    }

    public function getShippingAreas(Request $request)
    {
        $query = ShippingArea::latest();

        $result = $this->applyDataTable(
            $request,
            $query,
            ['name']
        );

        $result['data'] = $result['data']->map(function ($shippingArea) {
            $shippingArea->actions = '
                <div class="dropdown">
                    <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="actionsMenu' . $shippingArea->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </button>
                    <div class="dropdown-menu" aria-labelledby="actionsMenu' . $shippingArea->id . '">
                        <a class="dropdown-item" href="' . route('library.shipping-areas.edit', $shippingArea->id) . '">
                            <i class="la la-edit"></i> Edit
                        </a>
                        <hr/>
                        <button class="dropdown-item text-danger btn-delete" data-url="' . route('library.shipping-areas.destroy', $shippingArea->id) . '">
                            <i class="la la-trash"></i> Delete
                        </button>
                    </div>
                </div>
            ';

            return $shippingArea;
        });

        return response()->json($result);
    }

    public function create()
    {
        return view('Library.ShippingAreas.create');
    }

    public function store(ShippingAreaRequest $request)
    {
        try {
            ShippingArea::create($request->validated());
            return redirect()->route('library.shipping-areas.index')->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }

    public function edit(string $id)
    {
        $shippingArea = ShippingArea::findOrFail($id);
        return view('Library.ShippingAreas.edit', compact('shippingArea'));
    }

    public function update(ShippingAreaRequest $request, string $id)
    {
        try {
            $shippingArea = ShippingArea::findOrFail($id);
            $shippingArea->update($request->validated());
            return redirect()->route('library.shipping-areas.index')->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }

    public function destroy(string $id)
    {
        try {
            $shippingArea = ShippingArea::findOrFail($id);
            $shippingArea->delete();
            return redirect()->back()->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }
}
