<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('customer.profile', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'email'   => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name'    => $request->name,
            'phone'   => $request->phone,
            'address' => $request->address,
            'email'   => $request->email,
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'current_password' => 'required',
                'password'         => 'required|min:6|confirmed',
            ]);

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
            }

            $user->update(['password' => Hash::make($request->password)]);
        }

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
