<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = UserProfile::all();

        return view('profile', compact('profiles'));
    }
}
