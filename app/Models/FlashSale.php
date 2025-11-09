<?php

namespace App\Models;

use App\Models\Discount\DiscountModel;
use App\Observers\FlashSaleObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([FlashSaleObserver::class])]
class FlashSale extends DiscountModel
{
    protected $fillable = [
        'library_id',
        'discount_type',
        'discount_value',
        'start_at',
        'end_at',
        'status',
        'applies_to_all_books',
    ];

    public function books()
    {
        return $this->belongsToMany(Book::class, 'flash_sale_books', 'flash_sale_id', 'book_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'flash_sale_categories', 'flash_sale_id', 'category_id');
    }

    public function isWithinDateRange(): bool
    {
        $now = Carbon::now();
        return $now >= $this->start_at && $now < $this->end_at;
    }

    public function getStartAtFormatAttribute($val)
    {
        return date('Y/m/d - H:i A', strtotime($this->start_at));
    }

    public function getEndAtFormatAttribute($val)
    {
        return date('Y/m/d - H:i A', strtotime($this->end_at));
    }
}
