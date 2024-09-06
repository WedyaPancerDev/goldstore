<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedController extends Controller
{
    public function index()
    {
        return view('pages.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = User::where('username', $credentials['username'])->first();

            if ($user && $user->is_deleted) {
                Auth::logout();

                return back()->with('error', 'Akun anda telah dihapus oleh admin. Silahkan hubungi admin untuk informasi lebih lanjut.');
            }

            $user = auth()->user();
            $request->session()->regenerate();

            switch ($user) {
                case $user->hasRole('admin'):
                    return redirect()->route('admin.root')->with('success', 'Login berhasil.');
                    break;
                case $user->hasRole('manajer'):
                    return redirect()->route('manajer.root')->with('success', 'Login berhasil.');
                    break;
                case $user->hasRole('akuntan'):
                    return redirect()->route('akuntan.root')->with('success', 'Login berhasil.');
                    break;
                case $user->hasRole('staff'):
                    return redirect()->route('staff.root')->with('success', 'Login berhasil.');
                    break;
                default:
                    return abort(403);
                    break;
            }
        }
    }
}
