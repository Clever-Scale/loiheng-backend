@extends('layouts.mainlayout')
@section('title', 'Product')
@section('links')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css" />
@endsection
@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <div class="pagetitle">
            <h1>Product Page</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                    <li class="breadcrumb-item active">Product</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <a href="{{ route('product.create') }}" class="d-flex align-items-center btn btn-primary">
            <i class="bi bi-plus-lg"></i>&nbsp; Add
        </a>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Product Filter</div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="category" style="font-weight: 700">Category:</label>
                                    <select id="category_id" class="form-select" aria-label="Default select example">
                                        <option value="0">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="category" style="font-weight: 700">Brand:</label>
                                    <select id="brand_id" class="form-select" aria-label="Default select example">
                                        <option value="0">Select Brand</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="category" style="font-weight: 700">Date Range Picker:</label>
                                    <div
                                        style="display: flex; flex-direction: column; justify-content:end; align-items:start; height: 100%">
                                        <input type="text" class="form-control" name="daterange" id="daterange" />
                                        <div id="from"></div>
                                        <div id="to"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Product List </h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="productDataTable"
                                style="width: 100%; height: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        {{-- <th scope="col">Cover</th> --}}
                                        <th scope="col">SKU</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Stock</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Brand</th>
                                        <th scope="col">Created By</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                            </table>
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
                            <form action="{{ route('promotion') }}" method="POST" novalidate enctype="multipart/form-data"
                                class="needs-validation">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group pb-1">
                                        <label for="name">Name:*</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group pb-1">
                                        <label for="name">Percent Amount:*</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="percent" required>
                                        @error('percent')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group pb-1">
                                        <label for="name">Expired Date:*</label>
                                        <input type="date" class="form-control @error('name') is-invalid @enderror"
                                            name="expired_date" required>
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

    <script type="text/javascript">
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
                    // {
                    //     data: 'cover_img',
                    //     name: 'cover_img'
                    // },
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
    </script>

    <script>
        $('input[name="daterange"]').daterangepicker({
            opens: 'left',
            drops: 'buttom',
        }, function(start, end, label) {
            document.getElementById("from").innerHTML =
                `<input name='from_date' id="from_date" type='date' value="${start.format('YYYY-MM-DD') }" hidden />`;
            document.getElementById("to").innerHTML =
                `<input name='to_date' id="to_date" type='date' value="${end.format('YYYY-MM-DD')}" hidden/>`;
            // console.log(start.format('YYYY-MM-DD'));
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
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.5.0/js/dataTables.select.min.js"></script>
@endsection
