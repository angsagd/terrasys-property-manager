<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
            @endif

            <div class="grid gap-4 md:grid-cols-4">
                @foreach ([
                    'Total Property' => number_format($totalProperties),
                    'Total Sertifikat' => number_format($totalCertificates),
                    'Luas Tanah' => number_format($totalLandArea, 2).' m2',
                    'Nilai Sewa' => 'Rp '.number_format($totalRentalValue, 0, ',', '.'),
                    'Sertifikat Expired' => number_format($expiringCertificates),
                    'Lease Expired' => number_format($expiringLeases),
                    'Dokumen Expired' => number_format($expiringDocuments),
                    'Property Idle' => number_format($idleCount),
                ] as $label => $value)
                    <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                        <div class="text-sm text-gray-500">{{ $label }}</div>
                        <div class="mt-2 text-2xl font-semibold text-gray-900">{{ $value }}</div>
                    </div>
                @endforeach
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm lg:col-span-2">
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="font-semibold text-gray-900">Property Terbaru</h3>
                        <a href="{{ route('properties.create') }}" class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white">Tambah Property</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50 text-left text-xs font-medium uppercase text-gray-500">
                                <tr>
                                    <th class="px-3 py-2">Kode</th>
                                    <th class="px-3 py-2">Property</th>
                                    <th class="px-3 py-2">Lokasi</th>
                                    <th class="px-3 py-2">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($recentProperties as $property)
                                    <tr>
                                        <td class="px-3 py-2">{{ $property->property_code }}</td>
                                        <td class="px-3 py-2"><a class="font-medium text-blue-700" href="{{ route('properties.show', $property) }}">{{ $property->property_name }}</a></td>
                                        <td class="px-3 py-2">{{ $property->city?->name }}, {{ $property->province?->name }}</td>
                                        <td class="px-3 py-2">{{ $property->utilizationStatus?->name }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-3 py-6 text-center text-gray-500">Belum ada data property.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                    <h3 class="mb-4 font-semibold text-gray-900">Aset per Provinsi</h3>
                    <div class="space-y-3">
                        @forelse ($propertiesByProvince as $row)
                            <div class="flex items-center justify-between border-b border-gray-100 pb-2 text-sm">
                                <span>{{ $row->province?->name ?? '-' }}</span>
                                <span class="font-semibold">{{ $row->total }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Belum ada data.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
