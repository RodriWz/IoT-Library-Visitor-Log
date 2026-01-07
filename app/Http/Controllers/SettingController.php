<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    /**
     * Tampilkan data user ke modal/halaman pengaturan
     */
    public function index()
    {
        $user = Auth::user();
        return view('pengaturan', compact('user'));
    }

    /**
     * Update Profil (Nama & Foto) dalam satu form
     */
    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::id());

        // Validasi: Nama wajib, Foto opsional
        $request->validate([
            'name' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'name.required' => 'Nama tidak boleh kosong.',
            'foto.image'    => 'File harus berupa gambar.',
            'foto.max'      => 'Ukuran foto maksimal 2MB.',
        ]);

        try {
            // 1. Update Nama ke Database
            $user->name = $request->name;

            // 2. Update Foto jika ada file baru yang diunggah
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                
                $uploadPath = public_path('uploads/profile');
                if (!File::isDirectory($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }

                // Hapus foto lama jika ada untuk menghemat penyimpanan
                if ($user->foto && File::exists(public_path('uploads/profile/' . $user->foto))) {
                    File::delete(public_path('uploads/profile/' . $user->foto));
                }

                $file->move($uploadPath, $filename);
                $user->foto = $filename;
            }

            $user->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Profil berhasil diperbarui.',
                    'nama'    => $user->name,
                    'foto_url'=> asset('uploads/profile/' . $user->foto)
                ]);
            }

            return back()->with('success', 'Profil berhasil diperbarui.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update Password Manual
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6|confirmed',
        ], [
            'password_lama.required' => 'Password lama wajib diisi.',
            'password_baru.min'      => 'Password baru minimal 6 karakter.',
            'password_baru.confirmed'=> 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::find(Auth::id());

        // Cek apakah password lama benar
        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->with('error', 'Password lama Anda salah.');
        }

        // Simpan password baru
        $user->password = Hash::make($request->password_baru);
        $user->save();

        return back()->with('success', 'Password berhasil diganti.');
    }

    /**
     * Hapus Foto Profil (Reset ke default)
     */
    public function deleteProfile()
    {
        try {
            $user = User::find(Auth::id());

            if ($user->foto && File::exists(public_path('uploads/profile/' . $user->foto))) {
                File::delete(public_path('uploads/profile/' . $user->foto));
            }

            $user->foto = null;
            $user->save();

            return back()->with('success', 'Foto profil telah dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus foto.');
        }
    }
}