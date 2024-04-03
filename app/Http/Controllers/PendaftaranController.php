<?php

namespace App\Http\Controllers;

use App\Models\Cofigs;
use App\Models\Pendaftaran;
use App\Models\Prodi;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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
