<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        if (auth()->user()->role_id !== 1) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        $roles = Role::all();
        $users = User::with('role')
            ->where('id', '!=', auth()->id())
            ->latest()
            ->paginate(5);
        return view('master.user.index', compact('users','roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,umum,it',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return back()->with('success', 'User baru berhasil ditambahkan!');
    }

    public function edit($slug)
    {
        $user = User::where('name', $slug)->firstOrFail();

        return view('master.user.edit', compact('user'));
    }

    public function update(Request $request, $slug)
    {
        $user = User::where('name', $slug)->firstOrFail();
        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username,' . $user->id,
            'role' => 'required|in:admin,umum,it',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'min:6';
        }

        $request->validate($rules);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('master.user.index')->with('success', 'Data user berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus!');
    }
}
