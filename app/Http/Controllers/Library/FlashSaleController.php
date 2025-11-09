<?php

namespace App\Http\Controllers\Library;

use App\Enums\DiscountStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Library\FlashSaleRequest;
use App\Models\FlashSale;
use App\Traits\DataTableTrait;
use App\Traits\HasDiscountableItemsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlashSaleController extends Controller
{
    use DataTableTrait, HasDiscountableItemsTrait;

    public function index(Request $request)
    {
        return view('Library.FlashSales.index');
    }

    public function getFlashSales(Request $request)
    {
        $query = FlashSale::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $query->latest();

        $result = $this->applyDataTable(
            $request,
            $query,
            ['discount_value', 'start_at', 'end_at']
        );

        $result['data'] = $result['data']->map(function ($flashSale) {

            $flashSale->discount_value       = $flashSale->showDiscountValue();
            $flashSale->status_badge         = $flashSale->showStatus();
            $flashSale->applies_to_all_books = $flashSale->showAppliesToAllBooks();
            $flashSale->start_at_format      = $flashSale->start_at_format;
            $flashSale->end_at_format        = $flashSale->end_at_format;

            $icon = $flashSale->isInactive() ? 'la la-play' : 'la la-pause';
            $label = match (true) {
                $flashSale->isInactive() && $flashSale->isWithinDateRange() => 'Make Active',
                $flashSale->isInactive() => 'Make Scheduled',
                default => 'Make Inactive',
            };

            $actions = '
                <div class="dropdown">
                    <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="actionsMenu' . $flashSale->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </button>
                    <div class="dropdown-menu" aria-labelledby="actionsMenu' . $flashSale->id . '">
                        <a class="dropdown-item" href="' . route('library.flash-sales.edit', $flashSale->id) . '">
                            <i class="la la-edit"></i> Edit
                        </a>';


            $actions .= '
                        <a class="dropdown-item" href="' . route('library.flash-sales.show', $flashSale->id) . '">
                            <i class="la la-eye"></i> Show
                        </a>';

            if (!$flashSale->isExpired()) {
                $actions .= '
                        <button class="dropdown-item btn-status" data-url="' . route('library.flash-sales.changeStatus', $flashSale->id) . '">
                            <i class="' . $icon . '"></i> ' . $label . '
                        </button>
                        <hr/>';
            }

            $actions .= '
                        <button class="dropdown-item text-danger btn-delete" data-url="' . route('library.flash-sales.destroy', $flashSale->id) . '">
                            <i class="la la-trash"></i> Delete
                        </button>
                    </div>
                </div>
            ';

            $flashSale->actions = $actions;

            return $flashSale;
        });

        return response()->json($result);
    }

    private function getFlashSaleData(FlashSaleRequest $request)
    {
        return $request->only(
            [
                'discount_type',
                'discount_value',
                'start_at',
                'end_at',
                'applies_to_all_books'
            ]
        );
    }

    public function create()
    {
        $books      = $this->getAllBooks();
        $categories = $this->getAllCategories();
        return view('Library.FlashSales.create', compact('books', 'categories'));
    }

    public function store(FlashSaleRequest $request)
    {
        try {
            DB::beginTransaction();
            $flashSale = FlashSale::create($this->getFlashSaleData($request));
            $this->syncCategoriesAndBooks($flashSale, $request);
            DB::commit();
            return redirect()->route('library.flash-sales.index')->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }

    public function edit(string $id)
    {
        $flashSale  = FlashSale::findOrFail($id);
        $books      = $this->getAllBooks();
        $categories = $this->getAllCategories();
        return view('Library.FlashSales.edit', compact('flashSale', 'books', 'categories'));
    }

    public function update(FlashSaleRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $flashSale = FlashSale::findOrFail($id);
            $flashSale->update($this->getFlashSaleData($request));
            $this->syncCategoriesAndBooks($flashSale, $request);
            DB::commit();
            return redirect()->route('library.flash-sales.index')->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }

    public function show(string $id)
    {
        $flashSale = FlashSale::findOrFail($id);
        return view('Library.FlashSales.show', compact('flashSale'));
    }

    public function destroy(string $id)
    {
        try {
            $flashSale = FlashSale::findOrFail($id);
            $flashSale->delete();
            return redirect()->back()->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }

    public function changeStatus(string $id)
    {
        try {
            $flashSale = FlashSale::findOrFail($id);

            if ($flashSale->isExpired()) {
                return redirect()->back()->with('error', 'Cannot change status of expired flash sale');
            }

            $newStatus = match (true) {
                !$flashSale->isInactive() => DiscountStatus::Inactive,
                $flashSale->isWithinDateRange() => DiscountStatus::Active,
                default => DiscountStatus::Scheduled
            };

            $message = match ($newStatus) {
                DiscountStatus::Active => 'The flash sale is now active.',
                DiscountStatus::Inactive => 'The flash sale is now inactive.',
                DiscountStatus::Scheduled => 'The flash sale is now scheduled.',
                default => 'Status updated.'
            };

            $flashSale->update(['status' => $newStatus]);
            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }
}
