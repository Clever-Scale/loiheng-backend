@extends('layouts.mainlayout')
@section('title', 'Brand Create')
@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <div class="pagetitle">
            <h1>Brands</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('brand') }}">Brand</a></li>
                    <li class="breadcrumb-item active">New Brand</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('brand') }}" class="d-flex align-items-center btn btn-primary">
            <i class="bi bi-arrow-left-circle"></i> &nbsp; Back
        </a>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body" style="padding: 10px 30px">
                        <h5 class="card-title">Create Brand</h5>
                        <form action="{{ route('brand.save') }}" method="POST" novalidate enctype="multipart/form-data"
                            class="needs-validation">
                            @csrf
                            <input type="hidden" name="created_by" value="{{ Auth::user()->id }}">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="name" style="font-weight: 700">Brand Picture:</label><br>
                                    <label for="picture">
                                        <img id="blah" src="{{ asset('assets/img/images.jpg') }}"
                                            class="rounded shadow-sm p-1"
                                            style="transition: 0.4s; height: 100px; width: 100px" />
                                    </label>
                                    <input accept="image/*" name="picture" type='file' id="picture" class="mx-2" />
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="name" style="font-weight: 700" class="py-2">Brand Name:</label>
                                    <input type="name" name="name"
                                        class="@error('name') is-invalid @enderror form-control " required
                                        value="{{ old('name') }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="name" style="font-weight: 700" class="py-2">Description:</label>
                                    <textarea class="tinymce-editor" name="description"></textarea>
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
    </script>

@endsection
