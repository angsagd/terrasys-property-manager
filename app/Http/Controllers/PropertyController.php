<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyRequest;
use App\Models\CertificateStatus;
use App\Models\City;
use App\Models\LandRightType;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\PropertyUtilizationStatus;
use App\Models\Province;
use App\Services\AuditLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view_property');

        $properties = Property::query()
            ->with(['certificate.landRightType', 'certificate.certificateStatus', 'propertyType', 'utilizationStatus', 'province', 'city'])
            ->when($request->search, fn ($query, $search) => $query->where(fn ($q) => $q
                ->where('property_code', 'like', "%{$search}%")
                ->orWhere('property_name', 'like', "%{$search}%")))
            ->when($request->province_id, fn ($query, $value) => $query->where('province_id', $value))
            ->when($request->city_id, fn ($query, $value) => $query->where('city_id', $value))
            ->when($request->property_type_id, fn ($query, $value) => $query->where('property_type_id', $value))
            ->when($request->utilization_status_id, fn ($query, $value) => $query->where('utilization_status_id', $value))
            ->when($request->land_right_type_id, fn ($query, $value) => $query->whereHas('certificate', fn ($q) => $q->where('land_right_type_id', $value)))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('properties.index', [
            'properties' => $properties,
            'provinces' => Province::orderBy('name')->get(),
            'cities' => City::orderBy('name')->get(),
            'propertyTypes' => PropertyType::where('is_active', true)->orderBy('name')->get(),
            'utilizationStatuses' => PropertyUtilizationStatus::where('is_active', true)->orderBy('name')->get(),
            'landRightTypes' => LandRightType::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        $this->authorize('create_property');

        return view('properties.create', $this->formData());
    }

    public function store(PropertyRequest $request, AuditLogService $auditLog)
    {
        $property = DB::transaction(function () use ($request, $auditLog) {
            $propertyData = $request->validated('property');
            $certificateData = $request->validated('certificate');
            $propertyData['created_by'] = $request->user()->id;
            $certificateData['created_by'] = $request->user()->id;

            $property = Property::create($propertyData);
            $property->certificate()->create($certificateData);
            $auditLog->record('Property', $property, 'create', null, $property->load('certificate')->toArray());

            return $property;
        });

        return redirect()->route('properties.show', $property)->with('success', 'Property berhasil ditambahkan.');
    }

    public function show(Property $property)
    {
        $this->authorize('view_property');

        $property->load([
            'certificate.landRightType', 'certificate.certificateStatus', 'additionalCertificates.landRightType',
            'leaseContracts.leaseType', 'leaseContracts.leaseStatus', 'documents.category',
            'propertyType', 'utilizationStatus', 'province', 'city', 'district', 'village',
        ]);

        return view('properties.show', compact('property'));
    }

    public function edit(Property $property)
    {
        $this->authorize('update_property');

        $property->load('certificate');

        return view('properties.edit', $this->formData() + ['property' => $property]);
    }

    public function update(PropertyRequest $request, Property $property, AuditLogService $auditLog)
    {
        DB::transaction(function () use ($request, $property, $auditLog) {
            $oldValues = $property->load('certificate')->toArray();
            $propertyData = $request->validated('property');
            $certificateData = $request->validated('certificate');
            $propertyData['updated_by'] = $request->user()->id;
            $certificateData['updated_by'] = $request->user()->id;

            $property->update($propertyData);
            $property->certificate()->updateOrCreate(['property_id' => $property->id], $certificateData);
            $auditLog->record('Property', $property, 'update', $oldValues, $property->fresh('certificate')->toArray());
        });

        return redirect()->route('properties.show', $property)->with('success', 'Property berhasil diperbarui.');
    }

    public function destroy(Property $property, AuditLogService $auditLog)
    {
        $this->authorize('delete_property');

        $property->update(['deleted_by' => auth()->id()]);
        $auditLog->record('Property', $property, 'delete', $property->toArray());
        $property->delete();

        return redirect()->route('properties.index')->with('success', 'Property berhasil dihapus.');
    }

    private function formData(): array
    {
        return [
            'propertyTypes' => PropertyType::where('is_active', true)->orderBy('name')->get(),
            'utilizationStatuses' => PropertyUtilizationStatus::where('is_active', true)->orderBy('name')->get(),
            'landRightTypes' => LandRightType::where('is_active', true)->orderBy('name')->get(),
            'certificateStatuses' => CertificateStatus::where('is_active', true)->orderBy('name')->get(),
            'provinces' => Province::orderBy('name')->get(),
            'cities' => City::orderBy('name')->get(),
        ];
    }
}
