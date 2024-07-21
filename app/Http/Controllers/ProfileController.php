<?php
// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::all();
        return view('profile.index', compact('profiles'));
    }

    public function create()
    {
        $users = User::all();
        return view('profile.store', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'profile_picture' => 'nullable|image',
            'bio' => 'nullable|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        Profile::create($request->all());

        return redirect()->route('profile.index')->with('success', 'Profile created successfully.');
    }

    public function edit(Profile $profile)
    {
        return view('profile.update', compact('profile'));
    }

    public function update(Request $request, Profile $profile)
    {
        $request->validate([
            'profile_picture' => 'nullable|image',
            'bio' => 'nullable|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $profile->update($request->all());

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }

    public function destroy(Profile $profile)
    {
        $profile->delete();

        return redirect()->route('profile.index')->with('success', 'Profile deleted successfully.');
    }
}
