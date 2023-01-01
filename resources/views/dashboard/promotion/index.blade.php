@extends('layouts.mainlayout')
@section('title', 'Promotion')
@section('links')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css" />
@endsection
@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <div class="pagetitle">
            <h1>Promotion Page</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                    <li class="breadcrumb-item active">Promotion</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Promotion List </h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="promotionDataTable"
                                style="width: 100%; height: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Product Image</th>
                                        <th scope="col">Product</th>
                                        <th scope="col"> Price</th>
                                        <th scope="col">Percent</th>
                                        <th scope="col">Promo Price</th>
                                        <th scope="col">Created By</th>
                                        <th scope="col">CREATED AT</th>
                                        <th scope="col">ACTION</th>
                                    </tr>
                                </thead>
                            </table>
                            @foreach ($promotion as $promo)
                                <div class="modal fade" id="exampleModal{{ $promo->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Discount Product</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('promo.update', ['id' => $promo->id]) }}" method="POST"
                                                novalidate enctype="multipart/form-data" class="needs-validation">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="form-group pb-1">
                                                        <label for="name">Name:*</label>
                                                        <input type="text"
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            name="name" required value="{{ $promo->name }}">
                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group pb-1">
                                                        <label for="name">Percent Amount:*</label>
                                                        <input type="text"
                                                            class="form-control @error('percent') is-invalid @enderror"
                                                            name="percent" required value="{{ $promo->percent }}">
                                                        @error('percent')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group pb-1">
                                                        <label for="name">Expired Date:*</label>
                                                        <input type="date"
                                                            class="form-control @error('expired_date') is-invalid @enderror"
                                                            name="expired_date" required value="{{ $promo->expired_date }}">
                                                        @error('expired_date')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <input type="hidden" name="product_id"
                                                        value="{{ $promo->product_id }}">
                                                    <input type="hidden" name="user_id" value="{{ $promo->user_id }}">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary"><i
                                                            class="bi bi-check-circle"></i>
                                                        &nbsp;Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('script')
    <script type="text/javascript">
        $(function() {
            var table = $('#promotionDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('promo.list') }}",
                columns: [{
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'product_img',
                        name: 'product_img'
                    },
                    {
                        data: 'product_id',
                        name: 'product_id'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'percent',
                        name: 'percent'
                    },
                    {
                        data: 'promo_price',
                        name: 'promo_price'
                    },

                    {
                        data: 'user_id',
                        name: 'user_id',
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
            $('#daterange').change(function() {
                table.draw();
            });
            $('#promotionDataTable').on('click', 'button.delete', function(e) {
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
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.5.0/js/dataTables.select.min.js"></script>

@endsection
