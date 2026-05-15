<x-app-layout>
    <x-slot name="header">
    <div class="flex items-center justify-between w-full">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Laporan Sertifikat Akan Berakhir</h2>
            <p class="hidden lg:block text-sm text-gray-500 mt-1">Monitor certificates that are nearing their expiration dates.</p>
        </div>
    </div>
</x-slot>
    <div class="py-8"><div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"><div class="overflow-hidden rounded-lg border bg-white shadow-sm">
        <table class="min-w-full divide-y text-sm"><thead class="bg-gray-50 text-left text-xs uppercase text-gray-500"><tr><th class="px-4 py-3">Property</th><th class="px-4 py-3">Nomor</th><th class="px-4 py-3">Jenis Hak</th><th class="px-4 py-3">Tanggal Berakhir</th><th class="px-4 py-3">Sisa Hari</th></tr></thead><tbody class="divide-y">@forelse($certificates as $certificate)<tr><td class="px-4 py-3">{{ $certificate->property?->property_name }}</td><td class="px-4 py-3">{{ $certificate->certificate_number }}</td><td class="px-4 py-3">{{ $certificate->landRightType?->name }}</td><td class="px-4 py-3">{{ $certificate->expired_date?->format('d-m-Y') }}</td><td class="px-4 py-3">{{ now()->diffInDays($certificate->expired_date, false) }}</td></tr>@empty<tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">Tidak ada sertifikat yang akan berakhir.</td></tr>@endforelse</tbody></table>
    </div></div></div>
</x-app-layout>
