@extends('layouts.mainlayout')
@section('title', 'Brands')
@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <div class="pagetitle">
            <h1>Brands </h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                    <li class="breadcrumb-item active">Brand</li>
                    <li class="breadcrumb-item active">List</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <a href="{{ route('brand.create') }}" class="d-flex align-items-center btn btn-primary">
            <i class="bi bi-plus-lg"></i>&nbsp;Add
        </a>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body" style="padding: 10px 30px">
                        <h5 class="card-title">Brand Table </h5>
                        <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="pr-2"> Show: </div>
                                <div>
                                    <select id="limit" class="form-select">
                                        <option value="10" {{ request()->get('limit') == '10' ? 'selected' : '' }}>10
                                            Rows
                                        </option>
                                        <option value="20" {{ request()->get('limit') == '20' ? 'selected' : '' }}>20
                                            Rows
                                        </option>
                                        <option value="50" {{ request()->get('limit') == '50' ? 'selected' : '' }}>50
                                            Rows
                                        </option>
                                        <option value="100" {{ request()->get('limit') == '100' ? 'selected' : '' }}>100
                                            Rows
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <input type="text" id="myInput" value="{{ request()->get('key') }}"
                                    class="form-control" placeholder="Search.....">
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive ">
                            <table class="table table-striped table-hover" id="brandTable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">LOGO</th>
                                        <th scope="col">NAME</th>
                                        <th scope="col">CREATED AT</th>
                                        <th scope="col">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($brands) <= 0)
                                        <tr>
                                            <th scope="row" colspan="5">
                                                <div class="d-flex align-items-center justify-content-center"
                                                    style="height: 100%; padding: 100px 0px">
                                                    There is nothing</div>
                                            </th>
                                        </tr>
                                    @else
                                        @foreach ($brands as $key => $brand)
                                            <tr>
                                                <th scope="row">
                                                    <div class="d-flex align-items-center" style="height: 100%">
                                                        {{ $key + 1 }}</div>
                                                </th>
                                                <td><img src="{{ $brand->picture ? $brand->picture : asset('assets/img/images.jpg') }}"
                                                        style="object-fit: cover; width: 50px; height: 50px; border-radius: 50%"
                                                        alt="">
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="height: 100%">
                                                        {{ $brand->name }}</div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="height: 100%">
                                                        <div>
                                                            <i class="bi bi-calendar-date mx-2"></i>
                                                        </div>
                                                        <div class="px-2 ">
                                                            {{ \Carbon\Carbon::create($brand->created_at)->toFormattedDateString() }}
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
                                                                    <div class="edit-btn mb-2" style="width: 100%">
                                                                        <a href="{{ route('brand.edit', ['id' => $brand->id]) }}"
                                                                            class="px-2">
                                                                            <i class="bi bi-pencil-square"></i>
                                                                            <span style="padding-left: 4px">Edit</span>
                                                                        </a>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div style="width: 100%">

                                                                        <form
                                                                            action="{{ route('brand.delete', ['id' => $brand->id]) }}"
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
                                    <p><b>Showing:</b> {{ count($brands) }} </p>
                                </div>
                                <div>

                                    {{ $brands->appends(request()->except('page'))->links() }}
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
        $(document).ready(function() {
            $("#myInput").keypress(function(e) {
                var limit = $('#limit').val();
                var is_verified = $('#is_verified').val();
                var key = $('#myInput').val().toLowerCase();
                if (e.which == 13) {
                    location.replace(
                        `/brand?${limit ? 'limit='+limit : ''}${key ? '&key='+key : ''}`
                    );
                }
            });
            $("#limit").on('change', function() {
                var limit = $('#limit').val();
                var is_verified = $('#is_verified').val();
                var key = $('#myInput').val().toLowerCase();
                location.replace(
                    `/brand?${limit ? 'limit='+limit : ''}${key ? '&key='+key : ''}`
                );
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $('#brandTable').on('click', 'button.delete', function(e) {
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

@endsection
