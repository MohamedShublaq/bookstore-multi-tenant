<section class="hero-section">
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="">
                    <img src="{{ asset('assets/Website/images/logo.png') }}" alt="" />
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars text-light"></i>
                    <!-- <span class="navbar-toggler-icon "></span> -->
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ tenant_route('website.home') }}">Home</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ tenant_route('books') }}">Books</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{tenant_route('aboutUs')}}">About us</a>
                        </li> --}}
                    </ul>
                    <div class="d-flex gap-4 align-items-center">
                        <div class="profile d-flex gap-4 align-items-center">
                            <a href="#" class="wishlist-link">
                                <span>5</span>
                                <i class="fa-regular fa-heart fs-3"></i>
                            </a>
                            <a href="#" class="cart-link">
                                <span>3</span>
                                <i class="fa-solid fa-cart-shopping fs-3"></i>
                            </a>
                            @auth
                                <div class="dropdown">
                                    <button
                                        class="dropdown-toggle d-flex align-items-center border-0 profile_dropdown gap-2"
                                        type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <div class="profile_image">
                                            <img src="{{ asset('assets/Website/images/commentimage.jpeg') }}" alt=""
                                                class="w-100 h-100" />
                                        </div>
                                        <div class="flex-column align-items-start">
                                            <p class="fs-6 fw-bold text-light text-start">

                                            </p>
                                            <p class="text-secondary">{{ auth()->user()->email }}</p>
                                        </div>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        {{-- <li>
                                            <a class="dropdown-item" href="{{ route('profile') }}">Profile</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="orders.html">Order History</a>
                                        </li> --}}
                                        <li>
                                            <form action="{{ tenant_route('logout') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item">Log Out</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @endauth
                        </div>
                        @guest
                            <div class="d-flex gap-3">
                                <a class="main_btn login_btn" href="{{ tenant_route('showLogin') }}" type="button">Log in</a>
                                <a class="primary_btn" href="{{ tenant_route('website.showRegister') }}" type="button">Sign Up</a>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>
        <div class="overlay"></div>
    </header>
    @yield('hero_content')
</section>
