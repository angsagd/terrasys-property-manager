<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Certificate List</h2></x-slot>
    <div class="py-8"><div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-left text-xs font-medium uppercase text-gray-500"><tr><th class="px-4 py-3">Property</th><th class="px-4 py-3">Nomor</th><th class="px-4 py-3">Jenis Hak</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Expired</th><th></th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($certificates as $certificate)
                        <tr>
                            <td class="px-4 py-3">{{ $certificate->property?->property_name }}</td>
                            <td class="px-4 py-3">{{ $certificate->certificate_number }}</td>
                            <td class="px-4 py-3">{{ $certificate->landRightType?->name }}</td>
                            <td class="px-4 py-3">{{ $certificate->certificateStatus?->name }}</td>
                            <td class="px-4 py-3">{{ $certificate->expired_date?->format('d-m-Y') ?? '-' }}</td>
                            <td class="px-4 py-3 text-right"><a class="text-blue-700" href="{{ route('certificates.show', $certificate) }}">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">Belum ada sertifikat.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="border-t px-4 py-3">{{ $certificates->links() }}</div>
        </div>
    </div></div>
</x-app-layout>
