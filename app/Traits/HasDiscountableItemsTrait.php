<?php

namespace App\Traits;

use App\Models\Book;
use App\Models\Category;

trait HasDiscountableItemsTrait
{
    /**
     * Get all books (id and name)
     */
    public function getAllBooks()
    {
        return Book::select('id', 'name')->get();
    }

    /**
     * Get all categories (id and name)
     */
    public function getAllCategories()
    {
        return Category::select('id', 'name')->get();
    }

    /**
     * Sync categories and books for a discount model (Coupon or FlashSale)
     */
    public function syncCategoriesAndBooks($model, $request)
    {
        if (! $model->applies_to_all_books) {
            if ($request->has('categories')) {
                $model->categories()->sync($request->categories);
            }

            if ($request->has('books')) {
                $model->books()->sync($request->books);
            }
        } else {
            $model->categories()->detach();
            $model->books()->detach();
        }
    }
}
