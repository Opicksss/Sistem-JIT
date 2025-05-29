<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
// use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('login.signin');
    }

    public function login_proses(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $login = $request->input('login');
        $password = $request->input('password');
        $remember = $request->has('remember');

        $user = User::where('email', $login)->orWhere('name', $login)->first();

        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user, $remember);
            if (Auth::user()->role == 'pegawai') {
                return redirect('/dashboard')->with('success', 'Login successful');
            } elseif (Auth::user()->role == 'admin') {
                return redirect('/dashboard')->with('success', 'Login successful');
            }
        } else {
            return redirect()->route('login')->with('error', 'Email, username or password is incorrect');
        }
    }

    public function forgot()
    {
        return view('login.forgot');
    }

    // Proses kirim kode verifikasi 6 digit
    public function forgot_proses(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
            ]);

            $email = $request->email;

            // Generate kode 6 digit
            $code = random_int(100000, 999999);

            // Simpan ke DB password_reset_tokens
            DB::table('password_reset_tokens')->updateOrInsert(['email' => $email], ['token' => $code, 'created_at' => now()]);

            // Kirim email kode verifikasi
            Mail::send('login.email-code', ['code' => $code], function ($message) use ($email) {
                $message->to($email);
                $message->subject('Your Password Reset Verification Code');
            });

            // Simpan email ke session untuk cek di step selanjutnya
            session(['reset_email' => $email]);

            return redirect()->route('verify-code')->with('success', 'Verification code sent to your email.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim kode verifikasi.');
        }
    }

    // Form input kode verifikasi
    public function verify_code()
    {
        if (!session('reset_email')) {
            return redirect()->route('forgot')->with('error', 'Please enter your email first.');
        }
        return view('login.verify-code');
    }

    // Proses verifikasi kode
    public function verify_code_proses(Request $request)
    {
        try {
            $request->validate([
                'code' => 'required|digits:6',
            ]);

            $email = session('reset_email');
            if (!$email) {
                return redirect()->route('forgot')->with('error', 'Session expired, please start over.');
            }

            $record = DB::table('password_reset_tokens')->where('email', $email)->where('token', $request->code)->first();

            if (!$record) {
                return back()->with('error', 'Invalid verification code.');
            }

            $createdAt = Carbon::parse($record->created_at);
            if ($createdAt->addMinutes(10)->isPast()) {
                return redirect()->route('forgot')->with('error', 'Verification code expired. Please request again.');
            }

            // Kode valid, simpan flag di session dan redirect ke form reset password
            session(['code_verified' => true]);

            return redirect()->route('reset-password')->with('success', 'Kode verifikasi berhasil. Silakan reset password.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memverifikasi kode.');
        }
    }

    // Form reset password
    public function reset_password()
    {
        if (!session('reset_email') || !session('code_verified')) {
            return redirect()->route('forgot')->with('error', 'Unauthorized access.');
        }
        return view('login.reset-password');
    }

    // Proses reset password
    public function reset_password_proses(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required|min:8|confirmed',
            ]);

            if (!session('reset_email') || !session('code_verified')) {
                return redirect()->route('forgot')->with('error', 'Unauthorized access.');
            }

            $email = session('reset_email');

            // Update password user
            $user = User::where('email', $email)->first();
            $user->password = Hash::make($request->password);
            $user->save();

            // Hapus token
            DB::table('password_reset_tokens')->where('email', $email)->delete();

            // Clear session
            session()->forget(['reset_email', 'code_verified']);

            return redirect()->route('login')->with('success', 'Password has been reset successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mereset password.');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
