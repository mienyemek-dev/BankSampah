<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfilController extends Controller
{
    /**
     * Tampilkan halaman profil pengguna & ganti kata sandi
     */
    public function show()
    {
        $user = Auth::user();
        return view('nasabah.profil', compact('user'));
    }

    /**
     * Perbarui data profil (nama, no_hp, alamat lengkap)
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat_lengkap' => ['nullable', 'string', 'max:500'],
            'rt' => ['nullable', 'string', 'max:5'],
            'rw' => ['nullable', 'string', 'max:5'],
            'desa' => ['nullable', 'string', 'max:100'],
            'kecamatan' => ['nullable', 'string', 'max:100'],
            'nama_bank' => ['nullable', 'string', 'max:50'],
            'nomor_rekening' => ['nullable', 'string', 'max:50'],
            'atas_nama_rekening' => ['nullable', 'string', 'max:100'],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
        ]);

        $user->update($validated);

        return back()->with('success', 'Data profil Anda berhasil diperbarui!');
    }

    /**
     * Perbarui kata sandi akun
     */
    public function ubahPassword(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'password_saat_ini' => ['required', 'string'],
            'password_baru' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password_saat_ini.required' => 'Kata sandi saat ini wajib diisi.',
            'password_baru.required' => 'Kata sandi baru wajib diisi.',
            'password_baru.min' => 'Kata sandi baru minimal 8 karakter.',
            'password_baru.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        if (!Hash::check($validated['password_saat_ini'], $user->password)) {
            return back()->withErrors(['password_saat_ini' => 'Kata sandi saat ini tidak sesuai.'])->withInput();
        }

        $user->update([
            'password' => Hash::make($validated['password_baru']),
        ]);

        return back()->with('success_password', 'Kata sandi berhasil diperbarui! Silakan gunakan kata sandi baru Anda.');
    }
}

