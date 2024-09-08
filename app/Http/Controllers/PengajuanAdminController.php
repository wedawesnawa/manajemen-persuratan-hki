<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Mahasiswa;
use App\Models\PengajuanHKI;
use App\Models\PengajuanPublikasi;
use Illuminate\Support\Facades\Storage;


class PengajuanAdminController extends Controller
{
    public function hki()
    {
        $mhs = Mahasiswa::join('pengajuan_hki', 'mahasiswa.nim_mhs', '=', 'pengajuan_hki.nim_mhs')
        ->select('mahasiswa.*', 'pengajuan_hki.status')
        ->get();
        return view('admin.hki', ['mahasiswa' => $mhs]); 
    }

    public function publikasi()
    {
        $mhs = Mahasiswa::join('pengajuan_publikasi', 'mahasiswa.nim_mhs', '=', 'pengajuan_publikasi.nim_mhs')
        ->select('mahasiswa.*', 'pengajuan_publikasi.status')
        ->get();
        return view('admin.publikasi', ['mahasiswa' => $mhs]); 
    }
    public function detail($nim_mhs)
    {
        $mahasiswa = Mahasiswa::join('pengajuan_hki', 'mahasiswa.nim_mhs', '=', 'pengajuan_hki.nim_mhs')
        ->select('mahasiswa.*', 'pengajuan_hki.*')
        ->where('mahasiswa.nim_mhs', $nim_mhs)
        ->first(); 
        // dd($mahasiswa);
        return view('admin.detailHKI', ['mahasiswa' => $mahasiswa]);
    }
    public function detailPublikasi($nim_mhs)
    {
        $mahasiswa = Mahasiswa::join('pengajuan_publikasi', 'mahasiswa.nim_mhs', '=', 'pengajuan_publikasi.nim_mhs')
        ->select('mahasiswa.*', 'pengajuan_publikasi.*')
        ->where('mahasiswa.nim_mhs', $nim_mhs)
        ->first(); 
        return view('admin.detailPublikasi', ['mahasiswa' => $mahasiswa]);
    }
    public function editForm(Request $request)
    {
        try {
            // Validate incoming data
            $validatedData = $request->validate([
                'nim_mhs' => 'required|string',
                'status' => 'required|string',
                'komentar' => 'nullable|string|max:255',
            ]);
    
            // Find the record to update
            $pengajuanHKI = PengajuanHKI::where('nim_mhs', $validatedData['nim_mhs'])->first();
    
            if (!$pengajuanHKI) {
                return response()->json(['success' => false, 'message' => 'Data tidak ditemukan.'], 404);
            }
    
            // Update the record
            $pengajuanHKI->status = $validatedData['status'];
            $pengajuanHKI->komentar = $validatedData['komentar'];
            $pengajuanHKI->save();
    
            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan!']);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan data.'], 500);
        }
    }
    public function editFormPub(Request $request)
    {
        try {
            // Validate incoming data
            $validatedData = $request->validate([
                'nim_mhs' => 'required|string',
                'status' => 'required|string',
                'komentar' => 'nullable|string|max:255',
            ]);
    
            // Find the record to update
            $pengajuanPub = PengajuanPublikasi::where('nim_mhs', $validatedData['nim_mhs'])->first();
    
            if (!$pengajuanPub) {
                return response()->json(['success' => false, 'message' => 'Data tidak ditemukan.'], 404);
            }
    
            // Update the record
            $pengajuanPub->status = $validatedData['status'];
            $pengajuanPub->komentar = $validatedData['komentar'];
            $pengajuanPub->save();
    
            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan!']);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan data.'], 500);
        }
    }
}
