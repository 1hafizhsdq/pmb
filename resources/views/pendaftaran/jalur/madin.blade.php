<h4 class="card-title">Dokumen Beasiswa Pengembangan Madin</h4>
<div class="row">
    @includeIf('pendaftaran.jalur.normal')
    <div class="col-md-4">
        <label for="rekom_madin">Surat Rekomendasi Madin</label>
    </div>
    <div class="col-md-8 form-group">
        <input type="file" class="form-control @error('rekom_madin') is-invalid @enderror" id="rekom_madin" name="rekom_madin">
        <small>Surat rekomendasi dari Madin, File bertipe PDF/JPG/JPEG/PNG, maksimal berukuran 2MB</small>
    </div>
</div>