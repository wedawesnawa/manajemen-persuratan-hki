<?php

namespace App\Http\Controllers;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    public function mahasiswa()
    {
        $dosen = Dosen::all();
        $mhs = Mahasiswa::all();
        return view('admin.mahasiswa', ['mahasiswa' => $mhs, 'dosen' => $dosen]); 
    }
    public function tambahMhs(Request $request)
    {
        try {
            // Validate incoming data
            $validatedData = $request->validate([
                'nim_mhs' => 'required|integer',
                'nama_mhs' => 'required|string|max:255',
                'email' => 'required|email',
                'kelompok' => 'required|string|max:30',
                'dosen_pa' => 'nullable|string|max:255',
                'dosen_p1' => 'nullable|string|max:255',
                'dosen_p2' => 'nullable|string|max:255',
            ]);
    
            $mahasiswa = Mahasiswa::updateOrCreate(
                ['nim_mhs' => $validatedData['nim_mhs']],
                [
                    'nama_mhs' => $validatedData['nama_mhs'],
                    'email' => $validatedData['email'],
                    'kelompok' => $validatedData['kelompok'],
                    'dosen_pa' => $validatedData['dosen_pa'],
                    'dosen_p1' => $validatedData['dosen_p1'],
                    'dosen_p2' => $validatedData['dosen_p2']
                ]
            );
    
            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan!']);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan data.'], 500);
        }
    }
    public function editMhs($nim_mhs)
    {
        $dosen = Dosen::all();
        $mahasiswa = Mahasiswa::all()
        ->where('nim_mhs', $nim_mhs)
        ->first(); 
        return view('admin.detailMahasiswa', ['mahasiswa' => $mahasiswa, 'dosen'=> $dosen]);
    }
    public function editMahasiswa(Request $request){
        try {
            // Validate incoming data
            $validatedData = $request->validate([
                'nim_mhs' => 'required|integer',
                'nama_mhs' => 'required|string|max:255',
                'email' => 'required|email',
                'kelompok' => 'required|string|max:30',
                'dosen_pa' => 'nullable|string|max:255',
                'dosen_p1' => 'nullable|string|max:255',
                'dosen_p2' => 'nullable|string|max:255',
            ]);
    
            $mahasiswa = Mahasiswa::where('nim_mhs', $validatedData['nim_mhs'])->firstOrFail();

            $mahasiswa->update([
                'nama_mhs' => $validatedData['nama_mhs'],
                'email' => $validatedData['email'],
                'kelompok' => $validatedData['kelompok'],
                'dosen_pa' => $validatedData['dosen_pa'],
                'dosen_p1' => $validatedData['dosen_p1'],
                'dosen_p2' => $validatedData['dosen_p2'],
            ]);
    
            return response()->json(['success' => true, 'message' => 'Data mahasiswa berhasil diperbarui.']);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan data.'], 500);
        }
    }
    public function destroy($nim_mhs)
    {
        $mahasiswa = Mahasiswa::where('nim_mhs', $nim_mhs)->first();

        if ($mahasiswa) {
            $mahasiswa->delete();
            return redirect()->back()->with('success', 'Data mahasiswa berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }
    }


    public function dosen()
    {
        $dosen = Dosen::all();
        return view('admin.dosen',['dosen' => $dosen]); 
    }

    public function detailDosen($nip)
    {
        $dosen = Dosen::all() 
        ->where('NIP', $nip)
        ->first(); 
        return view('admin.detailDosen', ['dosen' => $dosen]);
    }

    public function tambahDosen(Request $request)
    {
        try {
            // Validate incoming data
            $validatedData = $request->validate([
                'NIP' => 'required|string|max:255',
                'NIDN' => 'required|string|max:255',
                'nama_dosen' => 'required|string|max:30',
                'no_telp' => 'required|string|max:30',
            ]);
    
            $dosen = Dosen::updateOrCreate(
                ['NIP' => $validatedData['NIP']],
                [
                    'NIDN' => $validatedData['NIDN'],
                    'nama_dosen' => $validatedData['nama_dosen'],
                    'no_telp' => $validatedData['no_telp']
                ]
            );
    
            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan!']);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan data.'], 500);
        }
    }
    public function editDosen(Request $request)
    {
        try {
            // Validate incoming data
            $validatedData = $request->validate([
                'NIP' => 'required|integer',
                'NIDN' => 'required|string|max:255',
                'nama_dosen' => 'required|string|max:30',
                'no_telp' => 'required|string|max:30',
            ]);
    
            $dosen = Dosen::where('NIP', $validatedData['NIP'])->firstOrFail();

            $dosen->update([
                'NIP' => $validatedData['NIP'],
                'NIDN' => $validatedData['NIDN'],
                'nama_dosen' => $validatedData['nama_dosen'],
                'no_telp' => $validatedData['no_telp'],
            ]);
    
            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan!']);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan data.'], 500);
        }
    }
    public function destroyDosen($nip)
    {
        $dosen = Dosen::where('NIP', $nip)->first();

        if ($dosen) {
            $dosen->delete();
            return redirect()->back()->with('success', 'Data mahasiswa berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }
    }
}
