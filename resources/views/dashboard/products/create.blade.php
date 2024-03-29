@extends('layouts.mainlayout')
@section('title', 'Product Create')
@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <div class="pagetitle">
            <h1>Products</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('product') }}">Product</a></li>
                    <li class="breadcrumb-item active">New Product</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('product') }}" class="d-flex align-items-center btn btn-primary">
            <i class="bi bi-arrow-left-circle"></i> &nbsp; Back
        </a>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <form action="{{ route('product.save') }}" method="POST" novalidate enctype="multipart/form-data"
                    class="needs-validation">
                    @csrf
                    <div class="card">
                        <div class="card-body" style="padding: 10px 30px">
                            <h5 class="card-title">Create Product</h5>
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="col-md-12">
                                        <label for="cover_img" style="font-weight: 700">Cover Picture <span
                                                style="color: red">*</span> :</label><br>
                                        <label for="cover_img" class="@error('cover_img') is-invalid @enderror"
                                            style="border: 2px solid grey; width: 100%; padding: 4px; height: 300px; border-style: dotted; display: flex;justify-content: center; align-items: center; border-radius: 10px">
                                            <div id="coverText" style="text-align: center">
                                                <b>Select File</b>
                                                <br>
                                                <span style="font-size: 12px; color: grey">select file here or click <span
                                                        style="color: blue; text-decoration: underline">browse</span>
                                                    through
                                                    your machine</span>
                                            </div>
                                            <img id="coverPic" class="rounded "
                                                style="transition: 0.4s; height: 100%; width: 100%; display: none;" />
                                        </label>
                                        <input accept="image/*" name="cover_img" type='file' id="cover_img"
                                            class="mx-2" hidden />
                                        @error('cover_img')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-8"></div>
                                <div class="col-md-6 mb-3">
                                    <label for="name" style="font-weight: 700">Product Name <span
                                            style="color: red">*</span> :</label>
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
                                    <label for="price" style="font-weight: 700">Product Price <span
                                            style="color: red">*</span> :</label>
                                    <input type="text" name="price"
                                        class="@error('price') is-invalid @enderror form-control py-1"
                                        value="{{ old('price') }}">
                                    @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="category_id" style="font-weight: 700">Category <span
                                            style="color: red">*</span> :</label>
                                    <select class="form-select @error('category_id') is-invalid @enderror"
                                        aria-label="Default select example" name="category_id">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="brand_id" style="font-weight: 700">Brand <span style="color: red">*</span>
                                        :</label>
                                    <select class="form-select @error('brand_id') is-invalid @enderror"
                                        aria-label="Default select example" name="brand_id">
                                        <option value="">Select Brand</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('brand_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="sku" style="font-weight: 700">SKU <span style="color: red">*</span>
                                        :</label>
                                    <input type="text" name="sku"
                                        class="@error('sku') is-invalid @enderror form-control py-1"
                                        value="{{ old('sku') }}">
                                    @error('sku')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="stock" style="font-weight: 700">Stock <span
                                            style="color: red">*</span>
                                        :</label>
                                    <input type="number" name="stock"
                                        class="@error('stock') is-invalid @enderror form-control py-1"
                                        value="{{ old('stock') }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="desc_file" style="font-weight: 700">Description File:</label>
                                    <input type="file" name="desc_file"
                                        class="@error('desc_file') is-invalid @enderror form-control py-1"
                                        value="{{ old('desc_file') }}">
                                    @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-12  mb-3">
                                    <label for="name" style="font-weight: 700">Full Description:</label>
                                    <textarea class="tinymce-editor" name="description" style="position: relative"></textarea>
                                </div>
                                <div class="col-md-12  mb-3">
                                    <label for="name" style="font-weight: 700">Short Description:</label>
                                    <textarea class="tinymce-editor" name="short_description"></textarea>
                                </div>
                                <hr>
                                <div class="col-md-12">
                                    <div class="row pb-3">
                                        <div class="form-check col-md-4">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                name="is_feature_product">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Is Feature Product
                                            </label>
                                        </div>
                                        <div class="form-check col-md-4">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                name="is_new_arrival">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Is New Arrival Product
                                            </label>
                                        </div>
                                        <div class="form-check col-md-4">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                name="is_preorder">
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
                                            Spec</a>
                                    </div>
                                    <div class="row listing listing_ad job mb-3">
                                        <div class="col-md-6">
                                            <input type="text" name="spec_key[]" class=" form-control py-1"
                                                placeholder="Enter specification name...">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="spec_value[]" class="form-control py-1"
                                                placeholder="Enter specification value...">
                                        </div>
                                    </div>
                                    <div id="addItem">
                                    </div>

                                </div>
                                <div class="col-md-12 mb-3 border py-3">
                                    <div class="d-flex justify-content-between mb-3">
                                        <label for="name" style="font-weight: 700">Service:</label>
                                        <a id="btnAddService" class="btn btn-success">Add
                                            Service</a>
                                    </div>
                                    <div class="row listing listing_ad job mb-3">
                                        <div class="col-md-6">
                                            <select class="form-select" aria-label="Default select example"
                                                name="service_key[]">
                                                <option value="">Select</option>
                                                <option value="shield">Shield</option>
                                                <option value="checked">Checked</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="service_value[]" class="form-control py-1"
                                                placeholder="Enter specification value...">
                                        </div>
                                    </div>
                                    <div id="addService">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body ">
                            <div class="d-flex justify-content-between mb-3 align-items-center">
                                <h5 class="card-title">Images</h5>
                                <div class="py-2">
                                    <a id="btnAddImage" class="btn btn-success">Add
                                        Image</a>
                                </div>
                            </div>
                            <div class="row py-2" style="border-bottom: 1px solid grey">
                                <div class="col-md-6">
                                    Picture
                                </div>
                                {{-- <div class="col-md-6">
                                    Display Order
                                </div> --}}
                                <div class="col-md-6">
                                    Action
                                </div>
                            </div>
                            <div class="row py-2">
                                <div class="col-md-12">
                                    <label for="picture">
                                        <img id="blah" src="{{ asset('assets/img/images.jpg') }}"
                                            class="rounded shadow-sm p-1"
                                            style="transition: 0.4s; height: 100px; width: 100px" />
                                    </label>
                                    <input accept="image/*" name="image[]" type='file' id="picture" class="mx-2"
                                        hidden />
                                </div>
                                {{-- <div class="col-md-4">
                                    <div class="d-flex align-items-center" style="height: 100%">
                                        <input type="number" name="display_order[]"
                                            class="@error('display_order') is-invalid @enderror form-control py-1">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">

                                </div> --}}
                            </div>
                            <div id="addImage"></div>

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
    <script>
        picture.onchange = evt => {
            const [file] = picture.files
            if (file) {
                blah.src = URL.createObjectURL(file)
            }
        }
        cover_img.onchange = evt => {
            const [file] = cover_img.files
            if (file) {
                coverPic.src = URL.createObjectURL(file)
                document.querySelector("#coverPic").style.display = "block";
                document.querySelector("#coverText").style.display = "none";
            }
        }
    </script>
    <script>
        $(function() {
            var i = 0;
            console.log(i);
            $('#btnAddtoList').click(function() {
                i = i + 1;
                var newDiv = $(
                    `<div class="row listing listing_ad job mb-3" id="gg${i}">
                        <div class="col-md-5">
                            <input type="text" name="spec_key[]"
                                class="form-control py-1" placeholder="Enter specification name..."
                                value="">
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="spec_value[]"
                                class="form-control py-1" placeholder="Enter specification value..."
                                value="">
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


            var j = 0;
            $('#btnAddService').click(function() {
                j = j + 1;
                var newDivService = $(
                    `<div class="row listing listing_ad job mb-3" id="service${j}">
                        <div class="col-md-5">
                            <select class="form-select" aria-label="Default select example"
                                name="service_key[]">
                                <option value="" selected>Select</option>
                                <option value="shield">Shield</option>
                                <option value="checked">Checked</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="service_value[]" class="form-control py-1"
                                placeholder="Enter specification value..." >
                        </div>
                        <div class="col-md-2">
                            <button id="removeService${j}" class="btn btn-danger py-1 shadow-sm px-2">Remove</button>
                        </div>
                    </div>`
                );
                //newDiv.style.background = "#000";
                $('#addService').append(newDivService);

                for (let rms = 1; rms <= j; rms++) {
                    $(`#removeService${rms}`).click(function() {
                        var childService = $(`#service${rms}`);
                        childService.remove();
                    })

                }
                console.log(i);
            });

            var k = 0;
            $('#btnAddImage').click(function() {
                k = k + 1;
                var newDivImage = $(
                    `<div class="row py-2" id="img${k}" style="border-top: 1px solid grey">
                        <div class="col-md-6">
                            <label for="imgInp${k}">
                                <img id="blah${k}" src="{{ asset('assets/img/images.jpg') }}" class="rounded shadow-sm p-1" style="transition: 0.4s; height: 100px; width: 100px" />
                            </label>
                            <input accept="image/*" name="image[]" type='file' id="imgInp${k}" class="mx-2" hidden />
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center" style="height: 100%">
                                <button id="removeImage${k}" class="btn btn-danger py-1 shadow-sm px-2">Remove</button>
                            </div>
                        </div>
                    </div>`
                );
                //newDiv.style.background = "#000";
                $('#addImage').append(newDivImage);

                for (let rmi = 1; rmi <= k; rmi++) {
                    $(`#removeImage${rmi}`).click(function() {
                        var childImage = $(`#img${rmi}`);
                        childImage.remove();
                    });

                    function readURL(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();

                            reader.onload = function(e) {
                                $(`#blah${rmi}`).attr('src', e.target.result);
                            }

                            reader.readAsDataURL(input.files[0]);
                        }
                    }

                    $(`#imgInp${rmi}`).change(function() {
                        readURL(this);
                    });

                }
                console.log(i);
            });



        });
    </script>

@endsection
