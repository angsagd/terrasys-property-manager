<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Property;

class ReportController extends Controller
{
    public function assetsByRegion()
    {
        $this->authorize('view_report');

        return view('reports.assets-by-region', [
            'rows' => Property::selectRaw('province_id, city_id, COUNT(*) as total_property, SUM(land_area) as total_land_area, SUM(building_area) as total_building_area')
                ->with(['province', 'city'])
                ->groupBy('province_id', 'city_id')
                ->get(),
        ]);
    }

    public function assetsByLandRight()
    {
        $this->authorize('view_report');

        return view('reports.assets-by-land-right', [
            'rows' => Certificate::selectRaw('land_right_type_id, COUNT(*) as total_certificate, SUM(certificate_area) as total_area')
                ->with('landRightType')
                ->groupBy('land_right_type_id')
                ->get(),
        ]);
    }

    public function idleProperties()
    {
        $this->authorize('view_report');

        return view('reports.idle-properties', [
            'properties' => Property::with(['certificate.landRightType', 'certificate.certificateStatus', 'province', 'city'])
                ->whereHas('utilizationStatus', fn ($query) => $query->where('name', 'Idle / Tidak Digunakan'))
                ->get(),
        ]);
    }

    public function expiringCertificates()
    {
        $this->authorize('view_report');

        return view('reports.expiring-certificates', [
            'certificates' => Certificate::with(['property.province', 'property.city', 'landRightType', 'certificateStatus'])
                ->whereNotNull('expired_date')
                ->whereBetween('expired_date', [now(), now()->addDays(180)])
                ->orderBy('expired_date')
                ->get(),
        ]);
    }
}
