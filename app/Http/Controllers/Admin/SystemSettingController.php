<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;

class SystemSettingController extends Controller
{
    public function index()
    {
        $this->authorize('view_system_setting');

        return view('admin.system-settings.index', [
            'settings' => SystemSetting::orderBy('setting_key')->get(),
        ]);
    }
}
