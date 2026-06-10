<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin - {{ config('app.name', 'Beepos') }}</title>
    <script>
        // Apply saved theme ASAP to avoid flash
        (function () {
            try {
                var t = localStorage.getItem('theme');
                if (!t) { t = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'; }
                if (t === 'dark') { document.documentElement.classList.add('dark'); document.documentElement.dataset.theme = 'dark'; }
                else { document.documentElement.dataset.theme = 'light'; }
            } catch (e) { /* noop */ }
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-dvh bg-slate-50 text-slate-900">
    <!-- Mobile sidebar backdrop -->
    <div id="sidebar-backdrop" class="fixed inset-0 z-30 hidden bg-slate-900/40" onclick="toggleSidebar(false)"></div>

    <!-- Sidebar -->
    <x-admin.sidebar />

    <!-- Main -->
    <div class="md:pl-72">
        <!-- Topbar -->
        <header class="sticky top-0 z-20 border-b border-slate-200 bg-white/80 backdrop-blur">
            <div class="flex h-16 items-center gap-3 px-4">
                <button class="md:hidden -ml-1 rounded-lg p-2 text-slate-600 hover:bg-slate-100" onclick="toggleSidebar(true)" title="Buka menu">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5"><path d="M3 6h18v2H3V6zm0 5h18v2H3v-2zm0 5h18v2H3v-2z"/></svg>
                </button>
                <div class="flex-1">
                    <h1 class="text-lg font-semibold">Dashboard</h1>
                    <p class="text-sm text-slate-500">Ringkasan operasional restoran hari ini</p>
                </div>

                <div class="hidden items-center gap-2 md:flex">
                    <div class="relative">
                        <input type="text" placeholder="Cari pesanan atau menu..." class="w-72 rounded-lg border border-slate-300 bg-white px-3 py-2 pl-9 text-sm placeholder-slate-400 shadow-sm outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20" />
                        <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 size-4 text-slate-400" viewBox="0 0 24 24" fill="currentColor"><path d="M15.5 14h-.79l-.28-.27a6.5 6.5 0 10-.71.71l.27.28v.79l5 5 1.5-1.5-5-5zM6.5 11a4.5 4.5 0 118.99 0A4.5 4.5 0 016.5 11z"/></svg>
                    </div>

                    <!-- Theme toggle -->
                    <button type="button" data-theme-toggle aria-pressed="false" title="Toggle dark mode" class="rounded-lg border border-slate-300 bg-white p-2 text-slate-600 shadow-sm hover:bg-slate-50">
                        <!-- Moon icon (shown in light mode) -->
                        <svg data-theme-icon="moon" class="size-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z" />
                        </svg>
                        <!-- Sun icon (shown in dark mode) -->
                        <svg data-theme-icon="sun" class="hidden size-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M6.76 4.84l-1.8-1.79-1.41 1.41 1.79 1.8 1.42-1.42zM1 13h3v-2H1v2zm10 10h2v-3h-2v3zm9-10v-2h-3v2h3zM17.66 4.46l1.79-1.8-1.41-1.41-1.8 1.79 1.42 1.42zM4.84 17.24l-1.79 1.8 1.41 1.41 1.8-1.79-1.42-1.42zM20 20l-1.41-1.41-1.8 1.79 1.41 1.41L20 20zM12 6a6 6 0 100 12A6 6 0 0012 6z"/>
                        </svg>
                    </button>

                    <div id="userMenuContainer" class="relative">
                        <button id="userMenuButton" type="button" class="inline-flex items-center gap-2 rounded-lg bg-slate-100 px-2.5 py-1.5 text-sm" onclick="toggleUserMenu()" aria-haspopup="menu" aria-expanded="false">
                            <span class="grid size-6 place-items-center overflow-hidden rounded-full bg-primary-600 text-white">{{ mb_substr(optional(auth()->user())->name ?? 'A', 0, 1) }}</span>
                            <span class="hidden md:inline max-w-36 truncate">{{ optional(auth()->user())->name ?? 'Admin' }}</span>
                            <svg class="size-4 text-slate-500" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
                        </button>

                        <div id="userMenu" class="invisible pointer-events-none absolute right-0 mt-2 w-56 translate-y-1 rounded-lg border border-slate-200 bg-white p-1 opacity-0 shadow-lg transition duration-150 ease-out">
                            <a href="#" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                <svg class="size-4 text-slate-400" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 100-10 5 5 0 000 10zm-7 9a7 7 0 0114 0H5z"/></svg>
                                Profil saya
                            </a>
                            <a href="#" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                <svg class="size-4 text-slate-400" viewBox="0 0 24 24" fill="currentColor"><path d="M19.14 12.94a7.5 7.5 0 00.06-.94 7.5 7.5 0 00-.06-.94l2.03-1.58a.5.5 0 00.12-.64l-1.92-3.32a.5.5 0 00-.6-.22l-2.39.96a7.5 7.5 0 00-1.63-.94l-.36-2.54a.5.5 0 00-.5-.42h-3.84a.5.5 0 00-.5.42l-.36 2.54c-.58.23-1.12.54-1.63.94l-2.39-.96a.5.5 0 00-.6.22L2.65 8.84a.5.5 0 00.12.64l2.03 1.58c-.04.31-.06.63-.06.94s.02.63.06.94L2.77 14.5a.5.5 0 00-.12.64l1.92 3.32c.13.22.39.31.6.22l2.39-.96c.51.4 1.05.71 1.63.94l.36 2.54a.5.5 0 00.5.42h3.84a.5.5 0 00.5-.42l.36-2.54c.58-.23 1.12-.54 1.63-.94l2.39.96c.22.09.47 0 .6-.22l1.92-3.32a.5.5 0 00-.12-.64l-2.03-1.58zM12 15.5a3.5 3.5 0 110-7 3.5 3.5 0 010 7z"/></svg>
                                Pengaturan
                            </a>
                            <a href="#" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                <svg class="size-4 text-slate-400" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 100 20 10 10 0 000-20zm1 15h-2v-2h2v2zm1.07-7.75l-.9.92A2.5 2.5 0 0012 13h-1v-1a3.5 3.5 0 011.02-2.49l1.2-1.2a1 1 0 10-1.41-1.41l-1.2 1.2a5.5 5.5 0 00-1.61 3.9V14a1 1 0 001 1h2a1 1 0 001-1 4.5 4.5 0 011.32-3.18l1-1a3 3 0 10-4.24-4.24l-.88.88 1.42 1.42.88-.88a1 1 0 111.41 1.41z"/></svg>
                                Bantuan & Support
                            </a>
                            <div class="my-1 h-px bg-slate-200"></div>
                            @if (Route::has('auth.logout'))
                                <a href="#" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium text-rose-600 hover:bg-rose-50" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <svg class="size-4" viewBox="0 0 24 24" fill="currentColor"><path d="M16 13v-2H7V8l-5 4 5 4v-3h9zM20 3h-8v2h8v14h-8v2h8a2 2 0 002-2V5a2 2 0 00-2-2z"/></svg>
                                    Keluar
                                </a>
                                <form id="logout-form" method="POST" action="{{ route('auth.logout') }}" class="hidden">
                                    @csrf
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="mx-auto max-w-7xl p-4 md:p-6">
            <!-- KPIs -->
            <section class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-slate-600">Pendapatan Hari Ini</p>
                        <span class="rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700">+12%</span>
                    </div>
                    <div class="mt-2 flex items-end gap-2">
                        <h3 id="income" class="text-2xl font-semibold">Rp. {{ number_format($income, 0, ',', '.') }}</h3>
                        <p class="text-xs text-slate-500">09:00 - sekarang</p>
                    </div>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-slate-600">Jumlah Pesanan</p>
                        <span id="orderBadge" class="rounded-md bg-primary-50 px-2 py-1 text-xs font-medium text-primary-700">{{ $orderCount }}</span>
                    </div>
                    <div class="mt-2 flex items-end gap-2">
                        <h3 id="orderCount" class="text-2xl font-semibold">{{ $orderCount }}</h3>
                        <p class="text-xs text-slate-500">Dine-in & Takeaway</p>
                    </div>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-slate-600">Rata-rata Transaksi</p>
                        <span class="rounded-md bg-slate-100 px-2 py-1 text-xs font-medium text-slate-700">Rp</span>
                    </div>
                    <div class="mt-2 flex items-end gap-2">
                        <h3 id="avgTransaction" class="text-2xl font-semibold">{{ number_format($averageTransaction, 0, ',', '.') }}</h3>
                        <p class="text-xs text-slate-500">per order</p>
                    </div>
                </div>
            </section>

            <!-- Actions -->
            <section class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-4">
                <a href="#" class="group rounded-xl border border-slate-200 bg-white p-4 shadow-sm hover:border-primary-300 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <p class="font-medium">Pesanan Baru</p>
                        <span class="rounded-md bg-primary-600/10 px-2 py-1 text-xs text-primary-700">F2</span>
                    </div>
                    <p class="mt-1 text-sm text-slate-500">Buat transaksi</p>
                </a>
                <a href="#" class="group rounded-xl border border-slate-200 bg-white p-4 shadow-sm hover:border-primary-300 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <p class="font-medium">Tambah Menu</p>
                        <span class="rounded-md bg-primary-600/10 px-2 py-1 text-xs text-primary-700">M</span>
                    </div>
                    <p class="mt-1 text-sm text-slate-500">Kelola katalog</p>
                </a>
                <a href="#" class="group rounded-xl border border-slate-200 bg-white p-4 shadow-sm hover:border-primary-300 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <p class="font-medium">Atur Meja</p>
                        <span class="rounded-md bg-primary-600/10 px-2 py-1 text-xs text-primary-700">T</span>
                    </div>
                    <p class="mt-1 text-sm text-slate-500">Layout & status</p>
                </a>
                <a href="#" class="group rounded-xl border border-slate-200 bg-white p-4 shadow-sm hover:border-primary-300 hover:shadow-md">
                    <div class="flex items-center justify-between">
                        <p class="font-medium">Penutupan Kas</p>
                        <span class="rounded-md bg-primary-600/10 px-2 py-1 text-xs text-primary-700">End</span>
                    </div>
                    <p class="mt-1 text-sm text-slate-500">Rekonsiliasi</p>
                </a>
            </section>

            <!-- Grid: Recent orders + Popular items -->
            <section class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Recent Orders -->
                <div class="lg:col-span-2 rounded-xl border border-slate-200 bg-white shadow-sm">
                    <div class="flex items-center justify-between border-b border-slate-200 p-4">
                        <h3 class="font-semibold">Pesanan Terbaru</h3>
                        <div class="flex items-center gap-2 text-sm">
                            <button class="rounded-md border border-slate-300 bg-white px-2.5 py-1.5 shadow-sm hover:bg-slate-50">Hari ini</button>
                            <button class="rounded-md border border-slate-300 bg-white px-2.5 py-1.5 shadow-sm hover:bg-slate-50">Kemarin</button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="border-b border-slate-200 bg-slate-50 text-slate-600">
                                    <th class="px-4 py-2">#</th>
                                    <th class="px-4 py-2">Waktu</th>
                                    <th class="px-4 py-2">Meja</th>
                                    <th class="px-4 py-2">Item</th>
                                    <th class="px-4 py-2">Total</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="recentOrdersTable">
                                <tr class="border-b border-slate-100">
                                    <td class="px-4 py-3 font-medium">INV-2041</td>
                                    <td class="px-4 py-3">12:11</td>
                                    <td class="px-4 py-3">A3</td>
                                    <td class="px-4 py-3">3</td>
                                    <td class="px-4 py-3">Rp 125.000</td>
                                    <td class="px-4 py-3"><span class="rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700">Selesai</span></td>
                                    <td class="px-4 py-3">
                                        <button class="rounded-md border border-slate-300 bg-white px-2 py-1 text-xs shadow-sm hover:bg-slate-50">Detail</button>
                                    </td>
                                </tr>
                                <tr class="border-b border-slate-100">
                                    <td class="px-4 py-3 font-medium">INV-2040</td>
                                    <td class="px-4 py-3">12:03</td>
                                    <td class="px-4 py-3">B1</td>
                                    <td class="px-4 py-3">5</td>
                                    <td class="px-4 py-3">Rp 217.000</td>
                                    <td class="px-4 py-3"><span class="rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700">Menunggu</span></td>
                                    <td class="px-4 py-3">
                                        <button class="rounded-md border border-slate-300 bg-white px-2 py-1 text-xs shadow-sm hover:bg-slate-50">Detail</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 font-medium">INV-2039</td>
                                    <td class="px-4 py-3">11:51</td>
                                    <td class="px-4 py-3">Takeaway</td>
                                    <td class="px-4 py-3">2</td>
                                    <td class="px-4 py-3">Rp 62.000</td>
                                    <td class="px-4 py-3"><span class="rounded-md bg-primary-50 px-2 py-1 text-xs font-medium text-primary-700">Diproses</span></td>
                                    <td class="px-4 py-3">
                                        <button class="rounded-md border border-slate-300 bg-white px-2 py-1 text-xs shadow-sm hover:bg-slate-50">Detail</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Popular Items -->
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold">Menu Terlaris</h3>
                        <a href="#" class="text-sm text-primary-600 hover:text-primary-700">Lihat semua</a>
                    </div>

                    <ul class="mt-4 space-y-4">
                        <li>
                            <div class="flex items-center justify-between">
                                <p>Nasi Goreng Spesial</p>
                                <p class="text-sm text-slate-500">124 terjual</p>
                            </div>
                            <div class="mt-2 h-2 w-full rounded-full bg-slate-100">
                                <div class="h-2 w-[76%] rounded-full bg-primary-600"></div>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center justify-between">
                                <p>Es Teh Manis</p>
                                <p class="text-sm text-slate-500">98 terjual</p>
                            </div>
                            <div class="mt-2 h-2 w-full rounded-full bg-slate-100">
                                <div class="h-2 w-[60%] rounded-full bg-fuchsia-600"></div>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center justify-between">
                                <p>Mie Ayam Bakso</p>
                                <p class="text-sm text-slate-500">74 terjual</p>
                            </div>
                            <div class="mt-2 h-2 w-full rounded-full bg-slate-100">
                                <div class="h-2 w-[44%] rounded-full bg-emerald-600"></div>
                            </div>
                        </li>
                    </ul>

                    <div class="mt-6 rounded-lg border border-dashed border-slate-300 p-4 text-center">
                        <p class="text-sm text-slate-600">Ingin tambah menu favorit?</p>
                        <a href="#" class="mt-2 inline-flex items-center justify-center gap-2 rounded-lg bg-primary-600 px-3 py-2 text-sm font-medium text-white shadow-sm hover:bg-primary-700">
                            <svg class="size-4" viewBox="0 0 24 24" fill="currentColor"><path d="M11 11V6h2v5h5v2h-5v5h-2v-5H6v-2z"/></svg>
                            Tambah Menu
                        </a>
                    </div>
                </div>
            </section>
        </main>

        <footer class="mx-auto max-w-7xl px-4 pb-6 text-xs text-slate-500">
            © {{ date('Y') }} {{ config('app.name', 'Beepos') }}. Semua hak dilindungi.
        </footer>
    </div>

    <script>
        function toggleSidebar(open) {
            const aside = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            if (open === true) {
                aside.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else if (open === false) {
                aside.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            } else {
                aside.classList.toggle('-translate-x-full');
                backdrop.classList.toggle('hidden');
            }
        }
        // User menu dropdown behavior
        (function () {
            const container = document.getElementById('userMenuContainer');
            const button = document.getElementById('userMenuButton');
            const menu = document.getElementById('userMenu');
            if (!container || !button || !menu) return;
            window.toggleUserMenu = function (open) {
                const isOpen = menu.classList.contains('opacity-100');
                const willOpen = typeof open === 'boolean' ? open : !isOpen;
                if (willOpen) {
                    menu.classList.remove('invisible', 'pointer-events-none', 'opacity-0', 'translate-y-1');
                    menu.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
                    button.setAttribute('aria-expanded', 'true');
                } else {
                    menu.classList.add('invisible', 'pointer-events-none', 'opacity-0', 'translate-y-1');
                    menu.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
                    button.setAttribute('aria-expanded', 'false');
                }
            };
            document.addEventListener('click', (e) => {
                if (!container.contains(e.target)) toggleUserMenu(false);
            });
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') toggleUserMenu(false);
            });
        })();

        // Realtime dashboard updates
        (function() {
            const fmt = new Intl.NumberFormat('id-ID');
            const money = (n=0) => `Rp ${fmt.format(Math.max(0, Math.round(n)))}`;
            const statsEndpoint = "{{ route('dashboard.admin.stats') }}";
            
            const elements = {
                income: document.getElementById('income'),
                orderCount: document.getElementById('orderCount'),
                orderBadge: document.getElementById('orderBadge'),
                avgTransaction: document.getElementById('avgTransaction'),
                occupancyBar: document.getElementById('occupancyBar'),
                occupancyBadge: document.getElementById('occupancyBadge'),
                occupancyText: document.getElementById('occupancyText'),
                recentOrdersTable: document.getElementById('recentOrdersTable'),
            };

            async function updateStats() {
                try {
                    const res = await fetch(statsEndpoint, { 
                        headers: { 'Accept': 'application/json' } 
                    });
                    if (!res.ok) throw new Error('Failed to fetch stats');
                    
                    const data = await res.json();
                    
                    // Update KPIs with smooth transitions
                    if (elements.income) {
                        elements.income.textContent = money(data.income);
                    }
                    if (elements.orderCount) {
                        elements.orderCount.textContent = data.orderCount;
                    }
                    if (elements.orderBadge) {
                        elements.orderBadge.textContent = data.orderCount;
                    }
                    if (elements.avgTransaction) {
                        elements.avgTransaction.textContent = fmt.format(Math.round(data.averageTransaction));
                    }
                    
                    // Update occupancy
                    const occupancy = data.occupancy || 0;
                    if (elements.occupancyBar) {
                        elements.occupancyBar.style.width = `${occupancy}%`;
                    }
                    if (elements.occupancyBadge) {
                        elements.occupancyBadge.textContent = `${occupancy}%`;
                    }
                    if (elements.occupancyText) {
                        elements.occupancyText.textContent = `${occupancy}% meja terisi`;
                    }

                    // Update recent orders table
                    if (elements.recentOrdersTable && Array.isArray(data.recentOrders)) {
                        const rows = data.recentOrders.slice(0, 10).map(order => `
                            <tr class="border-b border-slate-100">
                                <td class="px-4 py-3 font-medium">${order.invoice}</td>
                                <td class="px-4 py-3">${order.time}</td>
                                <td class="px-4 py-3">${order.table}</td>
                                <td class="px-4 py-3">${order.items}</td>
                                <td class="px-4 py-3">${money(order.total)}</td>
                                <td class="px-4 py-3"><span class="rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700">Selesai</span></td>
                                <td class="px-4 py-3">
                                    <button class="rounded-md border border-slate-300 bg-white px-2 py-1 text-xs shadow-sm hover:bg-slate-50">Detail</button>
                                </td>
                            </tr>
                        `).join('');
                        
                        elements.recentOrdersTable.innerHTML = rows || `
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-sm text-slate-500">
                                    Belum ada pesanan hari ini
                                </td>
                            </tr>
                        `;
                    }
                } catch (error) {
                    console.error('Error updating dashboard stats:', error);
                }
            }

            // Initial update
            updateStats();
            
            // Auto-refresh every 5 seconds
            setInterval(updateStats, 5000);
        })();
    </script>
    <x-swal />
</body>
</html>
