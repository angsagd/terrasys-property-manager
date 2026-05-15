<x-app-layout>
    <x-slot name="header">
    <div class="flex items-center justify-between w-full">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Detail Lease Contract</h2>
            <p class="hidden lg:block text-sm text-gray-500 mt-1">Lihat detail lengkap dari kontrak sewa.</p>
        </div>
            <div class="flex items-center gap-3">
                @can('update_lease')
                    <a href="{{ route('lease-contracts.edit', $leaseContract) }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm text-gray-700">Ubah</a>
                @endcan
                @can('delete_lease')
                    <form method="POST" action="{{ route('lease-contracts.destroy', $leaseContract) }}" onsubmit="return confirm('Hapus kontrak sewa ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="rounded-md bg-red-700 px-4 py-2 text-sm font-medium text-white">Hapus</button>
                    </form>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-5 px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
            @endif

            <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                <div class="grid gap-4 md:grid-cols-3">
                    <div>
                        <div class="text-xs font-medium uppercase text-gray-500">Properti</div>
                        <a href="{{ route('properties.show', $leaseContract->property) }}" class="mt-1 block text-sm font-medium text-blue-700">{{ $leaseContract->property?->property_name }}</a>
                        <div class="text-xs text-gray-500">{{ $leaseContract->property?->property_code }} · {{ $leaseContract->property?->city?->name }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-medium uppercase text-gray-500">Jenis Sewa</div>
                        <div class="mt-1 text-sm text-gray-900">{{ $leaseContract->leaseType?->name }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-medium uppercase text-gray-500">Status Kontrak</div>
                        <div class="mt-1 text-sm text-gray-900">{{ $leaseContract->leaseStatus?->name }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-medium uppercase text-gray-500">Pihak Lawan</div>
                        <div class="mt-1 text-sm text-gray-900">{{ $leaseContract->counterparty_name }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-medium uppercase text-gray-500">Nomor Perjanjian</div>
                        <div class="mt-1 text-sm text-gray-900">{{ $leaseContract->agreement_number ?: '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-medium uppercase text-gray-500">Tanggal Perjanjian</div>
                        <div class="mt-1 text-sm text-gray-900">{{ $leaseContract->agreement_date?->format('d-m-Y') ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-medium uppercase text-gray-500">Periode</div>
                        <div class="mt-1 text-sm text-gray-900">{{ $leaseContract->start_date?->format('d-m-Y') }} sampai {{ $leaseContract->end_date?->format('d-m-Y') }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-medium uppercase text-gray-500">Nilai Sewa</div>
                        <div class="mt-1 text-sm text-gray-900">Rp {{ number_format($leaseContract->rental_value, 0, ',', '.') }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-medium uppercase text-gray-500">Reminder Date</div>
                        <div class="mt-1 text-sm text-gray-900">{{ $leaseContract->reminder_date?->format('d-m-Y') ?? '-' }}</div>
                    </div>
                    <div class="md:col-span-3">
                        <div class="text-xs font-medium uppercase text-gray-500">Alamat Pihak Lawan</div>
                        <div class="mt-1 text-sm text-gray-900">{{ $leaseContract->counterparty_address ?: '-' }}</div>
                    </div>
                    <div class="md:col-span-3">
                        <div class="text-xs font-medium uppercase text-gray-500">Catatan</div>
                        <div class="mt-1 text-sm text-gray-900">{{ $leaseContract->notes ?: '-' }}</div>
                    </div>
                </div>
            </section>

            <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900">Dokumen Lease</h3>
                    @can('upload_document')
                        <a href="{{ route('documents.create', ['lease_contract_id' => $leaseContract->id]) }}" class="text-sm text-blue-700">Upload Dokumen</a>
                    @endcan
                </div>
                <div class="divide-y divide-gray-100 text-sm">
                    @forelse ($leaseContract->documents as $document)
                        <div class="flex items-center justify-between gap-4 py-3">
                            <div>
                                <div class="font-medium text-gray-900">{{ $document->document_name }}</div>
                                <div class="text-xs text-gray-500">{{ $document->category?->name }} · {{ $document->document_number ?: '-' }}</div>
                            </div>
                            <a href="{{ route('documents.download', $document) }}" class="text-blue-700">Unduh</a>
                        </div>
                    @empty
                        <p class="text-gray-500">Belum ada dokumen lease.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
