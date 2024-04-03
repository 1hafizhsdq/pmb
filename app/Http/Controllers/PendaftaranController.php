<?php

namespace App\Http\Controllers;

use App\Models\BiodataMahasiswa;
use App\Models\Cofigs;
use App\Models\Pendaftaran;
use App\Models\Prodi;
use App\Models\TahunAjaran;
use App\Models\User;
use CURLFile;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PendaftaranController extends Controller
{
    public function index()
    {
        $data['title'] = 'Pendaftaran Mahasiswa Baru';
        $data['tahun_ajarans'] = TahunAjaran::where('is_active',1)->first();
        $data['user'] = User::with('pendaftaran.tahunajaran','biodatamahasiswa')
            ->where('id', Auth::user()->id)
            ->first();
        $data['prodi'] = Prodi::get();
        $data['config'] = Cofigs::find(1);

        if($data['user']->pendaftaran->isEmpty()){
            $data['is_regis'] = false;
        }else{
            $data['is_regis'] = true;
        }

        return view('pendaftaran.index',$data);
    }

    public function pengumuman(){
        $data['title'] = 'Pengumuman Mahasiswa Baru';
        $data['pengumuman'] = Pendaftaran::with('tahunajaran','prodi','user')
            ->whereHas('tahunajaran', function($q){
                $q->where('is_active',1);
            })
            ->where('user_id', Auth::user()->id)
            ->first();
        $data['config'] = Cofigs::find(1);

        return view('pendaftaran.pengumuman',$data);
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
            'jenis_sekolah' => 'required',
            'nama_sekolah' => 'required',
            'jurusan_sekolah' => 'required',
            'tahun_masuk' => 'required',
            'tahun_lulus' => 'required',
            'file' => 'required|mimes:pdf|max:2048',
            'file_pembayaran' => 'required|mimes:jpg,jpeg,png|max:2048',
            'no_ijazah' => 'required',
            'prodi_id' => 'required',
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
            'jenis_sekolah.required' => 'Jenis Sekolah tidak boleh kosong!',
            'nama_sekolah.required' => 'Nama Sekolah tidak boleh kosong!',
            'jurusan_sekolah.required' => 'Jurusan Sekolah tidak boleh kosong!',
            'tahun_masuk.required' => 'Tahun Masuk tidak boleh kosong!',
            'tahun_lulus.required' => 'Tahun Lulus tidak boleh kosong!',
            'file.required' => 'Ijazah tidak boleh kosong!',
            'file.mimes' => 'Ijazah harus berformat PDF!',
            'file.max' => 'Ijazah maksimal berukuran 2MB!',
            'file_pembayaran.required' => 'Bukti Pembayaran tidak boleh kosong!',
            'file_pembayaran.mimes' => 'Bukti Pembayaran harus berformat PDF!',
            'file_pembayaran.max' => 'Bukti Pembayaran maksimal berukuran 2MB!',
            'no_ijazah.required' => 'No. Ijazah tidak boleh kosong!',
            'prodi_id.required' => 'Program Studi tidak boleh kosong!',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        
        if(isset($_FILES['file'])){
            $fileTmpName  = $_FILES['file']['tmp_name'];
            $filetype  = $_FILES['file']['type'];
            $filename  = $_FILES['file']['name'];
            $file = new CURLFile($fileTmpName,$filetype,$filename);
            $postDokData['file'] = $file;
        }
        if(isset($_FILES['file_pembayaran'])){
            $fileTmpName  = $_FILES['file_pembayaran']['tmp_name'];
            $filetype  = $_FILES['file_pembayaran']['type'];
            $filename  = $_FILES['file_pembayaran']['name'];
            $file = new CURLFile($fileTmpName,$filetype,$filename);
            $postDokData['file_pembayaran'] = $file;
        }

        $headers = array(
            "Accept: application/json",
            "Auth: wngoturldjjop08bbfjeq7xl",
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://siakad.test/api/pendaftaran-store-file');
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
            if($request->user_id != null){
                $user = User::where('id',$request->user_id)
                    ->update([
                        'tempat_lahir' => strtoupper($request->tempat_lahir), 
                        'tgl_lahir' => $request->tgl_lahir, 
                        'jenis_kelamin' => $request->jenis_kelamin, 
                        'nik' => $request->nik, 
                        'alamat' => $request->alamat, 
                    ]);
                $userId = $request->user_id;
            }else{
                if (substr($request->telp, 0, 1) === '0') {
                    $telp = '62' . substr($request->telp, 1);
                }else{
                    $telp = $request->telp;
                }
                $user = User::create([
                    'nama' => strtoupper($request->nama),
                    'telp' => $telp,
                    'email' => $request->email,
                    'role_id' => 5,
                    'password' => Hash::make($request->email),
                ]);
            $userId = $user->id;
            }
            
            BiodataMahasiswa::create([
                'user_id' => $userId,
                'nik' => $request->nik,
                'nisn' => $request->nisn,
                'jenis_sekolah' => strtoupper($request->jenis_sekolah),
                'nama_sekolah' => strtoupper($request->nama_sekolah),
                'jurusan_sekolah' => strtoupper($request->jurusan_sekolah),
                'tahun_masuk' => $request->tahun_masuk,
                'tahun_lulus' => $request->tahun_lulus,
                'nama_ayah' => strtoupper($request->nama_ayah),
                'tempat_lahir_ayah' => strtoupper($request->tempat_lahir_ayah),
                'tgl_lahir_ayah' => $request->tgl_lahir_ayah,
                'nik_ayah' => $request->nik_ayah,
                'alamat_ayah' => $request->alamat_ayah,
                'pendidikan_ayah' => $request->pendidikan_ayah,
                'pekerjaan_ayah' => strtoupper($request->pekerjaan_ayah),
                'nama_ibu' => strtoupper($request->nama_ibu),
                'tempat_lahir_ibu' => strtoupper($request->tempat_lahir_ibu),
                'tgl_lahir_ibu' => $request->tgl_lahir_ibu,
                'nik_ibu' => $request->nik_ibu,
                'alamat_ibu' => $request->alamat_ibu,
                'pendidikan_ibu' => $request->pendidikan_ibu,
                'pekerjaan_ibu' => strtoupper($request->pekerjaan_ibu),
                'prodi_id' => $request->prodi_id,
                'ijazah' => $response->data->ijazah,
                'no_ijazah' => $request->no_ijazah,
            ]);

            Pendaftaran::create([
                'user_id' => $userId,
                'tahun_ajaran_id' => $request->tahun_ajaran_id,
                'prodi_id' => $request->prodi_id,
                'nominal_pendaftaran' => $request->nominal_pendaftaran,
                'bukti_bayar_pendaftaran' => $response->data->pembayaran,
            ]);

            return response()->json([ 'success' => 'Berhasil menyimpan data.']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => ['Gagal menyimpan data']]);
        }
    }

    public function storeherregistrasi(Request $request){
        $validator = Validator::make($request->all(), [
            'file_herregistrasi' => 'required|mimes:jpg,jpeg,png|max:2048',
        ], [
            'file_herregistrasi.required' => 'Bukti Pembayaran tidak boleh kosong!',
            'file_herregistrasi.mimes' => 'Bukti Pembayaran harus berformat PDF!',
            'file_herregistrasi.max' => 'Bukti Pembayaran maksimal berukuran 2MB!',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        // if ($request->hasfile('file_herregistrasi')) {
        //     $fileBuktiBayar = round(microtime(true) * 1000).'.' . $request->file_herregistrasi->extension();
        //     $request->file_herregistrasi->move(storage_path('app/herregistrasi/'), $fileBuktiBayar);
        // }
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
        curl_setopt($ch, CURLOPT_URL, 'http://siakad.test/api/herregistrasi-store-file');
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
            Pendaftaran::where('id',$request->id)->update([
                'nominal_herregistrasi' => $request->nominal_herregistrasi,
                'bukti_bayar_herregistrasi' => $response->data->herregistrasi,
                'semester' => $request->semester,
            ]);
            return response()->json([ 'success' => 'Berhasil menyimpan data.']);
        } catch (\Throwable $th) {
            return response()->json(['errors' => ['Gagal menyimpan data']]);
        }
    }

    public function show(Pendaftaran $pendaftaran)
    {
        //
    }

    public function edit(Pendaftaran $pendaftaran)
    {
        //
    }

    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        //
    }

    public function destroy(Pendaftaran $pendaftaran)
    {
        //
    }
}
