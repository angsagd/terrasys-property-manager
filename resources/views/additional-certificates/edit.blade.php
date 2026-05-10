<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Edit Additional Certificate</h2></x-slot>
    <div class="py-8"><div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8"><form method="POST" action="{{ route('additional-certificates.update', $additionalCertificate) }}" class="rounded-lg border bg-white p-5 shadow-sm">@csrf @method('PUT') @include('additional-certificates.form')</form></div></div>
</x-app-layout>
