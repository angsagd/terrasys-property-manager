<x-app-layout>
    <x-slot name="header">
    <div class="flex items-center justify-between w-full">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Edit Lease Contract</h2>
            <p class="hidden lg:block text-sm text-gray-500 mt-1">Ubah detail kontrak sewa yang sudah ada.</p>
        </div>
    </div>
</x-slot>
    <div class="py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('lease-contracts.update', $leaseContract) }}" class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                @csrf
                @method('PUT')
                @include('lease-contracts.form', ['selectedPropertyId' => null])
            </form>
        </div>
    </div>
</x-app-layout>
