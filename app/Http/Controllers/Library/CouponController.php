<?php

namespace App\Http\Controllers\Library;

use App\Enums\DiscountStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Library\CouponRequest;
use App\Models\Book;
use App\Models\Category;
use App\Models\Coupon;
use Illuminate\Support\Str;
use App\Traits\DataTableTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    use DataTableTrait;

    public function index(Request $request)
    {
        return view('Library.Coupons.index');
    }

    public function getCoupons(Request $request)
    {
        $query = Coupon::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $query->latest();

        $result = $this->applyDataTable(
            $request,
            $query,
            ['code', 'discount_value', 'start_date', 'end_date']
        );

        $result['data'] = $result['data']->map(function ($coupon) {

            $coupon->start_date_format    = $coupon->showStartDate();
            $coupon->end_date_format      = $coupon->showEndDate();
            $coupon->discount_value       = $coupon->showDiscountValue();
            $coupon->status_badge         = $coupon->showStatus();
            $coupon->applies_to_all_books = $coupon->showAppliesToAllBooks();

            $icon = $coupon->inactive() ? 'la la-play' : 'la la-pause';
            $label = match (true) {
                $coupon->inactive() && ($coupon->hasNoDates() || $coupon->isWithinDateRange()) => 'Make Active',
                $coupon->inactive() => 'Make Scheduled',
                default => 'Make Inactive',
            };

            $actions = '
                <div class="dropdown">
                    <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="actionsMenu' . $coupon->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </button>
                    <div class="dropdown-menu" aria-labelledby="actionsMenu' . $coupon->id . '">
                        <a class="dropdown-item" href="' . route('library.coupons.edit', $coupon->id) . '">
                            <i class="la la-edit"></i> Edit
                        </a>';

            if (!$coupon->expired()) {
                $actions .= '
                        <button class="dropdown-item btn-status" data-url="' . route('library.coupons.changeStatus', $coupon->id) . '">
                            <i class="' . $icon . '"></i> ' . $label . '
                        </button>
                        <hr/>';
            }

            $actions .= '
                        <button class="dropdown-item text-danger btn-delete" data-url="' . route('library.coupons.destroy', $coupon->id) . '">
                            <i class="la la-trash"></i> Delete
                        </button>
                    </div>
                </div>
            ';

            $coupon->actions = $actions;

            return $coupon;
        });

        return response()->json($result);
    }

    private function getAllBooks()
    {
        return Book::select('id', 'name')->get();
    }

    private function getAllCategories()
    {
        return Category::select('id', 'name')->get();
    }

    private function getCouponData(CouponRequest $request)
    {
        return $request->only(
            [
                'code',
                'discount_type',
                'discount_value',
                'start_date',
                'end_date',
                'usage_limit',
                'per_user_limit',
                'applies_to_all_books'
            ]
        );
    }

    private function syncCategoriesAndBooks(Coupon $coupon, CouponRequest $request)
    {
        if (! $coupon->applies_to_all_books) {
            if ($request->has('categories')) {
                $coupon->categories()->sync($request->categories);
            }

            if ($request->has('books')) {
                $coupon->books()->sync($request->books);
            }
        }
    }

    public function create()
    {
        $books      = $this->getAllBooks();
        $categories = $this->getAllCategories();
        return view('Library.Coupons.create', compact('books', 'categories'));
    }

    public function store(CouponRequest $request)
    {
        try {
            DB::beginTransaction();
            $coupon = Coupon::create($this->getCouponData($request));
            $this->syncCategoriesAndBooks($coupon, $request);
            DB::commit();
            return redirect()->route('library.coupons.index')->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }

    public function edit(string $id)
    {
        $coupon     = Coupon::findOrFail($id);
        $books      = $this->getAllBooks();
        $categories = $this->getAllCategories();
        return view('Library.Coupons.edit', compact('coupon', 'books', 'categories'));
    }

    public function update(CouponRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $coupon = Coupon::findOrFail($id);
            $coupon->update($this->getCouponData($request));
            $this->syncCategoriesAndBooks($coupon, $request);
            DB::commit();
            return redirect()->route('library.coupons.index')->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }

    public function destroy(string $id)
    {
        try {
            $coupon = Coupon::findOrFail($id);
            $coupon->delete();
            return redirect()->back()->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }

    public function changeStatus(string $id)
    {
        try {
            $coupon = Coupon::findOrFail($id);

            if ($coupon->expired()) {
                return redirect()->back()->with('error', 'Cannot change status of expired coupon');
            }

            $newStatus = match (true) {
                !$coupon->inactive() => DiscountStatus::Inactive,
                $coupon->hasNoDates() => DiscountStatus::Active,
                $coupon->isWithinDateRange() => DiscountStatus::Active,
                default => DiscountStatus::Scheduled
            };

            $message = match ($newStatus) {
                DiscountStatus::Active => 'The coupon is now active.',
                DiscountStatus::Inactive => 'The coupon is now inactive.',
                DiscountStatus::Scheduled => 'The coupon is now scheduled.',
                default => 'Status updated.'
            };

            $coupon->update(['status' => $newStatus]);
            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }

    public function generateCode()
    {
        do {
            $code = Str::upper(Str::random(6));
            $exists = Coupon::where('code', $code)->exists();
        } while ($exists);

        return response()->json(['code' => $code]);
    }
}
