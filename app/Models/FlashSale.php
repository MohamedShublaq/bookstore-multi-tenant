<?php

namespace App\Models;

use App\Models\Discount\DiscountModel;
use App\Observers\FlashSaleObserver;
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
}
