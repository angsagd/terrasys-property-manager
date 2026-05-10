<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">{{ $property->property_name }}</h2>
                <p class="text-sm text-gray-500">{{ $property->property_code }} · {{ $property->utilizationStatus?->name }}</p>
            </div>
            @can('update_property')
                <a href="{{ route('properties.edit', $property) }}" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white">Edit</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
            @endif

            <div class="grid gap-4 md:grid-cols-4">
                <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                    <div class="text-sm text-gray-500">Jenis Hak</div>
                    <div class="mt-1 font-semibold text-gray-900">{{ $property->certificate?->landRightType?->name ?? '-' }}</div>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                    <div class="text-sm text-gray-500">Nomor Sertifikat</div>
                    <div class="mt-1 font-semibold text-gray-900">{{ $property->certificate?->certificate_number ?? '-' }}</div>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                    <div class="text-sm text-gray-500">Luas Tanah</div>
                    <div class="mt-1 font-semibold text-gray-900">{{ number_format($property->land_area ?? 0, 2) }} {{ $property->area_unit }}</div>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                    <div class="text-sm text-gray-500">Expired</div>
                    <div class="mt-1 font-semibold text-gray-900">{{ $property->certificate?->expired_date?->format('d-m-Y') ?? '-' }}</div>
                </div>
            </div>

            <div x-data="{ tab: 'overview' }" class="rounded-lg border border-gray-200 bg-white shadow-sm">
                <div class="overflow-x-auto border-b border-gray-200 px-4">
                    <nav class="flex min-w-max gap-2 py-3 text-sm">
                        @foreach ([
                            'overview' => 'Overview',
                            'property' => 'Property Data',
                            'certificate' => 'Certificate Data',
                            'additional' => 'Additional Certificates',
                            'lease' => 'Lease',
                            'documents' => 'Documents',
                            'map' => 'Map',
                            'audit' => 'Audit Log',
                        ] as $key => $label)
                            <button type="button" @click="tab = '{{ $key }}'" :class="tab === '{{ $key }}' ? 'bg-gray-900 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'" class="rounded-md border border-gray-200 px-3 py-2">{{ $label }}</button>
                        @endforeach
                    </nav>
                </div>

                <div class="p-5">
                    <section x-show="tab === 'overview'" class="space-y-6">
                        <div class="grid gap-6 lg:grid-cols-3">
                            <div class="lg:col-span-2">
                                <h3 class="mb-4 font-semibold text-gray-900">Informasi Property</h3>
                                <dl class="grid gap-4 text-sm md:grid-cols-2">
                                    <div><dt class="text-gray-500">Jenis Property</dt><dd class="font-medium">{{ $property->propertyType?->name }}</dd></div>
                                    <div><dt class="text-gray-500">Lokasi</dt><dd class="font-medium">{{ $property->city?->name }}, {{ $property->province?->name }}</dd></div>
                                    <div><dt class="text-gray-500">Luas Tanah</dt><dd class="font-medium">{{ number_format($property->land_area ?? 0, 2) }} {{ $property->area_unit }}</dd></div>
                                    <div><dt class="text-gray-500">Luas Bangunan</dt><dd class="font-medium">{{ number_format($property->building_area ?? 0, 2) }} {{ $property->area_unit }}</dd></div>
                                    <div class="md:col-span-2"><dt class="text-gray-500">Alamat</dt><dd class="font-medium">{{ $property->address ?: '-' }}</dd></div>
                                </dl>
                            </div>
                            <div>
                                <h3 class="mb-4 font-semibold text-gray-900">Informasi Sertifikat</h3>
                                <dl class="space-y-3 text-sm">
                                    <div><dt class="text-gray-500">Nomor</dt><dd class="font-medium">{{ $property->certificate?->certificate_number }}</dd></div>
                                    <div><dt class="text-gray-500">Pemegang Hak</dt><dd class="font-medium">{{ $property->certificate?->holder_name ?: '-' }}</dd></div>
                                    <div><dt class="text-gray-500">Status</dt><dd class="font-medium">{{ $property->certificate?->certificateStatus?->name }}</dd></div>
                                </dl>
                            </div>
                        </div>
                    </section>

                    <section x-show="tab === 'property'" class="space-y-4">
                        <h3 class="font-semibold text-gray-900">Property Data</h3>
                        <dl class="grid gap-4 text-sm md:grid-cols-2">
                            <div><dt class="text-gray-500">Kode</dt><dd class="font-medium">{{ $property->property_code }}</dd></div>
                            <div><dt class="text-gray-500">Nama</dt><dd class="font-medium">{{ $property->property_name }}</dd></div>
                            <div><dt class="text-gray-500">Status Pemanfaatan</dt><dd class="font-medium">{{ $property->utilizationStatus?->name }}</dd></div>
                            <div><dt class="text-gray-500">Kondisi Fisik</dt><dd class="font-medium">{{ $property->physical_condition ?: '-' }}</dd></div>
                            <div><dt class="text-gray-500">Provinsi</dt><dd class="font-medium">{{ $property->province?->name }}</dd></div>
                            <div><dt class="text-gray-500">Kota/Kabupaten</dt><dd class="font-medium">{{ $property->city?->name }}</dd></div>
                            <div><dt class="text-gray-500">Latitude</dt><dd class="font-medium">{{ $property->latitude ?: '-' }}</dd></div>
                            <div><dt class="text-gray-500">Longitude</dt><dd class="font-medium">{{ $property->longitude ?: '-' }}</dd></div>
                            <div class="md:col-span-2"><dt class="text-gray-500">Catatan</dt><dd class="font-medium">{{ $property->notes ?: '-' }}</dd></div>
                        </dl>
                    </section>

                    <section x-show="tab === 'certificate'" class="space-y-4">
                        <h3 class="font-semibold text-gray-900">Certificate Data</h3>
                        <dl class="grid gap-4 text-sm md:grid-cols-2">
                            <div><dt class="text-gray-500">Nomor Sertifikat</dt><dd class="font-medium">{{ $property->certificate?->certificate_number }}</dd></div>
                            <div><dt class="text-gray-500">Jenis Hak</dt><dd class="font-medium">{{ $property->certificate?->landRightType?->name }}</dd></div>
                            <div><dt class="text-gray-500">Pemegang Hak</dt><dd class="font-medium">{{ $property->certificate?->holder_name ?: '-' }}</dd></div>
                            <div><dt class="text-gray-500">Status</dt><dd class="font-medium">{{ $property->certificate?->certificateStatus?->name }}</dd></div>
                            <div><dt class="text-gray-500">Tanggal Terbit</dt><dd class="font-medium">{{ $property->certificate?->issued_date?->format('d-m-Y') ?? '-' }}</dd></div>
                            <div><dt class="text-gray-500">Tanggal Berakhir</dt><dd class="font-medium">{{ $property->certificate?->expired_date?->format('d-m-Y') ?? '-' }}</dd></div>
                            <div><dt class="text-gray-500">Luas Sertifikat</dt><dd class="font-medium">{{ number_format($property->certificate?->certificate_area ?? 0, 2) }} {{ $property->certificate?->area_unit }}</dd></div>
                            <div><dt class="text-gray-500">Kantor Pertanahan</dt><dd class="font-medium">{{ $property->certificate?->land_office ?: '-' }}</dd></div>
                            <div class="md:col-span-2"><dt class="text-gray-500">Catatan Legal</dt><dd class="font-medium">{{ $property->certificate?->legal_notes ?: '-' }}</dd></div>
                        </dl>
                    </section>

                    <section x-show="tab === 'additional'" class="space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold text-gray-900">Additional Certificates</h3>
                            @can('create_additional_certificate')
                                <a href="{{ route('additional-certificates.create') }}" class="text-sm text-blue-700">Tambah</a>
                            @endcan
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50 text-left text-xs uppercase text-gray-500"><tr><th class="px-3 py-2">Nomor</th><th class="px-3 py-2">Jenis</th><th class="px-3 py-2">Pemegang</th><th class="px-3 py-2">Expired</th></tr></thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse ($property->additionalCertificates as $item)
                                        <tr><td class="px-3 py-2">{{ $item->document_number ?: '-' }}</td><td class="px-3 py-2">{{ $item->landRightType?->name ?? $item->document_type }}</td><td class="px-3 py-2">{{ $item->holder_name ?: '-' }}</td><td class="px-3 py-2">{{ $item->expired_date?->format('d-m-Y') ?? '-' }}</td></tr>
                                    @empty
                                        <tr><td colspan="4" class="px-3 py-6 text-center text-gray-500">Belum ada sertifikat tambahan.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <section x-show="tab === 'lease'" class="space-y-4">
                        <h3 class="font-semibold text-gray-900">Lease</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50 text-left text-xs uppercase text-gray-500"><tr><th class="px-3 py-2">Jenis</th><th class="px-3 py-2">Pihak Lawan</th><th class="px-3 py-2">Mulai</th><th class="px-3 py-2">Selesai</th><th class="px-3 py-2">Nilai</th><th class="px-3 py-2">Status</th></tr></thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse ($property->leaseContracts as $lease)
                                        <tr><td class="px-3 py-2">{{ $lease->leaseType?->name }}</td><td class="px-3 py-2">{{ $lease->counterparty_name }}</td><td class="px-3 py-2">{{ $lease->start_date?->format('d-m-Y') }}</td><td class="px-3 py-2">{{ $lease->end_date?->format('d-m-Y') }}</td><td class="px-3 py-2">Rp {{ number_format($lease->rental_value, 0, ',', '.') }}</td><td class="px-3 py-2">{{ $lease->leaseStatus?->name }}</td></tr>
                                    @empty
                                        <tr><td colspan="6" class="px-3 py-6 text-center text-gray-500">Belum ada kontrak sewa.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <section x-show="tab === 'documents'" class="space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold text-gray-900">Documents</h3>
                            @can('upload_document')
                                <a href="{{ route('documents.create') }}" class="text-sm text-blue-700">Upload</a>
                            @endcan
                        </div>
                        <div class="divide-y divide-gray-100 text-sm">
                            @forelse ($relatedDocuments as $document)
                                <div class="flex items-center justify-between gap-4 py-3">
                                    <div>
                                        <div class="font-medium">{{ $document->document_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $document->category?->name }} · {{ $document->expired_date?->format('d-m-Y') ?? 'Tanpa expired' }}</div>
                                    </div>
                                    <a class="text-blue-700" href="{{ route('documents.download', $document) }}">Download</a>
                                </div>
                            @empty
                                <p class="text-gray-500">Belum ada dokumen.</p>
                            @endforelse
                        </div>
                    </section>

                    <section x-show="tab === 'map'" class="space-y-4">
                        <h3 class="font-semibold text-gray-900">Map</h3>
                        @if ($property->latitude && $property->longitude)
                            <div id="property-map" class="h-96 rounded-md border border-gray-200"></div>
                        @else
                            <p class="text-sm text-gray-500">Koordinat property belum diisi.</p>
                        @endif
                    </section>

                    <section x-show="tab === 'audit'" class="space-y-4">
                        <h3 class="font-semibold text-gray-900">Audit Log</h3>
                        <div class="divide-y divide-gray-100 text-sm">
                            @forelse ($auditLogs as $log)
                                <div class="grid gap-2 py-3 md:grid-cols-4">
                                    <div class="font-medium">{{ $log->created_at?->format('d-m-Y H:i') }}</div>
                                    <div>{{ $log->user?->name ?? '-' }}</div>
                                    <div>{{ $log->module_name }}</div>
                                    <div>{{ $log->action }}</div>
                                </div>
                            @empty
                                <p class="text-gray-500">Belum ada audit log.</p>
                            @endforelse
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    @if ($property->latitude && $property->longitude)
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            document.addEventListener('alpine:init', () => {
                setTimeout(() => {
                    const element = document.getElementById('property-map');
                    if (!element || element.dataset.loaded) return;

                    element.dataset.loaded = '1';
                    const map = L.map('property-map').setView([{{ $property->latitude }}, {{ $property->longitude }}], 16);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);
                    L.marker([{{ $property->latitude }}, {{ $property->longitude }}]).addTo(map).bindPopup(@json($property->property_name));

                    @if ($property->polygon_geojson)
                        L.geoJSON(@json(json_decode($property->polygon_geojson, true))).addTo(map);
                    @endif
                }, 250);
            });
        </script>
    @endif
</x-app-layout>
