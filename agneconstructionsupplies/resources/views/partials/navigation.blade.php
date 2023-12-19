<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <img src="{{ asset('storage/logo/ACST-logo.png') }}" class="overflow-auto me-3" alt="" height="60px"> 
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config("app.name", "Agne Construction Supplies") }}
        </a>
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="{{ __('Toggle navigation') }}"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto"></ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest 
                
                    @if (Route::has('login'))
                    <li class="nav-item btn btn-primary p-1 m-1">
                        <a
                            class="nav-link text-light"
                            href="{{ route('login') }}"
                            >{{ __("Login") }}</a
                        >
                    </li>
                    @endif 
                    
                    @if (Route::has('register'))
                    <li class="nav-item btn btn-outline-secondary p-1 m-1">
                        <a class="nav-link" href="{{ route('register') }}">{{
                            __("Register")
                        }}</a>
                    </li>
                    @endif 
                
                @else
                <div class="d-flex align-items-center">
                    @if(Auth::user()->user_type == 'user')
                    <li class="nav-item px-2">
                        <a href="/cart" class="position-relative">
                            <img src="{{ asset('storage/icons/shopping-cart.svg')}}" alt="" class="position-relative" />
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ Session::get('cart_count') }}
                            </span>
                        </a>
                    </li>
                    <li class="nav-item px-2">
                        <a href="/wishlist" class="position-relative">
                            <img src="{{ asset('storage/icons/heart.svg') }}" alt="" class="position-relative" />
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ Session::get('wishlist_count') }}
                            </span>
                        </a>
                    </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a
                            id="navbarDropdown"
                            class="nav-link dropdown-toggle"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                            v-pre
                        >
                            {{ Auth::user()->firstname }}
                        </a>

                        <div
                            class="dropdown-menu dropdown-menu-end"
                            aria-labelledby="navbarDropdown"
                        >
                            <a href="/addresses" class="dropdown-item"
                                >Addresses</a
                            >
                            <a href="/orders" class="dropdown-item"
                                >Order History</a
                            >
                            <a
                                class="dropdown-item"
                                href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();"
                            >
                                {{ __("Logout") }}
                            </a>

                            <form
                                id="logout-form"
                                action="{{ route('logout') }}"
                                method="POST"
                                class="d-none"
                            >
                                @csrf
                            </form>
                        </div>
                    </li>
                </div>
                @endguest
            </ul>
        </div>
    </div>
</nav>
