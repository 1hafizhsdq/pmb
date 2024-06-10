<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\CredentialApps;
use App\Http\Controllers\Controller;
use App\Models\Periode;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // public function login(Request $request)
    // {
    //     $crd = CredentialApps::check();
    //     if($crd == false){
    //         return back();
    //     }

    //     $this->validateLogin($request);

    //     if (method_exists($this, 'hasTooManyLoginAttempts') &&
    //         $this->hasTooManyLoginAttempts($request)) {
    //         $this->fireLockoutEvent($request);

    //         return $this->sendLockoutResponse($request);
    //     }

    //     if ($this->attemptLogin($request)) {
    //         if ($request->hasSession()) {
    //             $request->session()->put('auth.password_confirmed_at', time());
    //         }

    //         return $this->sendLoginResponse($request);
    //     }

    //     $this->incrementLoginAttempts($request);

    //     return $this->sendFailedLoginResponse($request);
    // }

    // public function attemptLogin(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     // Mengubah nomor telepon yang dimulai dengan '0' atau '+62' menjadi '62'
    //     if (substr($credentials['email'], 0, 1) === '0') {
    //         $credentials['email'] = '62' . substr($credentials['email'], 1);
    //     } elseif (substr($credentials['email'], 0, 3) === '+62') {
    //         $credentials['email'] = '62' . substr($credentials['email'], 3);
    //     }
    
    //     if (filter_var($credentials['email'], FILTER_VALIDATE_EMAIL)) {
    //         $field = 'email';
    //     } elseif (substr($credentials['email'], 0, 2) === '62') {
    //         $field = 'telp';
    //     } else {
    //         $field = 'no_induk';
    //     }

    //     return Auth::attempt([$field => $credentials['email'], 'password' => $credentials['password']]);
    // }

    public function showLoginForm()
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

        return view('auth.login',$data);
    }

    public function username()
    {
        return 'username';
    }

    protected function credentials(Request $request)
    {
        $login = $request->input($this->username());
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        return [
            $field => $login,
            'password' => $request->input('password'),
        ];
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            $this->username() => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => 'required|recaptcha',
        ], [
            'g-recaptcha-response.required' => 'Please complete the reCAPTCHA to proceed.',
            'g-recaptcha-response.recaptcha' => 'reCAPTCHA validation failed, please try again.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('login')->with('message', $validator->errors()->all()[0]);
        }
        
        // $crd = CredentialApps::check();
        // if($crd == false){
        //     return back();
        // }
        
        $loginField = $request->input($this->username());
        $credentials = [
            $this->username() => $loginField,
            'password' => $request->input('password'),
        ];

        $attemptWithEmail = Auth::attempt(['email' => $loginField, 'password' => $request->input('password')]);

        if (!$attemptWithEmail) {
            $attemptWithUsername = Auth::attempt(['username' => $loginField, 'password' => $request->input('password')]);
            if ($attemptWithUsername) {
                $user = Auth::user();
                if ($user->is_active != 1) {
                    Auth::logout();
                    return redirect()->route('login')->with('message', 'Akun Anda tidak aktif. Silakan hubungi administrator.');
                }
                if (!$user->hasRole('pendaftar')) {
                    Auth::logout();
                    return redirect()->route('login')->with('message', 'Maaf, Anda tidak diizinkan untuk masuk karena telah terdaftar sebagai civitas akademika STAINUPA.');
                }
                return redirect()->intended('/');
            }
        } else {
            $user = Auth::user();
            if ($user->is_active != 1) {
                Auth::logout();
                return redirect()->route('login')->with('message', 'Akun Anda tidak aktif. Silakan hubungi administrator.');
            }
            if (!$user->hasRole('pendaftar')) {
                Auth::logout();
                return redirect()->route('login')->with('message', 'Maaf, Anda tidak diizinkan untuk masuk karena telah terdaftar sebagai civitas akademika STAINUPA.');
            }
            return redirect()->intended('/');
        }

        return redirect()->route('login')->with('message', 'Email atau username dan password salah.');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
        // return response()->json([ 'success' => 'Berhasil menyimpan data.']);
    }
}
