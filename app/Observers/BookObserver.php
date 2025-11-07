<?php

namespace App\Observers;

use App\Models\Book;

class BookObserver
{
     /**
     * Handle the "creating" event.
     * Automatically set quantity equal to total_stock when a new book is created.
     */
    public function creating(Book $book)
    {
        $book->quantity = $book->total_stock;
    }

    /**
     * Handle the "updating" event.
     * Adjust quantity when total_stock changes.
     */
    public function updating(Book $book)
    {
        if ($book->isDirty('total_stock')) {
            $oldTotalStock = $book->getOriginal('total_stock');
            $newTotalStock = $book->total_stock;
            $currentQuantity = $book->quantity;

            // Adjust quantity based on total_stock change
            if ($newTotalStock < $oldTotalStock) {
                $book->quantity = min($currentQuantity, $newTotalStock);
            } else {
                $book->quantity = $currentQuantity + ($newTotalStock - $oldTotalStock);
            }
        }
    }
}
