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
                    <label for="file_herregistrasi">Bukti Pembayaran</label>
                </div>
                <div class="col-md-8 form-group">
                    <input type="file" class="image-preview-filepond @error('file_herregistrasi') is-invalid @enderror" id="file_herregistrasi" name="file_herregistrasi">
                    <small>File bertipe jpg/jpeg/png, maksimal berukuran 2MB</small>
                </div>
                <input type="hidden" name="nominal_bayar" id="nominal_bayar" value="{{ $config->biaya_herregistrasi }}">
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
        <input type="hidden" name="pendaftaran_id" value="{{ $pengumuman->id }}">
        <input type="hidden" name="statusmahasiswa_id" value="1">
        <input type="hidden" name="prodi_id" value="{{ $pengumuman->prodi_id }}">
        <input type="hidden" name="periode_id" value="{{ $pengumuman->periode_id }}">
        <input type="hidden" name="semester" value="1">
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
                <label for="negara_id">Kewarganegaraan</label>
            </div>
            <div class="col-md-8 form-group">
                <select class="form-select select2 @error('negara_id') is-invalid @enderror" id="negara_id" name="negara_id">
                    <option value="">-- Pilih Kewarganegaraan --</option>
                    @foreach ($negaras as $ng)
                        <option value="{{ $ng->id }}">{{ $ng->name }} ({{ $ng->code }})</option>
                    @endforeach
                </select>
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
            <div class="col-md-4">
                <label for="nik">NIK</label>
            </div>
            <div class="col-md-8 form-group">
                <input type="text" id="nik" class="form-control @error('nik') is-invalid @enderror" name="nik"
                    value="{{ $pengumuman->nik }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="nisn">NISN</label>
            </div>
            <div class="col-md-8 form-group">
                <input type="text" id="nisn" class="form-control @error('nisn') is-invalid @enderror" name="nisn"
                    value="{{ $pengumuman->nisn }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="alamat">Alamat</label>
            </div>
            <div class="col-md-8 form-group">
                <input type="text" id="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat"
                    value="{{ $pengumuman->alamat }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="provinsi_id">Provinsi</label>
            </div>
            <div class="col-md-8 form-group">
                <select class="form-select select2 @error('provinsi_id') is-invalid @enderror" id="provinsi_id" name="provinsi_id">
                    <option value="{{ $pengumuman->provinsi_id }}">{{ $pengumuman->provinsi->nama_provinsi }}</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="kota_id">Kota / Kabupaten</label>
            </div>
            <div class="col-md-8 form-group">
                <select class="form-select select2 @error('kota_id') is-invalid @enderror" id="kota_id" name="kota_id">
                    <option value="{{ $pengumuman->kota_id }}">{{ $pengumuman->kota->nama_kota }}</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="kota_id">Kota / Kabupaten</label>
            </div>
            <div class="col-md-8 form-group">
                <select class="form-select select2 @error('kecamatan_id') is-invalid @enderror" id="kecamatan_id" name="kecamatan_id">
                    <option value="{{ $pengumuman->kecamatan_id }}">{{ $pengumuman->kecamatan->nama_kecamatan }}</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="kelurahan_id">Kelurahan</label>
            </div>
            <div class="col-md-8 form-group">
                <select class="form-select select2 @error('kelurahan_id') is-invalid @enderror" id="kelurahan_id" name="kelurahan_id">
                    <option value="{{ $pengumuman->kelurahan_id }}">{{ $pengumuman->kelurahan->nama_kelurahan }}</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="kode_pos">Kodepos / Dusun / RT / RW</label>
            </div>
            <div class="col-md-2 form-group">
                <input type="text" id="kode_pos" class="form-control @error('kode_pos') is-invalid @enderror" name="kode_pos"
                    value="{{ $pengumuman->kode_pos }}" readonly>
            </div>
            <div class="col-md-2 form-group">
                <input type="text" id="dusun" class="form-control @error('dusun') is-invalid @enderror" name="dusun"
                    value="{{ $pengumuman->dusun }}" readonly>
            </div>
            <div class="col-md-2 form-group">
                <input type="text" id="rt" class="form-control @error('rt') is-invalid @enderror" name="rt"
                    value="{{ $pengumuman->rt }}" readonly>
            </div>
            <div class="col-md-2 form-group">
                <input type="text" id="rw" class="form-control @error('rw') is-invalid @enderror" name="rw"
                    value="{{ $pengumuman->rw }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="jenistinggal_id">Jenis Tinggal</label>
            </div>
            <div class="col-md-8 form-group">
                <select class="form-select select2 @error('jenistinggal_id') is-invalid @enderror" id="jenistinggal_id" name="jenistinggal_id">
                    <option value="">-- Pilih Jenis Tinggal --</option>
                    @foreach ($jenistinggals as $jt)
                        <option value="{{ $jt->id }}">{{ $jt->nama_jenis_tinggal }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="transportasi_id">Transportasi</label>
            </div>
            <div class="col-md-8 form-group">
                <select class="form-select select2 @error('transportasi_id') is-invalid @enderror" id="transportasi_id" name="transportasi_id">
                    <option value="">-- Pilih Transportasi --</option>
                    @foreach ($transportasis as $tp)
                        <option value="{{ $tp->id }}">{{ $tp->nama_transportasi }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
