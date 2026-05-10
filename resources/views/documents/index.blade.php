<x-app-layout>
    <x-slot name="header"><div class="flex items-center justify-between"><h2 class="text-xl font-semibold text-gray-800">Documents</h2>@can('upload_document')<a href="{{ route('documents.create') }}" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white">Upload</a>@endcan</div></x-slot>
    <div class="py-8"><div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @if (session('success'))<div class="mb-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>@endif
        <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-left text-xs font-medium uppercase text-gray-500"><tr><th class="px-4 py-3">Nama</th><th class="px-4 py-3">Kategori</th><th class="px-4 py-3">Property</th><th class="px-4 py-3">Expired</th><th></th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($documents as $document)
                        <tr><td class="px-4 py-3">{{ $document->document_name }}</td><td class="px-4 py-3">{{ $document->category?->name }}</td><td class="px-4 py-3">{{ $document->property?->property_name }}</td><td class="px-4 py-3">{{ $document->expired_date?->format('d-m-Y') ?? '-' }}</td><td class="px-4 py-3 text-right"><a class="text-blue-700" href="{{ route('documents.download', $document) }}">Download</a></td></tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada dokumen.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="border-t px-4 py-3">{{ $documents->links() }}</div>
        </div>
    </div></div>
</x-app-layout>
