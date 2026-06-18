<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Maksimum percobaan gagal sebelum akun dikunci.
     */
    private const MAX_ATTEMPTS = 5;

    /**
     * Durasi kunci (detik) setelah gagal berulang — 15 menit.
     */
    private const LOCKOUT_SECONDS = 900;

    public function show(): View
    {
        return view('admin.auth.login');
    }

    public function attempt(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $this->ensureIsNotRateLimited($request);

        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            RateLimiter::hit($this->throttleKey($request), self::LOCKOUT_SECONDS);

            ActivityLog::record('login_failed', 'Login gagal untuk '.$request->input('email'), null, $request);

            throw ValidationException::withMessages([
                'email' => 'Email atau kata sandi salah.',
            ]);
        }

        if (! Auth::user()->is_active) {
            ActivityLog::record('login_blocked', 'Akun nonaktif: '.$request->input('email'), Auth::id(), $request);
            Auth::logout();

            throw ValidationException::withMessages([
                'email' => 'Akun Anda dinonaktifkan.',
            ]);
        }

        RateLimiter::clear($this->throttleKey($request));

        $request->session()->regenerate();
        Auth::user()->forceFill(['last_login_at' => now()])->save();

        ActivityLog::record('login_success', 'Berhasil masuk panel', Auth::id(), $request);

        return redirect()->intended(route('panel.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        ActivityLog::record('logout', 'Keluar dari panel', Auth::id(), $request);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('panel.login');
    }

    /**
     * Tolak bila percobaan login sudah melewati batas (kunci 15 menit).
     */
    private function ensureIsNotRateLimited(Request $request): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), self::MAX_ATTEMPTS)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey($request));
        $minutes = (int) ceil($seconds / 60);

        throw ValidationException::withMessages([
            'email' => "Terlalu banyak percobaan login. Coba lagi dalam {$minutes} menit.",
        ]);
    }

    /**
     * Kunci throttle per kombinasi email + IP.
     */
    private function throttleKey(Request $request): string
    {
        return Str::transliterate(Str::lower((string) $request->input('email')).'|'.$request->ip());
    }
}
