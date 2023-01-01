@extends('layouts.mainlayout')
@section('title', 'User')
@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <div class="pagetitle">
            <h1>User Page</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                    <li class="breadcrumb-item active">User</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <a href="{{ route('user.create') }}" class="d-flex align-items-center btn btn-primary">
            <i class="bi bi-plus-lg"></i>&nbsp;Add
        </a>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">User List </h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover datatable" id="UserTable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">PROFILE</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">CREATED AT</th>
                                        <th scope="col">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $index = 1;
                                    @endphp
                                    @foreach ($users as $user)
                                        <tr>
                                            <th scope="row"><a href="#">{{ $index++ }}</a></th>
                                            <th><img src="{{ asset($user->profile_img ? $user->profile_img : 'assets/img/pp.jpg') }}"
                                                    alt="" width="60px" height="60px" style="border-radius: 50%">
                                            </th>
                                            <td>{{ $user->fullname }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ \Carbon\Carbon::create($user->created_at)->toFormattedDateString() }}
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center ">
                                                    <div class="edit-btn">
                                                        <a href="{{ route('user.edit', ['id' => $user->id]) }}"
                                                            class="px-2">
                                                            <i class="bi bi-pencil-square"></i>
                                                            <span style="padding-left: 4px">Edit</span>
                                                        </a>
                                                    </div>
                                                    <form action="{{ route('user.delete', ['id' => $user->id]) }}"
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
        </div>
    </section>
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $('#UserTable').on('click', 'button.delete', function(e) {
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
