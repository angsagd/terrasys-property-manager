<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Edit Property</h2></x-slot>
    <div class="py-8"><div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('properties.update', $property) }}" class="space-y-6">
            @csrf
            @method('PUT')
            @include('properties.partials.form', ['property' => $property])
            <div class="flex justify-end gap-3">
                <a href="{{ route('properties.show', $property) }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm">Batal</a>
                <button class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white">Simpan Perubahan</button>
            </div>
        </form>
    </div></div>
</x-app-layout>
