<div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item"><a href="{{ route('dashboard.home') }}"><i class="la la-home"></i><span class="menu-title"
                        data-i18n="">Home</span></a>
            </li>
            <li class=" nav-item"><a href="#"><i class="la la-book"></i><span class="menu-title"
                        data-i18n="nav.project.main">Libraries</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{ route('dashboard.libraries.index') }}"
                            data-i18n="nav.project.project_summary">All Libraries</a>
                    </li>
                    <li><a class="menu-item" href="{{ route('dashboard.libraries.index', ['status' => 1]) }}"
                            data-i18n="nav.project.project_summary">Active Libraries</a>
                    </li>
                    <li><a class="menu-item" href="{{ route('dashboard.libraries.index', ['status' => 0]) }}"
                            data-i18n="nav.project.project_summary">Inactive Libraries</a>
                    </li>
                    <li><a class="menu-item" href="{{ route('dashboard.libraries.create') }}"
                            data-i18n="nav.project.project_summary">Create Library</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
