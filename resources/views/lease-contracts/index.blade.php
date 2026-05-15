<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">Lease Management</h2>
                <p class="hidden lg:block text-sm text-gray-500 mt-1">Manage all your property lease contracts.</p>
            </div>
            @can('create_lease')
                <a href="{{ route('lease-contracts.create') }}" class="inline-flex items-center rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-brand-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-500 transition-all">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" /></svg>
                    New Lease
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-5 px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
            @endif

            <form method="GET" class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                <div class="grid gap-3 md:grid-cols-5">
                    <input name="search" value="{{ request('search') }}" placeholder="Search property, pihak lawan, nomor" class="rounded-md border-gray-300 text-sm md:col-span-2">
                    <select name="lease_type_id" class="rounded-md border-gray-300 text-sm">
                        <option value="">Semua Jenis Sewa</option>
                        @foreach ($leaseTypes as $leaseType)
                            <option value="{{ $leaseType->id }}" @selected(request('lease_type_id') == $leaseType->id)>{{ $leaseType->name }}</option>
                        @endforeach
                    </select>
                    <select name="lease_status_id" class="rounded-md border-gray-300 text-sm">
                        <option value="">Semua Status</option>
                        @foreach ($leaseStatuses as $leaseStatus)
                            <option value="{{ $leaseStatus->id }}" @selected(request('lease_status_id') == $leaseStatus->id)>{{ $leaseStatus->name }}</option>
                        @endforeach
                    </select>
                    <button class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white">Filter</button>
                </div>
                <div class="mt-3 grid gap-3 md:grid-cols-3">
                    <label class="text-xs font-medium uppercase text-gray-500">Mulai Dari
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="mt-1 w-full rounded-md border-gray-300 text-sm">
                    </label>
                    <label class="text-xs font-medium uppercase text-gray-500">Selesai Sampai
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="mt-1 w-full rounded-md border-gray-300 text-sm">
                    </label>
                    <div class="flex items-end">
                        <a href="{{ route('lease-contracts.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm text-gray-700">Reset</a>
                    </div>
                </div>
            </form>

            <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-left text-xs font-medium uppercase text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Property</th>
                            <th class="px-4 py-3">Jenis Sewa</th>
                            <th class="px-4 py-3">Pihak Lawan</th>
                            <th class="px-4 py-3">Periode</th>
                            <th class="px-4 py-3">Nilai Sewa</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($leaseContracts as $leaseContract)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ $leaseContract->property?->property_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $leaseContract->property?->property_code }} · {{ $leaseContract->property?->city?->name }}</div>
                                </td>
                                <td class="px-4 py-3">{{ $leaseContract->leaseType?->name }}</td>
                                <td class="px-4 py-3">{{ $leaseContract->counterparty_name }}</td>
                                <td class="px-4 py-3">{{ $leaseContract->start_date?->format('d-m-Y') }} sampai {{ $leaseContract->end_date?->format('d-m-Y') }}</td>
                                <td class="px-4 py-3">Rp {{ number_format($leaseContract->rental_value, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">{{ $leaseContract->leaseStatus?->name }}</td>
                                <td class="px-4 py-3 text-right">
                                    <a class="text-blue-700" href="{{ route('lease-contracts.show', $leaseContract) }}">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-4 py-8 text-center text-gray-500">Belum ada kontrak sewa.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="border-t px-4 py-3">{{ $leaseContracts->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
