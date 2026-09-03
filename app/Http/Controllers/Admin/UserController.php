<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.user', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:50',
            'email' => 'required|string|email|max:50|unique:tb_user,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,petugas,owner',
            'status_aktif' => 'required|boolean',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status_aktif' => $request->status_aktif,
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:50',
            'email' => 'required|string|email|max:50|unique:tb_user,email,'.$id.',id_user',
            'role' => 'required|in:admin,petugas,owner',
            'status_aktif' => 'required|boolean',
        ]);

        $user = User::findOrFail($id);
        
        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'role' => $request->role,
            'status_aktif' => $request->status_aktif,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus.');
    }
}
