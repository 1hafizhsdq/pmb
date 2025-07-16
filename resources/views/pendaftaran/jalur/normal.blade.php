<div class="col-md-4">
    <label for="pasfoto">Pas Foto Resmi</label>
</div>
<div class="col-md-8 form-group">
    <input type="file" class="form-control @error('pasfoto') is-invalid @enderror" id="pasfoto" name="pasfoto">
    <small>File bertipe JPG/JPEG/PNG, maksimal berukuran 2MB</small>
</div>
<div class="col-md-4">
    <label for="kk">Kartu Keluarga (KK)</label>
</div>
<div class="col-md-8 form-group">
    <input type="file" class="form-control @error('kk') is-invalid @enderror" id="kk" name="kk">
    <small>File bertipe PDF/JPG/JPEG/PNG, maksimal berukuran 2MB</small>
</div>
<div class="col-md-4">
    <label for="kartu_nisn">Kartu Nomor Induk Siswa Nasional (NISN)</label>
</div>
<div class="col-md-8 form-group">
    <input type="file" class="form-control @error('kartu_nisn') is-invalid @enderror" id="kartu_nisn" name="kartu_nisn">
    <small>File bertipe PDF/JPG/JPEG/PNG, maksimal berukuran 2MB</small>
</div>