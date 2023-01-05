@extends('layouts.mainlayout')
@section('title', 'Order')
@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <div class="pagetitle">
            <h1>Order Page</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                    <li class="breadcrumb-item active">Order</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Order Filter</div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status" style="font-weight: 700">Order Status:</label>
                                    <select id="status" class="form-select" aria-label="Default select example">
                                        <option value="0">Select Status</option>
                                        <option value="pending">Pending</option>
                                        <option value="confirm">Confirm</option>
                                        <option value="ontheway">On The Way</option>
                                        <option value="complete">Complete</option>
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
                        <h5 class="card-title">Order List </h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="orderDataTable"
                                style="width: 100%; height: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Order No</th>
                                        <th scope="col">User</th>
                                        <th scope="col">Total Price</th>
                                        <th scope="col">Payment</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Created By</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                            </table>
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
            var table = $('#orderDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('getorderlist') }}",
                    data: function(d) {
                        d.status = $('#status').val(),
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
                        data: 'order_no',
                        name: 'order_no'
                    },
                    {
                        data: 'user_id',
                        name: 'user_id'
                    },
                    {
                        data: 'total_price',
                        name: 'total_price'
                    },
                    {
                        data: 'payment_method',
                        name: 'payment_method'
                    },
                    {
                        data: 'status',
                        name: 'status'
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
            $('#status').change(function() {
                table.draw();
            });
            $('#orderDataTable').on('click', 'button.delete', function(e) {
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
@endsection
