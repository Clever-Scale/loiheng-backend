@extends('layouts.mainlayout')
@section('title', 'Customer')
@section('links')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css" />
@endsection
@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <div class="pagetitle">
            <h1>Customer Page</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                    <li class="breadcrumb-item active">Customer</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <a href="{{ route('customer.create') }}" class="d-flex align-items-center btn btn-primary">
            <i class="bi bi-plus-lg"></i>Add
        </a>
    </div>

    <section class="section">
        <div class="row">
            {{-- <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Customer Filter</div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fullname" style="font-weight: 700">Name:</label>
                                    <input type="text" placeholder="Enter fullname..." class="form-control"
                                        name="fullname" id="fullname">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="email" style="font-weight: 700">Email:</label>
                                    <input type="text" placeholder="Enter email..." class="form-control" name="email"
                                        id="email">
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
            </div> --}}
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Customer List </h5>
                        {{-- <hr class="pt-2">
                        <form action="{{ route('customer.search') }}" enctype="multipart/form-data" method="GET">

                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="name"
                                        placeholder="Search for Name...">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="email"
                                        placeholder="Search for Email...">
                                </div>
                                <div class="col-md-3">
                                    <div
                                        style="display: flex; flex-direction: column; justify-content:end; align-items:start; height: 100%">
                                        <input type="text" class="form-control" name="daterange" />
                                        <div id="from"></div>
                                        <div id="to"></div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit"
                                        class="d-flex justify-content-center align-items-center btn btn-primary">
                                        <i class="bi bi-search mx-2"></i>
                                        Search
                                    </button>
                                </div>

                            </div>
                        </form>
                        <hr class="py-2"> --}}
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="customerDataTable"
                                style="width: 100%; height: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">PROFILE</th>
                                        <th scope="col">NAME</th>
                                        <th scope="col">INFO</th>
                                        <th scope="col">LAST LOGIN</th>
                                        <th scope="col">CREATED AT</th>
                                        <th scope="col">ACTION</th>
                                    </tr>
                                </thead>
                                {{-- <tbody>
                                    @php
                                        $index = 1;
                                    @endphp
                                    @foreach ($customers as $customer)
                                        <tr>
                                            <th scope="row"><a href="#">{{ $index++ }}</a></th>
                                            <th><img src="{{ $customer->profile_img ? $customer->profile_img : 'assets/img/pp.jpg' }}"
                                                    alt="" width="60px" height="60px"></th>
                                            <td>{{ $customer->fullname }}</td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span><i
                                                            class="bi bi-envelope-fill px-2"></i>{{ $customer->email }}</span>
                                                    @if ($customer->phone_no)
                                                        <span><i
                                                                class="bi bi-phone px-2"></i>{{ $customer->phone_no }}</span>
                                                    @endif
                                                    @if ($customer->dob)
                                                        <span><i class="bi bi-heart px-2"></i>{{ $customer->dob }}</span>
                                                    @endif
                                                    @if ($customer->gender)
                                                        <span><i
                                                                class="bi bi-gender-trans px-2"></i>{{ $customer->gender }}</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>{{ $customer->last_login ? \Carbon\CarbonImmutable::create($customer->last_login)->calendar() : '' }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::create($customer->created_at)->toFormattedDateString() }}
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center ">
                                                    <div class="edit-btn">
                                                        <a href="{{ route('customer.edit', ['id' => $customer->id]) }}"
                                                            class="px-2">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                    </div>
                                                    <form action="{{ route('customer.delete', ['id' => $customer->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="delete-btn mx-2  delete">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody> --}}
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
            var table = $('#customerDataTable').DataTable({
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
                select: true,
                ajax: "{{ route('getcustomerlist') }}",
                columns: [{
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'profile_img',
                        name: 'profile_img'
                    },
                    {
                        data: 'fullname',
                        name: 'fullname'
                    },

                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'phone_no',
                        name: 'phone_no'
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
            $('#customerDataTable').on('click', 'button.delete', function(e) {
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
