@extends('layouts.mainlayout')
@section('title', 'Brand')
@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <div class="pagetitle">
            <h1>Brand Page</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                    <li class="breadcrumb-item active">Brand</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <a href="{{ route('brand.create') }}" class="d-flex align-items-center btn btn-primary">
            <i class="bi bi-plus-lg"></i>Add
        </a>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Brand List </h5>
                        <table class="table table-borderless datatable" id="brandTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">PICTURE</th>
                                    <th scope="col">NAME</th>
                                    <th scope="col">DESCRIPTION</th>
                                    <th scope="col">CREATED AT</th>
                                    <th scope="col">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $index = 1;
                                @endphp
                                @foreach ($brands as $brand)
                                    <tr>
                                        <th scope="row"><a href="#">{{ $index++ }}</a></th>
                                        <td><img src="{{ asset($brand->picture ? $brand->picture : 'assets/img/images.jpg') }}"
                                                alt="" width="60px" height="60px">
                                        </td>
                                        <td>{{ $brand->name }}</td>
                                        <td>{!! $brand->description !!}</td>
                                        <td>{{ \Carbon\Carbon::create($brand->created_at)->toFormattedDateString() }}
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="edit-btn">
                                                    <a href="{{ route('brand.edit', ['id' => $brand->id]) }}"
                                                        class="px-2">
                                                        <i class="bi bi-pencil-square"></i>
                                                        <span style="padding-left: 4px">Edit</span>
                                                    </a>
                                                </div>
                                                <form action="{{ route('brand.delete', ['id' => $brand->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="delete-btn mx-2  delete">
                                                        <i class="bi bi-trash"></i>
                                                        <span style="padding-left: 4px">Delete</span>
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
    </section>
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
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
