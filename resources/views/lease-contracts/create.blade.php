<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Tambah Lease Contract</h2></x-slot>
    <div class="py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('lease-contracts.store') }}" class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                @csrf
                @include('lease-contracts.form')
            </form>
        </div>
    </div>
</x-app-layout>
