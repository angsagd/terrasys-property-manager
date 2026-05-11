<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-xl font-semibold text-gray-800">User Management</h2>
            @can('create_user')
                <a href="{{ route('admin.users.create') }}" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white">Tambah User</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-5 px-4 sm:px-6 lg:px-8">
            @include('admin.partials.nav')

            @if (session('success'))
                <div class="rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
            @endif

            <form class="grid gap-3 rounded-lg border border-gray-200 bg-white p-4 shadow-sm md:grid-cols-5">
                <input name="search" value="{{ request('search') }}" placeholder="Cari nama/email" class="rounded-md border-gray-300 text-sm md:col-span-2">
                <select name="role" class="rounded-md border-gray-300 text-sm">
                    <option value="">Semua Role</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" @selected(request('role') === $role->name)>{{ $role->name }}</option>
                    @endforeach
                </select>
                <select name="is_active" class="rounded-md border-gray-300 text-sm">
                    <option value="">Semua Status</option>
                    <option value="1" @selected(request('is_active') === '1')>Aktif</option>
                    <option value="0" @selected(request('is_active') === '0')>Nonaktif</option>
                </select>
                <button class="rounded-md bg-gray-800 px-4 py-2 text-sm font-medium text-white">Filter</button>
            </form>

            <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-left text-xs font-medium uppercase text-gray-500">
                            <tr>
                                <th class="px-4 py-3">Nama</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Role</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Last Login</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($users as $user)
                                <tr>
                                    <td class="px-4 py-3 font-medium text-gray-900">{{ $user->name }}</td>
                                    <td class="px-4 py-3">{{ $user->email }}</td>
                                    <td class="px-4 py-3">{{ $user->roles->pluck('name')->join(', ') ?: '-' }}</td>
                                    <td class="px-4 py-3">
                                        <span class="rounded-full px-2 py-1 text-xs font-medium {{ $user->is_active ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">{{ $user->last_login_at?->format('d-m-Y H:i') ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex justify-end gap-3">
                                            @can('update_user')
                                                <a class="text-blue-700" href="{{ route('admin.users.edit', $user) }}">Edit</a>
                                                @unless (auth()->user()->is($user))
                                                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}">
                                                        @csrf
                                                        <button class="text-gray-700">{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                                                    </form>
                                                @endunless
                                            @endcan
                                            @can('delete_user')
                                                @unless (auth()->user()->is($user))
                                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus user ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="text-red-700">Hapus</button>
                                                    </form>
                                                @endunless
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">Belum ada user.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="border-t border-gray-100 px-4 py-3">{{ $users->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
