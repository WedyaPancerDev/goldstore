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

        $request->validate(
            [
                'username' => 'required|string|min:5',
                'password' => 'required',
            ],
            [
                'username.required' => 'Username harus diisi.',
                'username.username' => 'Username tidak valid.',
                'password.required' => 'Password harus diisi.',
            ]
        );
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $findUser = User::where('username', $credentials['username'])->first();

            $findUser->update([
                'last_login' => now(),
            ]);

            if ($findUser && $findUser->is_deleted) {
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
        return back()->with('error', 'Email atau password salah.');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'status' => 'success',
        ]);
    }
}
