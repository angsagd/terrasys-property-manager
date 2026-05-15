<x-app-layout>
    <x-slot name="header">
    <div class="flex items-center justify-between w-full">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Tambah Property</h2>
            <p class="hidden lg:block text-sm text-gray-500 mt-1">Add a new property to your portfolio.</p>
        </div>
    </div>
</x-slot>
    <div class="py-8"><div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('properties.store') }}" class="space-y-6">
            @csrf
            @include('properties.partials.form', ['property' => null])
            <div class="flex justify-end gap-3">
                <a href="{{ route('properties.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm">Batal</a>
                <button class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white">Simpan</button>
            </div>
        </form>
    </div></div>
</x-app-layout>
