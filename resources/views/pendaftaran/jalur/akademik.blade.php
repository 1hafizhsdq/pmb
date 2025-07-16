<h4 class="card-title">Dokumen Beasiswa Prestasi Akademik</h4>
<div class="row">
    @includeIf('pendaftaran.jalur.normal')
    <div class="col-md-4">
        <label for="bukti_prestasi">Bukti Prestasi</label>
    </div>
    <div class="col-md-8 form-group">
        <input type="file" class="basic-filepond @error('bukti_prestasi') is-invalid @enderror" id="bukti_prestasi" name="bukti_prestasi">
        <small>Bukti prestasi berupa sertifikat atau medali di bidang akademik minimal tingkat sekolah, File bertipe PDF/JPG/JPEG/PNG, maksimal berukuran 2MB</small>
    </div>
</div>