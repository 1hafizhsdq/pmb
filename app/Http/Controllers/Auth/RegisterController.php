<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Periode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $data['periode'] = Periode::with('pmb')->where('is_active',1)->first();
        $tanggal_saat_ini = Carbon::now();
        $data['form_dibuka'] = false;
        $data['tgl_melewati_semua_pmb'] = true;
        $data['status_message'] = '';

        if ($data['periode'] && $data['periode']->pmb->isNotEmpty()) {
            foreach ($data['periode']->pmb as $p) {
                $tgl_mulai_pmb = Carbon::createFromFormat('Y-m-d', $p->tgl_awal_pmb);
                $tgl_selesai_pmb = Carbon::createFromFormat('Y-m-d', $p->tgl_akhir_pmb);
                $gelombang = $p->gelombang;
    
                if ($tanggal_saat_ini->between($tgl_mulai_pmb, $tgl_selesai_pmb)) {
                    $data['form_dibuka'] = true;
                    break;
                }
    
                if ($tanggal_saat_ini->lt($tgl_mulai_pmb)) {
                    $data['tgl_melewati_semua_pmb'] = false;
                }
            }
            if (! $data['form_dibuka']) {
                if ($data['tgl_melewati_semua_pmb']) {
                    $data['status_message'] = 'PMB Periode '.$data['periode']->nama_periode.' '.$data['periode']->semester.' Gelombang '.$gelombang.' sudah berakhir.';
                } else {
                    $data['status_message'] = 'PMB Periode '.$data['periode']->nama_periode.' '.$data['periode']->semester.' Gelombang '.$gelombang.' belum dimulai.';
                }
            }
        } else {
            $data['status_message'] = 'PMB periode '.$data['periode']->nama_periode.' '.$data['periode']->semester.' Belum tersedia.';
        }

        return view('auth.register',$data);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'telp' => ['required', 'unique:users,telp'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'g-recaptcha-response' => ['required','recaptcha'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => strtoupper($data['name']),
            'telp' => $data['telp'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $user->assignRole('pendaftar');
        return $user;
    }
}
