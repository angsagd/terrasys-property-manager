<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdditionalCertificateRequest;
use App\Models\AdditionalCertificate;
use App\Models\LandRightType;
use App\Models\Property;
use App\Services\AuditLogService;

class AdditionalCertificateController extends Controller
{
    public function index()
    {
        $this->authorize('view_additional_certificate');

        return view('additional-certificates.index', [
            'additionalCertificates' => AdditionalCertificate::with(['property', 'landRightType'])->latest()->paginate(15),
        ]);
    }

    public function create()
    {
        $this->authorize('create_additional_certificate');

        return view('additional-certificates.create', $this->formData());
    }

    public function store(AdditionalCertificateRequest $request, AuditLogService $auditLog)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $additionalCertificate = AdditionalCertificate::create($data);
        $auditLog->record('Additional Certificate', $additionalCertificate, 'create', null, $additionalCertificate->toArray());

        return redirect()->route('additional-certificates.index')->with('success', 'Sertifikat tambahan berhasil ditambahkan.');
    }

    public function edit(AdditionalCertificate $additionalCertificate)
    {
        $this->authorize('update_additional_certificate');

        return view('additional-certificates.edit', $this->formData() + compact('additionalCertificate'));
    }

    public function update(AdditionalCertificateRequest $request, AdditionalCertificate $additionalCertificate, AuditLogService $auditLog)
    {
        $oldValues = $additionalCertificate->toArray();
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;
        $additionalCertificate->update($data);
        $auditLog->record('Additional Certificate', $additionalCertificate, 'update', $oldValues, $additionalCertificate->fresh()->toArray());

        return redirect()->route('additional-certificates.index')->with('success', 'Sertifikat tambahan berhasil diperbarui.');
    }

    public function destroy(AdditionalCertificate $additionalCertificate, AuditLogService $auditLog)
    {
        $this->authorize('delete_additional_certificate');

        $additionalCertificate->update(['deleted_by' => auth()->id()]);
        $auditLog->record('Additional Certificate', $additionalCertificate, 'delete', $additionalCertificate->toArray());
        $additionalCertificate->delete();

        return redirect()->route('additional-certificates.index')->with('success', 'Sertifikat tambahan berhasil dihapus.');
    }

    private function formData(): array
    {
        return [
            'properties' => Property::orderBy('property_name')->get(),
            'landRightTypes' => LandRightType::where('is_active', true)->orderBy('name')->get(),
        ];
    }
}
