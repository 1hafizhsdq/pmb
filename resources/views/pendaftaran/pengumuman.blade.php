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
                            <h3 class="text-dark font-weight-bold mb-2">Hi, {{ Auth::user()->name }}!</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 flex-column d-flex stretch-card">
                    <div class="row">
                        <div class="col-sm-12 grid-margin d-flex stretch-card">
                            <div class="card text-center py-5">
                                @if ($pengumuman == null)
                                    <div class="row mb-5">
                                        <div class="col"></div>
                                        <div class="col-10">
                                            <img style="height: 70px; width: 90px; margin-bottom: 25px;"
                                                src="{{ asset('img') }}/tolak.png"
                                                alt="logo" />
                                            <h2>PERHATIAN</h2>
                                            <h4>Anda belum melakukan pendaftaran, segera lakukan Pendaftaran Mahasiswa Baru!</h4>
                                        </div>
                                        <div class="col"></div>
                                    </div>
                                @else
                                    <div id="stepper3" class="bs-stepper">
                                        <div class="bs-stepper-header" role="tablist">
                                            <div class="step" data-target="#test-nlf-1">
                                                <button type="button" class="step-trigger" role="tab" id="stepper3trigger1"
                                                    aria-controls="test-nlf-1">
                                                    <span class="bs-stepper-circle">
                                                        <i class="mdi mdi-file-document-box menu-icon"></i>
                                                    </span>
                                                    <span class="bs-stepper-label">Pengumuman</span>
                                                </button>
                                            </div>
                                            <div class="bs-stepper-line"></div>
                                            <div class="step" data-target="#test-nlf-2">
                                                <button type="button" class="step-trigger" role="tab" id="stepper3trigger2"
                                                    aria-controls="test-nlf-2">
                                                    <span class="bs-stepper-circle">
                                                        <i class="mdi mdi-file-document-box menu-icon"></i>
                                                    </span>
                                                    <span class="bs-stepper-label">Daftar Ulang</span>
                                                </button>
                                            </div>
                                            <div class="bs-stepper-line"></div>
                                            <div class="step" data-target="#test-nlf-3">
                                                <button type="button" class="step-trigger" role="tab" id="stepper3trigger3"
                                                    aria-controls="test-nlf-3">
                                                    <span class="bs-stepper-circle">
                                                        <i class="mdi mdi-file-document-box menu-icon"></i>
                                                    </span>
                                                    <span class="bs-stepper-label">Biodata</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="bs-stepper-content">
                                            <form id="form" onSubmit="return false">
                                                @csrf
                                                <div id="test-nlf-1" role="tabpanel" class="bs-stepper-pane fade"
                                                    aria-labelledby="stepper3trigger1">
                                                    @if ($pengumuman->status == '1')
                                                        <div class="row mb-5">
                                                            <div class="col"></div>
                                                            <div class="col-10">
                                                                <img style="height: 70px; width: 90px; margin-bottom: 25px;"
                                                                    src="{{ asset('img') }}/pengumuman.png"
                                                                    alt="logo" />
                                                                <h2>SELAMAT CALON MAHASISWA BARU</h2>
                                                                <h4>Selamat Anda telah dinyatakan LULUS SELEKSI pendaftaran
                                                                    Mahasiswa baru {{ $pengumuman->periode->nama_periode }}
                                                                    {{ $pengumuman->periode->semester }}. </h4>
                                                                <div class="alert alert-light" role="alert">
                                                                    <div class="row">
                                                                        <div class="col-4"></div>
                                                                        <div class="col-4">
                                                                            <div class="table-responsive">
                                                                                <table class="table table-hover">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td style="text-align: left;"><strong>Nama Lengkap</strong></td>
                                                                                            <td style="text-align: left;">{{ $pengumuman->nama }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td style="text-align: left;"><strong>Program Studi</strong></td>
                                                                                            <td style="text-align: left;">{{ $pengumuman->prodi->nama_prodi }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td style="text-align: left;"><strong>Nominal Daftar Ulang</strong></td>
                                                                                            <td style="text-align: left;">{{ 'Rp ' . number_format($config->biaya_herregistrasi, 0, ',', '.') }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td style="text-align: left;"><strong>Batas Waktu Pendaftaran</strong></td>
                                                                                            <td style="text-align: left;">-</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col"></div>
                                                        </div>
                                                    @elseif($pengumuman->status == '0')
                                                        <div class="row mb-5">
                                                            <div class="col"></div>
                                                            <div class="col-10">
                                                                <img style="height: 70px; width: 90px; margin-bottom: 25px;"
                                                                    src="{{ asset('img') }}/tolak.png"
                                                                    alt="logo" />
                                                                <h2>MOHON MAAF, ANDA TIDAK LULUS</h2>
                                                                <h4>Masih ada kesempatan pendaftaran Mahasiswa baru ditahun berikutnya. Tetap Semangat!</h4>
                                                                <div class="alert alert-light" role="alert">
                                                                    <div class="row">
                                                                        <div class="col-4"></div>
                                                                        <div class="col-4">
                                                                            <div class="table-responsive">
                                                                                <table class="table table-hover">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td style="text-align: left;"><strong>Nama Lengkap</strong></td>
                                                                                            <td style="text-align: left;">{{ $pengumuman->nama }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td style="text-align: left;"><strong>Program Studi</strong></td>
                                                                                            <td style="text-align: left;">{{ $pengumuman->prodi->nama_prodi }}</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col"></div>
                                                        </div>
                                                    @else
                                                        <div class="row mb-5">
                                                            <div class="col"></div>
                                                            <div class="col-10">
                                                                <img style="height: 70px; width: 90px; margin-bottom: 25px;"
                                                                    src="{{ asset('img') }}/tolak.png"
                                                                    alt="logo" />
                                                                <h2>MOHON DITUNGGU</h2>
                                                                <h4>Pengumuman Penerimaan Mahasiswa Baru Akan Segera Di Umumkan</h4>
                                                            </div>
                                                            <div class="col"></div>
                                                        </div>
                                                    @endif
                                                    <button class="btn btn-primary"
                                                        onclick="stepper3.next()">Selanjutnya</button>
                                                </div>
                                                <div id="test-nlf-2" role="tabpanel" class="bs-stepper-pane fade"
                                                    aria-labelledby="stepper3trigger2">
                                                    @if (empty($herregistrasi))
                                                        @includeIf('pendaftaran.herreg')
                                                        <button class="btn btn-secondary"
                                                        onclick="stepper3.previous()">Kembali</button>
                                                        <button class="btn btn-primary"
                                                            id="save">Simpan & Lanjutkan</button>
                                                    @else
                                                        <div class="row mb-5">
                                                            <div class="col"></div>
                                                            <div class="col-10">
                                                                <img style="height: 70px; width: 90px; margin-bottom: 25px;"
                                                                    src="{{ asset('img') }}/tolak.png"
                                                                    alt="logo" />
                                                                <h2>MOHON DITUNGGU</h2>
                                                                <h4>Data Herregistrasi/Daftar Ulang anda telah tersimpan dan sedang dalam masa proses.</h4>
                                                            </div>
                                                            <div class="col"></div>
                                                        </div>
                                                        <button class="btn btn-secondary"
                                                            onclick="stepper3.previous()">Kembali</button>
                                                        <button class="btn btn-primary"
                                                            onclick="stepper3.next()">Selanjutnya</button>
                                                    @endif
                                                </div>
                                                <div id="test-nlf-3" role="tabpanel"
                                                    class="bs-stepper-pane fade text-center"
                                                    aria-labelledby="stepper3trigger3">
                                                    <button class="btn btn-secondary"
                                                        onclick="stepper3.previous()">Kembali</button>
                                                </div>
                                            </form>
                                        </div>
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
        var stepper3;
        stepper3 = new Stepper(document.querySelector('#stepper3'));
        $(document).ready(function () {
            $('#save').click(function () {
                Swal.fire({
                    icon: 'warning',
                    title: 'Apakah anda yakin data anda sudah benar?',
                    showCancelButton: true,
                    confirmButtonText: 'Yakin',
                    confirmButtonColor: '#0ddbb9',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
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
                            url: "herregistrasi",
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
                    }
                });
            });
        })

    </script>
@endpush
