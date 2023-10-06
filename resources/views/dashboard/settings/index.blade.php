@extends('layouts.mainlayout')
@section('title', 'Settings')
@section('links')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <div class="pagetitle">
            <h1>Settings</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                    <li class="breadcrumb-item active">Setting</li>
                    <li class="breadcrumb-item active">List</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body" style="padding: 10px 30px">
                        <h5 class="card-title">Setting Table </h5>
                        <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="pr-2"> Show: </div>
                                <div>
                                    <select id="limit" class="form-select">
                                        <option value="10" {{ request()->get('limit') == '10' ? 'selected' : '' }}>10
                                            Rows
                                        </option>
                                        <option value="20" {{ request()->get('limit') == '20' ? 'selected' : '' }}>20
                                            Rows
                                        </option>
                                        <option value="50" {{ request()->get('limit') == '50' ? 'selected' : '' }}>50
                                            Rows
                                        </option>
                                        <option value="100" {{ request()->get('limit') == '100' ? 'selected' : '' }}>100
                                            Rows
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <input type="text" id="myInput" value="{{ request()->get('key') }}"
                                    class="form-control" placeholder="Search.....">
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="settingDataTable"
                                style="width: 100%; height: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Key</th>
                                        {{-- <th scope="col">Value</th> --}}
                                        <th scope="col">Created At</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($settings) <= 0)
                                        <tr>
                                            <th scope="row" colspan="6">
                                                <div class="d-flex align-items-center justify-content-center"
                                                    style="height: 100%; padding: 100px 0px">
                                                    There is nothing</div>
                                            </th>
                                        </tr>
                                    @else
                                        @foreach ($settings as $key => $setting)
                                            <tr>
                                                <th scope="row">
                                                    <div class="d-flex align-items-center" style="height: 100%">
                                                        {{ $key + 1 }}</div>
                                                </th>
                                                <td>
                                                    <div class="d-flex align-items-center" style="height: 100%">
                                                        {{ $setting->key }}
                                                    </div>
                                                </td>
                                                {{-- <td>
                                                    <div class="d-flex align-items-center" style="height: 100%">
                                                        {!! $setting->value !!}</div>
                                                </td> --}}
                                                <td>
                                                    <div class="d-flex align-items-center" style="height: 100%">
                                                        <div>
                                                            <i class="bi bi-calendar-date mx-2"></i>
                                                        </div>
                                                        <div class="px-2 ">
                                                            {{ \Carbon\Carbon::create($setting->created_at)->toFormattedDateString() }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="height: 100%">
                                                        <div class="dropdown">
                                                            <button class="btn" type="button" data-bs-toggle="dropdown"
                                                                aria-expanded="false">
                                                                <i class="bi bi-three-dots-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu p-4">
                                                                <li>
                                                                    <div class="edit-btn mb-2" style="width: 100%">
                                                                        <a href="{{ route('settings.edit', ['id' => $setting->id]) }}"
                                                                            class="px-2">
                                                                            <i class="bi bi-pencil-square"></i>
                                                                            <span style="padding-left: 4px">Edit</span>
                                                                        </a>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

                                </tbody>
                            </table>
                            <div class="d-flex justify-content-between align-items-center py-2">
                                <div>
                                    <p><b>Showing:</b> {{ count($settings) }} </p>
                                </div>
                                <div>

                                    {{ $settings->appends(request()->except('page'))->links() }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('script')

    <script>
        $(document).ready(function() {
            $("#myInput").keypress(function(e) {
                var limit = $('#limit').val();
                var is_verified = $('#is_verified').val();
                var key = $('#myInput').val().toLowerCase();
                if (e.which == 13) {
                    location.replace(
                        `/settings?${limit ? 'limit='+limit : ''}${key ? '&key='+key : ''}`
                    );
                }
            });
            $("#limit").on('change', function() {
                var limit = $('#limit').val();
                var is_verified = $('#is_verified').val();
                var key = $('#myInput').val().toLowerCase();
                location.replace(
                    `/settings?${limit ? 'limit='+limit : ''}${key ? '&key='+key : ''}`
                );
            });
        });
    </script>
@endsection
