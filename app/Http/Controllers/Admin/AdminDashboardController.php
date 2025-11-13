<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminDashboardController extends Controller
{
    public function index() {
        $user = Auth::user();

        $recoveryCodes = null;
        if (!$user->two_factor_secret) {
            session()->flash('show2faPrompt', true);
        }

        return view('admin.dashboard', compact('user','recoveryCodes'));
    }

    public function enable2FA(Request $request) {
        $user = Auth::user();

        $secret = encrypt(Str::random(32));
        $user->two_factor_secret = $secret;

        $codes = [];
        for($i=0;$i<8;$i++) $codes[] = Str::upper(Str::random(10));
        $user->two_factor_recovery_codes = encrypt(json_encode($codes));
        $user->save();

        return redirect()->route('admin.dashboard')->with('success','2FA diaktifkan. Simpan recovery code dengan aman.');
    }
}
