<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">Peran & Hak Akses</h2>
                <p class="hidden lg:block text-sm text-gray-500 mt-1">Kelola peran pengguna dan daftar kontrol akses.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
            @include('admin.partials.nav')

            @if (session('success'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 flex items-center gap-2">
                    <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-3">
                @foreach ($roles as $role)
                    <section class="rounded-2xl bg-white shadow-sm ring-1 ring-gray-200/50 hover:shadow-md transition-shadow group flex flex-col">
                        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4 bg-gray-50/50 rounded-t-2xl">
                            <h3 class="font-bold text-gray-900 flex items-center gap-2">
                                <svg class="h-5 w-5 text-brand-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
                                {{ $role->name }}
                            </h3>
                            @can('update_role')
                                <a href="{{ route('admin.roles.edit', $role) }}" class="text-gray-400 hover:text-brand-600 transition-colors" title="Edit Role">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                                </a>
                            @endcan
                        </div>
                        <div class="p-6 flex-1">
                            <div class="mb-3 text-sm font-medium text-gray-500">{{ $role->permissions->count() }} active permissions</div>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($role->permissions->take(12) as $permission)
                                    <span class="inline-flex items-center rounded-md bg-gray-100 px-2 py-1 text-xs font-medium text-gray-600">{{ $permission->name }}</span>
                                @endforeach
                                @if ($role->permissions->count() > 12)
                                    <span class="inline-flex items-center rounded-md bg-brand-50 px-2 py-1 text-xs font-medium text-brand-700 ring-1 ring-inset ring-brand-600/20">+{{ $role->permissions->count() - 12 }} lainnya</span>
                                @endif
                            </div>
                        </div>
                    </section>
                @endforeach
            </div>

            <section class="rounded-2xl bg-white shadow-sm ring-1 ring-gray-200/50 overflow-hidden mt-8">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-base font-semibold leading-6 text-gray-900">Matriks Hak Akses</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-white">
                            <tr>
                                <th class="px-6 py-3.5 text-left font-semibold text-gray-900">Permission</th>
                                @foreach ($roles as $role)
                                    <th class="px-3 py-3.5 text-center font-semibold text-gray-900">{{ $role->name }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach ($permissions->flatten() as $permission)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-3 font-medium text-gray-900">{{ $permission->name }}</td>
                                    @foreach ($roles as $role)
                                        <td class="px-3 py-3 text-center">
                                            @if($role->hasPermissionTo($permission->name))
                                                <svg class="h-5 w-5 text-emerald-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                            @else
                                                <span class="text-gray-300">-</span>
                                            @endif
                                        </td>
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
