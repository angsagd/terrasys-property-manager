<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Roles & Permissions</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-5 px-4 sm:px-6 lg:px-8">
            @include('admin.partials.nav')

            @if (session('success'))
                <div class="rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
            @endif

            <div class="grid gap-6 lg:grid-cols-3">
                @foreach ($roles as $role)
                    <section class="rounded-lg border border-gray-200 bg-white shadow-sm">
                        <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
                            <h3 class="font-semibold text-gray-900">{{ $role->name }}</h3>
                            @can('update_role')
                                <a href="{{ route('admin.roles.edit', $role) }}" class="text-sm text-blue-700">Edit</a>
                            @endcan
                        </div>
                        <div class="p-5">
                            <div class="mb-2 text-sm text-gray-500">{{ $role->permissions->count() }} permissions</div>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($role->permissions->take(12) as $permission)
                                    <span class="rounded-full bg-gray-100 px-2 py-1 text-xs text-gray-700">{{ $permission->name }}</span>
                                @endforeach
                                @if ($role->permissions->count() > 12)
                                    <span class="rounded-full bg-gray-900 px-2 py-1 text-xs text-white">+{{ $role->permissions->count() - 12 }}</span>
                                @endif
                            </div>
                        </div>
                    </section>
                @endforeach
            </div>

            <section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                <h3 class="mb-4 font-semibold text-gray-900">Permission Matrix</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-left text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-3 py-2">Permission</th>
                                @foreach ($roles as $role)
                                    <th class="px-3 py-2">{{ $role->name }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($permissions->flatten() as $permission)
                                <tr>
                                    <td class="px-3 py-2 font-medium">{{ $permission->name }}</td>
                                    @foreach ($roles as $role)
                                        <td class="px-3 py-2">{{ $role->hasPermissionTo($permission->name) ? 'Ya' : '-' }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
