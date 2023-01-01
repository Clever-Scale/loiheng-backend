@extends('layouts.mainlayout')
@section('title', 'Product Edit')
@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <div class="pagetitle">
            <h1>Product Edit Page</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('product') }}">Product</a></li>
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
                <form action="{{ route('product.update', ['id' => $products[0]->id]) }}" method="POST" novalidate
                    enctype="multipart/form-data" class="needs-validation">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Edit Product</h5>
                            <input type="hidden" name="user_id" value="{{ $products[0]->created_by[0]->id }}">
                            <input type="hidden" name="product_code" value="{{ $products[0]->product_code }}">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="cover_img" style="font-weight: 700">Cover Picture <span
                                            style="color: red">*</span> :</label><br>
                                    <label for="cover_img" class="@error('cover_img') is-invalid @enderror">
                                        <img id="coverPic" src="{{ asset($products[0]->cover_img) }}"
                                            class="rounded shadow-sm p-1"
                                            style="transition: 0.4s; height: 100px; width: 100px" />
                                    </label>
                                    <input accept="image/*" name="cover_img" type='file' id="cover_img" class="mx-2" />
                                    @error('cover_img')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="name" style="font-weight: 700">Product Name <span
                                            style="color: red">*</span> :</label>
                                    <input type="text" name="name"
                                        class="@error('name') is-invalid @enderror form-control py-1"
                                        value="{{ $products[0]->name }}">
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
                                        value="{{ $products[0]->price }}">
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
                                            <option value="{{ $category->id }}"
                                                {{ $products[0]->category[0]->id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
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
                                            <option value="{{ $brand->id }}"
                                                {{ $products[0]->brand[0]->id == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
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
                                        value="{{ $products[0]->sku }}">
                                    @error('sku')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="stock" style="font-weight: 700">Stock <span style="color: red">*</span>
                                        :</label>
                                    <input type="number" name="stock"
                                        class="@error('stock') is-invalid @enderror form-control py-1"
                                        value="{{ $products[0]->stock }}">
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
                                <div class="col-md-12 col-xl-6 mb-3">
                                    <label for="name" style="font-weight: 700">Full Description:</label>
                                    <textarea id="summernote" name="description">{{ $products[0]->description }}</textarea>
                                </div>
                                <div class="col-md-12 col-xl-6 mb-3">
                                    <label for="name" style="font-weight: 700">Short Description:</label>
                                    <textarea id="shortdescription" name="short_description">{{ $products[0]->short_description }}</textarea>
                                </div>
                                <hr>
                                <div class="col-md-12">
                                    <div class="row pb-3">
                                        <div class="form-check col-md-4">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                name="is_feature_product"
                                                {{ $products[0]->is_feature_product == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Is Feature Product
                                            </label>
                                        </div>
                                        <div class="form-check col-md-4">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                name="is_new_arrival"
                                                {{ $products[0]->is_new_arrival == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Is New Arrival Product
                                            </label>
                                        </div>
                                        <div class="form-check col-md-4">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                name="is_preorder" {{ $products[0]->is_preorder == 1 ? 'checked' : '' }}>
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
                                    @php
                                        $spid = 0;
                                        $spk = 0;
                                        $spv = 0;
                                    @endphp
                                    @foreach ($products[0]->product_specs as $data)
                                        <input type="hidden" name="spec_product_id[{{ $spid++ }}]"
                                            value="{{ $data->id }}">
                                        <div class="row listing listing_ad job mb-3">
                                            <div class="col-md-6">
                                                <input type="text" name="edit_spec_key[{{ $spk++ }}]"
                                                    class=" form-control py-1" placeholder="Enter specification name..."
                                                    value="{{ $data->spec_key }}">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="edit_spec_value[{{ $spv++ }}]"
                                                    class="form-control py-1" placeholder="Enter specification value..."
                                                    value="{{ $data->spec_value }}">
                                            </div>
                                        </div>
                                    @endforeach
                                    <div id="addItem">
                                    </div>

                                </div>
                                <div class="col-md-12 mb-3 border py-3">
                                    <div class="d-flex justify-content-between mb-3">
                                        <label for="name" style="font-weight: 700">Service:</label>
                                        <a id="btnAddService" class="btn btn-success">Add
                                            Service</a>
                                    </div>
                                    @php
                                        $seid = 0;
                                        $sek = 0;
                                        $sev = 0;
                                    @endphp
                                    @foreach ($products[0]->product_warranties as $service)
                                        <input type="hidden" name="service_product_id[{{ $seid++ }}]"
                                            value="{{ $service->id }}">
                                        <div class="row listing listing_ad job mb-3">
                                            <div class="col-md-6">
                                                <select class="form-select" aria-label="Default select example"
                                                    name="edit_service_key[{{ $sek++ }}]">
                                                    <option value="">Select</option>
                                                    <option value="shield"
                                                        {{ $service->service_key == 'shield' ? 'selected' : '' }}>Shield
                                                    </option>
                                                    <option value="checked"
                                                        {{ $service->service_value == 'checked' ? 'selected' : '' }}>
                                                        Checked
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="edit_service_value[{{ $sev++ }}]"
                                                    class="form-control py-1" placeholder="Enter specification value..."
                                                    value="{{ $service->service_value }}">
                                            </div>
                                        </div>
                                    @endforeach
                                    <div id="addService">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body ">
                            <div class="d-flex justify-content-between mb-3 align-items-center">
                                <h5 class="card-title">Create Product</h5>
                                <div class="py-2">
                                    <a id="btnAddImage" class="btn btn-success">Add
                                        Image</a>
                                </div>
                            </div>
                            <div class="row py-2" style="border-bottom: 1px solid grey">
                                <div class="col-md-4">
                                    Picture
                                </div>
                                <div class="col-md-4">
                                    Display Order
                                </div>
                                <div class="col-md-4">
                                    Action
                                </div>
                            </div>
                            @php
                                $ppicid = 0;
                                $ppic = 0;
                                $ppicd = 0;
                                $edi = 0;
                                $edo = 0;
                                $edk = 0;
                            @endphp
                            @foreach ($products[0]->product_pictures as $pic)
                                <input type="hidden" name="img_product_id[{{ $ppicid++ }}]"
                                    value="{{ $pic->id }}">
                                <div class="row py-2 border-t" style="border-top: 1px solid grey">
                                    <div class="col-md-4">
                                        <label for="picture{{ $edk++ }}">
                                            <img id="blah{{ $edi++ }}" src="{{ asset($pic->image) }}"
                                                class="rounded shadow-sm p-1"
                                                style="transition: 0.4s; height: 100px; width: 100px" />
                                        </label>
                                        <input accept="image/*" name="edit_image[{{ $ppic++ }}]" type='file'
                                            id="picture{{ $edo++ }}" class="mx-2" hidden />
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center" style="height: 100%">
                                            <input type="number" name="edit_display_order[{{ $ppicd++ }}]"
                                                class="@error('display_order') is-invalid @enderror form-control py-1"
                                                value="{{ $pic->display_order }}">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">

                                    </div>
                                </div>
                            @endforeach
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
        var sites = {!! json_encode($products[0]->product_pictures) !!};
        console.log(sites);
        for (let ed = 0; ed <= sites.length; ed++) {
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $(`#blah${ed}`).attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
            $(`#picture${ed}`).change(function() {
                readURL(this);
            });
        }
        cover_img.onchange = evt => {
            const [file] = cover_img.files
            if (file) {
                coverPic.src = URL.createObjectURL(file)
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
                        <div class="col-md-4">
                            <label for="imgInp${k}">
                                <img id="eblah${k}" src="{{ asset('assets/img/images.jpg') }}" class="rounded shadow-sm p-1" style="transition: 0.4s; height: 100px; width: 100px" />
                            </label>
                            <input accept="image/*" name="image[]" type='file' id="imgInp${k}" class="mx-2" hidden />
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center" style="height: 100%">
                                <input type="number" name="display_order[]" class="@error('display_order') is-invalid @enderror form-control py-1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center justify-content-center" style="height: 100%">
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
                                $(`#eblah${rmi}`).attr('src', e.target.result);
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
