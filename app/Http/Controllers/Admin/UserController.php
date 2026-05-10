<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuditLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view_user');

        $users = User::query()
            ->with('roles')
            ->when($request->search, fn ($query, $search) => $query->where(fn ($q) => $q
                ->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")))
            ->when($request->role, fn ($query, $role) => $query->role($role))
            ->when($request->filled('is_active'), fn ($query) => $query->where('is_active', $request->boolean('is_active')))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        $this->authorize('create_user');

        return view('admin.users.form', [
            'user' => null,
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request, AuditLogService $auditLog)
    {
        $this->authorize('create_user');
        $data = $this->validatedData($request);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_active' => $request->boolean('is_active'),
        ]);
        $user->syncRoles($data['roles'] ?? []);

        $auditLog->record('User Management', $user, 'create', null, $user->load('roles')->toArray());

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $this->authorize('update_user');

        return view('admin.users.form', [
            'user' => $user->load('roles'),
            'roles' => Role::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, User $user, AuditLogService $auditLog)
    {
        $this->authorize('update_user');
        $data = $this->validatedData($request, $user);
        $oldValues = $user->load('roles')->toArray();

        $payload = [
            'name' => $data['name'],
            'email' => $data['email'],
            'is_active' => $request->user()->is($user) ? true : $request->boolean('is_active'),
        ];

        if (! empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
        }

        $user->update($payload);
        $user->syncRoles($data['roles'] ?? []);
        $auditLog->record('User Management', $user, 'update', $oldValues, $user->fresh('roles')->toArray());

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user, AuditLogService $auditLog)
    {
        $this->authorize('delete_user');
        abort_if(auth()->user()->is($user), 422, 'Anda tidak dapat menghapus akun sendiri.');

        $auditLog->record('User Management', $user, 'delete', $user->load('roles')->toArray());
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    public function toggleStatus(User $user, AuditLogService $auditLog)
    {
        $this->authorize('update_user');
        abort_if(auth()->user()->is($user), 422, 'Anda tidak dapat menonaktifkan akun sendiri.');

        $oldValues = $user->toArray();
        $user->update(['is_active' => ! $user->is_active]);
        $auditLog->record('User Management', $user, 'update', $oldValues, $user->fresh()->toArray());

        return back()->with('success', 'Status user berhasil diperbarui.');
    }

    private function validatedData(Request $request, ?User $user = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user?->id)],
            'password' => [$user ? 'nullable' : 'required', 'confirmed', Password::defaults()],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['required', 'exists:roles,name'],
            'is_active' => ['sometimes', 'boolean'],
        ]);
    }
}
