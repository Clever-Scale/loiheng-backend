@extends('layouts.mainlayout')
@section('title', 'User Create')
@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <div class="pagetitle">
            <h1>User Page</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user') }}">User</a></li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('user') }}" class="d-flex align-items-center btn btn-primary">
            <i class="bi bi-arrow-left-circle"></i> &nbsp; Back
        </a>
    </div>

    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Create User</h5>

                            <form action="{{ route('user.save') }}" method="POST" novalidate enctype="multipart/form-data"
                                class="needs-validation">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="name" style="font-weight: 700">User Picture:</label><br>
                                        <label for="picture">
                                            <img id="blah" src="{{ asset('assets/img/images.jpg') }}"
                                                class="rounded shadow-sm p-1"
                                                style="transition: 0.4s; height: 100px; width: 100px" />
                                        </label>
                                        <input accept="image/*" name="profile_img" type='file' id="picture"
                                            class="mx-2" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="fullname" style="font-weight: 700">Name:</label>
                                        <input type="text" name="fullname"
                                            class="@error('fullname') is-invalid @enderror form-control py-1"
                                            value="{{ old('fullname') }}">
                                        @error('fullname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" style="font-weight: 700">Email</label>
                                        <input type="email" name="email"
                                            class="@error('email') is-invalid @enderror form-control py-1"
                                            value="{{ old('email') }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="phone_no" style="font-weight: 700">Phone No</label>
                                        <input type="phone_no" name="phone_no"
                                            class="@error('phone_no') is-invalid @enderror form-control py-1"
                                            value="{{ old('phone_no') }}">
                                        @error('phone_no')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="dob" style="font-weight: 700">Date Of Birth</label>
                                        <input type="date" name="dob"
                                            class="@error('dob') is-invalid @enderror form-control py-1"
                                            value="{{ old('dob') }}">
                                        @error('dob')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="phone_no"
                                                class="font-semibold text-sm text-slate-600 required">Gender
                                                <span class="text-red-500">*</span> :</label>
                                            <div class="form-control">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="gender"
                                                        id="inlineRadio1" value="male" checked>
                                                    <label class="form-check-label" for="inlineRadio1">Male</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="gender"
                                                        id="inlineRadio2" value="female">
                                                    <label class="form-check-label" for="inlineRadio2">Female</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="gender"
                                                        id="inlineRadio3" value="other">
                                                    <label class="form-check-label" for="inlineRadio3">Other</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="password"
                                                class="font-semibold text-sm text-slate-600 required">User Type
                                                <span class="text-red-500">*</span> :</label>
                                            <select class="form-select" aria-label="Default select example"
                                                name="is_admin">
                                                <option value="" selected>Select Type</option>
                                                <option value="admin">Admin</option>
                                                <option value="user">User</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <div style="position: relative">
                                                <div
                                                    style="position: absolute; right: 2%; display: flex; align-items: center">
                                                    <a onclick="toggePassword()" id="toggleBtn" style="color: #000"><i
                                                            class="bi bi-eye"></i></a>

                                                </div>
                                                <input type="password" name="password"
                                                    class="@error('password') is-invalid @enderror form-control py-1"
                                                    id="upass">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirm</label>
                                            <div class="relative">
                                                <div
                                                    style="position: absolute; right: 2%; display: flex; align-items: center">
                                                    <a onclick="toggeConfirmPassword()" id="toggleBtnConfirm"
                                                        style="color: #000"><i class="bi bi-eye"></i></a>

                                                </div>
                                                <input type="password" name="password_confirmation"
                                                    class="@error('password') is-invalid @enderror form-control py-1"
                                                    id="upassConfirm">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <div class="row my-3">
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i>
                                            &nbsp;Save</button>
                                    </div>
                                </div>
                            </form>


                        </div>
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
        picture.onchange = evt => {
            const [file] = picture.files
            if (file) {
                blah.src = URL.createObjectURL(file)
            }
        }

        function toggePassword() {
            var upass = document.getElementById('upass');
            var toggleBtn = document.getElementById('toggleBtn');
            if (upass.type == "password") {
                upass.type = "text";
                document.getElementById('toggleBtn').innerHTML = `<i class="bi bi-eye-slash"></i>`
            } else {
                upass.type = "Password";
                document.getElementById('toggleBtn').innerHTML = `<i class="bi bi-eye"></i>`
            }
        }

        function toggeConfirmPassword() {
            var upassConfirm = document.getElementById('upassConfirm');
            var toggleBtnConfirm = document.getElementById('toggleBtnConfirm');
            if (upassConfirm.type == "password") {
                upassConfirm.type = "text";
                document.getElementById('toggleBtnConfirm').innerHTML = `<i class="bi bi-eye-slash"></i>`
            } else {
                upassConfirm.type = "Password";
                document.getElementById('toggleBtnConfirm').innerHTML = `<i class="bi bi-eye"></i>`
            }
        }
    </script>

@endsection
