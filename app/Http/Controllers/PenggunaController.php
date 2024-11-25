<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Str;
use Illuminate\Support\Facades\Storage;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // t

    public function index()
    {
        $users = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select([
                'users.id',
                'users.username',
                'users.fullname',
                'users.account_status',
                'users.last_login',
                'users.created_at',
                'users.is_deleted',
                'roles.name as role'
            ])
            ->orderBy('users.created_at', 'asc')
            ->get();

        $userRole = Auth::user()->roles->pluck('name')->toArray();

        return view('pages.admin.pengguna.index', compact('users', 'userRole'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:manajer,akuntan,staff',
            'account_status' => 'nullable|string|in:active,inactive',
        ]);


        DB::transaction(function () use ($request) {

            $user = User::create([
                'fullname' => $request->fullname,
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'account_status' => $request->account_status ?? 'active',
                'is_login' => null,
                'created_at' => now(),
                'is_delete' => 0,
            ]);

            DB::table('model_has_roles')->insert([
                'role_id' => DB::table('roles')->where('name', $request->role)->value('id'),
                'model_type' => User::class,
                'model_id' => $user->id,
            ]);
        });

        return redirect()->route('manajemen-pengguna.index')->with('success', 'penggua berhasil ditambah');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|string|in:manajer,akuntan,staff',
            'account_status' => 'nullable|string|in:active,inactive',
        ]);

        DB::transaction(function () use ($request, $id) {
            $user = User::findOrFail($id);


            $user->update([
                'fullname' => $request->fullname,
                'username' => $request->username,
                'password' => $request->password ? bcrypt($request->password) : $user->password,
                'account_status' => $request->account_status ?? $user->account_status,
            ]);


            $roleId = DB::table('roles')->where('name', $request->role)->value('id');
            DB::table('model_has_roles')
                ->where('model_type', User::class)
                ->where('model_id', $user->id)
                ->update(['role_id' => $roleId]);
        });

        return redirect()->route('manajemen-pengguna.index')->with('success', 'Pengguna berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::where('id', $id)->update([
            'is_deleted' => true,
            'account_status' => 'inactive'
        ]);

        return redirect()->route('manajemen-pengguna.index')->with('success', 'Data pengguna berhasil dinonaktifkan.');
    }

    public function restore(string $id)
    {
        User::where('id', $id)->update([
            'is_deleted' => false,
            'account_status' => 'active'
        ]);

        return redirect()->route('manajemen-pengguna.index')->with('success', 'Data pengguna berhasil diaktifkan.');
    }

    public function getUserProfile()
    {

        $userId = Auth::id();
        $user = DB::table('users')
            ->select('id', 'username', 'fullname', 'profile_picture')
            ->where('id', $userId)
            ->first();

        return view('pages.user-profile', ['user' => $user]);
    }

    public function getUserProfileHeader()
    {
        $user = auth()->user();

        $userId = Auth::id();
        $user = DB::table('users')
            ->select('id', 'profile_picture')
            ->where('id', $userId)
            ->first();

        return view('components.header', ['user' => $user]);
    }

    public function putUserProfile(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'fullname' => 'required|string|max:255',
            'password' => 'nullable|string|min:8',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Ambil user yang sedang login
        $user = Auth::user();

        // Update username dan fullname
        $user->username = $validatedData['username'];
        $user->fullname = $validatedData['fullname'];

        // Update password jika ada
        if (!empty($validatedData['password'])) {
            $user->password = bcrypt($validatedData['password']);
        }

        // Proses upload foto profil
        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            
            $fileName = time() . str($request->nama)->slug();

            $path = $image->storeAs('photos/profile_picture', $fileName, 'public');

            $user->profile_picture = Storage::url($path);
        }

        // Simpan perubahan user
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }


}
