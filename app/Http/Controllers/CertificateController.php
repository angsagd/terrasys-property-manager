<?php

namespace App\Http\Controllers;

use App\Models\Certificate;

class CertificateController extends Controller
{
    public function index()
    {
        $this->authorize('view_certificate');

        return view('certificates.index', [
            'certificates' => Certificate::with(['property.province', 'property.city', 'landRightType', 'certificateStatus'])
                ->latest()
                ->paginate(15),
        ]);
    }

    public function show(Certificate $certificate)
    {
        $this->authorize('view_certificate');

        $certificate->load(['property', 'landRightType', 'certificateStatus', 'documents']);

        return view('certificates.show', compact('certificate'));
    }
}
