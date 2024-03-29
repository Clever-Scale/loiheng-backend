@extends('layouts.mainlayout')
@section('title', 'Category Create')
@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <div class="pagetitle">
            <h1>Categories</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('category') }}">Category</a></li>
                    <li class="breadcrumb-item active">New Category</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('category') }}" class="d-flex align-items-center btn btn-primary">
            <i class="bi bi-arrow-left-circle"></i> &nbsp; Back
        </a>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body" style="padding: 10px 30px">
                        <h5 class="card-title">Create Category</h5>

                        <form action="{{ route('category.save') }}" method="POST" novalidate enctype="multipart/form-data"
                            class="needs-validation">
                            @csrf
                            <input type="hidden" name="created_by" value="{{ Auth::user()->id }}">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="name" style="font-weight: 700" class="py-2">Category
                                        Picture:</label><br>
                                    <label for="picture">
                                        <img id="blah" src="{{ asset('assets/img/images.jpg') }}"
                                            class="rounded shadow-sm p-1"
                                            style="transition: 0.4s; height: 100px; width: 100px" />
                                    </label>
                                    <input accept="image/*" name="picture" type='file' id="picture" class="mx-2" />
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="name" style="font-weight: 700" class="py-2">Category Name:</label>
                                    <input type="name" name="name"
                                        class="@error('name') is-invalid @enderror form-control py-1" required
                                        value="{{ old('name') }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="flexCheckDefault" checked>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Is Parent Category
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 myClass" style="display: none">
                                    <label for="name" style="font-weight: 700" class="py-2">Parent Category:</label>
                                    <select class="form-select" aria-label="Default select example" name="parent">
                                        <option value="0" name="parent">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option name="parent" value="{{ $category->id }}">{{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
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
    <script>
        $(document).ready(function() {
            $("#flexCheckDefault").click(function(event) {
                console.log($(this).is(":checked"));
                if ($(this).is(":checked"))
                    $(".myClass").hide();
                else
                    $(".myClass").show();
            });
        });
    </script>

@endsection
