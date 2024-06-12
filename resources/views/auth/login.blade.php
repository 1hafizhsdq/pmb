<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>PMB - STAINUPA</title>
  <link rel="stylesheet" href="{{ asset('template') }}/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="{{ asset('template') }}/vendors/base/vendor.bundle.base.css">
  <link rel="stylesheet" href="{{ asset('template') }}/css/style.css">
  <link rel="shortcut icon" href="{{ asset('img') }}/logo.png" />
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
                  <form class="pt-3" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                      <label for="username">Email</label>
                      @error('username')
                        <span class="text-danger">
                            *<strong>{{ $message }}</strong>
                        </span>
                      @enderror
                      <div class="input-group">
                        <input type="text" class="form-control form-control-lg border-left-0 @error('username') is-invalid @enderror" id="username" name="username" placeholder="Email" value="{{ old('username') }}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="password">Password</label>
                      @error('password')
                        <span class="text-danger" role="alert">
                            *<strong>{{ $message }}</strong>
                        </span>
                      @enderror
                      <div class="input-group">
                        <input type="password" class="form-control form-control-lg border-left-0 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password">                        
                      </div>
                    </div>
                    <div class="my-2 d-flex justify-content-between align-items-center">
                      <div class="form-check">
                        <label class="form-check-label text-muted">
                          <input type="checkbox" class="form-check-input" value="" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                          Ingat Saya
                        </label>
                      </div>
                      @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="auth-link text-black">Lupa password?</a>
                      @endif
                    </div>
                    <div class="col-12">
                      {!! htmlFormSnippet() !!}
                    </div>
                    <div class="my-3">
                      <button style="color: #fff;background-color: #076b37;border-color: #000000;" type="submit" class="btn btn-block btn-success btn-lg font-weight-medium auth-form-btn">LOGIN</button>
                    </div>
                    <div class="text-center mt-4 font-weight-light">
                      Belum memiliki akun? <a href="{{ route('register') }}" class="text-primary">Daftar disini</a>
                    </div>
                  </form>
              @endif
            </div>
          </div>
          <div class="col-lg-6 login-half-bg d-flex flex-row">
            {{-- <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright &copy; 2021  All rights reserved.</p> --}}
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('template') }}/vendors/base/vendor.bundle.base.js"></script>
  <script src="{{ asset('template') }}/js/template.js"></script>
</body>

</html>
