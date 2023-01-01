@extends('layouts.mainlayout')
@section('title', 'Banner Image Create')
@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <div class="pagetitle">
            <h1>Banner Image Page</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('brand') }}">Banner Image</a></li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('banner-slider') }}" class="d-flex align-items-center btn btn-primary">
            <i class="bi bi-arrow-left-circle"></i> &nbsp; Back
        </a>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Create Banner Image</h5>

                        <form action="{{ route('banner-slider.save') }}" method="POST" novalidate
                            enctype="multipart/form-data" class="needs-validation">
                            @csrf
                            <input type="hidden" name="created_by" value="{{ Auth::user()->id }}">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="name" style="font-weight: 700">Banner Image:</label><br>
                                    <label for="image" class=" @error('image') is-invalid @enderror">
                                        <img id="blah" src="{{ asset('assets/img/images.jpg') }}"
                                            class="rounded shadow-sm p-1"
                                            style="transition: 0.4s; height: 100px; width: 100px" />
                                    </label>
                                    <input accept="image/*" name="image" type='file' id="image" class="mx-2" />
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
        image.onchange = evt => {
            const [file] = image.files
            if (file) {
                blah.src = URL.createObjectURL(file)
            }
        }
    </script>

@endsection
