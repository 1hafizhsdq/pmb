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
                                <h3 class="text-dark font-weight-bold mb-2">Hi, {{ $user->name }}!</h3>
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
                                        <h4>Data Pendaftaran Mahasiswa Baru Tahun Ajaran {{ $user->pendaftaran[0]->periode->nama_periode }} Semester {{ $user->pendaftaran[0]->periode->semester }} telah tersimpan</h4>
                                        <span>Silahkan pantau hasil pengumuman Penerimaan Mahasiswa Baru pada menu "Pengumuman"</span>
                                    </div>
                                    @else
                                    <div class="card-body">
                                            <h2 style="color: black;margin-bottom: 35px;">{{ $title }}</h2>
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            {{-- <form id="form" method="POST" action="/pendaftaran" enctype="multipart/form-data"> --}}
                                            <form id="form">
                                                @csrf
                                                {{-- Start section Biodata Diri --}}
                                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                                <input type="hidden" name="periode_id" value="{{ $periodes->id }}">
                                                <h4 class="card-title">Biodata Diri</h4>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="nama">Nama Lengkap</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="nama" class="form-control @error('nama') is-invalid @enderror" name="nama"
                                                            value="{{ $user->name }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="tempat_lahir">Tempat & Tanggal Lahir</label>
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <input type="text" id="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" name="tempat_lahir">
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <input type="date" id="tgl_lahir" onkeypress="return isNumber(event)" class="form-control @error('tgl_lahir') is-invalid @enderror" name="tgl_lahir">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select select2 @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin">
                                                            <option value="">-- Pilih Jenis Kelamin --</option>
                                                            <option value="Laki-laki">Laki-laki</option>
                                                            <option value="Perempuan">Perempuan</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="alamat">Alamat</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="provinsi_id">Provinsi</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select select2 @error('provinsi_id') is-invalid @enderror" id="provinsi_id" name="provinsi_id">
                                                            <option value="">-- Pilih Provinsi --</option>
                                                            @foreach ($provinsis as $pr)
                                                                <option value="{{ $pr->id }}">{{ $pr->nama_provinsi }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="kota_id">Kabupaten/Kota</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select select2 @error('kota_id') is-invalid @enderror" id="kota_id" name="kota_id">
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="kecamatan_id">Kecamatan</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select select2 @error('kecamatan_id') is-invalid @enderror" id="kecamatan_id" name="kecamatan_id">
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="kelurahan_id">Kelurahan</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select select2 @error('kelurahan_id') is-invalid @enderror" id="kelurahan_id" name="kelurahan_id">
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="kode_pos">Kodepos/Dusun/RT/RW</label>
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <input type="text" id="kode_pos" class="form-control @error('kode_pos') is-invalid @enderror" name="kode_pos" placeholder="Kodepos">
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <input type="text" id="dusun" class="form-control @error('dusun') is-invalid @enderror" name="dusun" placeholder="Dusun">
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <input type="text" id="rt" class="form-control @error('rt') is-invalid @enderror" name="rt" placeholder="RT">
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <input type="text" id="rw" class="form-control @error('rw') is-invalid @enderror" name="rw" placeholder="RW">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="telp">Nomor Telepon</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="telp" onkeypress="return isNumber(event)" class="form-control @error('telp') is-invalid @enderror" name="telp"
                                                            value="{{ $user->telp }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="email">Email</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                                            value="{{ $user->email }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="nik">Nomor Induk Kependudukan (NIK)</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="nik" class="form-control @error('nik') is-invalid @enderror" name="nik"
                                                            onkeypress="return isNumber(event)">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="nisn">Nomor Induk Siswa Nasional (NISN)</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="nisn" class="form-control @error('nisn') is-invalid @enderror" name="nisn"
                                                            onkeypress="return isNumber(event)">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="jenis_sekolah">Jenis Sekolah</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select select2 @error('jenis_sekolah') is-invalid @enderror" id="jenis_sekolah" name="jenis_sekolah">
                                                            <option value="">-- Pilih Jenis Sekolah --</option>
                                                            <option value="SMA">SMA</option>
                                                            <option value="SMK">SMK</option>
                                                            <option value="Madarasah">Madarasah</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="nama_sekolah">Nama Sekolah</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="nama_sekolah" class="form-control @error('nama_sekolah') is-invalid @enderror" name="nama_sekolah">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="jurusan">Jurusan Sekolah</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="jurusan_sekolah" class="form-control @error('jurusan_sekolah') is-invalid @enderror" name="jurusan_sekolah"
                                                            placeholder="Contoh : IPA">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="periode">Periode Sekolah</label>
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <input type="text" id="tahun_masuk" class="form-control @error('tahun_masuk') is-invalid @enderror" name="tahun_masuk"
                                                            placeholder="Tahun Masuk" onkeypress="return isNumber(event)">
                                                    </div>
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
                                                        <select class="form-select select2" id="pendidikan_ayah" name="pendidikan_ayah">
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
                                                    <div class="col-md-4">
                                                        <label for="penghasilan">Penghasilan</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="penghasilan_ayah" class="form-control" name="penghasilan_ayah"
                                                            onkeypress="return isNumber(event)">
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
                                                        <select class="form-select select2" id="pendidikan_ibu" name="pendidikan_ibu">
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
                                                    <div class="col-md-4">
                                                        <label for="penghasilan">Penghasilan</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="penghasilan_ibu" class="form-control" name="penghasilan_ibu"
                                                            onkeypress="return isNumber(event)">
                                                    </div>
                                                </div>
                                                {{-- End section Biodata Ibu --}}
            
                                                {{-- Start section Dokumen --}}
                                                <h4 class="card-title">Dokumen</h4>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="file">File Ijazah</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="file" class="basic-filepond @error('file') is-invalid @enderror" id="file" name="file">
                                                        <small>File bertipe PDF, maksimal berukuran 2MB</small>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="no_ijazah">No Ijazah</label>
                                                    </div>
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
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select select2 @error('prodi_id') is-invalid @enderror" id="prodi_id" name="prodi_id">
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
                                                <span>Silahkan lakukan pembayaran Biaya Pendaftaran melalui transfer {{ $config->nama_bank }} a/n {{ $config->atasnama_rekenning }}</span>
                                                <div class="alert alert-light-secondary color-secondary mt-2">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            {{-- <img id="logo-bca" src="{{ asset('img') }}/bri.png" alt="Logo"> --}}
                                                            <img style="height: 70px; width: 90px;" src="{{ asset('img') }}/bri.png" alt="logo" />
                                                        </div>
                                                        <div class="col-md-8">
                                                            <h3 class="mt-5">No. Rekening : {{ $config->no_rekening }}</h3>
                                                            <h3>a/n {{ $config->atasnama_rekenning }}</h3>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <h5>Biaya Pendaftaran Calon Mahasiswa sejumlah Rp. {{ number_format($config->biaya_pendaftaran, 2, ",", ".") }}</h5>
                                                </div>
                                                <div class="row mt-5">
                                                    <div class="col-md-4">
                                                        <label for="file_pembayaran">Bukti Pembayaran</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="file" class="image-preview-filepond @error('file_pembayaran') is-invalid @enderror" id="file_pembayaran" name="file_pembayaran">
                                                        <small>File bertipe jpg/jpeg/png, maksimal berukuran 2MB</small>
                                                    </div>
                                                    <input type="hidden" name="nominal_pendaftaran" id="nominal_pendaftaran" value="{{ $config->biaya_pendaftaran }}">
                                                    <div class="col-md-4">
                                                        <label for="tgl_bayar">Tanggal Pembayaran</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="date" id="tgl_bayar" class="form-control @error('tgl_bayar') is-invalid @enderror" name="tgl_bayar">
                                                    </div>
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
                $('.spinner').css('display','block');
                $('#save').css('display','none');
            });
        }).on('change','#provinsi_id',function(){
            var id = $(this).val();

            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });
            $.ajax({
                url: "/kota/"+id,
                type: 'GET',
                success: function (result) {
                    var data = '<option value="">-- Pilih Kota --</option>'
                    $.each(result, function (key, val) {
                        data += '<option value="'+val.id+'">'+val.nama_kota+'</option>'
                    });
                    $('#kota_id').html(data);
                },
                // complete: function () {
                //     var newToken = $('meta[name="csrf-token"]').attr('content');
                //     $('input[name="_token"]').val(newToken);
                // }
            });
        }).on('change','#kota_id',function(){
            var id = $(this).val();

            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });
            $.ajax({
                url: "/kecamatan/"+id,
                type: 'GET',
                success: function (result) {
                    var data = '<option value="">-- Pilih Kecamatan --</option>'
                    $.each(result, function (key, val) {
                        data += '<option valie="'+val.id+'">'+val.name_kecamatan+'</option>'
                    });
                    $('#kecamatan_id').html(data);
                },
                // complete: function () {
                //     var newToken = $('meta[name="csrf-token"]').attr('content');
                //     $('input[name="_token"]').val(newToken);
                // }
            });
        }).on('change','#kecamatan_id',function(){
            var id = $(this).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/kelurahan/"+id,
                type: 'GET',
                success: function (result) {
                    var data = '<option value="">-- Pilih Kelurahan --</option>'
                    $.each(result, function (key, val) {
                        data += '<option value="'+val.id+'">'+val.nama_kelurahan+'</option>'
                    });
                    $('#kelurahan_id').html(data);
                },
                complete: function () {
                    var newToken = $('meta[name="csrf-token"]').attr('content');
                    $('input[name="_token"]').val(newToken);
                }
            });
        }).on('change','#kelurahan_id',function(){
            var id = $(this).val();

            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });
            $.ajax({
                url: "/kodepose/"+id,
                type: 'GET',
                success: function (result) {
                    $('#kode_pos').val(result.kode_pos);
                },
                complete: function () {
                    var newToken = $('meta[name="csrf-token"]').attr('content');
                    $('input[name="_token"]').val(newToken);
                }
            });
        }).on('click','#save',function(){
            var form = $('#form')[0],
            data = new FormData(form);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('pendaftaran')}}",
                method: "POST",
                processData: false,
                contentType: false,
                data: data,
                beforeSend: function() {
                    $('#save').css('display','none');
                    $('#loading').css('display','block');
                },
                success: function(result) {
                    if (result.success) {
                        successMsg(result.success)
                        $('#save').css('display','block');
                        $('#loading').css('display','none');
                        setInterval(function () {
                            window.location.reload();
                        }, 1000);
                    }else{
                        errorMsg(result.errors)
                        $('#save').css('display','block');
                        $('#loading').css('display','none');
                    }
                },
            });
        });
    </script>
@endpush

