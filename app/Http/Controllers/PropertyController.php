<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyRequest;
use App\Models\AuditLog;
use App\Models\CertificateStatus;
use App\Models\City;
use App\Models\Document;
use App\Models\District;
use App\Models\LandRightType;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\PropertyUtilizationStatus;
use App\Models\Province;
use App\Models\Village;
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

        $additionalCertificateIds = $property->additionalCertificates->pluck('id');
        $relatedDocuments = Document::with(['category', 'uploader'])
            ->where('property_id', $property->id)
            ->when($property->certificate, fn ($query) => $query->orWhere('certificate_id', $property->certificate->id))
            ->when($additionalCertificateIds->isNotEmpty(), fn ($query) => $query->orWhereIn('additional_certificate_id', $additionalCertificateIds))
            ->latest()
            ->get();

        $auditLogs = AuditLog::with('user')
            ->where(function ($query) use ($property) {
                $query->where(fn ($q) => $q->where('table_name', 'properties')->where('record_id', $property->id));

                if ($property->certificate) {
                    $query->orWhere(fn ($q) => $q->where('table_name', 'certificates')->where('record_id', $property->certificate->id));
                }
            })
            ->latest('created_at')
            ->limit(20)
            ->get();

        return view('properties.show', compact('property', 'relatedDocuments', 'auditLogs'));
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
        $property = request()->route('property');
        $oldProvinceId = old('property.province_id', $property?->province_id);
        $oldCityId = old('property.city_id', $property?->city_id);
        $oldDistrictId = old('property.district_id', $property?->district_id);
        $selectedProvince = $oldProvinceId ? Province::find($oldProvinceId) : null;
        $selectedCity = $oldCityId ? City::find($oldCityId) : null;
        $selectedDistrict = $oldDistrictId ? District::find($oldDistrictId) : null;

        return [
            'propertyTypes' => PropertyType::where('is_active', true)->orderBy('name')->get(),
            'utilizationStatuses' => PropertyUtilizationStatus::where('is_active', true)->orderBy('name')->get(),
            'landRightTypes' => LandRightType::where('is_active', true)->orderBy('name')->get(),
            'certificateStatuses' => CertificateStatus::where('is_active', true)->orderBy('name')->get(),
            'provinces' => Province::orderBy('name')->get(),
            'cities' => $selectedProvince
                ? City::where('province_code', $selectedProvince->code)->orderBy('name')->get()
                : collect(),
            'districts' => $selectedCity
                ? District::where('city_code', $selectedCity->code)->orderBy('name')->get()
                : collect(),
            'villages' => $selectedDistrict
                ? Village::where('district_code', $selectedDistrict->code)->orderBy('name')->get()
                : collect(),
        ];
    }
}
