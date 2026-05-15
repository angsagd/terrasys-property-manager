<x-app-layout>
    <x-slot name="header">
    <div class="flex items-center justify-between w-full">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Laporan Aset per Jenis Hak</h2>
            <p class="hidden lg:block text-sm text-gray-500 mt-1">Analyze property distribution based on land rights type.</p>
        </div>
    </div>
</x-slot>
    <div class="py-8"><div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"><div class="overflow-hidden rounded-lg border bg-white shadow-sm">
        <table class="min-w-full divide-y text-sm"><thead class="bg-gray-50 text-left text-xs uppercase text-gray-500"><tr><th class="px-4 py-3">Jenis Hak</th><th class="px-4 py-3">Jumlah Sertifikat</th><th class="px-4 py-3">Total Area</th></tr></thead><tbody class="divide-y">@forelse($rows as $row)<tr><td class="px-4 py-3">{{ $row->landRightType?->name }}</td><td class="px-4 py-3">{{ $row->total_certificate }}</td><td class="px-4 py-3">{{ number_format($row->total_area, 2) }}</td></tr>@empty<tr><td colspan="3" class="px-4 py-8 text-center text-gray-500">Belum ada data.</td></tr>@endforelse</tbody></table>
    </div></div></div>
</x-app-layout>
