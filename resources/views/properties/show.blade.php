<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">{{ $property->property_name }}</h2>
                <p class="text-sm text-gray-500">{{ $property->property_code }} · {{ $property->utilizationStatus?->name }}</p>
            </div>
            @can('update_property')
                <a href="{{ route('properties.edit', $property) }}" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white">Edit</a>
            @endcan
        </div>
    </x-slot>
    <div class="py-8"><div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
        @endif
        <div class="grid gap-6 lg:grid-cols-3">
            <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm lg:col-span-2">
                <h3 class="mb-4 font-semibold">Overview</h3>
                <dl class="grid gap-4 text-sm md:grid-cols-2">
                    <div><dt class="text-gray-500">Jenis Property</dt><dd class="font-medium">{{ $property->propertyType?->name }}</dd></div>
                    <div><dt class="text-gray-500">Lokasi</dt><dd class="font-medium">{{ $property->city?->name }}, {{ $property->province?->name }}</dd></div>
                    <div><dt class="text-gray-500">Luas Tanah</dt><dd class="font-medium">{{ number_format($property->land_area ?? 0, 2) }} {{ $property->area_unit }}</dd></div>
                    <div><dt class="text-gray-500">Luas Bangunan</dt><dd class="font-medium">{{ number_format($property->building_area ?? 0, 2) }} {{ $property->area_unit }}</dd></div>
                    <div class="md:col-span-2"><dt class="text-gray-500">Alamat</dt><dd class="font-medium">{{ $property->address ?: '-' }}</dd></div>
                </dl>
            </section>
            <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                <h3 class="mb-4 font-semibold">Sertifikat Utama</h3>
                <dl class="space-y-3 text-sm">
                    <div><dt class="text-gray-500">Nomor</dt><dd class="font-medium">{{ $property->certificate?->certificate_number }}</dd></div>
                    <div><dt class="text-gray-500">Jenis Hak</dt><dd class="font-medium">{{ $property->certificate?->landRightType?->name }}</dd></div>
                    <div><dt class="text-gray-500">Status</dt><dd class="font-medium">{{ $property->certificate?->certificateStatus?->name }}</dd></div>
                    <div><dt class="text-gray-500">Berakhir</dt><dd class="font-medium">{{ $property->certificate?->expired_date?->format('d-m-Y') ?? '-' }}</dd></div>
                </dl>
            </section>
        </div>
        <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <h3 class="mb-4 font-semibold">Dokumen</h3>
            <div class="divide-y divide-gray-100 text-sm">
                @forelse ($property->documents as $document)
                    <div class="flex items-center justify-between py-3">
                        <span>{{ $document->document_name }} <span class="text-gray-500">({{ $document->category?->name }})</span></span>
                        <a class="text-blue-700" href="{{ route('documents.download', $document) }}">Download</a>
                    </div>
                @empty
                    <p class="text-gray-500">Belum ada dokumen.</p>
                @endforelse
            </div>
        </section>
    </div></div>
</x-app-layout>
