<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_view_user_management(): void
    {
        $this->seed(DatabaseSeeder::class);
        $admin = User::where('email', 'admin@example.com')->firstOrFail();

        $this->actingAs($admin)
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('User Management');
    }

    public function test_viewer_cannot_view_user_management(): void
    {
        $this->seed(DatabaseSeeder::class);
        $viewer = User::factory()->create();
        $viewer->assignRole(Role::where('name', 'Viewer')->firstOrFail());

        $this->actingAs($viewer)
            ->get(route('admin.users.index'))
            ->assertForbidden();
    }

    public function test_super_admin_can_view_role_permission_matrix(): void
    {
        $this->seed(DatabaseSeeder::class);
        $admin = User::where('email', 'admin@example.com')->firstOrFail();

        $this->actingAs($admin)
            ->get(route('admin.roles.index'))
            ->assertOk()
            ->assertSee('Roles & Permissions', false);
    }
}
