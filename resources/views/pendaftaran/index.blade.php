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
                                    @if ($is_regis)
                                    <div class="card-body mt-3">
                                        <h2 style="color: black;">{{ $title }}</h2>
                                        <h4>Data Pendaftaran Mahasiswa Baru Tahun Ajaran {{ $user->pendaftaran[0]->tahunajaran->nama_tahun_ajaran }} telah tersimpan</h4>
                                        <span>Silahkan pantau hasil pengumuman Penerimaan Mahasiswa Baru pada menu "Pengumuman"</span>
                                    </div>
                                    @else
                                    <div class="card-body">
                                            <h2 style="color: black;margin-bottom: 35px;">{{ $title }}</h2>
                                            <form id="form">
                                                @csrf
                                                {{-- Start section Biodata Diri --}}
                                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                                <input type="hidden" name="tahun_ajaran_id" value="{{ $tahun_ajarans->id }}">
                                                <h4 class="card-title">Biodata Diri</h4>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="nama">Nama Lengkap</label>
                                                    </div>
                                                    @error('nama')
                                                        <span class="text-danger">
                                                            *<strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="nama" class="form-control @error('nama') is-invalid @enderror" name="nama"
                                                            value="{{ Auth::user()->nama }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="tempat_lahir">Tempat & Tanggal Lahir</label>
                                                    </div>
                                                    @error('tempat_lahir')
                                                        <span class="text-danger">
                                                            *<strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <div class="col-md-4 form-group">
                                                        <input type="text" id="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" name="tempat_lahir">
                                                    </div>
                                                    @error('tgl_lahir')
                                                        <span class="text-danger">
                                                            *<strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <div class="col-md-4 form-group">
                                                        <input type="date" id="tgl_lahir" onkeypress="return isNumber(event)" class="form-control @error('tgl_lahir') is-invalid @enderror" name="tgl_lahir">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                                    </div>
                                                    @error('jenis_kelamin')
                                                        <span class="text-danger">
                                                            *<strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin">
                                                            <option value="">-- Pilih Jenis Kelamin --</option>
                                                            <option value="Laki-laki">Laki-laki</option>
                                                            <option value="Perempuan">Perempuan</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="alamat">Alamat</label>
                                                    </div>
                                                    @error('alamat')
                                                        <span class="text-danger">
                                                            *<strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="telp">Nomor Telepon</label>
                                                    </div>
                                                    @error('telp')
                                                        <span class="text-danger">
                                                            *<strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="telp" onkeypress="return isNumber(event)" class="form-control @error('telp') is-invalid @enderror" name="telp"
                                                            value="{{ Auth::user()->telp }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="email">Email</label>
                                                    </div>
                                                    @error('email')
                                                        <span class="text-danger">
                                                            *<strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                                            value="{{ Auth::user()->email }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="nik">Nomor Induk Kependudukan (NIK)</label>
                                                    </div>
                                                    @error('nik')
                                                        <span class="text-danger">
                                                            *<strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="nik" class="form-control @error('nik') is-invalid @enderror" name="nik"
                                                            onkeypress="return isNumber(event)">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="nisn">Nomor Induk Siswa Nasional (NISN)</label>
                                                    </div>
                                                    @error('nisn')
                                                        <span class="text-danger">
                                                            *<strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="nisn" class="form-control @error('nisn') is-invalid @enderror" name="nisn"
                                                            onkeypress="return isNumber(event)">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="jenis_sekolah">Jenis Sekolah</label>
                                                    </div>
                                                    @error('jenis_sekolah')
                                                        <span class="text-danger">
                                                            *<strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select @error('jenis_sekolah') is-invalid @enderror" id="jenis_sekolah" name="jenis_sekolah">
                                                            <option value="">-- Pilih Jenis Sekolah --</option>
                                                            <option value="SMA">SMA</option>
                                                            <option value="SMK">SMK</option>
                                                            <option value="Madarasah">Madarasah</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="nama_sekolah">Nama Sekolah</label>
                                                    </div>
                                                    @error('nama_sekolah')
                                                        <span class="text-danger">
                                                            *<strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="nama_sekolah" class="form-control @error('nama_sekolah') is-invalid @enderror" name="nama_sekolah">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="jurusan">Jurusan Sekolah</label>
                                                    </div>
                                                    @error('jurusan_sekolah')
                                                        <span class="text-danger">
                                                            *<strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="jurusan_sekolah" class="form-control @error('jurusan_sekolah') is-invalid @enderror" name="jurusan_sekolah"
                                                            placeholder="Contoh : IPA">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="periode">Periode Sekolah</label>
                                                    </div>
                                                    @error('tahun_masuk')
                                                        <span class="text-danger">
                                                            *<strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <div class="col-md-4 form-group">
                                                        <input type="text" id="tahun_masuk" class="form-control @error('tahun_masuk') is-invalid @enderror" name="tahun_masuk"
                                                            placeholder="Tahun Masuk" onkeypress="return isNumber(event)">
                                                    </div>
                                                    @error('tahun_lulus')
                                                        <span class="text-danger">
                                                            *<strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <div class="col-md-4 form-group">
                                                        <input type="text" id="tahun_lulus" class="form-control @error('tahun_lulus') is-invalid @enderror" name="tahun_lulus"
                                                            placeholder="Tahun Lulus" onkeypress="return isNumber(event)">
                                                    </div>
                                                </div>
            
                                                {{-- End section Biodata Diri --}}
            
                                                {{-- Start section Biodata Ayah --}}
                                                <h4 class="card-title">Biodata Ayah</h4>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="nama_ayah">Nama Lengkap</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="nama_ayah" class="form-control" name="nama_ayah">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="tempat_lahir">Tempat & Tanggal Lahir</label>
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <input type="text" id="tempat_lahir_ayah" class="form-control"
                                                            name="tempat_lahir_ayah">
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <input type="date" id="tgl_lahir_ayah" class="form-control" name="tgl_lahir_ayah">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="nik">Nomor Induk Kependudukan (NIK)</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="nik_ayah" class="form-control" name="nik_ayah"
                                                            onkeypress="return isNumber(event)">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="alamat_ayah">Alamat</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="alamat_ayah" class="form-control" name="alamat_ayah">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="pendidikan_ayah">Pendidikan Terakhir</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select" id="pendidikan_ayah" name="pendidikan_ayah">
                                                            <option value="">-- Pilih Pendidikan Terakhir--</option>
                                                            <option value="SD">SD</option>
                                                            <option value="SMP">SMP</option>
                                                            <option value="SMA">SMA</option>
                                                            <option value="D-1">D-1</option>
                                                            <option value="D-2">D-2</option>
                                                            <option value="D-3">D-3</option>
                                                            <option value="D-4">D-4</option>
                                                            <option value="S-1">S-1</option>
                                                            <option value="S-2">S-2</option>
                                                            <option value="S-3">S-3</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="pekerjaan_ayah">Pekerjaan</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="pekerjaan_ayah" class="form-control" name="pekerjaan_ayah">
                                                    </div>
                                                </div>
                                                {{-- End section Biodata Ayah --}}
            
                                                {{-- Start section Biodata Ibu --}}
                                                <h4 class="card-title">Biodata Ibu</h4>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="nama_ibu">Nama Lengkap</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="nama_ibu" class="form-control" name="nama_ibu">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="tempat_lahir">Tempat & Tanggal Lahir</label>
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <input type="text" id="tempat_lahir_ibu" class="form-control"
                                                            name="tempat_lahir_ibu">
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <input type="date" id="tgl_lahir_ibu" class="form-control" name="tgl_lahir_ibu">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="nik">Nomor Induk Kependudukan (NIK)</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="nik_ibu" class="form-control" name="nik_ibu"
                                                            onkeypress="return isNumber(event)">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="alamat_ibu">Alamat</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="alamat_ibu" class="form-control" name="alamat_ibu">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="pendidikan_ibu">Pendidikan Terakhir</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select" id="pendidikan_ibu" name="pendidikan_ibu">
                                                            <option value="">-- Pilih Pendidikan Terakhir--</option>
                                                            <option value="SD">SD</option>
                                                            <option value="SMP">SMP</option>
                                                            <option value="SMA">SMA</option>
                                                            <option value="D-1">D-1</option>
                                                            <option value="D-2">D-2</option>
                                                            <option value="D-3">D-3</option>
                                                            <option value="D-4">D-4</option>
                                                            <option value="S-1">S-1</option>
                                                            <option value="S-2">S-2</option>
                                                            <option value="S-3">S-3</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="pekerjaan_ibu">Pekerjaan</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="pekerjaan_ibu" class="form-control" name="pekerjaan_ibu">
                                                    </div>
                                                </div>
                                                {{-- End section Biodata Ibu --}}
            
                                                {{-- Start section Dokumen --}}
                                                <h4 class="card-title">Dokumen</h4>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="file">File Ijazah</label>
                                                    </div>
                                                    @error('file')
                                                        <span class="text-danger">
                                                            *<strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <div class="col-md-8 form-group">
                                                        <input type="file" class="basic-filepond @error('file') is-invalid @enderror" id="file" name="file">
                                                        <small>File bertipe PDF, maksimal berukuran 2MB</small>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="no_ijazah">No Ijazah</label>
                                                    </div>
                                                    @error('no_ijazah')
                                                        <span class="text-danger">
                                                            *<strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="no_ijazah" class="form-control @error('no_ijazah') is-invalid @enderror" name="no_ijazah">
                                                    </div>
                                                </div>
                                                {{-- End section Dokumen --}}
            
                                                {{-- Start section Jurusan --}}
                                                <h4 class="card-title">Program Studi</h4>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="prodi_id">Program Studi</label>
                                                    </div>
                                                    @error('prodi_id')
                                                        <span class="text-danger">
                                                            *<strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select @error('prodi_id') is-invalid @enderror" id="prodi_id" name="prodi_id">
                                                            <option value="">-- Pilih Program Studi--</option>
                                                            @foreach($prodi as $p)
                                                                <option value="{{ $p->id }}">{{ $p->nama_prodi }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                {{-- End section Jurusan --}}
                                                {{-- start section pembayaran --}}
                                                <h4 class="card-title">Pembayaran Pendaftaran</h4>
                                                <span>Silahkan lakukan pembayaran Biaya Pendaftaran melalui transfer {{ $config->nama_bank }} a/n {{ $config->atasnama_rekening }}</span>
                                                <div class="alert alert-light-secondary color-secondary mt-2">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <img id="logo-bca" src="{{ asset('img') }}/bri.png" alt="Logo">
                                                        </div>
                                                        <div class="col-md-8">
                                                            <h3 class="mt-5">No. Rekening : {{ $config->no_rekening }}</h3>
                                                            <h3>a/n {{ $config->atasnama_rekening }}</h3>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <h5>Biaya Pendaftaran Calon Mahasiswa sejumlah Rp. {{ number_format($config->biaya_pendaftaran, 2, ",", ".") }}</h5>
                                                </div>
                                                <div class="row mt-5">
                                                    <div class="col-md-4">
                                                        <label for="file_pembayaran">Bukti Pembayaran</label>
                                                    </div>
                                                    @error('file_pembayaran')
                                                        <span class="text-danger">
                                                            *<strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <div class="col-md-8 form-group">
                                                        <input type="file" class="image-preview-filepond @error('file_pembayaran') is-invalid @enderror" id="file_pembayaran" name="file_pembayaran">
                                                        <small>File bertipe jpg/jpeg/png, maksimal berukuran 2MB</small>
                                                    </div>
                                                    <input type="hidden" name="nominal_pendaftaran" id="nominal_pendaftaran" value="{{ $config->biaya_pendaftaran }}">
                                                </div>
                                                {{-- end section pembayaran --}}
                                                <button id="save" type="button" class="btn btn-success">
                                                    {{-- <i class="bx bx-check d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">Daftar</span> --}}
                                                    Daftar
                                                </button>
                                                <button class="btn btn-success spinner" id="loading" style="display: none;" type="button" disabled="">
                                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                    Loading...
                                                </button>
                                            </form>
                                        </div>
                                    @endif
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

@push('script')
    <script>
        $(document).ready(function () {
            $('#save').click(function(){
                var form = $('#form')[0],
                data = new FormData(form);
                
                $('.spinner').css('display','block');
                $(this).css('display','none');

                $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "/pendaftaran",
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function(result) {
                        if (result.success) {
                            successMsg(result.success)
                            $('.spinner').css('display','none');
                            $('#save').css('display','block');
                            $('#form').find('input').val('');
                            location.reload();
                        } else {
                            $('.spinner').css('display','none');
                            $('#save').css('display','block');
                            msg = ''
                            $.each(result.errors, function(key, value) {
                                msg += value;
                            });
                            errorMsg(msg)
                        }
                    }
                });
            });
        })
    </script>
@endpush