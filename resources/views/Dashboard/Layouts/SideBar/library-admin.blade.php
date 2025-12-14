<div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item"><a href="{{ route('library.home') }}"><i class="la la-home"></i><span class="menu-title"
                        data-i18n="">Home</span></a>
            </li>
            @if (auth('library-admin')->user()->is_manager)
                <li class="nav-item">
                    <a href="#"><i class="la la-user"></i><span class="menu-title"
                            data-i18n="nav.project.main">Admins</span></a>
                    <ul class="menu-content">
                        <li>
                            <a class="menu-item d-flex justify-content-between align-items-center"
                                href="{{ route('library.admins.index') }}" data-i18n="nav.project.project_summary">
                                <span>All Admins</span>
                                <span class="badge badge-info">{{$adminsCount}}</span>
                            </a>
                        </li>
                        <li>
                            <a class="menu-item d-flex justify-content-between align-items-center"
                                href="{{ route('library.admins.create') }}" data-i18n="nav.project.project_summary">
                                <span>Create Admin</span>
                                <i class="la la-plus text-info"></i>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            <li class="nav-item">
                <a href="#"><i class="la la-globe"></i><span class="menu-title"
                        data-i18n="nav.project.main">Languages</span></a>
                <ul class="menu-content">
                    <li>
                        <a class="menu-item d-flex justify-content-between align-items-center"
                            href="{{ route('library.languages.index') }}" data-i18n="nav.project.project_summary">
                            <span>All Languages</span>
                            <span class="badge badge-info">{{$languagesCount}}</span>
                        </a>
                    </li>
                    <li>
                        <a class="menu-item d-flex justify-content-between align-items-center"
                            href="{{ route('library.languages.create') }}" data-i18n="nav.project.project_summary">
                            <span>Create Language</span>
                            <i class="la la-plus text-info"></i>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#"><i class="la la-th-large"></i><span class="menu-title"
                        data-i18n="nav.project.main">Categories</span></a>
                <ul class="menu-content">
                    <li>
                        <a class="menu-item d-flex justify-content-between align-items-center"
                            href="{{ route('library.categories.index') }}" data-i18n="nav.project.project_summary">
                            <span>All Categories</span>
                            <span class="badge badge-info">{{$categoriesCount}}</span>
                        </a>
                    </li>
                    <li>
                        <a class="menu-item d-flex justify-content-between align-items-center"
                            href="{{ route('library.categories.create') }}" data-i18n="nav.project.project_summary">
                            <span>Create Category</span>
                            <i class="la la-plus text-info"></i>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#"><i class="la la-map-marker"></i><span class="menu-title"
                        data-i18n="nav.project.main">Shipping Areas</span></a>
                <ul class="menu-content">
                    <li>
                        <a class="menu-item d-flex justify-content-between align-items-center"
                            href="{{ route('library.shipping-areas.index') }}" data-i18n="nav.project.project_summary">
                            <span>All Shipping Areas</span>
                            <span class="badge badge-info">{{$shippingAreasCount}}</span>
                        </a>
                    </li>
                    <li>
                        <a class="menu-item d-flex justify-content-between align-items-center"
                            href="{{ route('library.shipping-areas.create') }}" data-i18n="nav.project.project_summary">
                            <span>Create Shipping Area</span>
                            <i class="la la-plus text-info"></i>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#"><i class="la la-user"></i><span class="menu-title"
                        data-i18n="nav.project.main">Authors</span></a>
                <ul class="menu-content">
                    <li>
                        <a class="menu-item d-flex justify-content-between align-items-center"
                            href="{{ route('library.authors.index') }}" data-i18n="nav.project.project_summary">
                            <span>All Authors</span>
                            <span class="badge badge-info">{{$authorsCount}}</span>
                        </a>
                    </li>
                    <li>
                        <a class="menu-item d-flex justify-content-between align-items-center"
                            href="{{ route('library.authors.create') }}" data-i18n="nav.project.project_summary">
                            <span>Create Author</span>
                            <i class="la la-plus text-info"></i>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#"><i class="la la-user"></i><span class="menu-title"
                        data-i18n="nav.project.main">Publishers</span></a>
                <ul class="menu-content">
                    <li>
                        <a class="menu-item d-flex justify-content-between align-items-center"
                            href="{{ route('library.publishers.index') }}" data-i18n="nav.project.project_summary">
                            <span>All Publishers</span>
                            <span class="badge badge-info">{{$publishersCount}}</span>
                        </a>
                    </li>
                    <li>
                        <a class="menu-item d-flex justify-content-between align-items-center"
                            href="{{ route('library.publishers.create') }}" data-i18n="nav.project.project_summary">
                            <span>Create Publisher</span>
                            <i class="la la-plus text-info"></i>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#"><i class="la la-book"></i><span class="menu-title"
                        data-i18n="nav.project.main">Books</span></a>
                <ul class="menu-content">
                    <li>
                        <a class="menu-item d-flex justify-content-between align-items-center"
                            href="{{ route('library.books.index') }}" data-i18n="nav.project.project_summary">
                            <span>All Books</span>
                            <span class="badge badge-info">{{$booksCount}}</span>
                        </a>
                    </li>
                    <li>
                        <a class="menu-item d-flex justify-content-between align-items-center"
                            href="{{ route('library.books.create') }}" data-i18n="nav.project.project_summary">
                            <span>Create Book</span>
                            <i class="la la-plus text-info"></i>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#"><i class="la la-gift"></i><span class="menu-title"
                        data-i18n="nav.project.main">Coupons</span></a>
                <ul class="menu-content">
                    <li>
                        <a class="menu-item d-flex justify-content-between align-items-center"
                            href="{{ route('library.coupons.index') }}" data-i18n="nav.project.project_summary">
                            <span>All Coupons</span>
                            <span class="badge badge-info">{{$allCouponsCount}}</span>
                        </a>
                    </li>
                    <li>
                        <a class="menu-item d-flex justify-content-between align-items-center"
                            href="{{ route('library.coupons.index', ['status' => App\Enums\DiscountStatus::Active->value]) }}"
                            data-i18n="nav.project.project_summary">
                            <span>Active Coupons</span>
                            <span class="badge badge-success">{{$activeCouponsCount}}</span>
                        </a>
                    </li>
                    <li>
                        <a class="menu-item d-flex justify-content-between align-items-center"
                            href="{{ route('library.coupons.index', ['status' => App\Enums\DiscountStatus::Inactive->value]) }}"
                            data-i18n="nav.project.project_summary">
                            <span>Inactive Coupons</span>
                            <span class="badge badge-secondary">{{$inactiveCouponsCount}}</span>
                        </a>
                    </li>
                    <li>
                        <a class="menu-item d-flex justify-content-between align-items-center"
                            href="{{ route('library.coupons.index', ['status' => App\Enums\DiscountStatus::Scheduled->value]) }}"
                            data-i18n="nav.project.project_summary">
                            <span>Scheduled Coupons</span>
                            <span class="badge badge-warning">{{$scheduledCouponsCount}}</span>
                        </a>
                    </li>
                    <li>
                        <a class="menu-item d-flex justify-content-between align-items-center"
                            href="{{ route('library.coupons.index', ['status' => App\Enums\DiscountStatus::Expired->value]) }}"
                            data-i18n="nav.project.project_summary">
                            <span>Expired Coupons</span>
                            <span class="badge badge-danger">{{$expiredCouponsCount}}</span>
                        </a>
                    </li>
                    <li>
                        <a class="menu-item d-flex justify-content-between align-items-center"
                            href="{{ route('library.coupons.create') }}" data-i18n="nav.project.project_summary">
                            <span>Create Coupon</span>
                            <i class="la la-plus text-info"></i>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#"><i class="la la-bolt"></i><span class="menu-title"
                        data-i18n="nav.project.main">Flash Sales</span></a>
                <ul class="menu-content">
                    <li>
                        <a class="menu-item d-flex justify-content-between align-items-center"
                            href="{{ route('library.flash-sales.index') }}" data-i18n="nav.project.project_summary">
                            <span>All Flash Sales</span>
                            <span class="badge badge-info">{{$allFlashSalesCount}}</span>
                        </a>
                    </li>
                    <li>
                        <a class="menu-item d-flex justify-content-between align-items-center"
                            href="{{ route('library.flash-sales.index', ['status' => App\Enums\DiscountStatus::Active->value]) }}"
                            data-i18n="nav.project.project_summary">
                            <span>Active Flash Sales</span>
                            <span class="badge badge-success">{{$activeFlashSalesCount}}</span>
                        </a>
                    </li>
                    <li>
                        <a class="menu-item d-flex justify-content-between align-items-center"
                            href="{{ route('library.flash-sales.index', ['status' => App\Enums\DiscountStatus::Inactive->value]) }}"
                            data-i18n="nav.project.project_summary">
                            <span>Inactive Flash Sales</span>
                            <span class="badge badge-secondary">{{$inactiveFlashSalesCount}}</span>
                        </a>
                    </li>
                    <li>
                        <a class="menu-item d-flex justify-content-between align-items-center"
                            href="{{ route('library.flash-sales.index', ['status' => App\Enums\DiscountStatus::Scheduled->value]) }}"
                            data-i18n="nav.project.project_summary">
                            <span>Scheduled Flash Sales</span>
                            <span class="badge badge-warning">{{$scheduledFlashSalesCount}}</span>
                        </a>
                    </li>
                    <li>
                        <a class="menu-item d-flex justify-content-between align-items-center"
                            href="{{ route('library.flash-sales.index', ['status' => App\Enums\DiscountStatus::Expired->value]) }}"
                            data-i18n="nav.project.project_summary">
                            <span>Expired Flash Sales</span>
                            <span class="badge badge-danger">{{$expiredFlashSalesCount}}</span>
                        </a>
                    </li>
                    <li>
                        <a class="menu-item d-flex justify-content-between align-items-center"
                            href="{{ route('library.flash-sales.create') }}" data-i18n="nav.project.project_summary">
                            <span>Create Flash Sale</span>
                            <i class="la la-plus text-info"></i>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('library.users.index') }}"
                    class="d-flex justify-content-between align-items-center">
                    <span><i class="la la-user"></i> Users</span>
                    <span class="badge badge-info">{{$usersCount}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('library.contacts.index') }}"
                    class="d-flex justify-content-between align-items-center">
                    <span><i class="la la-envelope"></i> Contacts</span>
                    <span class="badge badge-info">{{$messagesCount}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('library.settings.index') }}"
                    class="d-flex justify-content-between align-items-center">
                    <span><i class="la la-cog"></i> Settings</span>
                </a>
            </li>

        </ul>
    </div>
</div>
