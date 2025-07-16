<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use App\Models\Aplikasi;
use App\Models\BiodataMahasiswa;
use App\Models\Cofigs;
use App\Models\Herregistrasi;
use App\Models\JalurPmb;
use App\Models\JenisTinggal;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Kota;
use App\Models\Negara;
use App\Models\Ortu;
use App\Models\Pekerjaan;
use App\Models\Pendaftaran;
use App\Models\Periode;
use App\Models\Prodi;
use App\Models\Provinsi;
use App\Models\StatusMahasiswa;
use App\Models\Transportasi;
use App\Models\User;
use Carbon\Carbon;
use CURLFile;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PendaftaranController extends Controller
{
    protected $_url;

    public function __construct()
    {
        $this->_url = 'https://siakad.stainupa.ac.id';
        // $this->_url = 'http://siakad.test';
    }

    public function index(){
        $data['title'] = 'Pendaftaran Mahasiswa Baru';
        $data['user'] = User::with('pendaftaran.periode')
            ->where('id', Auth::user()->id)
            ->first();
        $data['jalurs'] = JalurPmb::get();

        if($data['user']->pendaftaran->isEmpty()){
            $data['is_regis'] = false;
        }else{
            $data['is_regis'] = true;
        }

        return view('pendaftaran.jalur',$data);
    }

    public function form(Request $request){
        $data['title'] = 'Pendaftaran Mahasiswa Baru';
        $data['periode'] = Periode::with('pmb')
                            ->whereHas('pmb', function ($query) {
                                $query->whereDate('tgl_awal_pmb', '<=', Carbon::today())
                                    ->whereDate('tgl_akhir_pmb', '>=', Carbon::today());
                            })
                            ->first();
        $data['user'] = User::with('pendaftaran.periode')
            ->where('id', Auth::user()->id)
            ->first();
        $data['prodi'] = Prodi::get();
        $data['provinsis'] = Provinsi::all();
        $data['pekerjaans'] = Pekerjaan::all();
        $data['config'] = Aplikasi::find(1);
        $data['url'] = $this->_url;
        $data['forms'] = $this->_formJalur($request->jalur_id);
        $data['jalur_id'] = $request->jalur_id;

        if($data['user']->pendaftaran->isEmpty()){
            $data['is_regis'] = false;
        }else{
            $data['is_regis'] = true;
        }

        return view('pendaftaran.index',$data);
    }

    public function kota($provinsi_id){
        $data = Kota::where('provinsi_id',$provinsi_id)->get();
        return response()->json($data);
    }
    
    public function kecamatan($kota_id){
        $data = Kecamatan::where('kota_id',$kota_id)->get();
        return response()->json($data);
    }
    
    public function kelurahan($kecamatan_id){
        $data = Kelurahan::where('kecamatan_id',$kecamatan_id)->get();
        return response()->json($data);
    }
    
    public function kodepos($kelurahan){
        $data = Kelurahan::where('id',$kelurahan)->first();
        return response()->json($data);
    }

    public function pengumuman(){
        $data['title'] = 'Pengumuman Mahasiswa Baru';
        $data['pengumuman'] = Pendaftaran::with('periode','prodi','user')
            ->whereHas('periode', function($q){
                $q->where('is_active',1);
            })
            ->where('user_id', Auth::user()->id)
            ->first();
        $data['herregistrasi'] = Herregistrasi::where('user_id', Auth::user()->id)
            ->where('semester',1)
            ->first();
        $data['config'] = Aplikasi::find(1);
        $data['agamas'] = Agama::all();
        $data['transportasis'] = Transportasi::all();
        $data['negaras'] = Negara::all();
        $data['jenistinggals'] = JenisTinggal::all();
        $data['url'] = $this->_url;

        return view('pendaftaran.pengumuman',$data);
    }

    public function store(Request $request)
    {
        $specialValidation = $this->_specialValidation($request->jalur_id);
        $ruleValidation = [
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'telp' => 'required',
            'email' => 'required',
            'nik' => 'required',
            'jenis_sekolah' => 'required',
            'nama_sekolah' => 'required',
            'jurusan_sekolah' => 'required',
            'tahun_masuk' => 'required|numeric',
            'tahun_lulus' => 'required|numeric',
            'file' => 'required|mimes:pdf|max:2048',
            'file_pembayaran' => 'required|mimes:jpg,jpeg,png|max:2048',
            'no_ijazah' => 'required',
            'prodi_id' => 'required',
            'penghasilan_ayah' => 'numeric',
            'penghasilan_ibu' => 'numeric',
        ];
        $msgValidation = [
            'nama.required' => 'Nama tidak boleh kosong!',
            'tempat_lahir.required' => 'Tempat Lahir tidak boleh kosong!',
            'tgl_lahir.required' => 'Tanggal Lahir tidak boleh kosong!',
            'jenis_kelamin.required' => 'Jenis Kelamin tidak boleh kosong!',
            'alamat.required' => 'Alamat tidak boleh kosong!',
            'telp.required' => 'Nomor Telepon tidak boleh kosong!',
            'email.required' => 'Email tidak boleh kosong!',
            'nik.required' => 'NIK tidak boleh kosong!',
            'jenis_sekolah.required' => 'Jenis Sekolah tidak boleh kosong!',
            'nama_sekolah.required' => 'Nama Sekolah tidak boleh kosong!',
            'jurusan_sekolah.required' => 'Jurusan Sekolah tidak boleh kosong!',
            'tahun_masuk.required' => 'Tahun Masuk tidak boleh kosong!',
            'tahun_masuk.numeric' => 'Tahun Masuk harus angka!',
            'tahun_lulus.required' => 'Tahun Lulus tidak boleh kosong!',
            'tahun_lulus.numeric' => 'Tahun Lulus harus angka!',
            'file.required' => 'Ijazah tidak boleh kosong!',
            'file.mimes' => 'Ijazah harus berformat PDF!',
            'file.max' => 'Ijazah maksimal berukuran 2MB!',
            'file_pembayaran.required' => 'Bukti Pembayaran tidak boleh kosong!',
            'file_pembayaran.mimes' => 'Bukti Pembayaran harus berformat PDF!',
            'file_pembayaran.max' => 'Bukti Pembayaran maksimal berukuran 2MB!',
            'no_ijazah.required' => 'No. Ijazah tidak boleh kosong!',
            'prodi_id.required' => 'Program Studi tidak boleh kosong!',
            'penghasilan_ayah.numeric' => 'Penghasilan ayah harus angka!',
            'penghasilan_ibu.numeric' => 'Penghasilan ibu harus angka!',
        ];
        $validator = Validator::make($request->all(), 
            array_merge($ruleValidation,$specialValidation['validationRule']),
            array_merge($msgValidation,$specialValidation['validationRuleMsg'])
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
            // return redirect('/')->withErrors($validator)->withInput();
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
        if(isset($_FILES['pasfoto'])){
            $fileTmpName  = $_FILES['pasfoto']['tmp_name'];
            $filetype  = $_FILES['pasfoto']['type'];
            $filename  = $_FILES['pasfoto']['name'];
            $file = new CURLFile($fileTmpName,$filetype,$filename);
            $postDokData['pasfoto'] = $file;
        }
        if(isset($_FILES['kk'])){
            $fileTmpName  = $_FILES['kk']['tmp_name'];
            $filetype  = $_FILES['kk']['type'];
            $filename  = $_FILES['kk']['name'];
            $file = new CURLFile($fileTmpName,$filetype,$filename);
            $postDokData['kk'] = $file;
        }
        if(isset($_FILES['kartu_nisn'])){
            $fileTmpName  = $_FILES['kartu_nisn']['tmp_name'];
            $filetype  = $_FILES['kartu_nisn']['type'];
            $filename  = $_FILES['kartu_nisn']['name'];
            $file = new CURLFile($fileTmpName,$filetype,$filename);
            $postDokData['kartu_nisn'] = $file;
        }
        if(in_array($request->jalur_id, [2,3,4,5,6])){
            if($request->jalur_id == 5){
                if(isset($_FILES['rekom_madin'])){
                    $fileTmpName  = $_FILES['rekom_madin']['tmp_name'];
                    $filetype  = $_FILES['rekom_madin']['type'];
                    $filename  = $_FILES['rekom_madin']['name'];
                    $file = new CURLFile($fileTmpName,$filetype,$filename);
                    $postDokData['rekom_madin'] = $file;
                }
            }else{
                if(isset($_FILES['bukti_prestasi'])){
                    $fileTmpName  = $_FILES['bukti_prestasi']['tmp_name'];
                    $filetype  = $_FILES['bukti_prestasi']['type'];
                    $filename  = $_FILES['bukti_prestasi']['name'];
                    $file = new CURLFile($fileTmpName,$filetype,$filename);
                    $postDokData['bukti_prestasi'] = $file;
                }
            }
        }

        $headers = array(
            "Accept: application/json",
            "Auth: wngoturldjjop08bbfjeq7xl",
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->_url.'/api/pendaftaran-store-file');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postDokData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        
        $response = curl_exec($ch);
        $response = json_decode($response);
        curl_close($ch);
        if($response->meta->message != "Berhasil menyimpan data"){
            return response()->json(['errors' => ['Gagal upload data']]);
            // return redirect('/pendaftaran')->with('error', 'Gagal menyimpan data.');
        }

        try {
            $pendaftaran = Pendaftaran::create([
                'user_id' => $request->user_id,
                'periode_id' => $request->periode_id,
                'prodi_id' => $request->prodi_id,
                'jalur_id' => $request->jalur_id,
                'nama' => strtoupper($request->nama),
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => strtoupper($request->tempat_lahir), 
                'tgl_lahir' => $request->tgl_lahir,
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
                'telp' => $request->telp,
                'email' => $request->email,
                'jenis_sekolah' => strtoupper($request->jenis_sekolah),
                'nama_sekolah' => strtoupper($request->nama_sekolah),
                'jurusan_sekolah' => strtoupper($request->jurusan_sekolah),
                'tahun_masuk' => str_replace(' ', '', $request->tahun_masuk),
                'tahun_lulus' => str_replace(' ', '', $request->tahun_lulus),
                'file_ijazah' => $response->data->ijazah,
                'no_ijazah' => $request->no_ijazah,
                'nominal_bayar' => $request->nominal_pendaftaran,
                'bukti_bayar' => $response->data->pembayaran,
                'tgl_bayar' => $request->tgl_bayar,
                'pasfoto' => $response->data->pasfoto,
                'kk' => $response->data->kk,
                'kartu_nisn' => $response->data->kartu_nisn,
                'bukti_prestasi' => $response->data->bukti_prestasi ?? null,
                'rekom_madin' => $response->data->rekom_madin ?? null
            ]);

            Ortu::create(
                [
                    'user_id' => $request->user_id,
                    'pendaftaran_id' => $pendaftaran->id,
                    'status_keluarga' => 'ayah',
                    'nama' => strtoupper($request->nama_ayah),
                    'tempat_lahir' => strtoupper($request->tempat_lahir_ayah),
                    'tgl_lahir' => $request->tgl_lahir_ayah,
                    'nik' => $request->nik_ayah,
                    'alamat' => $request->alamat_ayah,
                    'pendidikan_terakhir' => $request->pendidikan_ayah,
                    'pekerjaan' => strtoupper($request->pekerjaan_ayah),
                    'penghasilan' => $request->penghasilan_ayah,
                ]
            );
            Ortu::create(
                [
                    'user_id' => $request->user_id,
                    'pendaftaran_id' => $pendaftaran->id,
                    'status_keluarga' => 'ibu',
                    'nama' => strtoupper($request->nama_ibu),
                    'tempat_lahir' => strtoupper($request->tempat_lahir_ibu),
                    'tgl_lahir' => $request->tgl_lahir_ibu,
                    'nik' => $request->nik_ibu,
                    'alamat' => $request->alamat_ibu,
                    'pendidikan_terakhir' => $request->pendidikan_ibu,
                    'pekerjaan' => strtoupper($request->pekerjaan_ibu),
                    'penghasilan' => $request->penghasilan_ibu,
                ]
            );

            return response()->json([ 'success' => 'Berhasil menyimpan data.']);
            // return redirect('/pendaftaran');
        } catch (\Throwable $th) {
            return response()->json(['errors' => ['Gagal menyimpan data '.$th]]);
            // return redirect('/pendaftaran')->with('error', 'Gagal menyimpan data.');
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

    private function _formJalur($jalur)
    {
        switch ($jalur) {
            case '1':
                return view('pendaftaran.jalur.umum');
            case '2':
                return view('pendaftaran.jalur.akademik');
            case '3':
                return view('pendaftaran.jalur.nonakademik');
            case '4':
                return view('pendaftaran.jalur.tahfidz');
            case '5':
                return view('pendaftaran.jalur.madin');
            case '6':
                return view('pendaftaran.jalur.umum');
            default:
                return view('pendaftaran.jalur.umum');
        }
    }

    private function _specialValidation($jalur)
    {
        $addValidationRule = [];
        $addValidationRuleMsg = [];

        if(in_array($jalur, [2,3,4,5])){
            if($jalur == 5){
                $addValidationRule = ['rekom_madin' => 'required|mimes:pdf,jpg,jpeg,png|max:2048'];
                $addValidationRuleMsg = [
                    'rekom_madin.required' => 'Surat Rekomendasi Madin tidak boleh kosong!',
                    'rekom_madin.mimes' => 'Surat Rekomendasi Madin harus berformat PDF!',
                    'rekom_madin.max' => 'Surat Rekomendasi Madin maksimal berukuran 2MB!',
                ];
            }else{
                $addValidationRule = ['bukti_prestasi' => 'required|mimes:pdf,jpg,jpeg,png|max:2048'];
                $addValidationRuleMsg = [
                    'bukti_prestasi.required' => 'Bukti Prestasi tidak boleh kosong!',
                    'bukti_prestasi.mimes' => 'Bukti Prestasi harus berformat PDF!',
                    'bukti_prestasi.max' => 'Bukti Prestasi maksimal berukuran 2MB!',
                ];
            }
    
            $validationRule = [
                'pasfoto' => 'required|mimes:jpg,jpeg,png|max:2048',
                'kk' => 'required|mimes:jpg,jpeg,png|max:2048',
                'nisn' => 'required|mimes:jpg,jpeg,png|max:2048',
            ];
            $validationRule = array_merge($validationRule, $addValidationRule);
    
            $validationRuleMsg = [
                'pasfoto.required' => 'Pas Foto tidak boleh kosong!',
                'pasfoto.mimes' => 'Pas Foto harus berformat JPG/JPEG/PNG!',
                'pasfoto.max' => 'Pas Foto maksimal berukuran 2MB!',
                'kk.required' => 'Kartu Keluarga tidak boleh kosong!',
                'kk.mimes' => 'Kartu Keluarga harus berformat JPG/JPEG/PNG!',
                'kk.max' => 'Kartu Keluarga maksimal berukuran 2MB!',
                'nisn.required' => 'Kartu NISN tidak boleh kosong!',
                'nisn.mimes' => 'Kartu NISN harus berformat JPG/JPEG/PNG!',
                'nisn.max' => 'Kartu NISN maksimal berukuran 2MB!',
            ];
            $addValidationRuleMsg = array_merge($validationRuleMsg, $addValidationRuleMsg);
        }else{
            $validationRule = [];
            $addValidationRuleMsg = [];
        }

        $data['validationRule'] = $validationRule;
        $data['validationRuleMsg'] = $addValidationRuleMsg;
    
        return $data;
    }

}
