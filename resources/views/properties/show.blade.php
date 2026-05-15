<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between w-full gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">{{ $property->property_name }}</h2>
                    <span class="inline-flex items-center rounded-md bg-brand-50 px-2 py-1 text-xs font-medium text-brand-700 ring-1 ring-inset ring-brand-600/20">{{ $property->utilizationStatus?->name }}</span>
                </div>
                <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                    {{ $property->city?->name }}, {{ $property->province?->name }} · Code: {{ $property->property_code }}
                </p>
            </div>
            @can('update_property')
                <a href="{{ route('properties.edit', $property) }}" class="inline-flex items-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-all">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                    Edit Property
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-8">
            @if (session('success'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 flex items-center gap-2">
                    <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200/50 hover:shadow-md transition-shadow">
                    <div class="text-sm font-medium text-gray-500">Jenis Hak</div>
                    <div class="mt-1 flex items-baseline text-xl font-bold text-gray-900">{{ $property->certificate?->landRightType?->name ?? '-' }}</div>
                </div>
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200/50 hover:shadow-md transition-shadow">
                    <div class="text-sm font-medium text-gray-500">Nomor Sertifikat</div>
                    <div class="mt-1 flex items-baseline text-xl font-bold text-gray-900">{{ $property->certificate?->certificate_number ?? '-' }}</div>
                </div>
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200/50 hover:shadow-md transition-shadow">
                    <div class="text-sm font-medium text-gray-500">Luas Tanah</div>
                    <div class="mt-1 flex items-baseline text-xl font-bold text-gray-900">{{ number_format($property->land_area ?? 0, 2) }} <span class="ml-1 text-sm font-medium text-gray-500">{{ $property->area_unit }}</span></div>
                </div>
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200/50 hover:shadow-md transition-shadow">
                    <div class="text-sm font-medium text-gray-500">Expired Date</div>
                    <div class="mt-1 flex items-baseline text-xl font-bold {{ $property->certificate?->expired_date?->isPast() ? 'text-rose-600' : 'text-gray-900' }}">{{ $property->certificate?->expired_date?->format('d M Y') ?? '-' }}</div>
                </div>
            </div>

            <!-- Tabs and Content -->
            <div x-data="{ tab: 'overview' }" class="rounded-2xl bg-white shadow-sm ring-1 ring-gray-200/50 overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50/50 px-4 sm:px-6">
                    <nav class="-mb-px flex space-x-6 overflow-x-auto" aria-label="Tabs">
                        @foreach ([
                            'overview' => 'Overview',
                            'property' => 'Detail Data',
                            'certificate' => 'Sertifikat',
                            'additional' => 'Dokumen Tambahan',
                            'lease' => 'Lease',
                            'documents' => 'Files',
                            'map' => 'Peta',
                            'audit' => 'Log Aktivitas',
                        ] as $key => $label)
                            <button @click="tab = '{{ $key }}'" 
                                    :class="tab === '{{ $key }}' ? 'border-brand-500 text-brand-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
                                    class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium transition-colors outline-none focus:text-brand-600">
                                {{ $label }}
                            </button>
                        @endforeach
                    </nav>
                </div>

                <div class="p-6 sm:p-8">
                    <!-- Overview -->
                    <section x-show="tab === 'overview'" class="space-y-8" style="display: none;" x-transition.opacity>
                        <div class="grid gap-8 lg:grid-cols-3">
                            <div class="lg:col-span-2">
                                <h3 class="text-base font-bold text-gray-900 tracking-tight mb-4">Informasi Property</h3>
                                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                    <div class="sm:col-span-1"><dt class="text-sm font-medium text-gray-500">Jenis Property</dt><dd class="mt-1 text-sm text-gray-900">{{ $property->propertyType?->name }}</dd></div>
                                    <div class="sm:col-span-1"><dt class="text-sm font-medium text-gray-500">Lokasi</dt><dd class="mt-1 text-sm text-gray-900">{{ $property->city?->name }}, {{ $property->province?->name }}</dd></div>
                                    <div class="sm:col-span-1"><dt class="text-sm font-medium text-gray-500">Luas Tanah</dt><dd class="mt-1 text-sm text-gray-900">{{ number_format($property->land_area ?? 0, 2) }} {{ $property->area_unit }}</dd></div>
                                    <div class="sm:col-span-1"><dt class="text-sm font-medium text-gray-500">Luas Bangunan</dt><dd class="mt-1 text-sm text-gray-900">{{ number_format($property->building_area ?? 0, 2) }} {{ $property->area_unit }}</dd></div>
                                    <div class="sm:col-span-2"><dt class="text-sm font-medium text-gray-500">Alamat Lengkap</dt><dd class="mt-1 text-sm text-gray-900">{{ $property->address ?: '-' }}</dd></div>
                                </dl>
                            </div>
                            <div class="rounded-xl bg-gray-50/50 ring-1 ring-gray-200/50 p-5">
                                <h3 class="text-base font-bold text-gray-900 tracking-tight mb-4">Informasi Sertifikat Utama</h3>
                                <dl class="space-y-4 text-sm">
                                    <div><dt class="font-medium text-gray-500">Nomor</dt><dd class="mt-1 text-gray-900 font-semibold">{{ $property->certificate?->certificate_number }}</dd></div>
                                    <div class="pt-4 border-t border-gray-200"><dt class="font-medium text-gray-500">Pemegang Hak</dt><dd class="mt-1 text-gray-900">{{ $property->certificate?->holder_name ?: '-' }}</dd></div>
                                    <div class="pt-4 border-t border-gray-200"><dt class="font-medium text-gray-500">Status Legal</dt><dd class="mt-1"><span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20">{{ $property->certificate?->certificateStatus?->name }}</span></dd></div>
                                </dl>
                            </div>
                        </div>
                    </section>

                    <!-- Property Data -->
                    <section x-show="tab === 'property'" class="space-y-6" style="display: none;" x-transition.opacity>
                        <h3 class="text-base font-bold text-gray-900 tracking-tight">Detail Property</h3>
                        <div class="overflow-hidden rounded-xl ring-1 ring-gray-200/50">
                            <dl class="divide-y divide-gray-100 bg-white">
                                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"><dt class="text-sm font-medium text-gray-500">Kode Internal</dt><dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $property->property_code }}</dd></div>
                                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-gray-50/50"><dt class="text-sm font-medium text-gray-500">Nama Property</dt><dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $property->property_name }}</dd></div>
                                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"><dt class="text-sm font-medium text-gray-500">Status Pemanfaatan</dt><dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $property->utilizationStatus?->name }}</dd></div>
                                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-gray-50/50"><dt class="text-sm font-medium text-gray-500">Kondisi Fisik</dt><dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $property->physical_condition ?: '-' }}</dd></div>
                                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"><dt class="text-sm font-medium text-gray-500">Provinsi & Kota</dt><dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $property->province?->name }} / {{ $property->city?->name }}</dd></div>
                                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-gray-50/50"><dt class="text-sm font-medium text-gray-500">Koordinat</dt><dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $property->latitude ?: '-' }}, {{ $property->longitude ?: '-' }}</dd></div>
                                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"><dt class="text-sm font-medium text-gray-500">Catatan</dt><dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $property->notes ?: '-' }}</dd></div>
                            </dl>
                        </div>
                    </section>

                    <!-- Certificate Data -->
                    <section x-show="tab === 'certificate'" class="space-y-6" style="display: none;" x-transition.opacity>
                        <h3 class="text-base font-bold text-gray-900 tracking-tight">Detail Sertifikat</h3>
                        <div class="overflow-hidden rounded-xl ring-1 ring-gray-200/50">
                            <dl class="divide-y divide-gray-100 bg-white">
                                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"><dt class="text-sm font-medium text-gray-500">Nomor Sertifikat</dt><dd class="mt-1 text-sm font-semibold text-gray-900 sm:col-span-2 sm:mt-0">{{ $property->certificate?->certificate_number }}</dd></div>
                                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-gray-50/50"><dt class="text-sm font-medium text-gray-500">Jenis Hak</dt><dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $property->certificate?->landRightType?->name }}</dd></div>
                                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"><dt class="text-sm font-medium text-gray-500">Pemegang Hak</dt><dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $property->certificate?->holder_name ?: '-' }}</dd></div>
                                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-gray-50/50"><dt class="text-sm font-medium text-gray-500">Status</dt><dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $property->certificate?->certificateStatus?->name }}</dd></div>
                                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"><dt class="text-sm font-medium text-gray-500">Masa Berlaku</dt><dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $property->certificate?->issued_date?->format('d M Y') ?? '?' }} s/d {{ $property->certificate?->expired_date?->format('d M Y') ?? '?' }}</dd></div>
                                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-gray-50/50"><dt class="text-sm font-medium text-gray-500">Luas Tercatat</dt><dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ number_format($property->certificate?->certificate_area ?? 0, 2) }} {{ $property->certificate?->area_unit }}</dd></div>
                                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"><dt class="text-sm font-medium text-gray-500">Kantor Pertanahan</dt><dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $property->certificate?->land_office ?: '-' }}</dd></div>
                                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-gray-50/50"><dt class="text-sm font-medium text-gray-500">Catatan Legal</dt><dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $property->certificate?->legal_notes ?: '-' }}</dd></div>
                            </dl>
                        </div>
                    </section>

                    <!-- Additional Certificates -->
                    <section x-show="tab === 'additional'" class="space-y-6" style="display: none;" x-transition.opacity>
                        <div class="flex items-center justify-between">
                            <h3 class="text-base font-bold text-gray-900 tracking-tight">Dokumen Tambahan (HGB/HGU/dll)</h3>
                            @can('create_additional_certificate')
                                <a href="{{ route('additional-certificates.create') }}" class="text-sm font-medium text-brand-600 hover:text-brand-500 transition-colors">+ Tambah Dokumen</a>
                            @endcan
                        </div>
                        <div class="overflow-hidden rounded-xl ring-1 ring-gray-200/50">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50/50"><tr><th class="px-4 py-3 text-left font-medium text-gray-900">Nomor</th><th class="px-4 py-3 text-left font-medium text-gray-900">Jenis</th><th class="px-4 py-3 text-left font-medium text-gray-900">Pemegang</th><th class="px-4 py-3 text-left font-medium text-gray-900">Expired</th></tr></thead>
                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @forelse ($property->additionalCertificates as $item)
                                        <tr class="hover:bg-gray-50/50"><td class="px-4 py-3 font-medium text-gray-900">{{ $item->document_number ?: '-' }}</td><td class="px-4 py-3 text-gray-500">{{ $item->landRightType?->name ?? $item->document_type }}</td><td class="px-4 py-3 text-gray-500">{{ $item->holder_name ?: '-' }}</td><td class="px-4 py-3 text-gray-500">{{ $item->expired_date?->format('d M Y') ?? '-' }}</td></tr>
                                    @empty
                                        <tr><td colspan="4" class="px-4 py-8 text-center text-sm text-gray-500">Belum ada dokumen tambahan.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <!-- Lease Contracts -->
                    <section x-show="tab === 'lease'" class="space-y-6" style="display: none;" x-transition.opacity>
                        <div class="flex items-center justify-between">
                            <h3 class="text-base font-bold text-gray-900 tracking-tight">Kontrak Sewa (Lease)</h3>
                            @can('create_lease')
                                <a href="{{ route('lease-contracts.create', ['property_id' => $property->id]) }}" class="text-sm font-medium text-brand-600 hover:text-brand-500 transition-colors">+ Tambah Lease</a>
                            @endcan
                        </div>
                        <div class="overflow-hidden rounded-xl ring-1 ring-gray-200/50">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50/50"><tr><th class="px-4 py-3 text-left font-medium text-gray-900">Jenis</th><th class="px-4 py-3 text-left font-medium text-gray-900">Pihak Lawan</th><th class="px-4 py-3 text-left font-medium text-gray-900">Durasi</th><th class="px-4 py-3 text-left font-medium text-gray-900">Nilai</th><th class="px-4 py-3 text-left font-medium text-gray-900">Status</th><th class="px-4 py-3 text-right font-medium text-gray-900">Aksi</th></tr></thead>
                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @forelse ($property->leaseContracts as $lease)
                                        <tr class="hover:bg-gray-50/50">
                                            <td class="px-4 py-3 text-gray-500">{{ $lease->leaseType?->name }}</td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $lease->counterparty_name }}</td>
                                            <td class="px-4 py-3 text-gray-500">{{ $lease->start_date?->format('d/m/Y') }} - {{ $lease->end_date?->format('d/m/Y') }}</td>
                                            <td class="px-4 py-3 text-gray-500">Rp {{ number_format($lease->rental_value, 0, ',', '.') }}</td>
                                            <td class="px-4 py-3"><span class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-600/20">{{ $lease->leaseStatus?->name }}</span></td>
                                            <td class="px-4 py-3 text-right"><a href="{{ route('lease-contracts.show', $lease) }}" class="text-brand-600 hover:text-brand-500 font-medium">Detail</a></td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="6" class="px-4 py-8 text-center text-sm text-gray-500">Belum ada kontrak sewa.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <!-- Documents -->
                    <section x-show="tab === 'documents'" class="space-y-6" style="display: none;" x-transition.opacity>
                        <div class="flex items-center justify-between">
                            <h3 class="text-base font-bold text-gray-900 tracking-tight">Arsip Dokumen</h3>
                            @can('upload_document')
                                <a href="{{ route('documents.create') }}" class="text-sm font-medium text-brand-600 hover:text-brand-500 transition-colors">+ Upload Baru</a>
                            @endcan
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @forelse ($relatedDocuments as $document)
                                <div class="flex items-center justify-between p-4 rounded-xl ring-1 ring-gray-200/50 bg-white hover:shadow-sm transition-shadow">
                                    <div class="flex items-center gap-3 overflow-hidden">
                                        <div class="h-10 w-10 flex-shrink-0 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $document->document_name }}</p>
                                            <p class="text-xs text-gray-500 truncate">{{ $document->category?->name }}</p>
                                        </div>
                                    </div>
                                    <a class="ml-4 flex-shrink-0 text-brand-600 hover:text-brand-500" href="{{ route('documents.download', $document) }}" title="Download">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                                    </a>
                                </div>
                            @empty
                                <div class="col-span-full py-8 text-center text-sm text-gray-500 rounded-xl ring-1 ring-gray-200/50 border-dashed">Belum ada arsip dokumen.</div>
                            @endforelse
                        </div>
                    </section>

                    <!-- Map -->
                    <section x-show="tab === 'map'" class="space-y-6" style="display: none;" x-transition.opacity>
                        <h3 class="text-base font-bold text-gray-900 tracking-tight">Peta Lokasi</h3>
                        @if ($property->latitude && $property->longitude)
                            <div class="overflow-hidden rounded-xl ring-1 ring-gray-200/50 p-1 bg-white">
                                <div id="property-map" class="h-[400px] w-full rounded-lg z-0 relative"></div>
                            </div>
                        @else
                            <div class="py-12 text-center rounded-xl ring-1 ring-gray-200/50 bg-gray-50/50">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                                <p class="mt-2 text-sm text-gray-500">Koordinat (Latitude/Longitude) property belum diisi.</p>
                            </div>
                        @endif
                    </section>

                    <!-- Audit Log -->
                    <section x-show="tab === 'audit'" class="space-y-6" style="display: none;" x-transition.opacity>
                        <h3 class="text-base font-bold text-gray-900 tracking-tight">Log Aktivitas Data</h3>
                        <div class="overflow-hidden rounded-xl ring-1 ring-gray-200/50">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50/50"><tr><th class="px-4 py-3 text-left font-medium text-gray-900">Waktu</th><th class="px-4 py-3 text-left font-medium text-gray-900">User</th><th class="px-4 py-3 text-left font-medium text-gray-900">Modul</th><th class="px-4 py-3 text-left font-medium text-gray-900">Aksi</th></tr></thead>
                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @forelse ($auditLogs as $log)
                                        <tr class="hover:bg-gray-50/50">
                                            <td class="px-4 py-3 text-gray-500">{{ $log->created_at?->format('d M Y, H:i') }}</td>
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $log->user?->name ?? 'Sistem' }}</td>
                                            <td class="px-4 py-3 text-gray-500">{{ $log->module_name }}</td>
                                            <td class="px-4 py-3 text-gray-500"><span class="inline-flex items-center rounded-md bg-gray-100 px-2 py-1 text-xs font-medium text-gray-600">{{ $log->action }}</span></td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="px-4 py-8 text-center text-sm text-gray-500">Belum ada riwayat aktivitas.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
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
                        L.geoJSON(@json(json_decode($property->polygon_geojson, true)), { style: { color: '#14b8a6', weight: 2, fillOpacity: 0.2 } }).addTo(map);
                    @endif
                }, 250); // slight delay to ensure Alpine has rendered the tab contents
            });
        </script>
    @endif
</x-app-layout>
