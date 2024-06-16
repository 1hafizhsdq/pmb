<?php

namespace App\Http\Controllers;

use App\Models\BiodataMahasiswa;
use App\Models\Herregistrasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use CURLFile;

class HerregistrasiController extends Controller
{
    protected $_url;

    public function __construct()
    {
        $this->_url = 'https://siakad.stainupa.ac.id';
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'telp' => 'required',
            'email' => 'required',
            'nik' => 'required',
            'nisn' => 'required',
            'negara_id' => 'required',
            'agama_id' => 'required',
            'jenistinggal_id' => 'required',
            'transportasi_id' => 'required',
            'file_herregistrasi' => 'required|mimes:png,jpg,jpeg|max:2048',
        ], [
            'nama.required' => 'Nama tidak boleh kosong!',
            'tempat_lahir.required' => 'Tempat Lahir tidak boleh kosong!',
            'tgl_lahir.required' => 'Tanggal Lahir tidak boleh kosong!',
            'jenis_kelamin.required' => 'Jenis Kelamin tidak boleh kosong!',
            'alamat.required' => 'Alamat tidak boleh kosong!',
            'telp.required' => 'Nomor Telepon tidak boleh kosong!',
            'email.required' => 'Email tidak boleh kosong!',
            'nik.required' => 'NIK tidak boleh kosong!',
            'nisn.required' => 'NISN tidak boleh kosong!',
            'negara_id.required' => 'Keewarganegaraan tidak boleh kosong!',
            'agama_id.required' => 'Agama tidak boleh kosong!',
            'jenistinggal_id.required' => 'Jenis Tinggal tidak boleh kosong!',
            'transportasi_id.required' => 'Transportasi tidak boleh kosong!',
            'tahun_lulus.required' => 'Tahun Lulus tidak boleh kosong!',
            'file_herregistrasi.required' => 'File Bukti Bayar tidak boleh kosong!',
            'file_herregistrasi.mimes' => 'File Bukti Bayar harus berformat PNG,JPG,JPEG!',
            'file_herregistrasi.max' => 'File Bukti Bayar maksimal berukuran 2MB!',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        if(isset($_FILES['file_herregistrasi'])){
            $fileTmpName  = $_FILES['file_herregistrasi']['tmp_name'];
            $filetype  = $_FILES['file_herregistrasi']['type'];
            $filename  = $_FILES['file_herregistrasi']['name'];
            $file = new CURLFile($fileTmpName,$filetype,$filename);
            $postDokData['file_herregistrasi'] = $file;
        }

        $headers = array(
            "Accept: application/json",
            "Auth: wngoturldjjop08bbfjeq7xl",
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->_url.'/api/herregistrasi-store-file');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postDokData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        
        $response = curl_exec($ch);
        $response = json_decode($response);
        curl_close($ch);
        if($response->meta->message != "Berhasil menyimpan data"){
            return response()->json(['errors' => ['Gagal upload data']]);
        }

        try {
            Herregistrasi::create([
                'user_id' => $request->user_id,
                'prodi_id' => $request->prodi_id,
                'periode_id' => $request->periode_id,
                'nominal_bayar' => $request->nominal_bayar,
                'nominal_herregistrasi' => $request->nominal_herregistrasi,
                'nominal_uanggedung' => $request->nominal_uanggedung,
                'bukti_bayar' => $response->data->herregistrasi,
                'tgl_bayar' => $request->tgl_bayar,
                'semester' => $request->semester,
            ]);

            BiodataMahasiswa::create([
                'user_id' => $request->user_id,
                'pendaftaran_id' => $request->pendaftaran_id,
                'agama_id' => $request->agama_id,
                'transportasi_id' => $request->transportasi_id,
                'statusmahasiswa_id' => $request->statusmahasiswa_id,
                'prodi_id' => $request->prodi_id,
                'negara_id' => $request->negara_id,
                'jenistinggal_id' => $request->jenistinggal_id,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'telp' => $request->telp,
                'hp' => $request->hp,
                'email' => $request->email,
                'nik' => $request->nik,
                'nisn' => $request->nisn,
                'alamat' => $request->alamat,
                'provinsi_id' => $request->provinsi_id,
                'kota_id' => $request->kota_id,
                'kecamatan_id' => $request->kecamatan_id,
                'kelurahan_id' => $request->kelurahan_id,
                'kode_pos' => $request->kode_pos,
                'dusun' => $request->dusun,
                'rt' => $request->rt,
                'rw' => $request->rw,
            ]);
            return response()->json([ 'success' => 'Berhasil menyimpan data.']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => ['Gagal menyimpan data']]);
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
