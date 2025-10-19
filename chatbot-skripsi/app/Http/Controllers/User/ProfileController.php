<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Personal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Helpers\LogHelper;
use App\Rules\MinimumAge;
use App\Rules\IndonesianPhoneNumber;

class ProfileController extends Controller
{
    public function showCompleteForm()
    {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        elseif (Auth::user()->is_profile_completed) {
            return redirect()->route('dashboard');
        }

        return view('user.complete-profile');
    }

    public function complete(Request $request)
    {
        if (Auth::user()->isAdmin()) {
            abort(403, 'Admin tidak perlu melengkapi profile.');
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => ['nullable, new IndonesianPhoneNumber'],
            'birth_date' => ['nullable', 'date', 'before_or_equal:today', new MinimumAge(12)],
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'medical_history' => 'nullable|string',
        ], [
            'first_name.required' => 'Nama depan wajib diisi.',
            'first_name.max' => 'Nama depan maksimal 255 karakter.',
            'last_name.required' => 'Nama belakang wajib diisi.',
            'last_name.max' => 'Nama belakang maksimal 255 karakter.',
            'birth_date.date' => 'Format tanggal lahir tidak valid.',
            'birth_date.before_or_equal' => 'Tanggal lahir tidak boleh lebih dari hari ini.',
            'gender.in' => 'Jenis kelamin yang dipilih tidak valid.',
            'address.max' => 'Alamat maksimal 500 karakter.',
            'medical_history.max' => 'Riwayat medis maksimal 1000 karakter.',
        ]);

        Personal::create([
            'user_id' => Auth::id(),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'address' => $request->address,
            'medical_history' => $request->medical_history,
        ]);

        Auth::user()->update(['is_profile_completed' => true]);

        return redirect()->route('dashboard')->with('success', 'Profil berhasil dilengkapi!');
    }

    public function edit()
    {
        $personal = Auth::user()->personal;
        return view('user.edit-profile', compact('personal'));
    }

    public function update(Request $request)
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
            'first_name.max' => 'Nama depan maksimal 255 karakter.',
            'last_name.required' => 'Nama belakang wajib diisi.',
            'last_name.max' => 'Nama belakang maksimal 255 karakter.',
            'birth_date.date' => 'Format tanggal lahir tidak valid.',
            'birth_date.before_or_equal' => 'Tanggal lahir tidak boleh lebih dari hari ini.',
            'gender.in' => 'Jenis kelamin yang dipilih tidak valid.',
            'address.max' => 'Alamat maksimal 500 karakter.',
            'medical_history.max' => 'Riwayat medis maksimal 1000 karakter.',
        ]);

        Auth::user()->personal->update($request->all());

        LogHelper::profileUpdateLog();

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diupdate!');
    }

    public function changePassword()
    {
        return view('user.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        LogHelper::passwordChangeLog();

        return redirect()->route('profile.edit')->with('success', 'Password berhasil diubah!');
    }
}
