<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>PMB - STAINUPA</title>
  <!-- base:css -->
  <link rel="stylesheet" href="{{ asset('template') }}/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="{{ asset('template') }}/vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('template') }}/css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ asset('img') }}/logo.png" />
  <style>
      #img-logo {
          height: 100px !important;
      }
      #auth #auth-right {
          /* background-image: url('{{ asset("dist/assets/compiled/jpg/cover.jpg") }}'); */
          background: url(./png/4853433.png), linear-gradient(90deg, #2d9d40, #918c3f);
          background-size: cover;
          background-position: center;
          width: 100%;
          height: 100%;
      }
  </style>
  {!! ReCaptcha::htmlScriptTagJsApi() !!}
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
        <div class="row flex-grow">
          <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <div class="auth-form-transparent text-left p-3">
              <div class="brand-logo">
                <img src="{{ asset('img') }}/logo.png" alt="logo">
              </div>
              <h2>PENDAFTARAN MAHASISWA BARU</h2>
              <h6 class="font-weight-light">SILAHKAN LOGIN</h6>
              @if (Session::has('message'))
                <div class="alert alert-danger">{{ Session::get('message') }}</div>
              @endif
              @if ($form_dibuka == false)
                <div class="alert alert-danger">{{ $status_message }}</div>
              @else
                <form class="pt-3" method="POST" action="{{ route('register') }}">
                  @csrf
                  @error('email')
                      <span class="text-danger">
                          *<strong>{{ $message }}</strong>
                      </span>
                  @enderror
                  <div class="form-group">
                    <label>Email</label>
                    <div class="input-group">
                      <input type="text" class="form-control form-control-lg border-left-0 @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email') }}" placeholder="Email">
                    </div>
                  </div>
                  @error('name')
                      <span class="text-danger">
                          *<strong>{{ $message }}</strong>
                      </span>
                  @enderror
                  <div class="form-group">
                    <label>Nama Lengkap</label>
                    <div class="input-group">
                      <input type="text" class="form-control form-control-lg border-left-0 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap">
                    </div>
                  </div>
                  @error('telp')
                      <span class="text-danger">
                          *<strong>{{ $message }}</strong>
                      </span>
                  @enderror
                  <div class="form-group">
                    <label>Telp (WA)</label>
                    <div class="input-group">
                      <input type="text" class="form-control form-control-lg border-left-0 @error('telp') is-invalid @enderror" name="telp" value="{{ old('telp') }}" placeholder="Telpon (WA)" onkeypress="return isNumber(event)">
                    </div>
                  </div>
                  @error('password')
                      <span class="text-danger">
                          *<strong>{{ $message }}</strong>
                      </span>
                  @enderror
                  <div class="form-group">
                    <label>Password</label>
                    <div class="input-group">
                      <input type="password" class="form-control form-control-lg border-left-0 @error('password') is-invalid @enderror" name="password" placeholder="Password">                        
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Ulangi Password</label>
                    <div class="input-group">
                      <input type="password" class="form-control form-control-lg border-left-0 @error('password') is-invalid @enderror" name="password_confirmation" placeholder="Confirm Password">                        
                    </div>
                  </div>
                  <div class="col-12">
                    @error('g-recaptcha-response')
                      <span class="text-danger">
                          *<strong>{{ $message }}</strong>
                      </span>
                    @enderror
                    {!! htmlFormSnippet() !!}
                  </div>
                  <div class="mt-3">
                    <button style="color: #fff;background-color: #076b37;border-color: #000000;" class="btn btn-block btn-success btn-lg font-weight-medium auth-form-btn">Register</button>
                  </div>
                  <div class="text-center mt-4 font-weight-light">
                    Sudah memiliki akun? <a href="/login" class="text-primary">Login</a>
                  </div>
                </form>
              @endif
            </div>
          </div>
          <div class="col-lg-6 register-half-bg d-flex flex-row">
            {{-- <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright &copy; 2021  All rights reserved.</p> --}}
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->
  <script src="{{ asset('template') }}/vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="{{ asset('template') }}/js/template.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->
</body>

</html>ß

</html>