@extends('layouts.mainlayout')
@section('title', 'Order Detail')
@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <div class="pagetitle">
            <h1>Order Detail Page</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                    <li class="breadcrumb-item active">Order</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <div class="d-flex">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Change Status
            </button>
            &nbsp;
            <a href="{{ route('orders') }}" class="d-flex align-items-center btn btn-primary">
                <i class="bi bi-arrow-left-circle px-2"></i> Back
            </a>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Change Status</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('orders.status', ['id' => $order->id]) }}" method="POST" novalidate
                        enctype="multipart/form-data" class="needs-validation">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select class="form-select" aria-label="Default select example" name="status">
                                            <option value="">Select Status</option>
                                            <option value="pending">Pending</option>
                                            <option value="confirm">Confirm</option>
                                            <option value="ontheway">On The Way</option>
                                            <option value="complete">Complete</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submmit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-md-4">
                <div class="card p-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center">
                            <div>
                                <img src="{{ asset($order->user[0]->profile_img ? $order->user[0]->profile_img : 'assets/img/pp.jpg') }}"
                                    alt="" class="img-fluid">
                                <hr>
                                <p style="text-transform: capitalize; padding-top: 10px; font-weight: 600">
                                    {{ $order->user[0]->fullname }}
                                </p>
                                @if ($order->user[0]->email)
                                    <p><i class="bi bi-envelope pr-2"></i> {{ $order->user[0]->email }}</p>
                                @endif
                                @if ($order->user[0]->phone_no)
                                    <p><i class="bi bi-telephone pr-2"></i> {{ $order->user[0]->phone_no }}</p>
                                @endif
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
                                            aria-controls="profile-tab-pane" aria-selected="false">Product</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel"
                                        aria-labelledby="home-tab" tabindex="0" style="min-height: 60vh">
                                        <div class="py-4">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <th>Order Code</th>
                                                        <td>
                                                            <p style="text-transform: capitalize p-0">
                                                                {{ $order->order_no }}
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Subtotal Price</th>
                                                        <td>
                                                            <p style="text-transform: capitalize; color: green">
                                                                {{ $order->cart[0]->subtotal }} MMK
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Delivery Price</th>
                                                        <td>
                                                            <p style="text-transform: capitalize; color: green">
                                                                {{ $order->delivery_fee }} MMK
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total Price</th>
                                                        <td>
                                                            <p style="text-transform: capitalize; color: green">
                                                                {{ $order->total_price }} MMK
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Payment</th>
                                                        <td>
                                                            <p style="text-transform: capitalize">
                                                                {{ $order->payment_method }}
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Status</th>
                                                        <td>
                                                            @if ($order->status == 'pending')
                                                                <span
                                                                    class="badge rounded-pill text-bg-primary">{{ $order->status }}</span>
                                                            @elseif ($order->status == 'confirm')
                                                                <span
                                                                    class="badge rounded-pill text-bg-warning">{{ $order->status }}</span>
                                                            @elseif ($order->status == 'ontheway')
                                                                <span
                                                                    class="badge rounded-pill text-bg-info">{{ $order->status }}</span>
                                                            @elseif ($order->status == 'complete')
                                                                <span
                                                                    class="badge rounded-pill text-bg-success">{{ $order->status }}</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            {{-- <hr>
                                            <div class="py-2 row">
                                                <div class="col-md-6">
                                                    <h5>Brand: </h5>
                                                    <img src="{{ asset('assets/img/pp.jpg') }}" alt=""
                                                        width="120px" height="120px">
                                                </div>
                                                <div class="col-md-6">
                                                    <h5>Category: </h5>
                                                    <img src="{{ asset('assets/img/pp.jpg') }}" alt=""
                                                        width="120px" height="120px">
                                                </div>
                                            </div>
                                            <hr>
                                            <div>

                                            </div>
                                            <div>

                                            </div> --}}
                                        </div>

                                        <h5>Order Address</h5>

                                        <div style="border: 1px solid grey">
                                            <h4 class="p-2">{{ $order->address[0]->full_name }}</h4>
                                            <hr>
                                            <div class="p-2">
                                                <p><strong>Region:</strong> {{ $order->address[0]->region }}</p>
                                                <p><strong>City:</strong> {{ $order->address[0]->city }}</p>
                                                <p><strong>Township:</strong> {{ $order->address[0]->township }}</p>
                                                <p><strong>Street:</strong> {{ $order->address[0]->street_address }}</p>
                                                <p><strong>Phone No:</strong> {{ $order->address[0]->phone }}</p>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel"
                                        aria-labelledby="profile-tab" tabindex="0">
                                        @foreach ($order->cart[0]->cart_item as $data)
                                            @foreach ($data->product as $prod)
                                                <div class="py-4 my-2 row" style="border: 1px solid grey;">
                                                    <div class="col-md-4">
                                                        <img src="{{ $prod->cover_img }}" alt="" width="100%"
                                                            height="200px">
                                                    </div>
                                                    <div class="col-md-8">
                                                        <h3>{{ $prod->name }}</h3>
                                                        <span
                                                            class="badge rounded-pill text-bg-primary">{{ $prod->brand[0]->name }}</span>
                                                        <span
                                                            class="badge rounded-pill text-bg-success">{{ $prod->category[0]->name }}</span>
                                                        <p class="pt-4" style="font-weight: 500">{{ $prod->price }}
                                                            MMK
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endforeach

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
