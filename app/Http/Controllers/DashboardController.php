<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Document;
use App\Models\LeaseContract;
use App\Models\Property;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $idleCount = Property::whereHas('utilizationStatus', fn ($query) => $query->where('name', 'Idle / Tidak Digunakan'))->count();
        $disputeCount = Property::whereHas('utilizationStatus', fn ($query) => $query->where('name', 'Sengketa'))->count();

        return view('dashboard', [
            'totalProperties' => Property::count(),
            'totalCertificates' => Certificate::count(),
            'totalLandArea' => Property::sum('land_area'),
            'totalBuildingArea' => Property::sum('building_area'),
            'totalRentalValue' => LeaseContract::sum('rental_value'),
            'expiringCertificates' => Certificate::whereNotNull('expired_date')->whereBetween('expired_date', [now(), now()->addDays(180)])->count(),
            'expiringLeases' => LeaseContract::whereBetween('end_date', [now(), now()->addDays(180)])->count(),
            'expiringDocuments' => Document::whereNotNull('expired_date')->whereBetween('expired_date', [now(), now()->addDays(180)])->count(),
            'idleCount' => $idleCount,
            'disputeCount' => $disputeCount,
            'propertiesByProvince' => Property::selectRaw('province_id, COUNT(*) as total')->with('province')->groupBy('province_id')->get(),
            'recentProperties' => Property::with(['certificate.landRightType', 'utilizationStatus', 'province', 'city'])->latest()->limit(8)->get(),
        ]);
    }
}
