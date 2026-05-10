<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Property & Certificate</h2>
            @can('create_property')
                <a href="{{ route('properties.create') }}" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white">Tambah Property</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-5 px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
            @endif

            <form class="grid gap-3 rounded-lg border border-gray-200 bg-white p-4 shadow-sm md:grid-cols-6">
                <input name="search" value="{{ request('search') }}" placeholder="Cari kode/nama" class="rounded-md border-gray-300 text-sm md:col-span-2">
                <select name="province_id" class="rounded-md border-gray-300 text-sm">
                    <option value="">Provinsi</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province->id }}" @selected(request('province_id') == $province->id)>{{ $province->name }}</option>
                    @endforeach
                </select>
                <select name="property_type_id" class="rounded-md border-gray-300 text-sm">
                    <option value="">Jenis Property</option>
                    @foreach ($propertyTypes as $type)
                        <option value="{{ $type->id }}" @selected(request('property_type_id') == $type->id)>{{ $type->name }}</option>
                    @endforeach
                </select>
                <select name="utilization_status_id" class="rounded-md border-gray-300 text-sm">
                    <option value="">Status</option>
                    @foreach ($utilizationStatuses as $status)
                        <option value="{{ $status->id }}" @selected(request('utilization_status_id') == $status->id)>{{ $status->name }}</option>
                    @endforeach
                </select>
                <button class="rounded-md bg-gray-800 px-4 py-2 text-sm font-medium text-white">Filter</button>
            </form>

            <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-left text-xs font-medium uppercase text-gray-500">
                            <tr>
                                <th class="px-4 py-3">Kode</th>
                                <th class="px-4 py-3">Nama</th>
                                <th class="px-4 py-3">Lokasi</th>
                                <th class="px-4 py-3">Jenis Hak</th>
                                <th class="px-4 py-3">No Sertifikat</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Expired</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($properties as $property)
                                <tr>
                                    <td class="px-4 py-3 font-medium">{{ $property->property_code }}</td>
                                    <td class="px-4 py-3">{{ $property->property_name }}</td>
                                    <td class="px-4 py-3">{{ $property->city?->name }}, {{ $property->province?->name }}</td>
                                    <td class="px-4 py-3">{{ $property->certificate?->landRightType?->name }}</td>
                                    <td class="px-4 py-3">{{ $property->certificate?->certificate_number }}</td>
                                    <td class="px-4 py-3">{{ $property->utilizationStatus?->name }}</td>
                                    <td class="px-4 py-3">{{ $property->certificate?->expired_date?->format('d-m-Y') ?? '-' }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <a class="text-blue-700" href="{{ route('properties.show', $property) }}">View</a>
                                        @can('update_property')
                                            <a class="ml-3 text-gray-700" href="{{ route('properties.edit', $property) }}">Edit</a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="px-4 py-8 text-center text-gray-500">Belum ada data property.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="border-t border-gray-100 px-4 py-3">{{ $properties->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
