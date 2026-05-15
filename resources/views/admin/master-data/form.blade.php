<x-app-layout>
    <x-slot name="header">
    <div class="flex items-center justify-between w-full">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">{{ $item ? 'Edit' : 'Tambah' }} {{ $definition['title'] }}</h2>
            <p class="hidden lg:block text-sm text-gray-500 mt-1">Buat atau perbarui entri master data.</p>
        </div>
    </div>
</x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl space-y-5 px-4 sm:px-6 lg:px-8">
            @include('admin.partials.nav')

            <form method="POST" action="{{ $item ? route('admin.master-data.update', [$type, $item]) : route('admin.master-data.store', $type) }}" class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                @csrf
                @if ($item)
                    @method('PUT')
                @endif

                @if ($errors->any())
                    <div class="mb-4 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="grid gap-4 md:grid-cols-2">
                    <label class="text-sm md:col-span-2">Nama *
                        <input name="name" value="{{ old('name', $item?->name) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm" required>
                    </label>

                    @if (in_array('code', $definition['fields'], true))
                        <label class="text-sm">Kode
                            <input name="code" value="{{ old('code', $item?->code) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm">
                        </label>
                    @endif

                    @if (in_array('color', $definition['fields'], true))
                        <label class="text-sm">Warna
                            <input name="color" value="{{ old('color', $item?->color) }}" placeholder="green, red, #16a34a" class="mt-1 w-full rounded-md border-gray-300 text-sm">
                        </label>
                    @endif

                    @if (in_array('description', $definition['fields'], true))
                        <label class="text-sm md:col-span-2">Deskripsi
                            <textarea name="description" rows="3" class="mt-1 w-full rounded-md border-gray-300 text-sm">{{ old('description', $item?->description) }}</textarea>
                        </label>
                    @endif

                    @if (in_array('has_expiry', $definition['fields'], true))
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" name="has_expiry" value="1" class="rounded border-gray-300" @checked(old('has_expiry', $item?->has_expiry ?? true))>
                            Memiliki tanggal berakhir
                        </label>
                    @endif

                    @if (in_array('is_active', $definition['fields'], true))
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300" @checked(old('is_active', $item?->is_active ?? true))>
                            Aktif
                        </label>
                    @endif
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('admin.master-data.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm">Batal</a>
                    <button class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
