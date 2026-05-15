<x-app-layout>
    <x-slot name="header">
    <div class="flex items-center justify-between w-full">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Edit Role: {{ $role->name }}</h2>
            <p class="hidden lg:block text-sm text-gray-500 mt-1">Konfigurasi hak akses (permissions) untuk peran spesifik ini.</p>
        </div>
    </div>
</x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-5xl space-y-5 px-4 sm:px-6 lg:px-8">
            @include('admin.partials.nav')

            <form method="POST" action="{{ route('admin.roles.update', $role) }}" class="space-y-6 rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">{{ $errors->first() }}</div>
                @endif

                <div class="grid gap-6 md:grid-cols-2">
                    @foreach ($permissions as $group => $items)
                        <section class="rounded-lg border border-gray-200 p-4">
                            <h3 class="mb-3 font-semibold capitalize text-gray-900">{{ str_replace('_', ' ', $group) }}</h3>
                            <div class="space-y-2">
                                @foreach ($items as $permission)
                                    <label class="flex items-center gap-2 text-sm">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="rounded border-gray-300" @checked(in_array($permission->name, old('permissions', $role->permissions->pluck('name')->all()), true))>
                                        {{ $permission->name }}
                                    </label>
                                @endforeach
                            </div>
                        </section>
                    @endforeach
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.roles.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm">Batal</a>
                    <button class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white">Simpan Permission</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
