@extends('layouts.mainlayout')
@section('title', 'Customer')
@section('links')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Customer List </h5>
                        <hr class="pt-2">
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
                        <hr class="py-2">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover datatable" id="customerTable">
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
                                <tbody>
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
                                                            {{-- <span style="padding-left: 4px">Edit</span> --}}
                                                        </a>
                                                    </div>
                                                    <form action="{{ route('customer.delete', ['id' => $customer->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="delete-btn mx-2  delete">
                                                            <i class="bi bi-trash"></i>
                                                            {{-- <span style="padding-left: 4px">Delete</span> --}}
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $('#customerTable').on('click', 'button.delete', function(e) {
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
                `<input name='from' type='date' value="${start.format('YYYY-MM-DD') }" hidden />`;
            document.getElementById("to").innerHTML =
                `<input name='to' type='date' value="${end.format('YYYY-MM-DD')}" hidden/>`;
            // console.log(selectedStart);
        });
    </script>

@endsection
