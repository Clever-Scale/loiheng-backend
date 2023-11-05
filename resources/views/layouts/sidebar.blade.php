<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ Request::is('/') ? '' : 'collapsed' }}" href="{{ route('homepage') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('orders') ? '' : 'collapsed' }}" href="{{ route('orders') }}">
                <i class="bi bi-cart3"></i>
                <span>Orders</span>
                <div style="padding-left: 40px">
                    <span class="badge text-bg-danger">
                        <span id="order-count"></span>
                        <span>News</span>
                    </span>
                </div>
            </a>
        </li>

        <li class="nav-heading">Pages</li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('category') || request()->routeIs('category.create') || request()->routeIs('category.edit') || request()->routeIs('coupon-code') || request()->routeIs('coupon-code.create') || request()->routeIs('brand') || request()->routeIs('brand.edit') || request()->routeIs('brand.create') || request()->routeIs('product') || request()->routeIs('product.edit') || request()->routeIs('product.show') || request()->routeIs('product.create') ? '' : 'collapsed' }}"
                data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Catalogs</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav"
                class="nav-content {{ request()->routeIs('category') || request()->routeIs('category.create') || request()->routeIs('category.edit') || request()->routeIs('coupon-code') || request()->routeIs('coupon-code.create') || request()->routeIs('brand') || request()->routeIs('brand.edit') || request()->routeIs('brand.create') || request()->routeIs('product') || request()->routeIs('product.edit') || request()->routeIs('product.show') || request()->routeIs('product.create') ? '' : 'collapse' }} "
                data-bs-parent="#sidebar-nav">

                <li>
                    <a href="{{ route('category') }}">
                        <i class="bi bi-receipt" style="font-size: 20px"></i><span>Categories</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('brand') }}">
                        <i class="bi bi-type-bold" style="font-size: 20px"></i><span>Brands</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('product') }}">
                        <i class="bi bi-tags" style="font-size: 20px"></i><span>Products</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('coupon-code') }}">
                        <i class="bi bi-cash-coin" style="font-size: 20px"></i><span>Coupon Code</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link  {{ request()->routeIs('banner-slider') || request()->routeIs('banner-slider.edit') ? '' : 'collapsed' }}"
                href="{{ route('banner-slider') }}">
                <i class="bi bi-card-image"></i>
                <span>Banners</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link  {{ request()->routeIs('reviews') ? '' : 'collapsed' }}" href="{{ route('reviews') }}">
                <i class="bi bi-star-half"></i>
                <span>Product Reviews</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link  {{ request()->routeIs('customer') || request()->routeIs('customer.edit') ? '' : 'collapsed' }}"
                href="{{ route('customer') }}">
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
            <a class="nav-link {{ request()->routeIs('delivery') || request()->routeIs('delivery.edit') ? '' : 'collapsed' }}"
                href="{{ route('delivery') }}">
                <i class="bi bi-truck
                "></i>
                <span>Deliveries</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('company') ? '' : 'collapsed' }}" href="{{ route('company') }}">
                <i class="bi bi-person"></i>
                <span>Company Profile</span>
            </a>
        </li>



        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('contact') ? '' : 'collapsed' }}" href="{{ route('contact') }}">
                <i class="bi bi-envelope"></i>
                <span>Contact</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('settings') || request()->routeIs('settings.edit') ? '' : 'collapsed' }}"
                href="{{ route('settings') }}">
                <i class="bi bi-gear"></i>
                <span>Settings</span>
            </a>
        </li><!-- End Contact Page Nav -->



    </ul>

</aside>
<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('d65532ac94059367b333', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('my-order-channel');
    var order = {!! \App\Models\Order::where('is_seen', '!=', 1)->count() !!}

    if (order) {
        document.getElementById('order-count').innerHTML = order;
    } else {
        document.getElementById('order-count').innerHTML = 0;
    }
    channel.bind('my-order', function(data) {
        if (data) {
            const newOrder = document.getElementById('order-count').innerHTML;
            Swal.fire({
                position: 'top-end',
                iconHtml: '<i class="bi bi-bell" style="color: green"></i>',
                title: 'User ordered!',
                showConfirmButton: false,
                timer: 1500
            })
            document.getElementById('order-count').innerHTML = +newOrder + 1;

        }
    });
</script>
