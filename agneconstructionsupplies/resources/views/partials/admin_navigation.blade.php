<nav class="navigation">
    <ul>
        <li>
            <a href="" class="logo">
                <img src="{{ asset('storage/logo/ACST-logo.png') }}" alt="" />
                <span class="navi-item">Agne Construction Supplies</span>
            </a>
        </li>
        <li>
            <a
                href="/"
                class="{{ request()->is('home') ? 'bg bg-primary bg-opacity-50' : '' }}"
            >
                <i class="fas fa-chart-bar"></i>
                <span class="navi-item">Dashboard</span>
            </a>
        </li>
        <li>
            <a
                href="/manage_product"
                class="{{ request()->is('manage_product') ? 'bg bg-primary bg-opacity-50' : '' }}"
            >
                <i class="fas fa-microchip"></i>
                <span class="navi-item">Manage Products</span>
            </a>
        </li>
        <li>
            <a
                href="/manage_category"
                class="{{ request()->is('manage_category') ? 'bg bg-primary bg-opacity-50' : '' }}"
            >
                <i class="fas fa-cog"></i>
                <span class="navi-item">Manage Category</span>
            </a>
        </li>
        <li>
            <a
                href="/manage_order"
                class="{{ request()->is('manage_order') ? 'bg bg-primary bg-opacity-50' : '' }}"
            >
                <i class="fas fa-book"></i>
                <span class="navi-item">Manage Orders</span>
            </a>
        </li>
        <li>
            <a
                href="/manage_user"
                class="{{ request()->is('manage_user') ? 'bg bg-primary bg-opacity-50' : '' }}"
            >
                <i class="fas fa-users"></i>
                <span class="navi-item">Manage Users</span>
            </a>
        </li>
        <li>
            <a
                href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="logout bg-danger"
            >
                <i class="fas fa-sign-out-alt text-white"></i>
                <span class="navi-item text-white">{{ __("Logout") }}</span>
            </a>
        </li>
        <form
            id="logout-form"
            action="{{ route('logout') }}"
            method="POST"
            class="d-none"
        >
            @csrf
        </form>
    </ul>
</nav>
