<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    /**
     * Menampilkan daftar semua role.
     */
    public function index()
    {
        if (auth()->user()->role_id !== 1) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        $roles = Role::orderBy('id', 'asc')->latest()->paginate(5);
        return view('role.index', compact('roles'));
    }

    /**
     * Menyimpan role baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'nama_role' => 'required|string|max:255|unique:roles,nama_role',
            ],
            [
                'nama_role.unique' => 'Nama role ini sudah ada!',
            ],
        );

        Role::create([
            'nama_role' => $request->nama_role,
            'slug' => Str::slug($request->nama_role), // Otomatis: "IT Support" -> "it-support"
        ]);

        return redirect()->route('role.index')->with('success', 'Role baru berhasil ditambahkan.');
    }

    public function edit($slug)
    {
        if (auth()->user()->role_id !== 1) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        $role = Role::where('slug', $slug)->firstOrFail();
        // Admin tidak boleh diedit
        if ($role->slug === 'admin') {
            return redirect()->route('role.index')->with('error', 'Role Administrator tidak dapat diubah.');
        }
        return view('role.edit', compact('role'));
    }
    public function update(Request $request, $slug)
    {
        $role = Role::where('slug', $slug)->firstOrFail();
        // Proteksi: Role 'admin' tidak boleh diubah slug-nya via aplikasi
        if ($role->slug === 'admin') {
            return back()->with('error', 'Role sistem tidak dapat diubah.');
        }

        $request->validate([
            'nama_role' => 'required|string|max:255|unique:roles,nama_role,' . $role->id,
        ]);

        $role->update([
            'nama_role' => $request->nama_role,
            'slug' => Str::slug($request->nama_role),
        ]);

        return redirect()->route('role.index')->with('success', 'Data role berhasil diperbarui.');
    }

    /**
     * Menghapus role dari database.
     */
    public function destroy($slug)
    {
        $role = Role::where('slug', $slug)->firstOrFail();
        // Proteksi: Jangan hapus role admin atau role yang masih punya user
        if ($role->slug === 'admin') {
            return back()->with('error', 'Role sistem dilindungi dan tidak bisa dihapus.');
        }

        if ($role->users()->count() > 0) {
            return back()->with('error', 'Role tidak bisa dihapus karena masih digunakan oleh beberapa user.');
        }

        $role->delete();

        return redirect()->route('master.role.index')->with('success', 'Role berhasil dihapus.');
    }
}
