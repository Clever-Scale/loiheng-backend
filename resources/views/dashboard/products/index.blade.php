@extends('layouts.mainlayout')
@section('title', 'Product')
@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <div class="pagetitle">
            <h1>Product Page</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                    <li class="breadcrumb-item active">Product</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <a href="{{ route('product.create') }}" class="d-flex align-items-center btn btn-primary">
            <i class="bi bi-plus-lg"></i>Add
        </a>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Product List </h5>
                        <div class="table-responsive">
                            <table class="table table-border datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Point Amount</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @php
                                        $index = 1;
                                    @endphp
                                    @foreach ($Product as $item)
                                        <tr>
                                            <th scope="row"><a href="#">{{ $index++ }}</a></th>
                                            <td>{{ $item->image }}</td>
                                            <td>{{ $item->point_amount }}</td>
                                            <td>{{ $item->type }}</td>
                                            <td>{{ $item->created_at }}</td>
                                        </tr>
                                    @endforeach --}}

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
