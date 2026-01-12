<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class OtpResetPasswordController extends Controller
{
    // FORM EMAIL
    public function showEmailForm()
    {
        return view('auth.forgot-otp');
    }

    // KIRIM OTP
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak terdaftar']);
        }

        $otp = rand(100000, 999999);

        DB::table('password_otps')->updateOrInsert(
            ['email' => $request->email],
            [
                'otp' => $otp,
                'expired_at' => Carbon::now()->addMinutes(5),
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        Mail::raw("Kode OTP reset password kamu: $otp (berlaku 5 menit)", function ($msg) use ($request) {
            $msg->to($request->email)->subject('Kode OTP Reset Password');
        });

        return redirect()->route('otp.reset.form')->with('email', $request->email);
    }

    // FORM RESET
    public function showResetForm()
    {
        return view('auth.reset-otp');
    }

    // RESET PASSWORD
    public function resetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'otp' => 'required',
        'password' => 'required|min:6|confirmed',
    ]);

    $otpData = DB::table('password_otps')
        ->where('email', $request->email)
        ->where('otp', $request->otp)
        ->where('expired_at', '>', now())
        ->first();

    if (!$otpData) {
        return back()->withErrors(['otp' => 'OTP tidak valid atau sudah kedaluwarsa']);
    }

    $user = User::where('email', $request->email)->firstOrFail();

    $user->update([
        'password' => Hash::make($request->password),
    ]);

    // 🔥 HAPUS OTP SETELAH BERHASIL
    DB::table('password_otps')->where('email', $request->email)->delete();

    // 🔥 PASTIKAN SESSION BERSIH
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')
        ->with('success', 'Password berhasil diubah. Silakan login.');
}
}
