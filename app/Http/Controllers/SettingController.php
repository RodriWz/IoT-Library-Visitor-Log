<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class SettingController extends Controller
{
   
    // 1. TAMPIL HALAMAN PENGATURAN - DIPERBAIKI
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = User::find(Auth::id());
        
        return view('pengaturan', compact('user'));
    }

    // 2. UPDATE FOTO PROFIL - DIPERBAIKI
    public function updateProfile(Request $request)
    {
        if (!Auth::check()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sesi Anda telah berakhir. Silakan login kembali.'
                ], 401);
            }
            return redirect()->route('login')->with('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
        }

        $user = Auth::user();

        // Validasi file
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'foto.required' => 'Foto harus diupload.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto harus jpeg, png, jpg, webp, atau gif.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        try {
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                
                $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                
                $uploadPath = public_path('uploads/profile');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $file->move($uploadPath, $filename);

                if ($user->foto && file_exists(public_path('uploads/profile/' . $user->foto))) {
                    unlink(public_path('uploads/profile/' . $user->foto));
                }

                User::where('id', $user->id)->update(['foto' => $filename]);

                $updatedUser = User::find($user->id);
                Auth::setUser($updatedUser);

                session()->forget('user_photo_cache');
                session()->save();

                $foto_url = asset('uploads/profile/' . $filename) . '?v=' . time();

                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Foto profil berhasil diperbarui.',
                        'foto_url' => $foto_url,
                        'filename' => $filename,
                        'timestamp' => time()
                    ]);
                }

                return back()->with('success', 'Foto profil berhasil diperbarui.')->with('timestamp', time());
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengupload foto.'
                ], 400);
            }

            return back()->with('error', 'Gagal mengupload foto.');

        } catch (\Exception $e) {

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    // 3. UPDATE PASSWORD MANUAL - SUDAH BENAR
    public function updatePassword(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
        }

        $user = Auth::user();

        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6|confirmed',
        ], [
            'password_lama.required' => 'Password lama harus diisi.',
            'password_baru.required' => 'Password baru harus diisi.',
            'password_baru.min' => 'Password baru minimal 6 karakter.',
            'password_baru.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->with('error', 'Password lama tidak cocok.');
        }

        User::where('id', $user->id)->update([
            'password' => Hash::make($request->password_baru)
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    // 4. KIRIM KODE RESET PASSWORD - SUDAH BENAR
    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan di sistem.');
        }

        $kode = rand(100000, 999999);

        User::where('id', $user->id)->update(['reset_code' => $kode]);

        try {
            Mail::raw("Halo {$user->name},\n\nKode reset password Anda adalah: {$kode}\n\nKode ini berlaku untuk satu kali penggunaan.\n\nTerima kasih,\nLibrary Medical Faculty", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Kode Reset Password - Library Medical Faculty');
            });

            return back()->with('success', 'Kode reset telah dikirim ke email Anda.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email: ' . $e->getMessage());
        }
    }

    // 5. RESET PASSWORD DENGAN KODE - SUDAH BENAR
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'kode' => 'required|numeric|digits:6',
            'password_baru' => 'required|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)
                    ->where('reset_code', $request->kode)
                    ->first();

        if (!$user) {
            return back()->with('error', 'Kode salah atau email tidak valid.');
        }

        User::where('id', $user->id)->update([
            'password' => Hash::make($request->password_baru),
            'reset_code' => null
        ]);

        return back()->with('success', 'Password berhasil direset. Silakan login dengan password baru Anda.');
    }

    // 6. HAPUS FOTO PROFIL - DIPERBAIKI
    public function deleteProfile(Request $request)
    {
        if (!Auth::check()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sesi Anda telah berakhir. Silakan login kembali.'
                ], 401);
            }
            return redirect()->route('login')->with('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
        }

        $user = Auth::user();

        try {
            if ($user->foto && file_exists(public_path('uploads/profile/' . $user->foto))) {
                unlink(public_path('uploads/profile/' . $user->foto));
            }

            User::where('id', $user->id)->update(['foto' => null]);

            $updatedUser = User::find($user->id);
            Auth::setUser($updatedUser);

            session()->forget('user_photo_cache');
            session()->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Foto profil berhasil dihapus.',
                    'foto_url' => asset('images/default.png') . '?v=' . time(),
                    'timestamp' => time()
                ]);
            }

            return back()->with('success', 'Foto profil berhasil dihapus.');

        } catch (\Exception $e) {

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function getUserPhoto(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Not authenticated'
            ], 401);
        }

        $user = User::find(Auth::id());
        
        $photoUrl = $user->foto 
            ? asset('uploads/profile/' . $user->foto) . '?v=' . time()
            : asset('images/default.png') . '?v=' . time();

        return response()->json([
            'success' => true,
            'foto_url' => $photoUrl,
            'has_photo' => !empty($user->foto),
            'timestamp' => time()
        ]);
    }
}