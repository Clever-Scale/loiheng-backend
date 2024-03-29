<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>LOI HENG - @yield('title')</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    {{-- <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon"> --}}

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Summer Note start --}}
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    {{-- Summer Note end --}}

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <style>
        /* For summernote override unordered and order list */
        .note-editable ul {
            list-style: disc !important;
            list-style-position: inside !important;
        }

        .note-editable ol {
            list-style: decimal !important;
            list-style-position: inside !important;
        }

        table,
        td {
            min-height: 80px;
        }
    </style>

    @yield('links')
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route('homepage') }}" class="logo d-flex align-items-center">
                <img src="{{ asset('assets/img/logo-only.png') }}" alt="">
                <span class="d-none d-lg-block">LOI HENG</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        {{-- <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div> --}}
        <!-- End Search Bar -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->

                <li class="nav-item dropdown">


                    <?php
                    $tmp = \App\Models\Contact::where('is_seen', '!=', 1)->count();
                    $contacts = \App\Models\Contact::where('is_seen', '!=', 1)->get();
                    ?>
                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-danger badge-number" id="noti-count">{{ $tmp }}</span>
                    </a><!-- End Notification Icon -->
                    @if ($tmp > 0)
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                            <li class="dropdown-header">
                                You have new notifications
                                {{-- <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a> --}}
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <div id="new-noti"></div>
                            @if ($tmp > 0)
                                @if ($tmp < 4)
                                    @foreach ($contacts as $contact)
                                        <li class="notification-item">
                                            <a href="{{ route('contact') }}"
                                                style="padding-left: 10px; text-decoration: none">
                                                <h4 style="text-transform: capitalize">{{ $contact->name }}</h4>
                                                <p
                                                    style="white-space: nowrap;
                                            width: 150px;
                                            overflow: hidden;
                                            text-overflow: ellipsis;">
                                                    {{ $contact->description }}</p>
                                                <p>{{ $contact->created_at }}</p>
                                            </a>
                                        </li>

                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                    @endforeach
                                @else
                                    @for ($i = 0; $i < 3; $i++)
                                        <li class="notification-item">
                                            <a href="{{ route('contact') }}"
                                                style="padding-left: 10px; text-decoration: none">
                                                <h4 style="text-transform: capitalize">{{ $contacts[$i]->name }}</h4>
                                                <p
                                                    style="white-space: nowrap;
                                            width: 150px;
                                            overflow: hidden;
                                            text-overflow: ellipsis;">
                                                    {{ $contacts[$i]->description }}</p>
                                                <p>{{ \Carbon\Carbon::create($contacts[$i]->created_at)->toFormattedDateString() }}
                                                </p>
                                            </a>
                                        </li>

                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                    @endfor
                                @endif
                            @endif

                        </ul><!-- End Notification Dropdown Items -->
                    @else
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                            <li class="dropdown-header">
                                You have no new notifications
                                {{-- <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a> --}}
                            </li>

                        </ul>
                    @endif

                </li><!-- End Notification Nav -->



                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown">
                        <img src="{{ asset(Auth::user()->profile_img ? Auth::user()->profile_img : 'assets/img/pp.jpg') }}"
                            alt="Profile"
                            style="border-radius: 50%; width: 50px; height: 50px; position: relative; object-fit: cover">
                        {{-- <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span> --}}
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ Auth::user()->fullname }}</h6>
                            {{-- <span>{{ Auth::user()->type }}</span> --}}
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center"
                                href="{{ route('user.edit', ['id' => Auth::user()->id]) }}">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    @include('layouts.sidebar')
    <!-- End Sidebar-->

    <main id="main" class="main">
        @include('sweetalert::alert')
        @yield('content')

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    @include('layouts.footer')
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('d65532ac94059367b333', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('my-contact-channel');
        var contact = document.getElementById('noti-count').innerHTML;
        document.getElementById('noti-count').innerHTML = contact;
        channel.bind('my-contact-event', function(data) {
            if (data) {
                var newCount = document.getElementById('noti-count').innerHTML;
                document.getElementById('noti-count').innerHTML = +newCount + 1;
                document.getElementById('new-noti').innerHTML = `<li class="notification-item">
                                    <a href="{{ route('contact') }}" style="padding-left: 10px; text-decoration: none">
                                        <h4  style="text-transform: capitalize">${data.contact.name}</h4>
                                        <p style="white-space: nowrap;
                                        width: 150px;
                                        overflow: hidden;
                                        text-overflow: ellipsis;">${data.contact.description}</p>
                                        <p>${data.contact.created_at}</p>
                                    </a>
                                </li>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>`;
            }
        });
    </script>
    @yield('script')
</body>

</html>
