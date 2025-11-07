<?php

namespace App\Models;

use App\Models\Tenant\TenantModel;
use App\Observers\BookObserver;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([BookObserver::class])]
class Book extends TenantModel
{
    use Sluggable;

    protected $fillable = [
        'library_id',
        'name',
        'slug',
        'image',
        'description',
        'total_stock',
        'pages',
        'rate',
        'publish_year',
        'price',
        'is_available',
        'category_id',
        'language_id',
        'publisher_id',
        'author_id',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true,
                'unique' => true
            ]
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_books', 'book_id', 'coupon_id');
    }
}
