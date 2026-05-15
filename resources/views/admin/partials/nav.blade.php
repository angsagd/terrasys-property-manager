<div class="rounded-lg border border-gray-200 bg-white p-2 shadow-sm">
    <nav class="flex flex-wrap gap-2 text-sm">
        @can('view_user')
            <a href="{{ route('admin.users.index') }}" class="rounded-md px-3 py-2 {{ request()->routeIs('admin.users.*') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-50' }}">Users</a>
        @endcan
        @can('view_role')
            <a href="{{ route('admin.roles.index') }}" class="rounded-md px-3 py-2 {{ request()->routeIs('admin.roles.*') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-50' }}">Peran</a>
        @endcan
        @can('view_master_data')
            <a href="{{ route('admin.master-data.index') }}" class="rounded-md px-3 py-2 {{ request()->routeIs('admin.master-data.*') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-50' }}">Master Data</a>
        @endcan
        @can('view_audit_log')
            <a href="{{ route('admin.audit-logs.index') }}" class="rounded-md px-3 py-2 {{ request()->routeIs('admin.audit-logs.*') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-50' }}">Jejak Audit</a>
        @endcan
        @can('view_system_setting')
            <a href="{{ route('admin.system-settings.index') }}" class="rounded-md px-3 py-2 {{ request()->routeIs('admin.system-settings.*') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-50' }}">Pengaturan</a>
        @endcan
    </nav>
</div>
