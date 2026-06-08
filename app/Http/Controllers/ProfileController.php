<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB; 

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function updateName(Request $request)
    {
        $adminId = Auth::id();

        $request->validate([
            'nama_admin' => 'required|string|max:255',
        ]);

        $adminLama = DB::table('tb_admin')->where('id_admin', $adminId)->first();

        if ($adminLama->nama_admin === $request->nama_admin) {
            return redirect()->route('profile.index')->with('info', 'Tidak ada perubahan identitas yang dilakukan.');
        }

        DB::table('tb_admin')
            ->where('id_admin', $adminId)
            ->update([
                'nama_admin' => $request->nama_admin,
                'updated_at' => now()
            ]);

        return redirect()->route('profile.index')->with('success', 'Nama akun berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ], [
            'new_password.min' => 'Password baru minimal harus 6 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.'
        ]);

        $admin = Auth::user();

        if (!Hash::check($request->current_password, $admin->password)) {
            return redirect()->route('profile.index')->withErrors(['current_password' => 'Password lama yang Anda masukkan salah.']);
        }

        DB::table('tb_admin')
            ->where('id_admin', $admin->id_admin)
            ->update([
                'password' => Hash::make($request->new_password),
                'updated_at' => now()
            ]);

        return redirect()->route('profile.index')->with('success', 'Password akun Anda berhasil diganti!');
    }

    public function destroy(Request $request)
    {
        $adminId = Auth::id();

        $jumlahAdmin = DB::table('tb_admin')->count();
        if ($jumlahAdmin <= 1) {
            return redirect()->route('profile.index')->with('error', 'Akun tidak bisa dihapus! Harus ada minimal satu Admin tersisa di sistem.');
        }

        DB::table('tb_admin')->where('id_admin', $adminId)->delete();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Akun admin berhasil dihapus secara permanen.');
    }
}