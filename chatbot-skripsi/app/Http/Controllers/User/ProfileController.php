<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Personal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'medical_history' => 'nullable|string',
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
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'medical_history' => 'nullable|string',
        ]);

        Auth::user()->personal->update($request->all());

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

        return redirect()->route('profile.edit')->with('success', 'Password berhasil diubah!');
    }
}
