<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\LeaseContract;
use App\Models\LeaseStatus;
use App\Models\LeaseType;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\PropertyUtilizationStatus;
use App\Models\Province;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class LeaseContractManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_view_lease_management(): void
    {
        $this->seed(DatabaseSeeder::class);
        $admin = User::where('email', 'admin@example.com')->firstOrFail();

        $this->actingAs($admin)
            ->get(route('lease-contracts.index'))
            ->assertOk()
            ->assertSee('Lease Management');
    }

    public function test_viewer_cannot_create_lease_contract(): void
    {
        $this->seed(DatabaseSeeder::class);
        $viewer = User::factory()->create();
        $viewer->assignRole(Role::where('name', 'Viewer')->firstOrFail());

        $this->actingAs($viewer)
            ->get(route('lease-contracts.create'))
            ->assertForbidden();
    }

    public function test_super_admin_can_create_and_update_lease_contract(): void
    {
        $this->seed(DatabaseSeeder::class);
        $admin = User::where('email', 'admin@example.com')->firstOrFail();
        $property = $this->createProperty($admin);
        $leaseType = LeaseType::firstOrFail();
        $leaseStatus = LeaseStatus::where('name', 'Aktif')->firstOrFail();

        $response = $this->actingAs($admin)->post(route('lease-contracts.store'), [
            'property_id' => $property->id,
            'lease_type_id' => $leaseType->id,
            'lease_status_id' => $leaseStatus->id,
            'counterparty_name' => 'PT Penyewa Contoh',
            'agreement_number' => 'LEASE-001',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'rental_value' => 120000000,
            'payment_period' => 'yearly',
            'payment_status' => 'Paid',
        ]);

        $leaseContract = LeaseContract::where('agreement_number', 'LEASE-001')->firstOrFail();
        $response->assertRedirect(route('lease-contracts.show', $leaseContract));
        $this->assertDatabaseHas('lease_contracts', [
            'id' => $leaseContract->id,
            'counterparty_name' => 'PT Penyewa Contoh',
            'created_by' => $admin->id,
        ]);

        $this->actingAs($admin)->put(route('lease-contracts.update', $leaseContract), [
            'property_id' => $property->id,
            'lease_type_id' => $leaseType->id,
            'lease_status_id' => $leaseStatus->id,
            'counterparty_name' => 'PT Penyewa Update',
            'agreement_number' => 'LEASE-001',
            'start_date' => '2026-01-01',
            'end_date' => '2027-12-31',
            'rental_value' => 150000000,
            'payment_period' => 'yearly',
            'payment_status' => 'Paid',
        ])->assertRedirect(route('lease-contracts.show', $leaseContract));

        $this->assertDatabaseHas('lease_contracts', [
            'id' => $leaseContract->id,
            'counterparty_name' => 'PT Penyewa Update',
            'updated_by' => $admin->id,
        ]);
    }

    private function createProperty(User $user): Property
    {
        return Property::create([
            'property_code' => 'PROP-LEASE-001',
            'property_name' => 'Property Lease Test',
            'property_type_id' => PropertyType::firstOrFail()->id,
            'utilization_status_id' => PropertyUtilizationStatus::firstOrFail()->id,
            'province_id' => Province::firstOrFail()->id,
            'city_id' => City::firstOrFail()->id,
            'area_unit' => 'm2',
            'created_by' => $user->id,
        ]);
    }
}
