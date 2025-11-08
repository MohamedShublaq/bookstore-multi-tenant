<?php

namespace App\Providers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Coupon;
use App\Models\Language;
use App\Models\LibraryAdmin;
use App\Models\Publisher;
use App\Models\ShippingArea;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('Dashboard.Layouts.SideBar.library-admin', function ($view) {
            $adminsCount           = LibraryAdmin::where('id', '!=', auth()->id())->count();
            $languagesCount        = Language::count();
            $categoriesCount       = Category::count();
            $shippingAreasCount    = ShippingArea::count();
            $authorsCount          = Author::count();
            $publishersCount       = Publisher::count();
            $booksCount            = Book::count();
            $allCouponsCount       = Coupon::count();
            $activeCouponsCount    = Coupon::active()->count();
            $inactiveCouponsCount  = Coupon::inactive()->count();
            $scheduledCouponsCount = Coupon::scheduled()->count();
            $expiredCouponsCount   = Coupon::expired()->count();
            $usersCount            = User::count();
            $messagesCount         = Contact::count();
            $view->with(compact(
                'adminsCount',
                'languagesCount',
                'categoriesCount',
                'shippingAreasCount',
                'authorsCount',
                'publishersCount',
                'booksCount',
                'allCouponsCount',
                'activeCouponsCount',
                'inactiveCouponsCount',
                'scheduledCouponsCount',
                'expiredCouponsCount',
                'usersCount',
                'messagesCount'
            ));
        });
    }
}
