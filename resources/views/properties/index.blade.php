<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">Properties Portfolio</h2>
                <p class="hidden lg:block text-sm text-gray-500 mt-1">Manage and view all your company's properties and certificates.</p>
            </div>
            @can('create_property')
                <a href="{{ route('properties.create') }}" class="inline-flex items-center rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-brand-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-500 transition-all">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" /></svg>
                    New Property
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 flex items-center gap-2">
                    <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filters -->
            <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-gray-200/50">
                <form class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                        </div>
                        <input name="search" value="{{ request('search') }}" placeholder="Search code or name..." class="block w-full rounded-xl border-0 py-2.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-500 sm:text-sm sm:leading-6 transition-shadow">
                    </div>
                    <select name="province_id" class="rounded-xl border-0 py-2.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-brand-500 sm:text-sm sm:leading-6 sm:w-48 transition-shadow">
                        <option value="">All Provinces</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}" @selected(request('province_id') == $province->id)>{{ $province->name }}</option>
                        @endforeach
                    </select>
                    <select name="property_type_id" class="rounded-xl border-0 py-2.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-brand-500 sm:text-sm sm:leading-6 sm:w-40 transition-shadow">
                        <option value="">Semua Jenis</option>
                        @foreach ($propertyTypes as $type)
                            <option value="{{ $type->id }}" @selected(request('property_type_id') == $type->id)>{{ $type->name }}</option>
                        @endforeach
                    </select>
                    <select name="utilization_status_id" class="rounded-xl border-0 py-2.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-brand-500 sm:text-sm sm:leading-6 sm:w-40 transition-shadow">
                        <option value="">Semua Status</option>
                        @foreach ($utilizationStatuses as $status)
                            <option value="{{ $status->id }}" @selected(request('utilization_status_id') == $status->id)>{{ $status->name }}</option>
                        @endforeach
                    </select>
                    <button class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-gray-800 transition-colors sm:w-auto">
                        Apply Filters
                    </button>
                </form>
            </div>

            <!-- Table -->
            <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200/50">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left font-semibold text-gray-900 sm:pl-6">Properti</th>
                                <th scope="col" class="px-3 py-3.5 text-left font-semibold text-gray-900">Lokasi</th>
                                <th scope="col" class="px-3 py-3.5 text-left font-semibold text-gray-900">Certificate</th>
                                <th scope="col" class="px-3 py-3.5 text-left font-semibold text-gray-900">Status</th>
                                <th scope="col" class="px-3 py-3.5 text-left font-semibold text-gray-900">Expiry</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6"><span class="sr-only">Aksi</span></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($properties as $property)
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 sm:pl-6">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0 rounded-xl bg-gray-100 flex items-center justify-center text-gray-500">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" /></svg>
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-medium text-gray-900 group-hover:text-brand-600 transition-colors">
                                                    {{ $property->property_name }}
                                                </div>
                                                <div class="text-gray-500 text-xs mt-0.5">{{ $property->property_code }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-gray-500">
                                        {{ $property->city?->name }}<br>
                                        <span class="text-xs text-gray-400">{{ $property->province?->name }}</span>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-gray-500">
                                        <div class="font-medium text-gray-700">{{ $property->certificate?->certificate_number ?? '-' }}</div>
                                        <div class="text-xs">{{ $property->certificate?->landRightType?->name }}</div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4">
                                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                            {{ $property->utilizationStatus?->name }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-gray-500">
                                        @if($property->certificate?->expired_date)
                                            <span class="{{ $property->certificate->expired_date->isPast() ? 'text-rose-600 font-medium' : '' }}">
                                                {{ $property->certificate->expired_date->format('d M Y') }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="{{ route('properties.show', $property) }}" class="text-gray-400 hover:text-brand-600 transition-colors" title="View Details">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                            </a>
                                            @can('update_property')
                                                <a href="{{ route('properties.edit', $property) }}" class="text-gray-400 hover:text-blue-600 transition-colors" title="Edit Property">
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                                                </a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zm3.75 11.625a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                                        <h3 class="mt-2 text-sm font-semibold text-gray-900">Properti tidak ditemukan</h3>
                                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new property record.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($properties->hasPages())
                <div class="border-t border-gray-100 bg-gray-50/50 px-4 py-3 sm:px-6">
                    {{ $properties->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
