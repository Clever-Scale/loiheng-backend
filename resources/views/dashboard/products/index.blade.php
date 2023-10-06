@extends('layouts.mainlayout')
@section('title', 'Product')
@section('links')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css" />
@endsection
@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <div class="pagetitle">
            <h1>Products</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                    <li class="breadcrumb-item active">Product</li>
                    <li class="breadcrumb-item active">List</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <a href="{{ route('product.create') }}" class="d-flex align-items-center btn btn-primary">
            <i class="bi bi-plus-lg"></i>&nbsp; Add
        </a>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body" style="padding: 10px 30px">
                        <h5 class="card-title">Product Table</h5>
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
                                <div class="d-flex align-items-center px-2">
                                    <div>
                                        <select id="brand_id" class="form-select">
                                            <option value="">Select Brand</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}"
                                                    {{ request()->get('brand_id') == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center px-2">
                                    <div>
                                        <select id="category_id" class="form-select">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ request()->get('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
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
                        <div class="table-responsive ">
                            <table class="table table-striped table-hover" id="productDataTable"
                                style="width: 100%; height: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">INFO</th>
                                        <th scope="col">SKU</th>
                                        <th scope="col">DISCOUNT</th>
                                        <th scope="col">PRICE</th>
                                        <th scope="col">CREATED BY</th>
                                        <th scope="col">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    @if (count($products) <= 0)
                                        <tr>
                                            <th scope="row" colspan="7">
                                                <div class="d-flex align-items-center justify-content-center"
                                                    style="height: 100%; padding: 100px 0px">
                                                    There is nothing</div>
                                            </th>
                                        </tr>
                                    @else
                                        @foreach ($products as $key => $product)
                                            <tr>
                                                <th scope="row">
                                                    <div class="d-flex align-items-center" style="height: 100%">
                                                        {{ $key + 1 }}</div>
                                                </th>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="px-2">
                                                            <img src="{{ $product->cover_img ? $product->cover_img : asset('assets/img/images.jpg') }}"
                                                                alt=""
                                                                style="object-fit: cover; width: 70px; height: 70px; border-radius: 50%">
                                                        </div>
                                                        <div>
                                                            <h5 style="text-transform: capitalize">{{ $product->name }}
                                                            </h5>
                                                            <span
                                                                class="badge rounded-pill text-bg-primary">{{ $product->stock }}
                                                                Left</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="height: 100%">
                                                        <h6 style="text-transform: capitalize">
                                                            {{ $product->sku }}
                                                        </h6>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="height: 100%">
                                                        @php
                                                            $now = today()->format('Y-m-d');
                                                            $isExpired = true;
                                                            $promo_price = 0;
                                                            if ($product->discount) {
                                                                if ($now > $product->discount->expired_date) {
                                                                    $isExpired = true;
                                                                } else {
                                                                    $isExpired = false;
                                                                }
                                                                // Promo Price
                                                                $promo_price = ($product->discount->percent / 100) * $product->price;
                                                                $promo_price = $product->price - $promo_price;
                                                            }
                                                        @endphp
                                                        @if ($product->discount)
                                                            <div style="display: flex; flex-direction: column">
                                                                <h6 style="text-transform: capitalize">
                                                                    {{ $product->discount->percent . '%' }}
                                                                    @if ($isExpired)
                                                                        <span
                                                                            class="badge rounded-pill text-bg-danger">Expired</span>
                                                                    @else
                                                                        <span
                                                                            class="badge rounded-pill text-bg-success">Active</span>
                                                                    @endif
                                                                </h6>
                                                                <span
                                                                    style="font-size: 12px">{{ 'Expired In: ' . $product->discount->expired_date }}</span>

                                                            </div>
                                                        @else
                                                            <h6 style="text-transform: capitalize">
                                                                0%
                                                            </h6>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="height: 100%">
                                                        @if ($product->discount)
                                                            <div>
                                                                <div>

                                                                    <del style="text-transform: capitalize">
                                                                        {{ number_format($product->price) }} MMK
                                                                    </del>
                                                                </div>
                                                                <h6 style="text-transform: capitalize">
                                                                    {{ number_format($promo_price) }} MMK
                                                                </h6>

                                                            </div>
                                                        @else
                                                            <h6 style="text-transform: capitalize">
                                                                {{ number_format($product->price) }} MMK</h6>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="height: 100%">
                                                        <div>
                                                            <i class="bi bi-calendar-date "></i>
                                                        </div>
                                                        <div class="px-2">
                                                            <span>{{ \Carbon\Carbon::create($product->created_at)->toFormattedDateString() }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="height: 100%">
                                                        <div class="dropdown">
                                                            <button class="btn" type="button"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="bi bi-three-dots-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu p-4">
                                                                <li>
                                                                    <div class="edit-btn mb-2" style="width: 100%">
                                                                        <a href="{{ route('product.edit', ['id' => $product->id]) }}"
                                                                            class="px-2">
                                                                            <i class="bi bi-pencil-square"></i>
                                                                            <span style="padding-left: 4px">Edit</span>
                                                                        </a>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <button type="button"
                                                                        class="btn btn-warning btn-sm mb-2"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#exampleModal{{ $product->id }}"
                                                                        style="width:100%">
                                                                        <i class="bi bi-percent"></i>
                                                                        Discount
                                                                    </button>
                                                                </li>
                                                                <li>
                                                                    <a class="btn btn-secondary btn-sm mb-2"
                                                                        style="width: 100%"
                                                                        href="{{ route('product.show', ['id' => $product->id]) }}">
                                                                        <i class="bi bi-eye"></i>
                                                                        <span style="padding-left: 4px">Show</span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <div style="width: 100%">

                                                                        <form
                                                                            action="{{ route('product.delete', ['id' => $product->id]) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <button type="submit"
                                                                                class="delete-btn  delete"
                                                                                style="width: 100%">
                                                                                <i class="bi bi-trash"></i>
                                                                                <span
                                                                                    style="padding-left: 4px">Delete</span>
                                                                            </button>
                                                                        </form>
                                                                    </div>
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
                                    <p>Showing: {{ count($products) }}</p>
                                </div>
                                <div>

                                    {{ $products->appends(request()->except('page'))->links() }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            @foreach ($products as $product)
                <div class="modal fade" id="exampleModal{{ $product->id }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Discount Product</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('promotion') }}" method="POST" novalidate
                                enctype="multipart/form-data" class="needs-validation">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group pb-1">
                                        <label for="name">Name:*</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name"
                                            value="{{ $product->discount ? $product->discount->name : '' }}" required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group pb-1">
                                        <label for="name">Percent Amount:*</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="percent"
                                            value="{{ $product->discount ? $product->discount->percent : '' }}" required
                                            maxlength="3">
                                        @error('percent')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group pb-1">
                                        <label for="name">Expired Date:*</label>
                                        <input type="date" class="form-control @error('name') is-invalid @enderror"
                                            name="expired_date"
                                            value="{{ $product->discount ? $product->discount->expired_date : '' }}"
                                            required>
                                        @error('expired_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i>
                                        &nbsp;Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection

@section('script')

    {{-- <script type="text/javascript">
        $(function() {
            var table = $('#productDataTable').DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfrtip',
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10 rows', '25 rows', '50 rows', 'Show all']
                ],
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
                ],
                // select: true,
                ajax: {
                    url: "{{ route('getproductlist') }}",
                    data: function(d) {
                        d.category_id = $('#category_id').val(),
                            d.brand_id = $('#brand_id').val(),
                            d.from_date = $('#from_date').val(),
                            d.to_date = $('#to_date').val(),
                            d.search = $('input[type="search"]').val()
                    }
                },
                columns: [{
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'sku',
                        name: 'sku'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'stock',
                        name: 'stock'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'category_id',
                        name: 'category_id'
                    },
                    {
                        data: 'brand_id',
                        name: 'brand_id'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                    },

                ]
            });
            $('#category_id').change(function() {
                table.draw();
            });
            $('#brand_id').change(function() {
                table.draw();
            });
            $('#daterange').change(function() {
                table.draw();
            });
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
    </script> --}}

    <script>
        $('input[name="daterange"]').daterangepicker({
            opens: 'left',
            drops: 'buttom',
        }, function(start, end, label) {
            var limit = $('#limit').val();
            var key = $('#myInput').val().toLowerCase();
            var brand_id = $('#brand_id').val();
            var category_id = $('#category_id').val();
            location.replace(
                `/product?${limit ? 'limit='+limit : ''}${key ? '&key='+key : ''}${brand_id ? '&brand_id='+brand_id : ''}${category_id ? '&category_id='+category_id : ''}${start ? '&from_date='+start.format('YYYY-MM-DD') : ''}${end ? '&to_date='+end.format('YYYY-MM-DD') : ''}`
            );
        });
    </script>
    <script>
        // var user = {{ Session::get('err') }};
        if ({{ Session::has('err') }}) {
            $(document).ready(function() {
                $('#exampleModal').modal('show');
            });
        }
        // console.log("This is javascript session" + user);
    </script>
    <script>
        $(document).ready(function() {
            $("#myInput").keypress(function(e) {
                var limit = $('#limit').val();
                var key = $('#myInput').val().toLowerCase();
                var brand_id = $('#brand_id').val();
                var category_id = $('#category_id').val();
                if (e.which == 13) {
                    location.replace(
                        `/product?${limit ? 'limit='+limit : ''}${key ? '&key='+key : ''}${brand_id ? '&brand_id='+brand_id : ''}${category_id ? '&category_id='+category_id : ''}`
                    );
                }
            });
            $("#limit").on('change', function() {
                var limit = $('#limit').val();
                var key = $('#myInput').val().toLowerCase();
                var brand_id = $('#brand_id').val();
                var category_id = $('#category_id').val();
                location.replace(
                    `/product?${limit ? 'limit='+limit : ''}${key ? '&key='+key : ''}${brand_id ? '&brand_id='+brand_id : ''}${category_id ? '&category_id='+category_id : ''}`
                );
            });
            $("#brand_id").on('change', function() {
                var limit = $('#limit').val();
                var key = $('#myInput').val().toLowerCase();
                var brand_id = $('#brand_id').val();
                var category_id = $('#category_id').val();
                location.replace(
                    `/product?${limit ? 'limit='+limit : ''}${key ? '&key='+key : ''}${brand_id ? '&brand_id='+brand_id : ''}${category_id ? '&category_id='+category_id : ''}`
                );
            });
            $("#category_id").on('change', function() {
                var limit = $('#limit').val();
                var key = $('#myInput').val().toLowerCase();
                var brand_id = $('#brand_id').val();
                var category_id = $('#category_id').val();
                location.replace(
                    `/product?${limit ? 'limit='+limit : ''}${key ? '&key='+key : ''}${brand_id ? '&brand_id='+brand_id : ''}${category_id ? '&category_id='+category_id : ''}`
                );
            });
            $("#clear_filter").click(function() {
                location.replace(
                    `/product`
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
