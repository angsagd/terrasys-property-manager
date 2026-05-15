<x-app-layout>
    <x-slot name="header">
    <div class="flex items-center justify-between w-full">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">{{ $user ? 'Edit User' : 'Tambah User' }}</h2>
            <p class="hidden lg:block text-sm text-gray-500 mt-1">Create or update system user details.</p>
        </div>
    </div>
</x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl space-y-5 px-4 sm:px-6 lg:px-8">
            @include('admin.partials.nav')

            <form method="POST" action="{{ $user ? route('admin.users.update', $user) : route('admin.users.store') }}" class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                @csrf
                @if ($user)
                    @method('PUT')
                @endif

                @if ($errors->any())
                    <div class="mb-4 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        <div class="font-medium">Periksa kembali input user.</div>
                        <ul class="mt-2 list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid gap-4 md:grid-cols-2">
                    <label class="text-sm">Nama *
                        <input name="name" value="{{ old('name', $user?->name) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm" required>
                    </label>
                    <label class="text-sm">Email *
                        <input type="email" name="email" value="{{ old('email', $user?->email) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm" required>
                    </label>
                    <label class="text-sm">Password {{ $user ? '(kosongkan jika tidak diubah)' : '*' }}
                        <input type="password" name="password" class="mt-1 w-full rounded-md border-gray-300 text-sm" @required(! $user)>
                    </label>
                    <label class="text-sm">Konfirmasi Password
                        <input type="password" name="password_confirmation" class="mt-1 w-full rounded-md border-gray-300 text-sm" @required(! $user)>
                    </label>
                    <div class="md:col-span-2">
                        <div class="mb-2 text-sm font-medium text-gray-700">Role *</div>
                        <div class="grid gap-2 md:grid-cols-3">
                            @foreach ($roles as $role)
                                <label class="flex items-center gap-2 rounded-md border border-gray-200 px-3 py-2 text-sm">
                                    <input type="checkbox" name="roles[]" value="{{ $role->name }}" class="rounded border-gray-300" @checked(in_array($role->name, old('roles', $user?->roles->pluck('name')->all() ?? []), true))>
                                    {{ $role->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300" @checked(old('is_active', $user?->is_active ?? true)) @disabled($user && auth()->user()->is($user))>
                        Aktif
                    </label>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('admin.users.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm">Batal</a>
                    <button class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
