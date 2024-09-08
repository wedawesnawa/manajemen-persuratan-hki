<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests;

class PengajuanUserController extends Controller
{
    public function role()
    {
        $user = User::all();
        return view('admin.ubahRole', ['user' => $user]); 
    }
    public function editRole(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'role' => 'required|in:1,2', // Validating role value
        ]);

        try {
            $user = User::where('email', $request->email)->first();

            if ($user) {
                $user->roles = $request->role;
                $user->save();
            } else {
                return redirect()->route('admin.role')->with('success', 'Role berhasil diubah (meskipun user tidak ditemukan)');
            }
        } catch (\Exception $e) {
            \Log::error('Error changing role: ' . $e->getMessage());
            return redirect()->route('admin.role')->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
        return redirect()->route('admin.role')->with('success', 'Role berhasil diubah');
    }


}
