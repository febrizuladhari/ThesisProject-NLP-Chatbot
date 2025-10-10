<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Personal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        ]);

        Auth::user()->update($request->all());

        return redirect()->route('admin.profile.edit')->with('success', 'Profil berhasil diupdate!');
    }

    public function updatePersonal(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'medical_history' => 'nullable|string',
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
        ]);

        $admin = Auth::user();

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $admin->update(['password' => Hash::make($request->password)]);

        return redirect()->route('admin.profile.edit')->with('success', 'Password berhasil diubah!');
    }
}
