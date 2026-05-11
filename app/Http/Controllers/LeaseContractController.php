<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaseContractRequest;
use App\Models\LeaseContract;
use App\Models\LeaseStatus;
use App\Models\LeaseType;
use App\Models\Property;
use App\Services\AuditLogService;
use Illuminate\Http\Request;

class LeaseContractController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view_lease');

        $leaseContracts = LeaseContract::query()
            ->with(['property.city', 'leaseType', 'leaseStatus'])
            ->when($request->search, fn ($query, $search) => $query->where(fn ($q) => $q
                ->where('counterparty_name', 'like', "%{$search}%")
                ->orWhere('agreement_number', 'like', "%{$search}%")
                ->orWhereHas('property', fn ($property) => $property
                    ->where('property_code', 'like', "%{$search}%")
                    ->orWhere('property_name', 'like', "%{$search}%"))))
            ->when($request->lease_type_id, fn ($query, $value) => $query->where('lease_type_id', $value))
            ->when($request->lease_status_id, fn ($query, $value) => $query->where('lease_status_id', $value))
            ->when($request->start_date, fn ($query, $value) => $query->whereDate('start_date', '>=', $value))
            ->when($request->end_date, fn ($query, $value) => $query->whereDate('end_date', '<=', $value))
            ->latest('end_date')
            ->paginate(15)
            ->withQueryString();

        return view('lease-contracts.index', $this->formData() + compact('leaseContracts'));
    }

    public function create(Request $request)
    {
        $this->authorize('create_lease');

        return view('lease-contracts.create', $this->formData() + [
            'leaseContract' => null,
            'selectedPropertyId' => $request->integer('property_id') ?: null,
        ]);
    }

    public function store(LeaseContractRequest $request, AuditLogService $auditLog)
    {
        $data = $request->validated();
        $data['rental_value'] = $data['rental_value'] ?? 0;
        $data['created_by'] = $request->user()->id;

        $leaseContract = LeaseContract::create($data);
        $auditLog->record('Lease Contract', $leaseContract, 'create', null, $leaseContract->toArray());

        return redirect()->route('lease-contracts.show', $leaseContract)->with('success', 'Kontrak sewa berhasil ditambahkan.');
    }

    public function show(LeaseContract $leaseContract)
    {
        $this->authorize('view_lease');

        $leaseContract->load(['property.province', 'property.city', 'leaseType', 'leaseStatus', 'documents.category']);

        return view('lease-contracts.show', compact('leaseContract'));
    }

    public function edit(LeaseContract $leaseContract)
    {
        $this->authorize('update_lease');

        return view('lease-contracts.edit', $this->formData() + compact('leaseContract'));
    }

    public function update(LeaseContractRequest $request, LeaseContract $leaseContract, AuditLogService $auditLog)
    {
        $oldValues = $leaseContract->toArray();
        $data = $request->validated();
        $data['rental_value'] = $data['rental_value'] ?? 0;
        $data['updated_by'] = $request->user()->id;

        $leaseContract->update($data);
        $auditLog->record('Lease Contract', $leaseContract, 'update', $oldValues, $leaseContract->fresh()->toArray());

        return redirect()->route('lease-contracts.show', $leaseContract)->with('success', 'Kontrak sewa berhasil diperbarui.');
    }

    public function destroy(LeaseContract $leaseContract, AuditLogService $auditLog)
    {
        $this->authorize('delete_lease');

        $auditLog->record('Lease Contract', $leaseContract, 'delete', $leaseContract->toArray());
        $leaseContract->update(['deleted_by' => auth()->id()]);
        $leaseContract->delete();

        return redirect()->route('lease-contracts.index')->with('success', 'Kontrak sewa berhasil dihapus.');
    }

    private function formData(): array
    {
        return [
            'properties' => Property::orderBy('property_name')->get(),
            'leaseTypes' => LeaseType::where('is_active', true)->orderBy('name')->get(),
            'leaseStatuses' => LeaseStatus::where('is_active', true)->orderBy('name')->get(),
            'paymentPeriods' => [
                'monthly' => 'Bulanan',
                'quarterly' => 'Triwulanan',
                'semesterly' => 'Semesteran',
                'yearly' => 'Tahunan',
                'one_time' => 'Sekali Bayar',
            ],
        ];
    }
}
