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
                                <div class="card text-center py-5">
                                    @if($pengumuman == null)
                                        <h5 class="mt-3">
                                            Anda belum melakukan pendaftaran, segera lakukan Pendaftaran Mahasiswa Baru!
                                        </h5>
                                    @else
                                        @if($pengumuman->status == 1)
                                            <h5 class="mt-3">
                                                SELAMAT ANDA DINYATAKAN DITERIMA
                                            </h5>
                                            <p>{{ $pengumuman->prodi->nama_prodi }}</p>
                                            @if ($pengumuman->bukti_bayar_herregistrasi == null)
                                                <form id="form">
                                                    @csrf
                                                    <span>Silahkan lakukan pembayaran Biaya Herregistrasi melalui transfer
                                                        {{ $config->nama_bank }} a/n {{ $config->atasnama_rekening }}</span>
                                                    <div class="alert alert-light-secondary color-secondary mt-2">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <img id="logo-bca"
                                                                    src="{{ asset('img') }}/bri.png"
                                                                    alt="Logo">
                                                            </div>
                                                            <div class="col-md-8">
                                                                <h3 class="mt-5">No. Rekening : {{ $config->no_rekening }}</h3>
                                                                <h3>a/n {{ $config->atasnama_rekening }}
                                                                </h3>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <h5>Biaya Pendaftaran Calon Mahasiswa sejumlah Rp. {{ number_format($config->biaya_pendaftaran, 2, ",", ".") }}</h5>
                                                    </div>
                                                    <div class="row mt-5">
                                                        <div class="col-md-4">
                                                            <label for="file_herregistrasi">Bukti Pembayaran</label>
                                                        </div>
                                                        @error('file_herregistrasi')
                                                            <span class="text-danger">
                                                                *<strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <div class="col-md-8 form-group">
                                                            <input type="file"
                                                                class="image-preview-filepond @error('file_herregistrasi') is-invalid @enderror"
                                                                id="file_herregistrasi" name="file_herregistrasi">
                                                                <input type="hidden" name="id" value="{{ $pengumuman->id }}">
                                                            <small>File bertipe jpg/jpeg/png, maksimal berukuran 2MB</small>
                                                            <input type="hidden" name="semester" value="1">
                                                        </div>
                                                        <input type="hidden" name="nominal_herregistrasi" id="nominal_herregistrasi" value="{{ $config->biaya_herregistrasi }}">
                                                    </div>
                                                    <button id="save" type="button" class="btn btn-success">
                                                        Submit
                                                    </button>
                                                    <button class="btn btn-success spinner" id="loading" style="display: none;" type="button" disabled="">
                                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                        Loading...
                                                    </button>
                                                </form>
                                            @else
                                                <span>Pembayaran Herregistrasi telah dilakukan, dan dalam proses verifikasi admin</span>
                                            @endif
                                        @elseif($pengumuman->status == 3)
                                            <h5 class="mt-3">
                                                MOHON MAAF ANDA DINYATAKAN <b>TIDAK DITERIMA</b>
                                            </h5>
                                            <p>
                                                {{ $pengumuman->keterangan }}
                                            </p>
                                        @else
                                            <h5 class="mt-3">
                                                Proses Pendaftaran anda sedang dalam proses, penerimaan akan diumumkan
                                                setelah proses selesai!
                                            </h5>
                                        @endif
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
            $('#save').click(function () {
                var form = $('#form')[0],
                    data = new FormData(form);

                $('.spinner').css('display', 'block');
                $(this).css('display', 'none');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "/herregistrasi",
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: data,
                    success: function (result) {
                        if (result.success) {
                            successMsg(result.success)
                            $('.spinner').css('display', 'none');
                            $('#save').css('display', 'block');
                            $('#form').find('input').val('');
                            location.reload();
                        } else {
                            $('.spinner').css('display', 'none');
                            $('#save').css('display', 'block');
                            $.each(result.errors, function (key, value) {
                                errorMsg(value)
                            });
                        }
                    }
                });
            });
        })
    </script>
@endpush