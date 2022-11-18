<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ Request::is('/') ? '' : 'collapsed' }}" href="{{ route('homepage') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-heading">Pages</li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('category') || request()->routeIs('category.create') || request()->routeIs('category.edit') ? '' : 'collapsed' }}"
                data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Catalog</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('product') }}">
                        <i class="bi bi-circle"></i><span>Products</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('category') }}">
                        <i class="bi bi-circle"></i><span>Categories</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- <li class="nav-item">
            <a class="nav-link {{ Request::is('category') ? '' : 'collapsed' }}" href="/">
                <i class="bi bi-person"></i>
                <span>Customers</span>
            </a>
        </li> --}}
        <li class="nav-item">
            <a class="nav-link collapsed" href="/">
                <i class="bi bi-person"></i>
                <span>Customers</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('user') || request()->routeIs('user.edit') ? '' : 'collapsed' }}"
                href="{{ route('user') }}">
                <i class="bi bi-shield-fill-check
                "></i>
                <span>Users</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="/">
                <i class="bi bi-card-heading"></i>
                <span>Posts</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('brand') || request()->routeIs('brand.edit') || request()->routeIs('brand.create') ? '' : 'collapsed' }}"
                href="{{ route('brand') }}">
                <i class="bi bi-flower3"></i>
                <span>Brands</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="/">
                <i class="bi bi-cart3"></i>
                <span>Orders</span>
            </a>
        </li>



        <li class="nav-item">
            <a class="nav-link collapsed" href="">
                <i class="bi bi-envelope"></i>
                <span>Contact</span>
            </a>
        </li><!-- End Contact Page Nav -->

    </ul>

</aside>
