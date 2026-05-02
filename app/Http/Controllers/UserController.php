<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $preferensi = $user->preferensi;
        $ulasanCount = $user->ulasans()->count();
        
        return view('user.dashboard', compact('user', 'preferensi', 'ulasanCount'));
    }
}
