@extends('layouts.mainlayout')
@section('title', 'Company Profile')
@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <div class="pagetitle">
            <h1>Company Profile Page</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                    <li class="breadcrumb-item active">Company Profile</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('company.edit', ['id' => $company->id]) }}" class="d-flex align-items-center btn btn-primary">
            <i class="bi bi-pencil-square"></i>&nbsp;Edit
        </a>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Company Profile </h5>
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{ asset($company->image ? $company->image : 'assets/img/images.jpg') }}"
                                    alt="" style="width: 100%">
                            </div>
                            <div class="col-md-8">
                                <h3>{{ $company->title }}</h3>
                                <br>
                                <p>{!! $company->content !!}</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
