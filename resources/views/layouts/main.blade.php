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
	</head>
	<body>
		<div class="container-scroller">
			<!-- partial:partials/_horizontal-navbar.html -->
			<div class="horizontal-menu">
				<nav class="navbar top-navbar col-lg-12 col-12 p-0">
					<div class="container-fluid">
					<div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
						<ul class="navbar-nav navbar-nav-left">
							<li>
								<div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
									<a class="navbar-brand brand-logo" href="#">
										<img style="height: 70px; width: 70px;" src="{{ asset('img') }}/logo.png" alt="logo"/>
									</a>
									<a class="navbar-brand brand-logo-mini" href="#">
										<img style="height: 50px; width: 50px;" src="{{ asset('img') }}/logo.png" alt="logo"/>
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
						<ul class="navbar-nav navbar-nav-right">
							<li class="nav-item nav-profile dropdown">
								<a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
									<span class="nav-profile-name">{{ Auth::user()->nama }}</span>
									<span class="online-status"></span>
									<img src="{{ asset('template') }}/images/faces/face28.png" alt="profile"/>
								</a>
								<div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
									{{-- <a class="dropdown-item">
										<i class="mdi mdi-settings text-primary"></i>
										Settings
									</a> --}}
									<a class="dropdown-item" id="logout">
										<i class="mdi mdi-logout text-primary"></i>
										Logout
									</a>
								</div>
							</li>
						</ul>
						<button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
						<span class="mdi mdi-menu"></span>
						</button>
					</div>
					</div>
				</nav>
				<nav class="bottom-navbar">
					<div class="container">
						<ul class="nav page-navigation">
							<li class="nav-item active">
								<a class="nav-link" href="/">
								<i class="mdi mdi-file-document-box menu-icon"></i>
								<span class="menu-title" style="color: #000000;">Pendaftaran</span>
								</a>
							</li>
							<li class="nav-item">
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
		<script src="{{ asset('template') }}/js/template.js"></script>
		<script src="{{ asset('template') }}/vendors/chart.js/Chart.min.js"></script>
		<script src="{{ asset('template') }}/vendors/progressbar.js/progressbar.min.js"></script>
		<script src="{{ asset('template') }}/vendors/chartjs-plugin-datalabels/chartjs-plugin-datalabels.js"></script>
		<script src="{{ asset('template') }}/vendors/justgage/raphael-2.1.4.min.js"></script>
		<script src="{{ asset('template') }}/vendors/justgage/justgage.js"></script>
		<script src="{{ asset('template') }}/js/jquery.cookie.js" type="text/javascript"></script>
		<script src="{{ asset('template') }}/js/dashboard.js"></script>
		<script>
			$(document).ready(function () {
				$('#logout').click(function(){
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
		</script>
        @stack('script')
	</body>
</html>