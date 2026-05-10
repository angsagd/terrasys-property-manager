<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\Property;
use App\Services\AuditLogService;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $this->authorize('view_document');

        return view('documents.index', [
            'documents' => Document::with(['category', 'property'])->latest()->paginate(15),
        ]);
    }

    public function create()
    {
        $this->authorize('upload_document');

        return view('documents.create', [
            'categories' => DocumentCategory::where('is_active', true)->orderBy('name')->get(),
            'properties' => Property::with('certificate')->orderBy('property_name')->get(),
        ]);
    }

    public function store(DocumentRequest $request, AuditLogService $auditLog)
    {
        $file = $request->file('file');
        $path = $file->store('documents', 'public');

        $document = Document::create($request->safe()->except('file') + [
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'file_extension' => $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'uploaded_by' => $request->user()->id,
        ]);
        $auditLog->record('Document', $document, 'upload', null, $document->toArray());

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diunggah.');
    }

    public function show(Document $document)
    {
        $this->authorize('view_document');

        $document->load(['category', 'property', 'certificate', 'additionalCertificate', 'leaseContract', 'uploader']);

        return view('documents.show', compact('document'));
    }

    public function download(Document $document, AuditLogService $auditLog)
    {
        $this->authorize('download_document');

        $auditLog->record('Document', $document, 'download');

        return Storage::disk('public')->download($document->file_path, $document->file_name);
    }
}
