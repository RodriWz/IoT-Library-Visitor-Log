<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengunjung;
use Illuminate\Support\Facades\Log; 

class DaftarPengunjungController extends Controller
{
    public function index()
    {
        $pengunjungs = Pengunjung::orderBy('created_at', 'desc')->get();
        return view('daftarpengunjung', compact('pengunjungs'));
    }

    public function update(Request $request, $id)
    {
        // Debug info - PAKAI Log:: BUKAN \Log::
        Log::info("Update request for ID: $id", $request->all());

        try {
            $pengunjung = Pengunjung::find($id);
            
            if (!$pengunjung) {
                Log::warning("Data not found for ID: $id");
                return response()->json([
                    'success' => false, 
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            // Update data
            $pengunjung->update([
                'nama' => $request->nama,
                'nim' => $request->nim,
                'prodi' => $request->prodi,
                'tujuan' => $request->tujuan
            ]);

            Log::info("Data updated successfully - ID: $id");

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diupdate',
                'data' => $pengunjung
            ]);

        } catch (\Exception $e) {
            Log::error("Update error for ID $id: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            Log::info("Delete request for ID: $id");
            
            $pengunjung = Pengunjung::find($id);
            
            if (!$pengunjung) {
                Log::warning("Data not found for deletion - ID: $id");
                return response()->json([
                    'success' => false, 
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $pengunjung->delete();
            
            Log::info("Data deleted successfully - ID: $id");

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            Log::error("Delete error for ID $id: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}