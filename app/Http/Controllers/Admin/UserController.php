<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $perPage = in_array($request->per_page, [10, 25, 50]) ? $request->per_page : 10;
        $users   = $query->latest()->paginate($perPage)->withQueryString();

        return view('admin.users.index', compact('users', 'perPage'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate(['role' => 'required|in:admin,user']);

        // Cegah admin mengubah role dirinya sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Kamu tidak bisa mengubah role diri sendiri.');
        }

        $user->update(['role' => $request->role]);
        ActivityLog::record('update_role', "Role user {$user->email} diubah menjadi {$request->role}");

        return back()->with('success', "Role {$user->name} berhasil diubah.");
    }

    public function toggleStatus(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Kamu tidak bisa menonaktifkan diri sendiri.');
        }

        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        ActivityLog::record('toggle_status', "User {$user->email} {$status}");

        return back()->with('success', "User {$user->name} berhasil {$status}.");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Kamu tidak bisa menghapus diri sendiri.');
        }

        $email = $user->email;
        $user->delete();
        ActivityLog::record('delete_user', "User {$email} dihapus");

        return back()->with('success', "User {$email} berhasil dihapus.");
    }
}
