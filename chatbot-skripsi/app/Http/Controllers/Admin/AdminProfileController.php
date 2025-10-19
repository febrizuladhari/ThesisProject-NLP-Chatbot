<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Personal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Rules\MinimumAge;
use App\Rules\IndonesianPhoneNumber;

class AdminProfileController extends Controller
{
    public function edit()
    {
        $admin = Auth::user();
        // dd($admin);
        return view('admin.edit', compact('admin'));
    }

    public function updateAccount(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|max:255',
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
        ]);

        Auth::user()->update($request->all());

        return redirect()->route('admin.profile.edit')->with('success', 'Profil berhasil diupdate!');
    }

    public function updatePersonal(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => ['nullable', new IndonesianPhoneNumber],
            'birth_date' => ['nullable', 'date', 'before_or_equal:today', new MinimumAge(12)],
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'medical_history' => 'nullable|string',
        ], [
            'first_name.required' => 'Nama depan wajib diisi.',
            'last_name.required' => 'Nama belakang wajib diisi.',
            'birth_date.date' => 'Format tanggal lahir tidak valid.',
            'birth_date.before_or_equal' => 'Tanggal lahir tidak boleh lebih dari hari ini.',
            'gender.in' => 'Jenis kelamin yang dipilih tidak valid.',
        ]);

        Auth::user()->personal->update($request->all());

        return redirect()->route('admin.profile.edit')->with('success', 'Profil berhasil diupdate!');
    }

    public function changePassword()
    {
        return view('admin.edit');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $admin = Auth::user();

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $admin->update(['password' => Hash::make($request->password)]);

        return redirect()->route('admin.profile.edit')->with('success', 'Password berhasil diubah!');
    }
}
