<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('role:staff');
    }

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

        return view('pages.admin.pengguna.index', compact('users'));
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
}
