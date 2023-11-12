@extends('layouts.mainlayout')
@section('title', 'Order')
@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <div class="pagetitle">
            <h1>Order</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                    <li class="breadcrumb-item active">Order</li>
                    <li class="breadcrumb-item active">List</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body" style="padding: 10px 30px">
                        <h5 class="card-title">Order Table </h5>
                        <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="pr-2">
                                        <h5>Filters : </h5>
                                    </div>
                                    <div>
                                        <select id="limit" class="form-select">
                                            <option value="10" {{ request()->get('limit') == '10' ? 'selected' : '' }}>
                                                10
                                                Rows
                                            </option>
                                            <option value="20" {{ request()->get('limit') == '20' ? 'selected' : '' }}>
                                                20
                                                Rows
                                            </option>
                                            <option value="50" {{ request()->get('limit') == '50' ? 'selected' : '' }}>
                                                50
                                                Rows
                                            </option>
                                            <option value="100" {{ request()->get('limit') == '100' ? 'selected' : '' }}>
                                                100
                                                Rows
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="px-2">
                                    <select id="status" class="form-select" aria-label="Default select example">
                                        <option value="" {{ request()->get('status') == '' ? 'selected' : '' }}>Select
                                            Status</option>
                                        <option value="pending"
                                            {{ request()->get('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirm"
                                            {{ request()->get('status') == 'confirm' ? 'selected' : '' }}>Confirm</option>
                                        <option value="ontheway"
                                            {{ request()->get('status') == 'ontheway' ? 'selected' : '' }}>On The Way
                                        </option>
                                        <option value="complete"
                                            {{ request()->get('status') == 'complete' ? 'selected' : '' }}>Complete</option>
                                    </select>
                                </div>
                                <div style="display: flex; flex-direction: column; justify-content:end; align-items:start; height: 100%"
                                    class="px-2">
                                    <input type="text" class="form-control" name="daterange" id="daterange" />
                                    <div id="from"></div>
                                    <div id="to"></div>
                                </div>
                                <div>
                                    <button class="btn btn-danger" id="clear_filter">Clear Filter</button>
                                </div>

                            </div>
                            <div>
                                <input type="text" id="myInput" value="{{ request()->get('key') }}"
                                    class="form-control" placeholder="Search.....">
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="orderDataTable"
                                style="width: 100%; height: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">ORDER NO</th>
                                        <th scope="col">USER</th>
                                        <th scope="col">TOTAL PRICE</th>
                                        <th scope="col">PAYMENT</th>
                                        <th scope="col">STATUS</th>
                                        <th scope="col">CREATED AT</th>
                                        <th scope="col">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($orders) <= 0)
                                        <tr>
                                            <th scope="row" colspan="8">
                                                <div class="d-flex align-items-center justify-content-center"
                                                    style="height: 100%; padding: 100px 0px">
                                                    There is nothing</div>
                                            </th>
                                        </tr>
                                    @else
                                        @foreach ($orders as $key => $order)
                                            <tr>
                                                <th scope="row">
                                                    <div class="d-flex align-items-center" style="height: 100%">
                                                        {{ $key + 1 }}</div>
                                                </th>
                                                <td>
                                                    <div class="d-flex align-items-center" style="height: 100%">
                                                        {{ $order->order_no }}</div>
                                                </td>
                                                <td>
                                                    <a href="{{ route('user.edit', ['id' => $order->user->id]) }}">
                                                        <div class="d-flex align-items-center" style="height: 100%">
                                                            <img src="{{ asset($order->user->profile_img ?? 'assets/img/logo-only.png') }}"
                                                                alt="Profile Image"
                                                                style="border-radius: 50%, width: 50px; height: 40px">
                                                            <div style="display: flex; flex-direction: column">
                                                                <span style="color: #000; font-weight: 600">
                                                                    {{ $order->user->fullname }}</span>
                                                                <span> {{ $order->user->email }}</span>

                                                            </div>

                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center"
                                                        style="height: 100%; color: #000; font-weight: 600">
                                                        {{ number_format($order->total_price) }} MMK</div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="height: 100%">
                                                        {{ $order->payment_method }}</div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center"
                                                        style="height: 100%; text-transform: capitalize">
                                                        @if ($order->status == 'pending')
                                                            <span
                                                                class="badge rounded-pill text-bg-primary">{{ $order->status }}</span>
                                                        @elseif ($order->status == 'confirm')
                                                            <span
                                                                class="badge rounded-pill text-bg-warning">{{ $order->status }}</span>
                                                        @elseif ($order->status == 'ontheway')
                                                            <span
                                                                class="badge rounded-pill text-bg-info">{{ $order->status }}</span>
                                                        @elseif ($order->status == 'complete')
                                                            <span
                                                                class="badge rounded-pill text-bg-success">{{ $order->status }}</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="height: 100%">
                                                        <div>
                                                            <i class="bi bi-calendar-date mx-2"></i>
                                                        </div>
                                                        <div class="px-2 ">
                                                            {{ \Carbon\Carbon::create($order->created_at)->toFormattedDateString() }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="height: 100%">
                                                        <div class="dropdown">
                                                            <button class="btn" type="button" data-bs-toggle="dropdown"
                                                                aria-expanded="false">
                                                                <i class="bi bi-three-dots-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu p-4">
                                                                <li>
                                                                    <a class="btn btn-secondary btn-sm mb-2"
                                                                        style="width: 100%"
                                                                        href="{{ route('orders.show', ['id' => $order->id]) }}">
                                                                        <i class="bi bi-eye"></i>
                                                                        <span style="padding-left: 4px">Show</span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

                                </tbody>
                            </table>
                            <div class="d-flex justify-content-between align-items-center py-2">
                                <div>
                                    <p><b>Showing:</b> {{ count($orders) }} </p>
                                </div>
                                <div>

                                    {{ $orders->appends(request()->except('page'))->links() }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('script')

    <script>
        $('input[name="daterange"]').daterangepicker({
            opens: 'left',
            drops: 'buttom',
        }, function(start, end, label) {
            var limit = $('#limit').val();
            var key = $('#myInput').val().toLowerCase();
            var status = $('#status').val();
            location.replace(
                `/orders?${limit ? 'limit='+limit : ''}${key ? '&key='+key : ''}${status ? '&status='+status : ''}${start ? '&from_date='+start.format('YYYY-MM-DD') : ''}${end ? '&to_date='+end.format('YYYY-MM-DD') : ''}`
            );
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#myInput").keypress(function(e) {
                var limit = $('#limit').val();
                var key = $('#myInput').val().toLowerCase();
                var status = $('#status').val();
                if (e.which == 13) {
                    location.replace(
                        `/orders?${limit ? 'limit='+limit : ''}${key ? '&key='+key : ''}${status ? '&status='+status : ''}`
                    );
                }
            });
            $("#limit").on('change', function() {
                var limit = $('#limit').val();
                var key = $('#myInput').val().toLowerCase();
                var status = $('#status').val();
                location.replace(
                    `/orders?${limit ? 'limit='+limit : ''}${key ? '&key='+key : ''}${status ? '&status='+status : ''}`
                );
            });
            $("#status").on('change', function() {
                var limit = $('#limit').val();
                var key = $('#myInput').val().toLowerCase();
                var status = $('#status').val();
                location.replace(
                    `/orders?${limit ? 'limit='+limit : ''}${key ? '&key='+key : ''}${status ? '&status='+status : ''}`
                );
            });
            $("#clear_filter").click(function() {
                location.replace(
                    `/orders`
                );
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $('#productDataTable').on('click', 'button.delete', function(e) {
                // console.log(e);
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete record",
                    icon: 'warning',
                    showCancelButton: true,
                    timer: 4000,
                    timerProgressBar: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(e.target).closest('form').submit() // Post the surrounding form
                    }
                })
            });
        });
    </script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.5.0/js/dataTables.select.min.js"></script>
@endsection
