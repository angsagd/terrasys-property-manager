<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3 w-full">
            <a href="{{ route('certificates.index') }}" class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white text-gray-400 hover:text-gray-500 shadow-sm ring-1 ring-inset ring-gray-300 transition-all">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            </a>
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Sertifikat {{ $certificate->certificate_number }}</h2>
                    <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20">{{ $certificate->certificateStatus?->name }}</span>
                </div>
                <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                    {{ $certificate->landRightType?->name }} Document Details
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200/50">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-base font-semibold leading-6 text-gray-900">Informasi Lengkap Sertifikat</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Legal details and related property association.</p>
                </div>
                <div class="px-6 py-5">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 flex items-center gap-2">
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" /></svg>
                                Linked Property
                            </dt>
                            <dd class="mt-2 text-sm text-gray-900">
                                @if($certificate->property)
                                    <a class="font-semibold text-brand-600 hover:text-brand-500 underline decoration-brand-200 decoration-2 underline-offset-2 transition-colors" href="{{ route('properties.show', $certificate->property) }}">
                                        {{ $certificate->property->property_name }}
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">Not linked to any property</span>
                                @endif
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Jenis Hak / Tipe</dt>
                            <dd class="mt-2 text-sm text-gray-900">{{ $certificate->landRightType?->name ?? '-' }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Tanggal Terbit</dt>
                            <dd class="mt-2 text-sm text-gray-900">{{ $certificate->issued_date?->format('d M Y') ?? '-' }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Tanggal Berakhir (Expired Date)</dt>
                            <dd class="mt-2 text-sm font-semibold {{ $certificate->expired_date?->isPast() ? 'text-rose-600' : 'text-gray-900' }}">
                                {{ $certificate->expired_date?->format('d M Y') ?? '-' }}
                            </dd>
                        </div>
                        <div class="sm:col-span-2 pt-4 border-t border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 mb-2">Catatan Legal Khusus</dt>
                            <dd class="text-sm text-gray-900 rounded-xl bg-gray-50 p-4 border border-gray-100 min-h-[4rem]">
                                {{ $certificate->legal_notes ?: 'Tidak ada catatan legal tambahan yang tersimpan untuk sertifikat ini.' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
