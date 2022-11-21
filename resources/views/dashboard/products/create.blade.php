@extends('layouts.mainlayout')
@section('title', 'Product Create')
@section('content')
    <div class="pagetitle">
        <h1>Product Page</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('product') }}">Product</a></li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Create Product</h5>

                        <form action="{{ route('product.save') }}" method="POST" novalidate enctype="multipart/form-data"
                            class="needs-validation">
                            @csrf
                            <input type="hidden" name="created_by" value="{{ Auth::user()->id }}">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="name" style="font-weight: 700">Product Picture:</label><br>
                                    <label for="picture">
                                        <img id="blah" src="{{ asset('assets/img/images.jpg') }}"
                                            class="rounded shadow-sm p-1"
                                            style="transition: 0.4s; height: 100px; width: 100px" />
                                    </label>
                                    <input accept="image/*" name="picture" type='file' id="picture" class="mx-2" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="name" style="font-weight: 700">Product Name:</label>
                                    <input type="name" name="name"
                                        class="@error('name') is-invalid @enderror form-control py-1" required
                                        value="{{ old('name') }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="name" style="font-weight: 700">Product Price:</label>
                                    <input type="name" name="name"
                                        class="@error('name') is-invalid @enderror form-control py-1" required
                                        value="{{ old('name') }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="name" style="font-weight: 700">Category:</label>
                                    <select class="form-select" aria-label="Default select example" name="parent">
                                        <option value="0" name="parent">Select Category</option>
                                        {{-- @foreach ($categories as $Product)
                                            <option name="parent" value="{{ $Product->id }}">{{ $Product->name }}
                                            </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="name" style="font-weight: 700">Brand:</label>
                                    <select class="form-select" aria-label="Default select example" name="parent">
                                        <option value="0" name="parent">Select Brand</option>
                                        {{-- @foreach ($categories as $Product)
                                            <option name="parent" value="{{ $Product->id }}">{{ $Product->name }}
                                            </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="name" style="font-weight: 700">Description:</label>
                                    <textarea id="summernote" name="description"></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="name" style="font-weight: 700">Short Description:</label>
                                    <textarea id="shortdescription" name="description"></textarea>
                                </div>
                                <hr>
                                <div class="col-md-12">
                                    <div class="row pb-3">
                                        <div class="form-check col-md-4">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Is Feature Product
                                            </label>
                                        </div>
                                        <div class="form-check col-md-4">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Is New Arrival Product
                                            </label>
                                        </div>
                                        <div class="form-check col-md-4">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Is Pre-order
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-12 mb-3 border py-3">
                                    <div class="d-flex justify-content-between mb-3">
                                        <label for="name" style="font-weight: 700">Other Specification:</label>
                                        <a id="btnAddtoList" class="btn btn-success">Add
                                            Item</a>
                                    </div>
                                    <div class="row listing listing_ad job mb-3">
                                        <div class="col-md-6">
                                            <input type="name" name="name" class=" form-control py-1"
                                                placeholder="Enter specification name..." value="{{ old('name') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="name" name="name" class="form-control py-1"
                                                placeholder="Enter specification value..." value="{{ old('name') }}">
                                        </div>
                                    </div>
                                    <div id="addItem">
                                    </div>

                                </div>

                            </div>

                            <div class="row my-3">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
        $('#shortdescription').summernote({
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
    {{-- <script>
        picture.onchange = evt => {
            const [file] = picture.files
            if (file) {
                blah.src = URL.createObjectURL(file)
            }
        }
    </script> --}}
    <script>
        $(function() {
            var i = 0;
            console.log(i);
            $('#btnAddtoList').click(function() {
                i = i + 1;
                var newDiv = $(
                    `<div class="row listing listing_ad job mb-3" id="gg${i}">
                        <div class="col-md-5">
                            <input type="name" name="name"
                                class="form-control py-1" placeholder="Enter specification name..."
                                value="{{ old('name') }}">
                        </div>
                        <div class="col-md-5">
                            <input type="name" name="name"
                                class="form-control py-1" placeholder="Enter specification value..."
                                value="{{ old('name') }}">
                        </div>
                        <div class="col-md-2">
                            <button id="remove${i}" class="btn btn-danger py-1 shadow-sm px-2">Remove</button>
                        </div>
                    </div>`
                );
                //newDiv.style.background = "#000";
                $('#addItem').append(newDiv);

                for (let rm = 1; rm <= i; rm++) {
                    $(`#remove${rm}`).click(function() {
                        var child = $(`#gg${rm}`);
                        child.remove();
                    })

                }
                console.log(i);
            });



        });
    </script>

@endsection
