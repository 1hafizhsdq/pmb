<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\CredentialApps;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                    return redirect()->route('login')->with('error', 'Akun Anda tidak aktif. Silakan hubungi administrator.');
                }
                if (!$user->hasRole('pendaftar')) {
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'Maaf, Anda tidak diizinkan untuk masuk.');
                }
                return redirect()->intended('/');
            }
        } else {
            $user = Auth::user();
            if ($user->is_active != 1) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Akun Anda tidak aktif. Silakan hubungi administrator.');
            }
            if (!$user->hasRole('pendaftar')) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Maaf, Anda tidak diizinkan untuk masuk.');
            }
            return redirect()->intended('/');
        }

        return redirect()->route('login')->with('error', 'Email atau username dan password salah.');
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
