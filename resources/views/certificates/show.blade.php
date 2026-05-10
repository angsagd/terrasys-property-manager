<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Sertifikat {{ $certificate->certificate_number }}</h2></x-slot>
    <div class="py-8"><div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <dl class="grid gap-4 text-sm md:grid-cols-2">
                <div><dt class="text-gray-500">Property</dt><dd><a class="font-medium text-blue-700" href="{{ route('properties.show', $certificate->property) }}">{{ $certificate->property?->property_name }}</a></dd></div>
                <div><dt class="text-gray-500">Jenis Hak</dt><dd class="font-medium">{{ $certificate->landRightType?->name }}</dd></div>
                <div><dt class="text-gray-500">Status</dt><dd class="font-medium">{{ $certificate->certificateStatus?->name }}</dd></div>
                <div><dt class="text-gray-500">Tanggal Berakhir</dt><dd class="font-medium">{{ $certificate->expired_date?->format('d-m-Y') ?? '-' }}</dd></div>
                <div class="md:col-span-2"><dt class="text-gray-500">Catatan Legal</dt><dd class="font-medium">{{ $certificate->legal_notes ?: '-' }}</dd></div>
            </dl>
        </div>
    </div></div>
</x-app-layout>
