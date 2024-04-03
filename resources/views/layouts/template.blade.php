@extends('layouts.main')

@section('title', $title)

@push('css')
@endpush

@section('content')
    <div class="container-fluid page-body-wrapper">
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-sm-6 mb-4 mb-xl-0">
                        <div class="d-lg-flex align-items-center">
                            <div>
                                <h3 class="text-dark font-weight-bold mb-2">Hi, {{ Auth::user()->nama }}!</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 flex-column d-flex stretch-card">
                        <div class="row">
                            <div class="col-sm-12 grid-margin d-flex stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main-panel ends -->
    </div>
@endsection