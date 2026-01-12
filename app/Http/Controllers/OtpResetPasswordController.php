<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class OtpResetPasswordController extends Controller
{
    public function showEmailForm()
    {
        return view('auth.forgot-otp');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email tidak terdaftar');
        }

        $otpData = DB::table('password_otps')
            ->where('email', $request->email)
            ->first();

        if ($otpData && $otpData->resend_count >= 3 && $otpData->expired_at > now()) {
            return back()->with('error', 'Terlalu banyak permintaan OTP. Coba lagi nanti.');
        }

        $otp = rand(100000, 999999);

        DB::table('password_otps')->updateOrInsert(
            ['email' => $request->email],
            [
                'otp' => $otp,
                'expired_at' => now()->addMinutes(5),
                'resend_count' => $otpData ? $otpData->resend_count + 1 : 1,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        // Kirim email
        Mail::raw(
            "Kode OTP reset password kamu: $otp (berlaku 5 menit)",
            function ($msg) use ($request) {
                $msg->to($request->email)->subject('Kode OTP Reset Password');
            }
        );

        $request->session()->put('email', $request->email);

        return redirect()->route('otp.reset.form')
            ->with('success', 'Kode OTP berhasil dikirim ke email kamu');
    }

    public function showResetForm()
    {
        return view('auth.reset-otp');
    }

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
            return back()->with('error', 'OTP tidak valid atau sudah kedaluwarsa');
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        DB::table('password_otps')
            ->where('email', $request->email)
            ->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Password berhasil diubah. Silakan login.');
    }
}
