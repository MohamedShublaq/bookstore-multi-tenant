<div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item"><a href="{{ route('library.home') }}"><i class="la la-home"></i><span class="menu-title"
                        data-i18n="">Home</span></a>
            </li>
            @if (auth('library-admin')->user()->is_manager)
                <li class=" nav-item"><a href="#"><i class="la la-user"></i><span class="menu-title"
                            data-i18n="nav.project.main">Admins</span></a>
                    <ul class="menu-content">
                        <li><a class="menu-item" href="{{ route('library.admins.index') }}"
                                data-i18n="nav.project.project_summary">All Admins</a>
                        </li>
                        <li><a class="menu-item" href="{{ route('library.admins.create') }}"
                                data-i18n="nav.project.project_summary">Create Admin</a>
                        </li>
                    </ul>
                </li>
            @endif
            <li class=" nav-item"><a href="#"><i class="la la-globe"></i><span class="menu-title"
                        data-i18n="nav.project.main">Languages</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{ route('library.languages.index') }}"
                            data-i18n="nav.project.project_summary">All Languages</a>
                    </li>
                    <li><a class="menu-item" href="{{ route('library.languages.create') }}"
                            data-i18n="nav.project.project_summary">Create Language</a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a href="#"><i class="la la-th-large"></i><span class="menu-title"
                        data-i18n="nav.project.main">Categories</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{ route('library.categories.index') }}"
                            data-i18n="nav.project.project_summary">All Categories</a>
                    </li>
                    <li><a class="menu-item" href="{{ route('library.categories.create') }}"
                            data-i18n="nav.project.project_summary">Create Category</a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a href="#"><i class="la la-map-marker"></i><span class="menu-title"
                        data-i18n="nav.project.main">Shipping Areas</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{ route('library.shipping-areas.index') }}"
                            data-i18n="nav.project.project_summary">All Shipping Areas</a>
                    </li>
                    <li><a class="menu-item" href="{{ route('library.shipping-areas.create') }}"
                            data-i18n="nav.project.project_summary">Create Shipping Area</a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a href="#"><i class="la la-user"></i><span class="menu-title"
                        data-i18n="nav.project.main">Authors</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{ route('library.authors.index') }}"
                            data-i18n="nav.project.project_summary">All Authors</a>
                    </li>
                    <li><a class="menu-item" href="{{ route('library.authors.create') }}"
                            data-i18n="nav.project.project_summary">Create Author</a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a href="#"><i class="la la-user"></i><span class="menu-title"
                        data-i18n="nav.project.main">Publishers</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{ route('library.publishers.index') }}"
                            data-i18n="nav.project.project_summary">All Publishers</a>
                    </li>
                    <li><a class="menu-item" href="{{ route('library.publishers.create') }}"
                            data-i18n="nav.project.project_summary">Create Publisher</a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a href="#"><i class="la la-book"></i><span class="menu-title"
                        data-i18n="nav.project.main">Books</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{ route('library.books.index') }}"
                            data-i18n="nav.project.project_summary">All Books</a>
                    </li>
                    <li><a class="menu-item" href="{{ route('library.books.create') }}"
                            data-i18n="nav.project.project_summary">Create Book</a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a href="#"><i class="la la-book"></i><span class="menu-title"
                        data-i18n="nav.project.main">Coupons</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{ route('library.coupons.index') }}"
                            data-i18n="nav.project.project_summary">All Coupons</a>
                    </li>
                    <li><a class="menu-item" href="{{ route('library.coupons.index', ['status' => App\Enums\DiscountStatus::Active->value]) }}"
                            data-i18n="nav.project.project_summary">Active Coupons</a>
                    </li>
                    <li><a class="menu-item" href="{{ route('library.coupons.index', ['status' => App\Enums\DiscountStatus::Inactive->value]) }}"
                            data-i18n="nav.project.project_summary">Inactive Coupons</a>
                    </li>
                    <li><a class="menu-item" href="{{ route('library.coupons.index', ['status' => App\Enums\DiscountStatus::Scheduled->value]) }}"
                            data-i18n="nav.project.project_summary">Scheduled Coupons</a>
                    </li>
                    <li><a class="menu-item" href="{{ route('library.coupons.index', ['status' => App\Enums\DiscountStatus::Expired->value]) }}"
                            data-i18n="nav.project.project_summary">Expired Coupons</a>
                    </li>
                    <li><a class="menu-item" href="{{ route('library.coupons.create') }}"
                            data-i18n="nav.project.project_summary">Create Coupon</a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a href="{{ route('library.users.index') }}"><i class="la la-user"></i><span
                    class="menu-title" data-i18n="">Users</span></a>
            </li>
            <li class=" nav-item"><a href="{{ route('library.contacts.index') }}"><i class="la la-envelope"></i><span
                    class="menu-title" data-i18n="">Contacts</span></a>
            </li>
        </ul>
    </div>
</div>
