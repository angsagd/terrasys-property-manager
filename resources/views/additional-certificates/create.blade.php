<x-app-layout>
    <x-slot name="header">
    <div class="flex items-center justify-between w-full">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Tambah Additional Certificate</h2>
            <p class="hidden lg:block text-sm text-gray-500 mt-1">Tambahkan dokumen pendukung tambahan baru.</p>
        </div>
    </div>
</x-slot>
    <div class="py-8"><div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8"><form method="POST" action="{{ route('additional-certificates.store') }}" class="rounded-lg border bg-white p-5 shadow-sm">@csrf @include('additional-certificates.form', ['additionalCertificate' => null])</form></div></div>
</x-app-layout>
