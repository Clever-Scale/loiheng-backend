@extends('layouts.mainlayout')
@section('title', 'Delivery Create')
@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <div class="pagetitle">
            <h1>Delivery Page</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('delivery') }}">Delivery</a></li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('delivery') }}" class="d-flex align-items-center btn btn-primary">
            <i class="bi bi-arrow-left-circle"></i> &nbsp; Back
        </a>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Create Delivery</h5>

                        <form action="{{ route('delivery.save') }}" method="POST" novalidate enctype="multipart/form-data"
                            class="needs-validation">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="name" style="font-weight: 700">Name:</label>
                                    <input type="text" name="name"
                                        class="@error('name') is-invalid @enderror form-control py-1"
                                        value="{{ old('name') }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="fee" style="font-weight: 700">Fee:</label>
                                    <input type="text" name="fee"
                                        class="@error('fee') is-invalid @enderror form-control py-1"
                                        value="{{ old('fee') }}">
                                    @error('fee')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="rage" style="font-weight: 700">Rage:</label>
                                    <input type="number" name="rage"
                                        class="@error('rage') is-invalid @enderror form-control py-1"
                                        value="{{ old('rage') }}">
                                    @error('rage')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12  mb-3">
                                    <label for="name" style="font-weight: 700">Full Description:</label>
                                    <textarea id="summernote" name="description"></textarea>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i>
                                        &nbsp;Save</button>
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
            height: 200,
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
