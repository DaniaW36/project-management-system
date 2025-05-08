<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
{
    $user = Auth::user(); // hardcoded user ID
    return view('profile.edit', compact('user'));
}

public function update(Request $request)
{
    $user = Auth::user();  // hardcoded user ID

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'department' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:20',
        'profile_pic' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('profile_pic')) {
        $path = $request->file('profile_pic')->store('profile_pics', 'public');
        $user->profile_pic = $path;
    }

    $user->update($request->except('profile_pic'));

    return back()->with('success', 'Profile updated successfully!');
}
}
