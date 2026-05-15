<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">Dashboard</h2>
                <p class="hidden lg:block text-sm text-gray-500 mt-1">Welcome back, {{ Auth::user()->name }}! Here's what's happening with your properties.</p>
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
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-8">
            @if (session('success'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 flex items-center gap-2">
                    <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Key Metrics -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    ['Total Property', number_format($totalProperties), 'bg-blue-50 text-blue-600'],
                    ['Total Sertifikat', number_format($totalCertificates), 'bg-indigo-50 text-indigo-600'],
                    ['Luas Tanah', number_format($totalLandArea, 2).' m²', 'bg-emerald-50 text-emerald-600'],
                    ['Nilai Sewa', 'Rp '.number_format($totalRentalValue, 0, ',', '.'), 'bg-brand-50 text-brand-600'],
                ] as $metric)
                    <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200/50 hover:shadow-md transition-shadow group">
                        <dt>
                            <div class="absolute rounded-xl {{ $metric[2] }} p-3 top-6 left-6">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" /></svg>
                            </div>
                            <p class="ml-16 truncate text-sm font-medium text-gray-500">{{ $metric[0] }}</p>
                        </dt>
                        <dd class="ml-16 flex items-baseline pb-1 sm:pb-2">
                            <p class="text-2xl font-bold text-gray-900">{{ $metric[1] }}</p>
                        </dd>
                    </div>
                @endforeach
            </div>

            <!-- Alerts & Main Content -->
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                
                <!-- Main Portfolio Table -->
                <div class="lg:col-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900 tracking-tight">Recent Properties</h3>
                        <a href="{{ route('properties.index') }}" class="text-sm font-medium text-brand-600 hover:text-brand-500">View all &rarr;</a>
                    </div>
                    <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200/50">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50/50">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left font-semibold text-gray-900 sm:pl-6">Property Details</th>
                                        <th scope="col" class="px-3 py-3.5 text-left font-semibold text-gray-900">Location</th>
                                        <th scope="col" class="px-3 py-3.5 text-left font-semibold text-gray-900">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white">
                                    @forelse ($recentProperties as $property)
                                        <tr class="hover:bg-gray-50/50 transition-colors group">
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 sm:pl-6">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 flex-shrink-0 rounded-xl bg-gray-100 flex items-center justify-center text-gray-500">
                                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" /></svg>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="font-medium text-gray-900 group-hover:text-brand-600 transition-colors">
                                                            <a href="{{ route('properties.show', $property) }}">{{ $property->property_name }}</a>
                                                        </div>
                                                        <div class="text-gray-500 text-xs mt-0.5">{{ $property->property_code }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-gray-500">
                                                {{ $property->city?->name }}<br>
                                                <span class="text-xs text-gray-400">{{ $property->province?->name }}</span>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4">
                                                <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                                    {{ $property->utilizationStatus?->name }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="py-10 text-center text-gray-500">Belum ada data property.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Alerts & Sidebar Widgets -->
                <div class="space-y-8">
                    
                    <!-- Actionable Alerts -->
                    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-gray-200/50 p-6">
                        <h3 class="text-lg font-bold text-gray-900 tracking-tight mb-4 flex items-center gap-2">
                            <svg class="h-5 w-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" /></svg>
                            Key Alerts
                        </h3>
                        <ul class="space-y-3">
                            <li class="flex items-center justify-between rounded-xl bg-orange-50/50 p-3 ring-1 ring-orange-200/50">
                                <span class="text-sm font-medium text-orange-800">Sertifikat Expired</span>
                                <span class="inline-flex items-center justify-center rounded-full bg-orange-100 px-2.5 py-0.5 text-sm font-bold text-orange-700">{{ $expiringCertificates }}</span>
                            </li>
                            <li class="flex items-center justify-between rounded-xl bg-rose-50/50 p-3 ring-1 ring-rose-200/50">
                                <span class="text-sm font-medium text-rose-800">Lease Expired</span>
                                <span class="inline-flex items-center justify-center rounded-full bg-rose-100 px-2.5 py-0.5 text-sm font-bold text-rose-700">{{ $expiringLeases }}</span>
                            </li>
                            <li class="flex items-center justify-between rounded-xl bg-yellow-50/50 p-3 ring-1 ring-yellow-200/50">
                                <span class="text-sm font-medium text-yellow-800">Dokumen Expired</span>
                                <span class="inline-flex items-center justify-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-sm font-bold text-yellow-700">{{ $expiringDocuments }}</span>
                            </li>
                            <li class="flex items-center justify-between rounded-xl bg-gray-50/50 p-3 ring-1 ring-gray-200/50">
                                <span class="text-sm font-medium text-gray-700">Property Idle</span>
                                <span class="inline-flex items-center justify-center rounded-full bg-gray-200 px-2.5 py-0.5 text-sm font-bold text-gray-800">{{ $idleCount }}</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Assets by Region -->
                    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-gray-200/50 p-6">
                        <h3 class="text-lg font-bold text-gray-900 tracking-tight mb-4">Aset per Provinsi</h3>
                        <div class="space-y-4">
                            @forelse ($propertiesByProvince as $row)
                                <div>
                                    <div class="flex items-center justify-between text-sm mb-1">
                                        <span class="font-medium text-gray-700">{{ $row->province?->name ?? '-' }}</span>
                                        <span class="font-semibold text-gray-900">{{ $row->total }}</span>
                                    </div>
                                    <div class="overflow-hidden rounded-full bg-gray-100 h-1.5">
                                        <div class="h-1.5 rounded-full bg-brand-500" style="width: {{ min(100, ($row->total / max(1, $totalProperties)) * 100) }}%"></div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">Belum ada data.</p>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
