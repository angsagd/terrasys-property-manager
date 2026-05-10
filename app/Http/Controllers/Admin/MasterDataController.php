<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CertificateStatus;
use App\Models\DocumentCategory;
use App\Models\LandRightType;
use App\Models\PropertyType;
use App\Models\PropertyUtilizationStatus;

class MasterDataController extends Controller
{
    public function index()
    {
        $this->authorize('view_master_data');

        return view('admin.master-data.index', [
            'propertyTypes' => PropertyType::orderBy('name')->get(),
            'utilizationStatuses' => PropertyUtilizationStatus::orderBy('name')->get(),
            'landRightTypes' => LandRightType::orderBy('name')->get(),
            'certificateStatuses' => CertificateStatus::orderBy('name')->get(),
            'documentCategories' => DocumentCategory::orderBy('name')->get(),
        ]);
    }
}
