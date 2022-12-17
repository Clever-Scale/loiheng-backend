@extends('layouts.mainlayout')
@section('title', 'User Edit')
@section('content')
    <div class="pagetitle">
        <h1>User Page</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user') }}">User</a></li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit User</h5>

                        <form action="{{ route('user.update', ['id' => $user->id]) }}" method="POST" novalidate
                            enctype="multipart/form-data" class="needs-validation">
                            @csrf
                            @method('PUT')
                            <input type="hidden" value="{{ $user->is_admin }}" name="is_admin">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="profile_img" style="font-weight: 700">User Profile:</label>
                                    <label for="profile_img">
                                        <img id="blah"
                                            src="{{ asset($user->profile_img ? $user->profile_img : 'assets/img/images.jpg') }}"
                                            class="rounded shadow-sm p-1"
                                            style="transition: 0.4s; height: 100px; width: 100px" />
                                    </label>
                                    <input accept="image/*" name="profile_img" type='file' id="profile_img"
                                        class="mx-2" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="fullname" style="font-weight: 700">Name:</label>
                                    <input type="text" name="fullname"
                                        class="@error('fullname') is-invalid @enderror form-control py-1"
                                        value="{{ $user->fullname }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" style="font-weight: 700">Email:</label>
                                    <input type="email" name="email"
                                        class="@error('email') is-invalid @enderror form-control py-1"
                                        value="{{ $user->email }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone_no" style="font-weight: 700">Phone No:</label>
                                    <input type="text" name="phone_no"
                                        class="@error('phone_no') is-invalid @enderror form-control py-1"
                                        value="{{ $user->phone_no }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="role" style="font-weight: 700">Role:</label>
                                    <input type="text" name="role"
                                        class="@error('role') is-invalid @enderror form-control py-1"
                                        value="{{ $user->role }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password" style="font-weight: 700">Password:</label>
                                    <input type="password" name="password"
                                        class="@error('password') is-invalid @enderror form-control py-1"
                                        value="{{ $user->role }}">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                    </div>

                    </form>


                </div>
            </div>

        </div>
        </div>
    </section>
    <script>
        $('#summernote').summernote({
            placeholder: 'Hello stand alone ui',
            tabsize: 2,
            height: 400,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
            ]
        });
    </script>
    <script>
        profile_img.onchange = evt => {
            const [file] = profile_img.files
            if (file) {
                blah.src = URL.createObjectURL(file)
            }
        }
    </script>

@endsection
