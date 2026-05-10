<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Laporan Aset per Wilayah</h2></x-slot>
    <div class="py-8"><div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"><div class="overflow-hidden rounded-lg border bg-white shadow-sm">
        <table class="min-w-full divide-y text-sm"><thead class="bg-gray-50 text-left text-xs uppercase text-gray-500"><tr><th class="px-4 py-3">Provinsi</th><th class="px-4 py-3">Kota</th><th class="px-4 py-3">Jumlah</th><th class="px-4 py-3">Luas Tanah</th><th class="px-4 py-3">Luas Bangunan</th></tr></thead><tbody class="divide-y">@forelse($rows as $row)<tr><td class="px-4 py-3">{{ $row->province?->name }}</td><td class="px-4 py-3">{{ $row->city?->name }}</td><td class="px-4 py-3">{{ $row->total_property }}</td><td class="px-4 py-3">{{ number_format($row->total_land_area, 2) }}</td><td class="px-4 py-3">{{ number_format($row->total_building_area, 2) }}</td></tr>@empty<tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada data.</td></tr>@endforelse</tbody></table>
    </div></div></div>
</x-app-layout>
