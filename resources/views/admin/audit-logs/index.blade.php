<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Audit Trail</h2></x-slot>
    <div class="py-8"><div class="mx-auto max-w-7xl space-y-5 px-4 sm:px-6 lg:px-8">@include('admin.partials.nav')<div class="overflow-hidden rounded-lg border bg-white shadow-sm">
        <table class="min-w-full divide-y text-sm"><thead class="bg-gray-50 text-left text-xs uppercase text-gray-500"><tr><th class="px-4 py-3">Waktu</th><th class="px-4 py-3">User</th><th class="px-4 py-3">Module</th><th class="px-4 py-3">Action</th><th class="px-4 py-3">Record</th></tr></thead><tbody class="divide-y">@forelse($auditLogs as $log)<tr><td class="px-4 py-3">{{ $log->created_at?->format('d-m-Y H:i') }}</td><td class="px-4 py-3">{{ $log->user?->name ?? '-' }}</td><td class="px-4 py-3">{{ $log->module_name }}</td><td class="px-4 py-3">{{ $log->action }}</td><td class="px-4 py-3">{{ $log->table_name }} #{{ $log->record_id }}</td></tr>@empty<tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada audit log.</td></tr>@endforelse</tbody></table>
        <div class="border-t px-4 py-3">{{ $auditLogs->links() }}</div>
    </div></div></div>
</x-app-layout>
