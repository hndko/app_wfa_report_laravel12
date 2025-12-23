<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display listing of users with filters
     * NOTE: Superadmin only, with search and filter capabilities
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'user');

        // FILTER: Search by name, email, NIP
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        // FILTER: By department
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        // FILTER: By status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active' ? 1 : 0);
        }

        // Get distinct departments for filter dropdown
        $departments = User::where('role', 'user')
            ->distinct()
            ->pluck('department')
            ->filter()
            ->sort()
            ->values();

        $data = [
            'page_title' => 'Manajemen User',
            'users' => $query->latest()->paginate(15)->withQueryString(),
            'departments' => $departments,
            'filters' => $request->only(['search', 'department', 'status']),
        ];

        return view('backend.users.index', $data);
    }

    /**
     * Show create user form
     * NOTE: Superadmin only
     */
    public function create()
    {
        $data = [
            'page_title' => 'Tambah User Baru',
        ];

        return view('backend.users.create', $data);
    }

    /**
     * Store new user
     * NOTE: Superadmin only, creates user with hashed password
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nip' => 'required|string|max:50|unique:users,nip',
            'position' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'user';
        $validated['is_active'] = true;

        User::create($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Display user details
     * NOTE: Superadmin only, with report statistics
     */
    public function show($id)
    {
        $user = User::where('id', $id)
            ->where('role', 'user')
            ->withCount([
                'reports',
                'reports as draft_count' => function ($q) {
                    $q->where('status', 'draft');
                },
                'reports as submitted_count' => function ($q) {
                    $q->where('status', 'submitted');
                },
                'reports as approved_count' => function ($q) {
                    $q->where('status', 'approved');
                },
                'reports as rejected_count' => function ($q) {
                    $q->where('status', 'rejected');
                },
            ])
            ->firstOrFail();

        $data = [
            'page_title' => 'Detail User',
            'user' => $user,
            'recent_reports' => $user->reports()->latest()->limit(5)->get(),
        ];

        return view('backend.users.show', $data);
    }

    /**
     * Show edit user form
     * NOTE: Superadmin only
     */
    public function edit($id)
    {
        $user = User::where('id', $id)
            ->where('role', 'user')
            ->firstOrFail();

        $data = [
            'page_title' => 'Edit User',
            'user' => $user,
        ];

        return view('backend.users.edit', $data);
    }

    /**
     * Update user data
     * NOTE: Superadmin only, password optional
     */
    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)
            ->where('role', 'user')
            ->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'nip' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'position' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil diupdate!');
    }

    /**
     * Delete user
     * NOTE: Superadmin only, soft delete with cascading
     */
    public function destroy($id)
    {
        $user = User::where('id', $id)
            ->where('role', 'user')
            ->firstOrFail();

        // Delete user (cascade will delete reports)
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil dihapus!');
    }

    /**
     * Toggle user active status
     * NOTE: Superadmin only, activate/deactivate
     */
    public function toggleStatus($id)
    {
        $user = User::where('id', $id)
            ->where('role', 'user')
            ->firstOrFail();

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()
            ->route('users.index')
            ->with('success', "User berhasil {$status}!");
    }
}
