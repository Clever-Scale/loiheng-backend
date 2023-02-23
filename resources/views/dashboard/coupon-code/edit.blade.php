@extends('layouts.mainlayout')
@section('title', 'Coupon Code Edit')
@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <div class="pagetitle">
            <h1>Coupon Code Page</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('coupon-code') }}">Coupon Code</a></li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('coupon-code') }}" class="d-flex align-items-center btn btn-primary">
            <i class="bi bi-arrow-left-circle"></i> &nbsp; Back
        </a>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Coupon Code</h5>

                        <form action="{{ route('coupon-code.save') }}" method="POST" novalidate
                            enctype="multipart/form-data" class="needs-validation">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="type" style="font-weight: 700">Select Type:</label>
                                    <select class="form-select @error('type') is-invalid @enderror"
                                        aria-label="Default select example" name="type">
                                        <option value="">Select Coupon Type</option>
                                        <option value="percent" {{ $coupon->type == 'percent' ? 'checked' : '' }}>Percent
                                        </option>
                                        <option value="amount" {{ $coupon->type == 'amount' ? 'checked' : '' }}>Amount
                                        </option>
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="value" style="font-weight: 700">Value:</label>
                                    <input type="number" name="value"
                                        class="@error('value') is-invalid @enderror form-control py-1" required
                                        value="{{ $coupon->value }}" placeholder="Enter percent or amount...">
                                    @error('count')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="expired_date" style="font-weight: 700">Expired Date:</label>
                                    <input type="date" name="expired_date"
                                        class="@error('expired_date') is-invalid @enderror form-control py-1" required
                                        value="{{ $coupon->expired_date }}">
                                    @error('expired_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="count" style="font-weight: 700">Usable Count:</label>
                                    <input type="number" name="count"
                                        class="@error('count') is-invalid @enderror form-control py-1" required
                                        value="{{ $coupon->count }}" placeholder="100">
                                    @error('count')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="is_customer" style="font-weight: 700">Is For Customer:</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_customer"
                                            id="flexCheckDefault" onchange="valueChanged()"
                                            {{ $coupon->is_customer == true ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="answer">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Email</th>
                                                    <th scope="col">Phone</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = 1;
                                                @endphp
                                                @foreach ($users as $user)
                                                    @php
                                                        echo in_array($user->id, $couponUser);
                                                    @endphp
                                                    <tr>
                                                        <th><input type="checkbox" name="user_id[]"
                                                                value="{{ $user->id }}"
                                                                {{ $u == $user->id ? 'checked' : '' }}>
                                                        </th>
                                                        <td>{{ $i++ }}</td>
                                                        <td>{{ $user->fullname }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->phone_no }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="name" style="font-weight: 700">Note:</label>
                                    <textarea id="summernote" name="note">{{ $coupon->note }}</textarea>
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
    <script type="text/javascript">
        var check = {!! json_encode($coupon) !!};
        if (check.is_customer == true) {
            $(".answer").show();
        } else {
            $(".answer").hide();
        }

        function valueChanged() {
            if ($('#flexCheckDefault').is(":checked"))
                $(".answer").show();
            else
                $(".answer").hide();
        }
    </script>
    <script>
        $('#summernote').summernote({
            placeholder: 'You can add note....',
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
