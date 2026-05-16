<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">Dokumen</h2>
                <p class="hidden lg:block text-sm text-gray-500 mt-1">Repositori terpusat untuk semua berkas dan dokumen properti.</p>
            </div>
            @can('upload_document')
                <a href="{{ route('documents.create') }}" class="inline-flex items-center rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-brand-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-500 transition-all">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 3a.75.75 0 01.75.75v10.638l3.96-4.158a.75.75 0 111.08 1.04l-5.25 5.5a.75.75 0 01-1.08 0l-5.25-5.5a.75.75 0 111.08-1.04l3.96 4.158V3.75A.75.75 0 0110 3z" clip-rule="evenodd" /></svg>
                    Upload Document
                </a>
            @endcan
        </div>
    </x-slot>
    <div class="py-8"><div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @if (session('success'))<div class="mb-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>@endif
        <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-left text-xs font-medium uppercase text-gray-500"><tr><th class="px-4 py-3">Nama</th><th class="px-4 py-3">Kategori</th><th class="px-4 py-3">Properti</th><th class="px-4 py-3">Kedaluwarsa</th><th></th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($documents as $document)
                        <tr><td class="px-4 py-3">{{ $document->document_name }}</td><td class="px-4 py-3">{{ $document->category?->name }}</td><td class="px-4 py-3">{{ $document->property?->property_name }}</td><td class="px-4 py-3">{{ $document->expired_date?->format('d-m-Y') ?? '-' }}</td><td class="px-4 py-3 text-right"><a class="text-blue-700" href="{{ route('documents.download', $document) }}">Unduh</a></td></tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada dokumen.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="border-t px-4 py-3">{{ $documents->links() }}</div>
        </div>
    </div></div>
</x-app-layout>
