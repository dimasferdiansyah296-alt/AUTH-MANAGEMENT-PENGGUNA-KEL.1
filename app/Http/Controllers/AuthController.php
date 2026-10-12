<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * ------------------------------------------------------------------
     * 1. MENAMPILKAN FORM LOGIN
     * ------------------------------------------------------------------
     * Method ini hanya merender halaman login.
     * Middleware 'guest' memastikan user yang sudah login tidak bisa
     * mengakses halaman login lagi.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * ------------------------------------------------------------------
     * 2. PROSES LOGIN (AUTENTIKASI)
     * ------------------------------------------------------------------
     * Menerima email & password, memverifikasi kredensial, lalu
     * mengarahkan user ke dashboard sesuai rolenya.
     */
    public function login(Request $request): RedirectResponse
    {
        // Validasi input: email harus format email, password wajib diisi
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Attempt login. Kolom 'password' akan otomatis dibandingkan dengan
        // hash yang tersimpan di database (Laravel mengurus bcrypt).
        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            // Jika gagal, kembalikan ke halaman login dengan error & input lama
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->onlyInput('email');
        }

        // Regenerasi session untuk mencegah session fixation attack
        $request->session()->regenerate();

        // Arahkan ke dashboard sesuai role user
        return redirect()->intended($this->redirectByRole(Auth::user()->role));
    }

    /**
     * ------------------------------------------------------------------
     * 3. MENAMPILKAN FORM REGISTER (KHUSUS PELANGGAN)
     * ------------------------------------------------------------------
     * Hanya pelanggan yang bisa register sendiri di halaman publik.
     * Admin & karyawan dibuat oleh admin (bukan lewat form register publik).
     */
    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    /**
     * ------------------------------------------------------------------
     * 4. PROSES REGISTER PELANGGAN
     * ------------------------------------------------------------------
     * Membuat record di tabel `users` (role = pelanggan) DAN tabel
     * `pelanggan` (data no_telepon & alamat) dalam satu transaksi DB.
     * Jika salah satu gagal, rollback semuanya (atomic).
     */
    public function register(Request $request): RedirectResponse
    {
        // Validasi semua field
        $validated = $request->validate([
            'nama'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'], // 'confirmed' butuh field password_confirmation
            'no_telepon' => ['required', 'string', 'max:20'],
            'alamat'     => ['required', 'string'],
        ]);

        // Gunakan transaksi agar user & pelanggan terbuat bersamaan
        $user = DB::transaction(function () use ($validated) {
            // 1. Buat user. Password di-hash otomatis oleh cast 'hashed' di model User.
            //    (Bisa juga pakai Hash::make($validated['password']) secara eksplisit)
            $user = User::create([
                'nama'     => $validated['nama'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']), // enkripsi password
                'role'     => 'pelanggan', // role ditetapkan otomatis
            ]);

            // 2. Buat record pelanggan yang terhubung ke user baru
            Pelanggan::create([
                'id_user'    => $user->id_user, // pakai PK kustom: id_user
                'no_telepon' => $validated['no_telepon'],
                'alamat'     => $validated['alamat'],
            ]);

            return $user;
        });

        // Login otomatis setelah register agar user langsung masuk
        Auth::login($user);

        return redirect()
            ->route('pelanggan.dashboard')
            ->with('success', 'Akun pelanggan berhasil dibuat! Selamat datang, '.$user->nama.'.');
    }

    /**
     * ------------------------------------------------------------------
     * 5. LOGOUT
     * ------------------------------------------------------------------
     * Menghapus session login dan meregenerasi token.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }

    /**
     * ------------------------------------------------------------------
     * HELPER: Tentukan URL dashboard berdasarkan role
     * ------------------------------------------------------------------
     */
    private function redirectByRole(string $role): string
    {
        return match ($role) {
            'admin'    => route('admin.dashboard'),
            'karyawan' => route('karyawan.dashboard'),
            'pelanggan' => route('pelanggan.dashboard'),
            default    => route('login'),
        };
    }
}
