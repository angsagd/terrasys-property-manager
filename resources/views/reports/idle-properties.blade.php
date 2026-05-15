<x-app-layout>
    <x-slot name="header">
    <div class="flex items-center justify-between w-full">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Laporan Property Idle</h2>
            <p class="hidden lg:block text-sm text-gray-500 mt-1">Lacak properti yang saat ini tidak sedang dimanfaatkan.</p>
        </div>
    </div>
</x-slot>
    <div class="py-8"><div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"><div class="overflow-hidden rounded-lg border bg-white shadow-sm">
        <table class="min-w-full divide-y text-sm"><thead class="bg-gray-50 text-left text-xs uppercase text-gray-500"><tr><th class="px-4 py-3">Kode</th><th class="px-4 py-3">Properti</th><th class="px-4 py-3">Lokasi</th><th class="px-4 py-3">Jenis Hak</th><th class="px-4 py-3">Status Sertifikat</th></tr></thead><tbody class="divide-y">@forelse($properties as $property)<tr><td class="px-4 py-3">{{ $property->property_code }}</td><td class="px-4 py-3">{{ $property->property_name }}</td><td class="px-4 py-3">{{ $property->city?->name }}</td><td class="px-4 py-3">{{ $property->certificate?->landRightType?->name }}</td><td class="px-4 py-3">{{ $property->certificate?->certificateStatus?->name }}</td></tr>@empty<tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada data.</td></tr>@endforelse</tbody></table>
    </div></div></div>
</x-app-layout>
