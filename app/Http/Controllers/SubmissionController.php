<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Mahasiswa;
use App\Models\PengajuanHKI;
use App\Models\PengajuanPublikasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Beranda;

class SubmissionController extends Controller
{
    public function beranda()
    {
        $posts = Beranda::where('status', 'active')->get(); 
        $jumlahActive = Beranda::where('status', 'active')->count();
        return view('users.beranda', ['posts'=> $posts, 'countPosts' => $jumlahActive]); 
    }
    public function hki(User $user)
    {
        $dosen = Dosen::all();
        $email = Auth::user()->email;

        $pengajuanHkiData = PengajuanHKI::whereHas('mahasiswa', function ($query) use ($email) {
            $query->where('email', $email);
        })->get();

        if (request()->ajax()) {
            return response()->json(['userData' => $pengajuanHkiData]);
        }    

        // dd($pengajuanHkiData);
        return view('users.hki', [
            'id' => $user->name,
            'dosen' => $dosen,
            'email' => $email,
            'userData' => $pengajuanHkiData
        ]); 
    }

    public function submitForm(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nim_mhs' => 'required|integer',
                'nama_mhs' => 'required|string|max:255',
                'email' => 'required|email',
                'kelompok' => 'required|string|max:30',
                'dosen_pa' => 'nullable|string|max:255',
                'dosen_p1' => 'nullable|string|max:255',
                'dosen_p2' => 'nullable|string|max:255',
                'manual_book' => 'nullable|file|mimes:pdf',
                'fomulir_dokumen' => 'nullable|file|mimes:pdf',
                'sertifikat_hki' => 'nullable|file|mimes:pdf',
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

            $filePaths = [
                'manualBook' => $request->file('manual_book') ? $request->file('manual_book')->store('documents', 'public') : null,
                'fomulirDokumen' => $request->file('fomulir_dokumen') ? $request->file('fomulir_dokumen')->store('documents', 'public') : null,
                'sertifikatHki' => $request->file('sertifikat_hki') ? $request->file('sertifikat_hki')->store('documents', 'public') : null,
            ];

            $pengajuanHki = new PengajuanHki();
            $pengajuanHki->nim_mhs = $validatedData['nim_mhs'];
            $pengajuanHki->submission_date = now();
            $pengajuanHki->status = 'diajukan';
            $pengajuanHki->manual_book = $filePaths['manualBook'];
            $pengajuanHki->fomulir_dokumen = $filePaths['fomulirDokumen'];
            $pengajuanHki->sertifikat_hki = $filePaths['sertifikatHki'];
            $pengajuanHki->komentar = null;
            $pengajuanHki->save();

            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan!']);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan data.'], 500);
        }
    }
   

    public function publikasi(User $user)
    {
        $dosen = Dosen::all();
        $email = Auth::user()->email;
        
        $pengajuanPublikasiData = PengajuanPublikasi::whereHas('mahasiswa', function ($query) use ($email) {
            $query->where('email', $email);
        })->get();

        if (request()->ajax()) {
            return response()->json(['userDataPub' => $pengajuanPublikasiData]);
        }    

        return view('users.publikasi',[
            'dosen' => $dosen,
            'email' => $email,
            'userDataPub' => $pengajuanPublikasiData,
        ]); 
    }

    public function submitFormPub(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nim_mhs' => 'required|integer',
                'nama_mhs' => 'required|string|max:255',
                'email' => 'required|email',
                'kelompok' => 'required|string|max:30',
                'dosen_pa' => 'nullable|string|max:255',
                'dosen_p1' => 'nullable|string|max:255',
                'dosen_p2' => 'nullable|string|max:255',
                'tanggal_pengajuan' => 'required|date',
                'judul_makalah_snatia' => 'required|string|max:255',
                'sertifikat_snatia' => 'nullable|file|mimes:pdf',
                'turnitin_snatia' => 'nullable|file|mimes:pdf',
                'loa_snatia' => 'nullable|file|mimes:pdf',
                'judul_makalah_pkl' => 'required|string|max:255',
                'turnitin_pkl' => 'nullable|file|mimes:pdf',
                'loa_pkl' => 'nullable|file|mimes:pdf',
                'judul_hki_pkl' => 'required|string|max:255',
                'tanggal_terbit_hki_pkl' => 'required|date',
                'manual_book_hki_pkl' => 'nullable|file|mimes:pdf',
                'sertifikat_hki_pkl' => 'nullable|file|mimes:pdf',
                'form_pendaftaran_hki_pkl' => 'nullable|file|mimes:pdf',
                'laporan_tugas_akhir' => 'nullable|file|mimes:pdf',
                'berita_acara_ujian_ta' => 'nullable|file|mimes:pdf',
                'lembar_pengesahan_ta' => 'nullable|file|mimes:pdf',
                'file_program_ta' => 'nullable|file|mimes:pdf',
                'judul_jurnal_ta' => 'required|string|max:255',
                'upload_draft_jurnal_ta' => 'nullable|file|mimes:pdf',
                'file_turnitin_draft_jurnal_ta' => 'nullable|file|mimes:pdf',
                'loa_publikasi_makalah_ta' => 'nullable|file|mimes:pdf',
                'judul_manual_book_ta' => 'required|string|max:255',
                'upload_file_manual_book_ta' => 'nullable|file|mimes:pdf',
                'upload_file_pendaftaran_hki_ta' => 'nullable|file|mimes:pdf',
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

            $filePaths = [
               'sertifikatSnatia' => $request->file('sertifikat_snatia') ? $request->file('sertifikat_snatia')->store('documents', 'public') : null,
                'turnitinSnatia' => $request->file('turnitin_snatia') ? $request->file('turnitin_snatia')->store('documents', 'public') : null,
                'loaSnatia' => $request->file('loa_snatia') ? $request->file('loa_snatia')->store('documents', 'public') : null,
                'turnitinPkl' => $request->file('turnitin_pkl') ? $request->file('turnitin_pkl')->store('documents', 'public') : null,
                'loaPkl' => $request->file('loa_pkl') ? $request->file('loa_pkl')->store('documents', 'public') : null,
                'manualBookHkiPkl' => $request->file('manual_book_hki_pkl') ? $request->file('manual_book_hki_pkl')->store('documents', 'public') : null,
                'sertifikatHkiPkl' => $request->file('sertifikat_hki_pkl') ? $request->file('sertifikat_hki_pkl')->store('documents', 'public') : null,
                'formPendaftaranHKIPkl' => $request->file('form_pendaftaran_hki_pkl') ? $request->file('form_pendaftaran_hki_pkl')->store('documents', 'public') : null,
                'laporanTugasAkhir' => $request->file('laporan_tugas_akhir') ? $request->file('laporan_tugas_akhir')->store('documents', 'public') : null,
                'beritaAcaraUjianTA' => $request->file('berita_acara_ujian_ta') ? $request->file('berita_acara_ujian_ta')->store('documents', 'public') : null,
                'lembarPengesahanTA' => $request->file('lembar_pengesahan_ta') ? $request->file('lembar_pengesahan_ta')->store('documents', 'public') : null,
                'fileProgramTA' => $request->file('file_program_ta') ? $request->file('file_program_ta')->store('documents', 'public') : null,
                'uploadDraftJurnalTA' => $request->file('upload_draft_jurnal_ta') ? $request->file('upload_draft_jurnal_ta')->store('documents', 'public') : null,
                'fileTurnitinDraftJurnalTA' => $request->file('file_turnitin_draft_jurnal_ta') ? $request->file('file_turnitin_draft_jurnal_ta')->store('documents', 'public') : null,
                'loaPublikasiMakalahTA' => $request->file('loa_publikasi_makalah_ta') ? $request->file('loa_publikasi_makalah_ta')->store('documents', 'public') : null,
                'uploadFileManualBookTA' => $request->file('upload_file_manual_book_ta') ? $request->file('upload_file_manual_book_ta')->store('documents', 'public') : null,
                'uploadFilePendaftaranHKITA' => $request->file('upload_file_pendaftaran_hki_ta') ? $request->file('upload_file_pendaftaran_hki_ta')->store('documents', 'public') : null,
            ];

            $pengajuanPublikasi = new PengajuanPublikasi();
            $pengajuanPublikasi->nim_mhs = $validatedData['nim_mhs'];
            $pengajuanPublikasi->tanggal_pengajuan = $validatedData['tanggal_pengajuan'];
            $pengajuanPublikasi->judul_makalah_snatia = $validatedData['judul_makalah_snatia'];
            $pengajuanPublikasi->sertifikat_snatia = $filePaths['sertifikatSnatia'];
            $pengajuanPublikasi->turnitin_snatia = $filePaths['turnitinSnatia'];
            $pengajuanPublikasi->loa_snatia = $filePaths['loaSnatia'];
            $pengajuanPublikasi->judul_makalah_pkl = $validatedData['judul_makalah_pkl'];
            $pengajuanPublikasi->turnitin_pkl = $filePaths['turnitinPkl'];
            $pengajuanPublikasi->loa_pkl = $filePaths['loaPkl'];
            $pengajuanPublikasi->judul_hki_pkl = $validatedData['judul_hki_pkl'];
            $pengajuanPublikasi->tanggal_terbit_hki_pkl = $validatedData['tanggal_terbit_hki_pkl'];
            $pengajuanPublikasi->manual_book_hki_pkl = $filePaths['manualBookHkiPkl'];
            $pengajuanPublikasi->sertifikat_hki_pkl = $filePaths['sertifikatHkiPkl'];
            $pengajuanPublikasi->form_pendaftaran_hki_pkl = $filePaths['formPendaftaranHKIPkl'];
            $pengajuanPublikasi->laporan_tugas_akhir = $filePaths['laporanTugasAkhir'];
            $pengajuanPublikasi->berita_acara_ujian_ta = $filePaths['beritaAcaraUjianTA'];
            $pengajuanPublikasi->lembar_pengesahan_ta = $filePaths['lembarPengesahanTA'];
            $pengajuanPublikasi->file_program_ta = $filePaths['fileProgramTA'];
            $pengajuanPublikasi->judul_jurnal_ta = $validatedData['judul_jurnal_ta'];
            $pengajuanPublikasi->upload_draft_jurnal_ta = $filePaths['uploadDraftJurnalTA'];
            $pengajuanPublikasi->file_turnitin_draft_jurnal_ta = $filePaths['fileTurnitinDraftJurnalTA'];
            $pengajuanPublikasi->loa_publikasi_makalah_ta = $filePaths['loaPublikasiMakalahTA'];
            $pengajuanPublikasi->judul_manual_book_ta = $validatedData['judul_manual_book_ta'];
            $pengajuanPublikasi->upload_file_manual_book_ta = $filePaths['uploadFileManualBookTA'];
            $pengajuanPublikasi->upload_file_pendaftaran_hki_ta = $filePaths['uploadFilePendaftaranHKITA'];
            $pengajuanPublikasi->status = 'diajukan';
            $pengajuanPublikasi->komentar = null;
            $pengajuanPublikasi->save();

            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan!']);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan data.'], 500);
        }
    }
}
