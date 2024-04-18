<div class="card m-3">
    <div class="card-body">
        <table class="table table-hover">
            <tbody>
                <tr>
                    <td style="text-align: left;"><strong>Nama Lengkap</strong></td>
                    <td style="text-align: left;">{{ $pengumuman->nama }}</td>
                </tr>
                <tr>
                    <td style="text-align: left;"><strong>Program Studi</strong></td>
                    <td style="text-align: left;">{{ $pengumuman->prodi->nama_prodi }}</td>
                </tr>
                <tr>
                    <td style="text-align: left;"><strong>Nominal Daftar Ulang</strong></td>
                    <td style="text-align: left;">{{ 'Rp ' . number_format($config->biaya_herregistrasi, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td style="text-align: left;"><strong>Batas Waktu Pendaftaran</strong></td>
                    <td style="text-align: left;">-</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="card m-3">
    <div class="card-body">
        <div class="konten" style="text-align: left;">
            <h5>
                Biaya daftar ulang sudah ditetapkan oleh pihak kampus. Apabila terdapat pertanyaan, anda dapat hubungi langsung melalui kontak kami.
            </h5>
            <img style="height: 70px; width: 90px;" src="{{ asset('img') }}/bri.png" alt="logo" />
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <td style="text-align: left;"><strong>Metode Pembayaran</strong></td>
                        <td style="text-align: left;">: Teller Bank / ATM Bank / Transfer Bank</td>
                    </tr>
                    <tr>
                        <td style="text-align: left;"><strong>Bank</strong></td>
                        <td style="text-align: left;">{{ $config->nama_bank }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: left;"><strong>Nominal Daftar Ulang</strong></td>
                        <td style="text-align: left;">{{ 'Rp ' . number_format($config->biaya_herregistrasi, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: left;"><strong>Batas Waktu Pendaftaran</strong></td>
                        <td style="text-align: left;">-</td>
                    </tr>
                </tbody>
            </table>
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
        </div>
    </div>
</div>
<div class="card m-3">
    <div class="card-body" style="text-align: left;">
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <h4 class="card-title">Biodata Diri</h4>
        <div class="row">
            <div class="col-md-4">
                <label for="nama">Nama Lengkap</label>
            </div>
            <div class="col-md-8 form-group">
                <input type="text" id="nama" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ $pengumuman->nama }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="tempat_lahir">Tempat & Tanggal Lahir</label>
            </div>
            <div class="col-md-4 form-group">
                <input type="text" id="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" name="tempat_lahir" value="{{ $pengumuman->tempat_lahir }}" readonly>
            </div>
            <div class="col-md-4 form-group">
                <input type="date" id="tgl_lahir" onkeypress="return isNumber(event)" class="form-control @error('tgl_lahir') is-invalid @enderror" name="tgl_lahir" value="{{ $pengumuman->tgl_lahir }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="jenis_kelamin">Jenis Kelamin</label>
            </div>
            <div class="col-md-8 form-group">
                <input type="text" id="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin" value="{{ $pengumuman->jenis_kelamin }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="telp">Nomor Telepon</label>
            </div>
            <div class="col-md-8 form-group">
                <input type="text" id="telp" onkeypress="return isNumber(event)" class="form-control @error('telp') is-invalid @enderror" name="telp"
                    value="{{ $pengumuman->telp }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="telp">HP</label>
            </div>
            <div class="col-md-8 form-group">
                <input type="text" id="hp" onkeypress="return isNumber(event)" class="form-control @error('hp') is-invalid @enderror" name="hp"
                    value="{{ $pengumuman->hp }}">
            </div>
            <div class="col-md-4">
                <label for="email">Email</label>
            </div>
            <div class="col-md-8 form-group">
                <input type="text" id="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ $pengumuman->email }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="agama_id">Agama</label>
            </div>
            <div class="col-md-8 form-group">
                <select class="form-select select2 @error('agama_id') is-invalid @enderror" id="agama_id" name="agama_id">
                    <option value="">-- Pilih Agama --</option>
                    @foreach ($agamas as $ag)
                        <option value="{{ $ag->id }}">{{ $ag->agama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
