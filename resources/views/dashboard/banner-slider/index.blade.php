@extends('layouts.mainlayout')
@section('title', 'Banner Slider')
@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <div class="pagetitle">
            <h1>Banner Slider Page</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                    <li class="breadcrumb-item active">Banner Slider</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <button type="button" class="d-flex align-items-center btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#exampleModal">
            <i class="bi bi-plus-lg"></i>Add
        </button>
        {{-- Model start --}}
        <div class="modal  fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <form action="{{ route('banner-slider.save') }}" method="POST" novalidate enctype="multipart/form-data"
                    class="needs-validation">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Banner Slider</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="created_by" value="{{ Auth::user()->id }}">
                            @if (Session::has('err'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Warning!</strong> {{ Session::get('err') }}
                                    <button type="button" class="btn-close text-red-500 flex items-center"
                                        data-bs-dismiss="alert" aria-label="Close"><i
                                            class="fa-solid fa-xmark"></i></button>
                                </div>
                            @endif
                            <div class="d-flex justify-content-center">
                                <label for="image">
                                    <img id="blah" src="{{ asset('assets/img/up.jpg') }}" class="rounded shadow-sm p-1"
                                        style="transition: 0.4s; height: 400px; width: 100%" />
                                </label>
                                <input accept="image/*" name="image" type='file' id="image" class="mx-2"
                                    hidden />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- Model end --}}
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Banner Slider List </h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover " id="bannerSliderDataTable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Picture</th>
                                        <th scope="col">Created By</th>
                                        <th scope="col">CREATED AT</th>
                                        <th scope="col">ACTION</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        image.onchange = evt => {
            const [file] = image.files
            if (file) {
                blah.src = URL.createObjectURL(file)
            }
        }
    </script>
    <script>
        // var user = {{ Session::get('err') }};
        if ({{ Session::has('err') }}) {
            $(document).ready(function() {
                $('#exampleModal').modal('show');
            });
        }
        // console.log("This is javascript session" + user);
    </script>
    <script type="text/javascript">
        $(function() {
            var table = $('#bannerSliderDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('getbannerlist') }}"
                },
                columns: [{
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'created_by',
                        name: 'created_by'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                    },

                ]
            });
            $('#bannerSliderDataTable').on('click', 'button.delete', function(e) {
                // console.log(e);
                e.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete record",
                    icon: 'warning',
                    showCancelButton: true,
                    timer: 4000,
                    timerProgressBar: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(e.target).closest('form').submit() // Post the surrounding form

                    }
                })

            });

        });
    </script>

@endsection
