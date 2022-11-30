@extends('layouts.mainlayout')
@section('title', 'Product Show')
@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <div class="pagetitle">
            <h1>Product Show Page</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                    <li class="breadcrumb-item active">Product</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <a href="{{ route('product') }}" class="d-flex align-items-center btn btn-primary">
            <i class="bi bi-arrow-left-circle px-2"></i> Back
        </a>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-md-4">
                <div class="card p-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center">
                            <div>
                                <img src="{{ asset($products[0]->cover_img) }}" alt="" class="img-fluid">
                                <h1 style="text-transform: capitalize; padding-top: 10px">
                                    {{ $products[0]->name }} <span style="font-size: 18px">({{ $products[0]->sku }})</span>
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card p-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center">
                            <div style="width: 100%">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                            data-bs-target="#home-tab-pane" type="button" role="tab"
                                            aria-controls="home-tab-pane" aria-selected="true">Over View</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                            data-bs-target="#profile-tab-pane" type="button" role="tab"
                                            aria-controls="profile-tab-pane" aria-selected="false">Product Picture </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                            data-bs-target="#contact-tab-pane" type="button" role="tab"
                                            aria-controls="contact-tab-pane" aria-selected="false">Product
                                            Specification</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="service-tab" data-bs-toggle="tab"
                                            data-bs-target="#service-tab-pane" type="button" role="tab"
                                            aria-controls="service-tab-pane" aria-selected="false">Product
                                            Service</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel"
                                        aria-labelledby="home-tab" tabindex="0" style="min-height: 60vh">
                                        <div class="py-4">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <th>Product Name</th>
                                                        <td>
                                                            <p style="text-transform: capitalize">{{ $products[0]->name }}
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Product Price</th>
                                                        <td>
                                                            <p style="text-transform: capitalize">{{ $products[0]->price }}
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>SKU</th>
                                                        <td>
                                                            <p style="text-transform: capitalize">{{ $products[0]->sku }}
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <hr>
                                            <div class="py-2 row">
                                                <div class="col-md-6">
                                                    <h5>Brand: {{ $products[0]->brand[0]->name }}</h5>
                                                    <img src="{{ asset($products[0]->brand[0]->picture ? $products[0]->brand[0]->picture : 'assets/img/pp.jpg') }}"
                                                        alt="" width="120px" height="120px">
                                                </div>
                                                <div class="col-md-6">
                                                    <h5>Category: {{ $products[0]->category[0]->name }}</h5>
                                                    <img src="{{ asset($products[0]->category[0]->picture ? $products[0]->category[0]->picture : 'assets/img/pp.jpg') }}"
                                                        alt="" width="120px" height="120px">
                                                </div>
                                            </div>
                                            <hr>
                                            <div>
                                                {!! $products[0]->description !!}
                                            </div>
                                            <div>
                                                {!! $products[0]->short_description !!}
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel"
                                        aria-labelledby="profile-tab" tabindex="0">
                                        <div class="py-4 row">
                                            @foreach ($products[0]->product_pictures as $data)
                                                <div class="col-md-12 pb-2">
                                                    <img src="{{ $data->image }}" alt="" width="100%"
                                                        height="500px">
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel"
                                        aria-labelledby="contact-tab" tabindex="0">
                                        <div class="py-4">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    @foreach ($products[0]->product_specs as $spec)
                                                        <tr>
                                                            <th>{{ $spec->spec_key }}</th>
                                                            <td>
                                                                <p style="text-transform: capitalize">
                                                                    {{ $spec->spec_value }}
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="service-tab-pane" role="tabpanel"
                                        aria-labelledby="service-tab" tabindex="0">
                                        <div class="py-4">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    @foreach ($products[0]->product_warranties as $spec)
                                                        <tr>
                                                            <th>{{ $spec->service_key }}</th>
                                                            <td>
                                                                <p style="text-transform: capitalize">
                                                                    {{ $spec->service_value }}
                                                                </p>
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
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
