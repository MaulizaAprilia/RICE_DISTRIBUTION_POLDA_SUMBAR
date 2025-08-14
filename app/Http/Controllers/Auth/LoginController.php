<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\UserProfile;


class LoginController extends Controller
{
    public function index(Request $request)
    {
        return view('login');
    }

    public function adminPage(){
        return view('loginadmin');
    }

    public function login(Request $request)
    {
        // Validasi form login
        $request->validate([
            'nrp' => 'required|digits:8|exists:user_profile,nrp',
            'password' => 'required|min:8',
        ], [
            'nrp.required' => 'NRP wajib diisi.',
            'nrp.digits' => 'NRP harus terdiri dari tepat 8 digit angka.',
            'nrp.exists' => 'NRP tidak ditemukan.',

            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Kata sandi minimal :min karakter.',
        ]);

        

        $this->checkTooManyAttempts($request);

        // Ambil profile berdasarkan NRP
        $profile = UserProfile::where('nrp', $request->nrp)->first();

        if (!$profile || !$profile->user) {
            return back()->with('alert', [
                'type' => 'error',
                'title' => 'Gagal',
                'text' => 'NRP tidak ditemukan!'
            ]);
        }

        $user = $profile->user; // Relasi ke model User

        // Cek password
        if (!\Hash::check($request->password, $user->password)) {
            RateLimiter::hit($this->throttleKey($request), 60);

            Log::warning('Percobaan login gagal', [
                'nrp' => $request->nrp,
                'ip' => $request->ip(),
                'time' => now(),
            ]);

            throw ValidationException::withMessages([
                'nrp' => __('NRP atau password salah.'),
            ]);
        }

        if ($user->is_approved == 0) {
            return redirect()->back()
                ->with('alert', [
                    'type' => 'warning',
                    'title' => 'Akun Belum Disetujui',
                    'text' => 'Silakan menunggu persetujuan dari admin.'
                ]);
        }

        // Login manual
        Auth::login($user, $request->filled('remember'));

        // Reset limit percobaan login
        RateLimiter::clear($this->throttleKey($request));

        // Regenerate session untuk keamanan
        $request->session()->regenerate();

        Log::info('User berhasil login', [
            'user_id' => $user->id,
            'ip' => $request->ip(),
            'time' => now(),
        ]);

        // Redirect berdasarkan role
        return $this->redirectBasedOnRole();
    }

    public function loginAdmin(Request $request){
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|min:8',
        ], [
            'name.required' => 'Username wajib diisi.',
            'name.string' => 'Username harus berupa teks.',

            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Kata sandi minimal :min karakter.',
        ]);

        

        $this->checkTooManyAttempts($request);

        if (Auth::attempt($request->only('name', 'password'), $request->filled('remember'))) {

            $user = Auth::user();

            // Reset limit percobaan login
            RateLimiter::clear($this->throttleKey($request));

            // Regenerate session untuk keamanan
            $request->session()->regenerate();

            Log::info('User berhasil login', [
                'user_id' => Auth::id(),
                'ip' => $request->ip(),
                'time' => now(),
            ]);

            // Redirect berdasarkan role
            return $this->redirectBasedOnRole();
        }

        RateLimiter::hit($this->throttleKey($request), 60); // cooldown 60 detik

        Log::warning('Percobaan login gagal', [
            'name' => $request->name,
            'ip' => $request->ip(),
            'time' => now(),
        ]);

        throw ValidationException::withMessages([
            'name' => __('Username atau password salah.'),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('alert', [
            'type' => 'success',
            'title' => 'Berhasil',
            'text' => 'Keluar Berhasil!'
        ]);
    }

    private function checkTooManyAttempts(Request $request)
    {
        if (RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            $seconds = RateLimiter::availableIn($this->throttleKey($request));

            throw ValidationException::withMessages([
                'email' => __("Terlalu banyak percobaan login. Coba lagi dalam $seconds detik."),
            ]);
        }
    }

    private function throttleKey(Request $request)
    {
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }

    private function redirectBasedOnRole()
    {
        $role = Auth::user()->role;

        if ($role === 'superadmin') {
            return redirect()->route('superadmin.dashboard')->with('alert', [
                'type' => 'success',
                'title' => 'Berhasil',
                'text' => 'Login Berhasil!'
            ]);
        } elseif ($role === 'admin polres') {
            return redirect()->route('admin.polres.dashboard')->with('alert', [
                'type' => 'success',
                'title' => 'Berhasil',
                'text' => 'Login Berhasil!'
            ]);
        }elseif ($role === 'admin polsek') {
            return redirect()->route('admin.polsek.dashboard')->with('alert', [
                'type' => 'success',
                'title' => 'Berhasil',
                'text' => 'Login Berhasil!'
            ]);
        } elseif ($role === 'admin polda') {
            return redirect()->route('admin.polda.dashboard')->with('alert', [
                'type' => 'success',
                'title' => 'Berhasil',
                'text' => 'Login Berhasil!'
            ]);
        }
        elseif ($role === 'pimpinan') {
            return redirect()->route('pimpinan.dashboard')->with('alert', [
                'type' => 'success',
                'title' => 'Berhasil',
                'text' => 'Login Berhasil!'
            ]);
        }elseif ($role === 'user') {
            return redirect()->route('user.masyarakat')->with('alert', [
                'type' => 'success',
                'title' => 'Berhasil',
                'text' => 'Login Berhasil!'
            ]);
        }

        return redirect()->back();
    }


}
