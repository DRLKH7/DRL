<!-- Sidebar Overlay (Mobile) -->
<div id="sidebarOverlay" class="fixed inset-0 z-30 bg-slate-900/50 backdrop-blur-sm transition-opacity lg:hidden hidden" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-72 -translate-x-full border-r border-slate-200 bg-white transition-transform duration-300 ease-in-out lg:translate-x-0 dark:bg-slate-900 dark:border-slate-700">
    <div class="flex h-full flex-col">
        <!-- Header Sidebar -->
        <div class="flex items-center justify-between border-b border-slate-100 p-4 bg-yellow-500 dark:border-slate-700 dark:bg-yellow-600">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2.5">
                <span class="inline-grid size-16 place-items-center rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/30 ring-1 ring-primary-600/10">
                    <img class="w-full h-full object-contain" src="{{ asset('assets/img/logo.png') }}" alt="BeePOS Logo">
                </span>
                <span class="text-xl font-bold text-slate-900 dark:text-slate-50">BeePOS</span>
            </a>
            <div class="flex items-center gap-1">
                <!-- Theme toggle (visible on all screens) -->
                <button type="button" data-theme-toggle aria-pressed="false" title="Ganti tema" class="rounded-lg p-2 text-slate-800/80 hover:bg-white/20 hover:text-slate-900 transition-colors dark:text-slate-100 dark:hover:bg-black/10">
                    <!-- Moon icon (shown in light) -->
                    <svg data-theme-icon="moon" class="size-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z" />
                    </svg>
                    <!-- Sun icon (shown in dark) -->
                    <svg data-theme-icon="sun" class="hidden size-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M6.76 4.84l-1.8-1.79-1.41 1.41 1.79 1.8 1.42-1.42zM1 13h3v-2H1v2zm10 10h2v-3h-2v3zm9-10v-2h-3v2h3zM17.66 4.46l1.79-1.8-1.41-1.41-1.8 1.79 1.42 1.42zM4.84 17.24l-1.79 1.8 1.41 1.41 1.8-1.79-1.42-1.42zM20 20l-1.41-1.41-1.8 1.79 1.41 1.41L20 20zM12 6a6 6 0 100 12A6 6 0 0012 6z"/>
                    </svg>
                </button>
                <button class="lg:hidden rounded-lg p-2 text-slate-700 hover:bg-slate-100 transition-colors dark:text-slate-200 dark:hover:bg-slate-800" onclick="toggleSidebar()" title="Tutup menu">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                </button>
            </div>
        </div>

        <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto p-4 space-y-6">
            <!-- Main Menu Section -->
            <div>
                <h3 class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Menu Utama</h3>
                <div class="space-y-1">
                          <a href="{{ route('dashboard.admin') }}" 
                              class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-150 {{ request()->routeIs('dashboard.admin') ? 'bg-primary-50 text-primary-700 shadow-sm' : 'text-slate-700 hover:bg-slate-50 dark:text-slate-300' }}">
                                <svg class="size-5 {{ request()->routeIs('dashboard.admin') ? 'text-primary-600' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z"/>
                            <path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    
                              <a href="{{ route('admin.pesanan.index') }}" 
                                  class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.pesanan.*') ? 'bg-primary-50 text-primary-700 shadow-sm' : 'text-slate-700 hover:bg-slate-50 dark:text-slate-300' }}">
                                    <svg class="size-5 {{ request()->routeIs('admin.pesanan.*') ? 'text-primary-600' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0118 9.375v9.375a3 3 0 003-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 00-.673-.05A3 3 0 0015 1.5h-1.5a3 3 0 00-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6zM13.5 3A1.5 1.5 0 0012 4.5h4.5A1.5 1.5 0 0015 3h-1.5z" clip-rule="evenodd"/>
                            <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 013 20.625V9.375zm9.586 4.594a.75.75 0 00-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 00-1.06 1.06l1.5 1.5a.75.75 0 001.116-.062l3-3.75z" clip-rule="evenodd"/>
                        </svg>
                        <span>Pesanan</span>
                    </a>
                </div>
            </div>

            <!-- Manajemen Section -->
            <div>
                <h3 class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Manajemen</h3>
                <div class="space-y-1">
                          <a href="{{ route('admin.kategori.index') }}" 
                              class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.kategori.*') ? 'bg-primary-50 text-primary-700 shadow-sm' : 'text-slate-700 hover:bg-slate-50 dark:text-slate-300' }}">
                                <svg class="size-5 {{ request()->routeIs('admin.kategori.*') ? 'text-primary-600' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h2.25a3 3 0 013 3v2.25a3 3 0 01-3 3H6a3 3 0 01-3-3V6zm9.75 0a3 3 0 013-3H18a3 3 0 013 3v2.25a3 3 0 01-3 3h-2.25a3 3 0 01-3-3V6zM3 15.75a3 3 0 013-3h2.25a3 3 0 013 3V18a3 3 0 01-3 3H6a3 3 0 01-3-3v-2.25zm9.75 0a3 3 0 013-3H18a3 3 0 013 3V18a3 3 0 01-3 3h-2.25a3 3 0 01-3-3v-2.25z" clip-rule="evenodd"/>
                        </svg>
                        <span>Kategori</span>
                    </a>
                    
                              <a href="{{ route('admin.menu.index') }}" 
                                  class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.menu.*') ? 'bg-primary-50 text-primary-700 shadow-sm' : 'text-slate-700 hover:bg-slate-50 dark:text-slate-300' }}">
                                    <svg class="size-5 {{ request()->routeIs('admin.menu.*') ? 'text-primary-600' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M11.644 1.59a.75.75 0 01.712 0l9.75 5.25a.75.75 0 010 1.32l-9.75 5.25a.75.75 0 01-.712 0l-9.75-5.25a.75.75 0 010-1.32l9.75-5.25z"/>
                            <path d="M3.265 10.602l7.668 4.129a2.25 2.25 0 002.134 0l7.668-4.13 1.37.739a.75.75 0 010 1.32l-9.75 5.25a.75.75 0 01-.71 0l-9.75-5.25a.75.75 0 010-1.32l1.37-.738z"/>
                            <path d="M10.933 19.231l-7.668-4.13-1.37.739a.75.75 0 000 1.32l9.75 5.25c.221.12.489.12.71 0l9.75-5.25a.75.75 0 000-1.32l-1.37-.738-7.668 4.13a2.25 2.25 0 01-2.134-.001z"/>
                        </svg>
                        <span>Menu</span>
                    </a>
                    
                    <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 transition-all duration-150 hover:bg-slate-50 dark:text-slate-300">
                        <svg class="size-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 013.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 013.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 01-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875zm5.845 17.03a.75.75 0 001.06 0l3-3a.75.75 0 10-1.06-1.06l-1.72 1.72V12a.75.75 0 00-1.5 0v4.19l-1.72-1.72a.75.75 0 00-1.06 1.06l3 3z" clip-rule="evenodd"/>
                            <path d="M14.25 5.25a5.23 5.23 0 00-1.279-3.434 9.768 9.768 0 016.963 6.963A5.23 5.23 0 0016.5 7.5h-1.875a.375.375 0 01-.375-.375V5.25z"/>
                        </svg>
                        <span>Inventori</span>
                    </a>
                </div>
            </div>

            <!-- Laporan Section -->
            <div>
                <h3 class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Laporan</h3>
                <div class="space-y-1">
                          <a href="{{ route('admin.report.pesanan') }}" 
                              class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.report.pesanan') ? 'bg-primary-50 text-primary-700 shadow-sm' : 'text-slate-700 hover:bg-slate-50 dark:text-slate-300' }}">
                                <svg class="size-5 {{ request()->routeIs('admin.report.pesanan') ? 'text-primary-600' : 'text-slate-400' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625z"/>
                            <path d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z"/>
                        </svg>
                        <span>Laporan Pesanan</span>
                    </a>
                </div>
            </div>

            <!-- Pengaturan Section -->
            <div>
                <h3 class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Sistem</h3>
                <div class="space-y-1">
                    <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 transition-all duration-150 hover:bg-slate-50">
                        <svg class="size-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 00-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 00-2.282.819l-.922 1.597a1.875 1.875 0 00.432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 000 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 00-.432 2.385l.922 1.597a1.875 1.875 0 002.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 002.28-.819l.923-1.597a1.875 1.875 0 00-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 000-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 00-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 00-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 00-1.85-1.567h-1.843zM12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z" clip-rule="evenodd"/>
                        </svg>
                        <span>Pengaturan</span>
                    </a>
                </div>
            </div>
        </nav>

        <!-- Footer Card -->
        <div class="border-t border-slate-100 p-4">
            <div class="rounded-xl bg-linear-to-br from-slate-50 to-slate-100 p-4 shadow-sm dark:from-slate-800 dark:to-slate-700">
                <div class="flex items-center gap-3">
                    <div class="flex size-10 items-center justify-center rounded-lg bg-white shadow-sm dark:bg-slate-800">
                        <svg class="size-5 text-primary-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-slate-500">Shift saat ini</p>
                        <p class="text-sm font-semibold text-slate-900 truncate dark:text-slate-100">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-slate-500">{{ now()->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>

<!-- Mobile Menu Toggle Button -->
<button onclick="toggleSidebar()" class="fixed left-4 top-4 z-50 rounded-lg bg-white p-2.5 text-slate-700 shadow-lg ring-1 ring-slate-200 transition-all hover:bg-slate-50 lg:hidden dark:bg-slate-800 dark:text-slate-200 dark:ring-slate-700 dark:hover:bg-slate-700/80">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
    </svg>
</button>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
}
</script>