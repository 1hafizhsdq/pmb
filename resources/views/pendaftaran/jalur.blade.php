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
                                    <div class="card-body">
                                        @if ($is_regis)
                                            <div class="card-body mt-3">
                                                <h2 style="color: black;">{{ $title }}</h2>
                                                <h4>Data Pendaftaran Mahasiswa Baru Tahun Ajaran {{ $user->pendaftaran[0]->periode->nama_periode }} Semester {{ $user->pendaftaran[0]->periode->semester }} telah tersimpan</h4>
                                                <span>Silahkan pantau hasil pengumuman Penerimaan Mahasiswa Baru pada menu "Pengumuman"</span>
                                            </div>
                                        @else
                                            <h2 class="text-dark text-center">JALUR PENDAFTARAN</h2>
                                            <div class="container">
                                                <div class="row">
                                                    @foreach ($jalurs as $j)
                                                        <div class="col-12 col-md-4">
                                                        <div class="alert alert-secondary" role="alert">
                                                            <b>{{ $j->nama_jalur }} {{ ($j->is_beasiswa) ? `| <span class="badge badge-danger">Beasiswa</span>` : '' }}</b>
                                                            <p class="jalur-deskripsi">{{ $j->deskripsi }}</p>
                                                            <hr class="my-2">
                                                            <div class="row">
                                                                <div class="col-5">
                                                                    <form action="{{ route('form') }}" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="jalur_id" value="{{ $j->id }}">
                                                                        <button type="submit" class="btn btn-success">
                                                                            Daftar Sekarang
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                                <div class="col-7">
                                                                    @if (isset($j->persyaratan))
                                                                        <button id="#persyaratan" type="button" class="persyaratan btn btn-secondary" data-nama="{{ $j->nama_jalur }}" data-syarat="{{ $j->persyaratan }}">
                                                                            Lihat Syarat Pendaftaran
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
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
            $('.persyaratan').click(function(){
                var nama = $(this).data('nama');
                var syarat = $(this).data('syarat');

                $('#exampleModalLabel').text(nama);
                $('.modal-body').html(syarat);
                $('#exampleModal').modal('show');
            });
        }).on('click', '.close', function() {
            $('#exampleModal').modal('hide');
        });
    </script>
@endpush

