<div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-52 lg:flex-col">
    <!-- Sidebar component -->
    <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-sidebar-900 border-r border-sidebar-800 px-6 pb-4">
        <div class="flex h-16 shrink-0 items-center">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-brand-400 to-brand-600 text-white font-bold text-lg shadow-lg shadow-brand-500/30">T</div>
                <span class="text-xl font-semibold text-white tracking-tight">Terrasys</span>
            </a>
        </div>
        <nav class="flex flex-1 flex-col">
            <ul role="list" class="flex flex-1 flex-col gap-y-7">
                <li>
                    <div class="text-xs font-semibold leading-6 text-gray-500 uppercase tracking-wider mb-2">Menu Utama</div>
                    <ul role="list" class="-mx-2 space-y-1">
                        <li>
                            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-brand-500/10 text-brand-400' : 'text-gray-400 hover:text-white hover:bg-sidebar-800/50' }} group flex gap-x-3 rounded-lg p-2.5 text-sm leading-6 font-medium transition-all">
                                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>
                                Dasbor
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('properties.index') }}" class="{{ request()->routeIs('properties.*') ? 'bg-brand-500/10 text-brand-400' : 'text-gray-400 hover:text-white hover:bg-sidebar-800/50' }} group flex gap-x-3 rounded-lg p-2.5 text-sm leading-6 font-medium transition-all">
                                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" /></svg>
                                Properti
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('certificates.index') }}" class="{{ request()->routeIs('certificates.*') ? 'bg-brand-500/10 text-brand-400' : 'text-gray-400 hover:text-white hover:bg-sidebar-800/50' }} group flex gap-x-3 rounded-lg p-2.5 text-sm leading-6 font-medium transition-all">
                                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                                Sertifikat
                            </a>
                        </li>
                        @can('view_lease')
                        <li>
                            <a href="{{ route('lease-contracts.index') }}" class="{{ request()->routeIs('lease-contracts.*') ? 'bg-brand-500/10 text-brand-400' : 'text-gray-400 hover:text-white hover:bg-sidebar-800/50' }} group flex gap-x-3 rounded-lg p-2.5 text-sm leading-6 font-medium transition-all">
                                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Kontrak Sewa
                            </a>
                        </li>
                        @endcan
                        <li>
                            <a href="{{ route('documents.index') }}" class="{{ request()->routeIs('documents.*') ? 'bg-brand-500/10 text-brand-400' : 'text-gray-400 hover:text-white hover:bg-sidebar-800/50' }} group flex gap-x-3 rounded-lg p-2.5 text-sm leading-6 font-medium transition-all">
                                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" /></svg>
                                Dokumen
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('reports.expiring-certificates') }}" class="{{ request()->routeIs('reports.*') ? 'bg-brand-500/10 text-brand-400' : 'text-gray-400 hover:text-white hover:bg-sidebar-800/50' }} group flex gap-x-3 rounded-lg p-2.5 text-sm leading-6 font-medium transition-all">
                                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" /></svg>
                                Laporan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('map.index') }}" class="{{ request()->routeIs('map.*') ? 'bg-brand-500/10 text-brand-400' : 'text-gray-400 hover:text-white hover:bg-sidebar-800/50' }} group flex gap-x-3 rounded-lg p-2.5 text-sm leading-6 font-medium transition-all">
                                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" /></svg>
                                Peta
                            </a>
                        </li>
                    </ul>
                </li>
                
                @canany(['view_user', 'view_role', 'view_master_data', 'view_audit_log', 'view_system_setting'])
                <li>
                    <div class="text-xs font-semibold leading-6 text-gray-500 uppercase tracking-wider mb-2">Administrasi</div>
                    <ul role="list" class="-mx-2 space-y-1">
                        <li>
                            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.*') ? 'bg-brand-500/10 text-brand-400' : 'text-gray-400 hover:text-white hover:bg-sidebar-800/50' }} group flex gap-x-3 rounded-lg p-2.5 text-sm leading-6 font-medium transition-all">
                                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                Area Admin
                            </a>
                        </li>
                    </ul>
                </li>
                @endcanany
            </ul>
        </nav>
    </div>
</div>

<!-- Mobile Sidebar Off-canvas menu -->
<div class="relative z-50 lg:hidden" role="dialog" aria-modal="true" x-show="sidebarOpen" style="display: none;">
    <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm"></div>
    <div class="fixed inset-0 flex">
        <div x-show="sidebarOpen" @click.outside="sidebarOpen = false" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="relative mr-16 flex w-full max-w-xs flex-1">
            <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
                    <span class="sr-only">Close sidebar</span>
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <!-- Sidebar component for mobile -->
            <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-sidebar-900 px-6 pb-4">
                <div class="flex h-16 shrink-0 items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-brand-400 to-brand-600 text-white font-bold text-lg">T</div>
                        <span class="text-xl font-semibold text-white tracking-tight">Terrasys</span>
                    </a>
                </div>
                <nav class="flex flex-1 flex-col">
                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                        <li>
                            <ul role="list" class="-mx-2 space-y-1">
                                <li>
                                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-brand-500/10 text-brand-400' : 'text-gray-400 hover:text-white hover:bg-sidebar-800/50' }} group flex gap-x-3 rounded-lg p-2.5 text-sm leading-6 font-medium">
                                        Dasbor
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('properties.index') }}" class="{{ request()->routeIs('properties.*') ? 'bg-brand-500/10 text-brand-400' : 'text-gray-400 hover:text-white hover:bg-sidebar-800/50' }} group flex gap-x-3 rounded-lg p-2.5 text-sm leading-6 font-medium">
                                        Properti
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('certificates.index') }}" class="{{ request()->routeIs('certificates.*') ? 'bg-brand-500/10 text-brand-400' : 'text-gray-400 hover:text-white hover:bg-sidebar-800/50' }} group flex gap-x-3 rounded-lg p-2.5 text-sm leading-6 font-medium">
                                        Sertifikat
                                    </a>
                                </li>
                                @can('view_lease')
                                <li>
                                    <a href="{{ route('lease-contracts.index') }}" class="{{ request()->routeIs('lease-contracts.*') ? 'bg-brand-500/10 text-brand-400' : 'text-gray-400 hover:text-white hover:bg-sidebar-800/50' }} group flex gap-x-3 rounded-lg p-2.5 text-sm leading-6 font-medium">
                                        Kontrak Sewa
                                    </a>
                                </li>
                                @endcan
                                <li>
                                    <a href="{{ route('documents.index') }}" class="{{ request()->routeIs('documents.*') ? 'bg-brand-500/10 text-brand-400' : 'text-gray-400 hover:text-white hover:bg-sidebar-800/50' }} group flex gap-x-3 rounded-lg p-2.5 text-sm leading-6 font-medium">
                                        Dokumen
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('reports.expiring-certificates') }}" class="{{ request()->routeIs('reports.*') ? 'bg-brand-500/10 text-brand-400' : 'text-gray-400 hover:text-white hover:bg-sidebar-800/50' }} group flex gap-x-3 rounded-lg p-2.5 text-sm leading-6 font-medium">
                                        Laporan
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('map.index') }}" class="{{ request()->routeIs('map.*') ? 'bg-brand-500/10 text-brand-400' : 'text-gray-400 hover:text-white hover:bg-sidebar-800/50' }} group flex gap-x-3 rounded-lg p-2.5 text-sm leading-6 font-medium">
                                        Peta
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @canany(['view_user', 'view_role', 'view_master_data', 'view_audit_log', 'view_system_setting'])
                        <li>
                            <div class="text-xs font-semibold leading-6 text-gray-500 uppercase tracking-wider mb-2">Administrasi</div>
                            <ul role="list" class="-mx-2 space-y-1">
                                <li>
                                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.*') ? 'bg-brand-500/10 text-brand-400' : 'text-gray-400 hover:text-white hover:bg-sidebar-800/50' }} group flex gap-x-3 rounded-lg p-2.5 text-sm leading-6 font-medium">
                                        Area Admin
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endcanany
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
