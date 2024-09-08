<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Beranda;

class BerandaController extends Controller
{
    public function index()
    {
        $beranda = Beranda::all();
        return view('admin.beranda',['beranda'=>$beranda]);
    }
    public function edit($id)
    {
        $beranda = Beranda::all()
        ->where('id', $id)
        ->first(); 
        return view('admin.detail',['beranda'=>$beranda]);
    }
    public function store(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255',
                'body' => 'required|string',
                'file' => 'nullable|file|mimes:pdf',
                'status' => 'required|string',
            ]);

            $filePaths = [
                'file' => $request->file('file') ? $request->file('file')->store('documents', 'public') : null,
            ];
    
            $beranda = new Beranda();
            $beranda ->file = $filePaths['file'];
            $beranda ->title = $validatedData['title'];
            $beranda ->slug = null;
            $beranda ->body = $validatedData['body'];
            $beranda ->status = $validatedData['status'];
            $beranda ->save();

            return redirect()->route('admin.beranda')->with('success', 'Berhasil disimpan!');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return redirect()->route('admin.beranda')->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }
    public function update(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'id' => 'required|integer',
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255',
                'body' => 'required|string',
                'file' => 'nullable|file|mimes:pdf',
                'status' => 'required|string',
            ]);

            $beranda = Beranda::findOrFail($validatedData['id']);

            // Menghandle file jika ada
            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('documents', 'public');
                $beranda->file = $filePath;
            }

            $beranda ->title = $validatedData['title'];
            $beranda ->slug = null;
            $beranda ->body = $validatedData['body'];
            $beranda ->status = $validatedData['status'];
            $beranda ->save();

            return redirect()->route('admin.beranda.edit', ['id' => $beranda->id])->with('success', 'Berhasil diupdate!');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return redirect()->route('admin.beranda.edit', ['id' => $request->id])->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }
    public function destroy($id)
    {
        $beranda = Beranda::where('id', $id)->first();

        if ($beranda) {
            $beranda->delete();
            return redirect()->back()->with('success', 'Data mahasiswa berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }
    }
}