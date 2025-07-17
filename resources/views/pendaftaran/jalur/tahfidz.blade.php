<h4 class="card-title">Dokumen Beasiswa Prestasi Tahfidz</h4>
<div class="row">
    @includeIf('pendaftaran.jalur.normal')
    <div class="col-md-4">
        <label for="bukti_prestasi">Bukti Prestasi Hafiz Qur’an</label>
    </div>
    <div class="col-md-8 form-group">
        <input type="file" class="form-control @error('bukti_prestasi') is-invalid @enderror" id="bukti_prestasi" name="bukti_prestasi">
        <small>Surat keterangan atau sertifikat Hafiz Qur’an dari lembaga terkait, File bertipe PDF/JPG/JPEG/PNG, maksimal berukuran 2MB</small>
    </div>
</div>