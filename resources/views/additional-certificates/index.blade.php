<x-app-layout>
    <x-slot name="header">
    <div class="flex items-center justify-between w-full">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Additional Certificates</h2>
            <p class="hidden lg:block text-sm text-gray-500 mt-1">Kelola dokumen atau sertifikat pendukung tambahan.</p>
        </div>@can('create_additional_certificate')<a href="{{ route('additional-certificates.create') }}" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white">Tambah</a>@endcan</div></x-slot>
    <div class="py-8"><div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @if (session('success'))<div class="mb-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>@endif
        <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-left text-xs font-medium uppercase text-gray-500"><tr><th class="px-4 py-3">Properti</th><th class="px-4 py-3">Nomor</th><th class="px-4 py-3">Jenis</th><th class="px-4 py-3">Kedaluwarsa</th><th></th></tr></thead>
                <tbody class="divide-y divide-gray-100">@forelse($additionalCertificates as $item)<tr><td class="px-4 py-3">{{ $item->property?->property_name }}</td><td class="px-4 py-3">{{ $item->document_number }}</td><td class="px-4 py-3">{{ $item->landRightType?->name ?? $item->document_type }}</td><td class="px-4 py-3">{{ $item->expired_date?->format('d-m-Y') ?? '-' }}</td><td class="px-4 py-3 text-right"><a class="text-blue-700" href="{{ route('additional-certificates.edit', $item) }}">Ubah</a></td></tr>@empty<tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada data.</td></tr>@endforelse</tbody>
            </table>
            <div class="border-t px-4 py-3">{{ $additionalCertificates->links() }}</div>
        </div>
    </div></div>
</x-app-layout>
