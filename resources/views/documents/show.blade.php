<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">{{ $document->document_name }}</h2></x-slot>
    <div class="py-8"><div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm text-sm">
            <p>Kategori: <strong>{{ $document->category?->name }}</strong></p>
            <p>File: <a class="text-blue-700" href="{{ route('documents.download', $document) }}">{{ $document->file_name }}</a></p>
        </div>
    </div></div>
</x-app-layout>
