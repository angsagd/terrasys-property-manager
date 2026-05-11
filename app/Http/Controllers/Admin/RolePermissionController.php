<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AuditLogService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionController extends Controller
{
    public function index()
    {
        $this->authorize('view_role');

        return view('admin.roles.index', [
            'roles' => Role::with('permissions')->orderBy('name')->get(),
            'permissions' => Permission::orderBy('name')->get()->groupBy(fn ($permission) => str($permission->name)->after('_')->before('_')->value() ?: 'general'),
        ]);
    }

    public function edit(Role $role)
    {
        $this->authorize('update_role');

        return view('admin.roles.edit', [
            'role' => $role->load('permissions'),
            'permissions' => Permission::orderBy('name')->get()->groupBy(fn ($permission) => str($permission->name)->after('_')->before('_')->value() ?: 'general'),
        ]);
    }

    public function update(Request $request, Role $role, AuditLogService $auditLog)
    {
        $this->authorize('update_role');
        $data = $request->validate([
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,name'],
        ]);

        $oldValues = $role->load('permissions')->toArray();
        $role->syncPermissions($data['permissions'] ?? []);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $auditLog->record('Role & Permission', $role, 'update', $oldValues, $role->fresh('permissions')->toArray());

        return redirect()->route('admin.roles.index')->with('success', 'Permission role berhasil diperbarui.');
    }
}
