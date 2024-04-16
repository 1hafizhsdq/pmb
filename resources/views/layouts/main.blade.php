<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('template') }}/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{ asset('template') }}/vendors/base/vendor.bundle.base.css">
    <link rel="stylesheet" href="{{ asset('template') }}/css/style.css">
    <link rel="shortcut icon" href="{{ asset('template') }}/images/favicon.png" />
    <link rel="stylesheet" href="{{ asset('template') }}/vendors/filepond/filepond.css">
    <link rel="stylesheet" href="{{ asset('select2') }}/dist/css/select2.css">
    <link rel="stylesheet"
        href="{{ asset('template') }}/vendors/filepond-plugin-image-preview/filepond-plugin-image-preview.css">
</head>

<body>
    <div class="container-scroller">
        <div class="row p-0 m-0 proBanner" id="proBanner" style="z-index:-1000;">
            <div class="col-md-12 p-0 m-0">
                <div class="card-body card-body-padding d-flex align-items-center justify-content-between">
                    <div class="ps-lg-1">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0 font-weight-medium me-3 buy-now-text">Free 24/7 customer support, updates, and more with this template!</p>
                            <a href="https://www.bootstrapdash.com/product/kapella-admin-pro/?utm_source=organic&utm_medium=banner&utm_campaign=buynow_demo" target="_blank" class="btn me-2 buy-now-btn border-0">Get Pro</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <a href="https://www.bootstrapdash.com/product/kapella-admin-pro/"><i class="mdi mdi-home me-3 text-white"></i></a>
                        <button id="bannerClose" class="btn border-0 p-0">
                            <i class="mdi mdi-close text-white me-0"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- partial:partials/_horizontal-navbar.html -->
        <div class="horizontal-menu">
            <nav class="navbar top-navbar col-lg-12 col-12 p-0">
                <div class="container-fluid">
                    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
                        <ul class="navbar-nav navbar-nav-left">
                            <li>
                                <div
                                    class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                                    <a class="navbar-brand brand-logo" href="#">
                                        <img style="height: 70px; width: 70px;"
                                            src="{{ asset('img') }}/logo.png" alt="logo" />
                                    </a>
                                    <a class="navbar-brand brand-logo-mini" href="#">
                                        <img style="height: 50px; width: 50px;"
                                            src="{{ asset('img') }}/logo.png" alt="logo" />
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                            <a class="navbar-brand brand-logo" href="#">
                                <h2 style="margin-top: 10px; margin-left: 10px;">
                                    <b style="color: black;">
                                        SEKOLAH TINGGI AGAMA ISLAM NAHDLATUL ULAMA PACITAN
                                    </b>
                                </h2>
                            </a>
                            <a class="navbar-brand brand-logo-mini" href="#"></a>
                        </div>
                        {{-- <ul class="navbar-nav navbar-nav-right">
                            <li class="nav-item nav-profile dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                    id="profileDropdown">
                                    <span class="nav-profile-name">{{ Auth::user()->nama }}</span>
                                    <span class="online-status"></span>
                                    <img src="{{ asset('template') }}/images/faces/face28.png"
                                        alt="profile" />
                                </a>
                                <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                                    aria-labelledby="profileDropdown">
                                    <a class="dropdown-item">
                                        <i class="mdi mdi-settings text-primary"></i>
                                        Settings
                                    </a>
                                    <a class="dropdown-item" id="logout">
                                        <i class="mdi mdi-logout text-primary"></i>
                                        Logout
                                    </a>
                                </div>
                            </li>
                        </ul> --}}
                        <ul class="navbar-nav navbar-nav-right">
                            <li class="nav-item dropdown  d-lg-flex d-none">
                                {{-- <button type="button" id="logout" class="btn btn-inverse-danger btn-sm">Logout </button> --}}
                                <a class="btn btn-inverse-danger btn-sm" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                            data-toggle="horizontal-menu-toggle">
                            <span class="mdi mdi-menu"></span>
                        </button>
                    </div>
                </div>
            </nav>
            <nav class="bottom-navbar">
                <div class="container">
                    <ul class="nav page-navigation">
                        <li class="nav-item {{ ($title == 'Pendaftaran Mahasiswa Baru') ? 'active' : '' }}">
                            <a class="nav-link" href="/">
                                <i class="mdi mdi-file-document-box menu-icon"></i>
                                <span class="menu-title" style="color: #000000;">Pendaftaran</span>
                            </a>
                        </li>
                        <li class="nav-item {{ ($title != 'Pendaftaran Mahasiswa Baru') ? 'active' : '' }}">
                            <a href="/pengumuman" class="nav-link">
                                <i class="mdi mdi-volume-high menu-icon"></i>
                                <span class="menu-title" style="color: #000000;">Pengumuman</span>
                                <i class="menu-arrow"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- partial -->
        @yield('content')
        <!-- page-body-wrapper ends -->
    </div>
    <script src="{{ asset('template') }}/vendors/base/vendor.bundle.base.js"></script>
    <script src="{{ asset('template') }}/vendors/jquery/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="{{ asset('template') }}/js/template.js"></script>
    <script src="{{ asset('template') }}/vendors/chart.js/Chart.min.js"></script>
    <script src="{{ asset('template') }}/vendors/progressbar.js/progressbar.min.js"></script>
    <script
        src="{{ asset('template') }}/vendors/chartjs-plugin-datalabels/chartjs-plugin-datalabels.js">
    </script>
    <script src="{{ asset('template') }}/vendors/justgage/raphael-2.1.4.min.js"></script>
    <script src="{{ asset('template') }}/vendors/justgage/justgage.js"></script>
    <script src="{{ asset('template') }}/js/jquery.cookie.js" type="text/javascript"></script>
    <script src="{{ asset('template') }}/js/dashboard.js"></script>
    <script
        src="{{ asset('template') }}/vendors/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js">
    </script>
    <script
        src="{{ asset('template') }}/vendors/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js">
    </script>
    <script
        src="{{ asset('template') }}/vendors/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js">
    </script>
    <script
        src="{{ asset('template') }}/vendors/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js">
    </script>
    <script
        src="{{ asset('template') }}/vendors/filepond-plugin-image-filter/filepond-plugin-image-filter.min.js">
    </script>
    <script
        src="{{ asset('template') }}/vendors/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js">
    </script>
    <script
        src="{{ asset('template') }}/vendors/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js">
    </script>
    <script src="{{ asset('template') }}/vendors/filepond/filepond.js"></script>
    <script src="{{ asset('template') }}/vendors/filepond.js"></script>
    <script src="{{ asset('template') }}/vendors/toastify-js/src/toastify.js"></script>
    <script src="{{ asset('template') }}/vendors/toast.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js') }}/sweetalert.js"></script>
    <script src="{{ asset('select2') }}/dist/js/select2.js"></script>
    <script>
        $('.select2').select2();
        $(document).ready(function () {
            $('#logout').click(function () {
                console.log('tes');
                $.ajaxSetup({
                	headers: {
                		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                	}
                });
                $.ajax({
                	url: "/logout",
                	type: 'POST',
                	data: {
                		_token:'{{ csrf_token() }}'
                	},
                	success: function (result) {
                		if (result.success) {
                			location.reload();
                		}
                	},
                });
            });
        });

        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (
                (charCode >= 48 && charCode <= 57) ||
                charCode === 46 ||
                charCode === 8 ||
                charCode === 46 ||
                charCode === 37 ||
                charCode === 39
            ) {
                if (charCode === 46 && evt.target.value.indexOf('.') !== -1) {
                    return false;
                }
                return true;
            }
            return false;
        }

    </script>
    @stack('script')
</body>

</html>
