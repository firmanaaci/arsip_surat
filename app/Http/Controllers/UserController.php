<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function redirectAfterLogin()
    {
        ActivityLogger::log('LOGIN', 'Pengguna masuk ke sistem');
        return redirect()->route('dashboard');
    }

    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $roleFilter = $request->query('role');

        $query = User::withCount('activityLogs')->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($roleFilter && in_array($roleFilter, ['admin', 'pimpinan', 'staf'])) {
            $query->where('role', $roleFilter);
        }

        $users = $query->paginate(10)->withQueryString();

        $stats = [
            'total'    => User::count(),
            'admin'    => User::where('role', 'admin')->count(),
            'pimpinan' => User::where('role', 'pimpinan')->count(),
            'staf'     => User::where('role', 'staf')->count(),
        ];

        return view('pengguna.index', compact('users', 'stats', 'search', 'roleFilter'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:admin,pimpinan,staf',
        ], [
            'email.unique' => 'Email ini sudah terdaftar oleh pengguna lain.',
            'password.min' => 'Password minimal 6 karakter.',
            'role.in'      => 'Pilihan peran tidak valid.',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        ActivityLogger::log('CREATE', "Menambahkan pengguna baru: {$user->name} ({$user->role_label})", $user);

        return redirect()->route('pengguna.index')->with('success', "Pengguna '{$user->name}' berhasil ditambahkan.");
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
            'role'     => 'required|in:admin,pimpinan,staf',
        ], [
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $user->name  = $validated['name'];
        $user->email = $validated['email'];
        $user->role  = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        ActivityLogger::log('UPDATE', "Memperbarui data pengguna: {$user->name} ({$user->role_label})", $user);

        return redirect()->route('pengguna.index')->with('success', "Data pengguna '{$user->name}' berhasil diperbarui.");
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return redirect()->route('pengguna.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        $userName = $user->name;
        $userRole = $user->role_label;

        $user->delete();

        ActivityLogger::log('DELETE', "Menghapus akun pengguna: {$userName} ({$userRole})");

        return redirect()->route('pengguna.index')->with('success', "Pengguna '{$userName}' berhasil dihapus.");
    }
}
