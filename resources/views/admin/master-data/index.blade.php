<x-app-layout>
    <x-slot name="header">
    <div class="flex items-center justify-between w-full">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Master Data</h2>
            <p class="hidden lg:block text-sm text-gray-500 mt-1">Kelola data referensi inti di seluruh sistem.</p>
        </div>
    </div>
</x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @include('admin.partials.nav')

            @if (session('success'))
                <div class="rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
            @endif

            <div class="grid gap-6 lg:grid-cols-2">
                @foreach ($groups as $group)
                    <section class="rounded-lg border border-gray-200 bg-white shadow-sm">
                        <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
                            <h3 class="font-semibold text-gray-900">{{ $group['title'] }}</h3>
                            @can('create_master_data')
                                <a href="{{ route('admin.master-data.create', $group['type']) }}" class="rounded-md bg-gray-900 px-3 py-2 text-xs font-medium text-white">Tambah</a>
                            @endcan
                        </div>
                        <div class="divide-y divide-gray-100">
                            @forelse ($group['items'] as $item)
                                <div class="flex items-center justify-between gap-4 px-5 py-3 text-sm">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $item->name }}</div>
                                        <div class="mt-1 text-xs text-gray-500">
                                            @isset($item->code) Kode: {{ $item->code ?: '-' }} · @endisset
                                            @isset($item->color) Warna: {{ $item->color ?: '-' }} · @endisset
                                            @isset($item->is_active) {{ $item->is_active ? 'Aktif' : 'Nonaktif' }} @endisset
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        @can('update_master_data')
                                            <a class="text-blue-700" href="{{ route('admin.master-data.edit', [$group['type'], $item]) }}">Ubah</a>
                                        @endcan
                                        @can('delete_master_data')
                                            <form method="POST" action="{{ route('admin.master-data.destroy', [$group['type'], $item]) }}" onsubmit="return confirm('Hapus master data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-700">Hapus</button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            @empty
                                <p class="px-5 py-6 text-sm text-gray-500">Belum ada data.</p>
                            @endforelse
                        </div>
                    </section>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
