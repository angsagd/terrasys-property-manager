<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;

class AuditLogController extends Controller
{
    public function index()
    {
        $this->authorize('view_audit_log');

        return view('admin.audit-logs.index', [
            'auditLogs' => AuditLog::with('user')->latest('created_at')->paginate(25),
        ]);
    }
}
