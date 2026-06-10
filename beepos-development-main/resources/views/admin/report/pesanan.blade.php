<!DOCTYPE html>
<html lang="id" class="h-full bg-gradient-to-br from-slate-50 via-white to-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laporan Pesanan - BeePOS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }
        
        .animate-slide-up { animation: slideUp 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .animate-fade-in { animation: fadeIn 0.3s ease-out; }
        
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 1000px 100%;
            animation: shimmer 2s infinite;
        }
        
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { 
            background: rgb(203 213 225); 
            border-radius: 3px; 
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgb(148 163 184); }
        
        .stat-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }
        
        .filter-badge {
            transition: all 0.2s ease;
        }
        
        .filter-badge:hover {
            transform: scale(1.05);
        }
        
        table tr {
            transition: background-color 0.15s ease;
        }
        
        table tbody tr:hover {
            background-color: rgb(248 250 252);
        }
    </style>
</head>
<body class="h-full text-slate-800">
    <div class="min-h-screen flex">
        <x-admin.sidebar :menu="'Laporan'" />
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:ml-72">
            <!-- Header -->
            <header class="sticky top-0 z-30 border-b border-slate-200/60 bg-white/80 backdrop-blur-xl shadow-sm">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="flex size-11 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-600 to-emerald-700 text-white shadow-lg shadow-emerald-500/30 ring-1 ring-emerald-600/10">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-lg font-bold text-slate-900">Laporan Pesanan</h1>
                                <p class="text-xs text-slate-500">Monitoring dan analisis transaksi</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2">
                            <button id="refreshBtn" type="button" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:bg-slate-50 active:scale-95">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                    <path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0112.548-3.364l1.903 1.903h-3.183a.75.75 0 100 1.5h4.992a.75.75 0 00.75-.75V4.356a.75.75 0 00-1.5 0v3.18l-1.9-1.9A9 9 0 003.306 9.67a.75.75 0 101.45.388zm15.408 3.352a.75.75 0 00-.919.53 7.5 7.5 0 01-12.548 3.364l-1.902-1.903h3.183a.75.75 0 000-1.5H2.984a.75.75 0 00-.75.75v4.992a.75.75 0 001.5 0v-3.18l1.9 1.9a9 9 0 0015.059-4.035.75.75 0 00-.53-.918z" clip-rule="evenodd" />
                                </svg>
                                <span class="hidden sm:inline">Refresh</span>
                            </button>
                            <button id="exportBtn" type="button" class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-emerald-500/30 transition-all hover:bg-emerald-700 active:scale-95">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                    <path fill-rule="evenodd" d="M12 2.25a.75.75 0 01.75.75v11.69l3.22-3.22a.75.75 0 111.06 1.06l-4.5 4.5a.75.75 0 01-1.06 0l-4.5-4.5a.75.75 0 111.06-1.06l3.22 3.22V3a.75.75 0 01.75-.75zm-9 13.5a.75.75 0 01.75.75v2.25a1.5 1.5 0 001.5 1.5h13.5a1.5 1.5 0 001.5-1.5V16.5a.75.75 0 011.5 0v2.25a3 3 0 01-3 3H5.25a3 3 0 01-3-3V16.5a.75.75 0 01.75-.75z" clip-rule="evenodd" />
                                </svg>
                                Export Excel
                            </button>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto custom-scrollbar bg-slate-50/50">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6 space-y-6">
                    
                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5 animate-slide-up">
                        <div class="stat-card overflow-hidden rounded-xl bg-white border border-slate-200/60 shadow-sm">
                            <div class="p-5">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-slate-600">Total Pesanan</p>
                                        <p id="totalOrders" class="mt-2 text-3xl font-bold text-slate-900">0</p>
                                    </div>
                                    <div class="rounded-lg bg-primary-100 p-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-primary-600">
                                            <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0118 9.375v9.375a3 3 0 003-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 00-.673-.05A3 3 0 0015 1.5h-1.5a3 3 0 00-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6zM13.5 3A1.5 1.5 0 0012 4.5h4.5A1.5 1.5 0 0015 3h-1.5z" clip-rule="evenodd" />
                                            <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 013 20.625V9.375zm9.586 4.594a.75.75 0 00-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 00-1.06 1.06l1.5 1.5a.75.75 0 001.116-.062l3-3.75z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center text-sm">
                                    <span class="text-slate-500">Dari semua transaksi</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="stat-card overflow-hidden rounded-xl bg-white border border-slate-200/60 shadow-sm">
                            <div class="p-5">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-slate-600">Total Pendapatan</p>
                                        <p id="totalRevenue" class="mt-2 text-3xl font-bold text-slate-900">Rp 0</p>
                                    </div>
                                    <div class="rounded-lg bg-emerald-100 p-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-emerald-600">
                                            <path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 01-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004zM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 01-.921.42z" />
                                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v.816a3.836 3.836 0 00-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 01-.921-.421l-.879-.66a.75.75 0 00-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 001.5 0v-.81a4.124 4.124 0 001.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 00-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 00.933-1.175l-.415-.33a3.836 3.836 0 00-1.719-.755V6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center text-sm">
                                    <span class="text-slate-500">Akumulasi penjualan</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="stat-card overflow-hidden rounded-xl bg-white border border-slate-200/60 shadow-sm">
                            <div class="p-5">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-slate-600">Pesanan Lunas</p>
                                        <p id="paidOrders" class="mt-2 text-3xl font-bold text-slate-900">0</p>
                                    </div>
                                    <div class="rounded-lg bg-green-100 p-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-green-600">
                                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center text-sm">
                                    <span class="text-slate-500">Transaksi selesai</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="stat-card overflow-hidden rounded-xl bg-white border border-slate-200/60 shadow-sm">
                            <div class="p-5">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-slate-600">Pesanan Pending</p>
                                        <p id="pendingOrders" class="mt-2 text-3xl font-bold text-slate-900">0</p>
                                    </div>
                                    <div class="rounded-lg bg-blue-100 p-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-blue-600">
                                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center text-sm">
                                    <span class="text-slate-500">Menunggu konfirmasi</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="stat-card overflow-hidden rounded-xl bg-white border border-slate-200/60 shadow-sm">
                            <div class="p-5">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-slate-600">Draft Pesanan</p>
                                        <p id="draftOrders" class="mt-2 text-3xl font-bold text-slate-900">0</p>
                                    </div>
                                    <div class="rounded-lg bg-amber-100 p-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-amber-600">
                                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center text-sm">
                                    <span class="text-slate-500">Menunggu pembayaran</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Filters Section -->
                    <div class="rounded-xl bg-white border border-slate-200/60 shadow-sm p-6 animate-slide-up" style="animation-delay: 0.1s;">
                        <h2 class="text-base font-semibold text-slate-900 mb-4">Filter & Pencarian</h2>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                            <div>
                                <label for="startDate" class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Mulai</label>
                                <input type="date" id="startDate" class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" value="{{ date('Y-m-01') }}">
                            </div>
                            <div>
                                <label for="endDate" class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Akhir</label>
                                <input type="date" id="endDate" class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" value="{{ date('Y-m-d') }}">
                            </div>
                            <div>
                                <label for="statusFilter" class="block text-sm font-medium text-slate-700 mb-1.5">Status</label>
                                <select id="statusFilter" class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                                    <option value="all">Semua Status</option>
                                    <option value="paid">Lunas</option>
                                    <option value="pending">Pending</option>
                                    <option value="draft">Draft</option>
                                </select>
                            </div>
                            <div>
                                <label for="searchInput" class="block text-sm font-medium text-slate-700 mb-1.5">Cari Menu</label>
                                <input type="text" id="searchInput" placeholder="Cari nama menu..." class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                            </div>
                        </div>
                        <div class="mt-4 flex items-center gap-2">
                            <button id="applyFilter" type="button" class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 transition-all active:scale-95">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                    <path fill-rule="evenodd" d="M3.792 2.938A49.069 49.069 0 0112 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 011.541 1.836v1.044a3 3 0 01-.879 2.121l-6.182 6.182a1.5 1.5 0 00-.439 1.061v2.927a3 3 0 01-1.658 2.684l-1.757.878A.75.75 0 019.75 21v-5.818a1.5 1.5 0 00-.44-1.06L3.13 7.938a3 3 0 01-.879-2.121V4.774c0-.897.64-1.683 1.542-1.836z" clip-rule="evenodd" />
                                </svg>
                                Terapkan Filter
                            </button>
                            <button id="resetFilter" type="button" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition-all active:scale-95">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                    <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                </svg>
                                Reset
                            </button>
                        </div>
                    </div>
                    
                    <!-- Table Section -->
                    <div class="rounded-xl bg-white border border-slate-200/60 shadow-sm overflow-hidden animate-slide-up" style="animation-delay: 0.2s;">
                        <div class="border-b border-slate-200 bg-slate-50/50 px-6 py-4">
                            <h2 class="text-base font-semibold text-slate-900">Daftar Pesanan</h2>
                            <p class="mt-1 text-sm text-slate-500">Riwayat transaksi dan detail pesanan</p>
                        </div>
                        
                        <div class="overflow-x-auto custom-scrollbar">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-slate-900 uppercase tracking-wider">ID Pesanan</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-slate-900 uppercase tracking-wider">Menu</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-slate-900 uppercase tracking-wider">Kategori</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-slate-900 uppercase tracking-wider">Customer</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-slate-900 uppercase tracking-wider">Qty</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-slate-900 uppercase tracking-wider">Diskon</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-slate-900 uppercase tracking-wider">Total</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-slate-900 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-slate-900 uppercase tracking-wider">Kasir</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-slate-900 uppercase tracking-wider">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody" class="divide-y divide-slate-200 bg-white">
                                    <!-- Loading State -->
                                    <tr id="loadingRow">
                                        <td colspan="9" class="px-6 py-12 text-center">
                                            <div class="flex items-center justify-center gap-3">
                                                <div class="animate-spin rounded-full h-8 w-8 border-4 border-slate-200 border-t-emerald-600"></div>
                                                <span class="text-sm font-medium text-slate-600">Memuat data...</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Empty State -->
                                    <tr id="emptyRow" class="hidden">
                                        <td colspan="9" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center gap-3">
                                                <div class="rounded-full bg-slate-100 p-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 text-slate-400">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-base font-semibold text-slate-900">Tidak ada data</p>
                                                    <p class="mt-1 text-sm text-slate-500">Belum ada pesanan yang sesuai dengan filter</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div id="paginationContainer" class="border-t border-slate-200 bg-slate-50/50 px-6 py-4 flex items-center justify-between">
                            <div class="flex-1 flex justify-between sm:hidden">
                                <button id="prevPageMobile" class="relative inline-flex items-center rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                                    Sebelumnya
                                </button>
                                <button id="nextPageMobile" class="relative ml-3 inline-flex items-center rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                                    Selanjutnya
                                </button>
                            </div>
                            <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-slate-700">
                                        Menampilkan <span id="showingFrom" class="font-medium">0</span> sampai <span id="showingTo" class="font-medium">0</span> dari <span id="totalData" class="font-medium">0</span> hasil
                                    </p>
                                </div>
                                <div>
                                    <nav id="paginationNav" class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                                        <!-- Pagination buttons will be inserted here -->
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </main>
        </div>
    </div>
    
    <script>
        // State management
        let currentPage = 1;
        let filters = {
            start_date: document.getElementById('startDate').value,
            end_date: document.getElementById('endDate').value,
            status: 'all',
            search: ''
        };
        
        // Format currency
        function formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(amount);
        }
        
        // Format date
        function formatDate(dateString) {
            const date = new Date(dateString);
            return new Intl.DateTimeFormat('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            }).format(date);
        }
        
        // Get status badge HTML
        function getStatusBadge(status) {
            const badges = {
                'paid': '<span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-800"><span class="size-1.5 rounded-full bg-green-600"></span>Lunas</span>',
                'pending': '<span class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-800"><span class="size-1.5 rounded-full bg-blue-600"></span>Pending</span>',
                'draft': '<span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-800"><span class="size-1.5 rounded-full bg-amber-600"></span>Draft</span>'
            };
            return badges[status] || status;
        }
        
        // Load data
        async function loadData(page = 1) {
            try {
                const params = new URLSearchParams({
                    page: page,
                    ...filters
                });
                
                const response = await fetch(`/dashboard/admin/report/pesanan/data?${params}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                
                if (!response.ok) throw new Error('Network response was not ok');
                
                const data = await response.json();
                
                // Update statistics
                updateStats(data.stats);
                
                // Update table
                updateTable(data.orders.data);
                
                // Update pagination
                updatePagination(data.orders);
                
                currentPage = page;
            } catch (error) {
                console.error('Error loading data:', error);
                showError('Gagal memuat data. Silakan coba lagi.');
            }
        }
        
        // Update statistics
        function updateStats(stats) {
            document.getElementById('totalOrders').textContent = stats.total_orders.toLocaleString('id-ID');
            document.getElementById('totalRevenue').textContent = formatRupiah(stats.total_revenue);
            document.getElementById('paidOrders').textContent = stats.paid_orders.toLocaleString('id-ID');
            document.getElementById('pendingOrders').textContent = stats.pending_orders.toLocaleString('id-ID');
            document.getElementById('draftOrders').textContent = stats.draft_orders.toLocaleString('id-ID');
        }
        
        // Update table
        function updateTable(orders) {
            const tbody = document.getElementById('tableBody');
            const loadingRow = document.getElementById('loadingRow');
            const emptyRow = document.getElementById('emptyRow');
            
            // Remove loading and empty states
            loadingRow.classList.add('hidden');
            emptyRow.classList.add('hidden');
            
            // Clear existing data rows
            tbody.querySelectorAll('tr:not(#loadingRow):not(#emptyRow)').forEach(row => row.remove());
            
            if (orders.length === 0) {
                emptyRow.classList.remove('hidden');
                return;
            }
            
            orders.forEach((order, index) => {
                const row = document.createElement('tr');
                row.className = 'animate-fade-in';
                row.style.animationDelay = `${index * 0.03}s`;
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                    ${order.order_id || 'N/A'}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                        ${order.menu?.name || 'N/A'}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                        ${order.menu?.category?.name || 'N/A'}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                        ${order.customer || 'N/A'}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                        ${order.quantity}x
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                        ${formatRupiah(order.discount)}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-900">
                        ${formatRupiah(order.total_price)}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        ${getStatusBadge(order.status)}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                        ${order.user?.name || 'N/A'}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                        ${formatDate(order.created_at)}
                    </td>
                `;
                tbody.appendChild(row);
            });
        }
        
        // Update pagination
        function updatePagination(paginationData) {
            document.getElementById('showingFrom').textContent = paginationData.from || 0;
            document.getElementById('showingTo').textContent = paginationData.to || 0;
            document.getElementById('totalData').textContent = paginationData.total || 0;
            
            const nav = document.getElementById('paginationNav');
            nav.innerHTML = '';
            
            // Previous button
            const prevBtn = createPaginationButton('Previous', paginationData.current_page - 1, !paginationData.prev_page_url);
            nav.appendChild(prevBtn);
            
            // Page numbers
            const totalPages = paginationData.last_page;
            const currentPage = paginationData.current_page;
            
            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(totalPages, currentPage + 2);
            
            if (startPage > 1) {
                nav.appendChild(createPaginationButton(1, 1));
                if (startPage > 2) {
                    nav.appendChild(createPaginationEllipsis());
                }
            }
            
            for (let i = startPage; i <= endPage; i++) {
                nav.appendChild(createPaginationButton(i, i, false, i === currentPage));
            }
            
            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    nav.appendChild(createPaginationEllipsis());
                }
                nav.appendChild(createPaginationButton(totalPages, totalPages));
            }
            
            // Next button
            const nextBtn = createPaginationButton('Next', paginationData.current_page + 1, !paginationData.next_page_url);
            nav.appendChild(nextBtn);
        }
        
        function createPaginationButton(label, page, disabled = false, active = false) {
            const button = document.createElement('button');
            button.textContent = label;
            button.className = `relative inline-flex items-center px-4 py-2 text-sm font-semibold ${
                active 
                    ? 'z-10 bg-emerald-600 text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600' 
                    : disabled 
                        ? 'text-slate-400 cursor-not-allowed' 
                        : 'text-slate-900 ring-1 ring-inset ring-slate-300 hover:bg-slate-50 focus:z-20 focus:outline-offset-0'
            }`;
            
            if (!disabled && !active) {
                button.onclick = () => loadData(page);
            }
            
            button.disabled = disabled;
            return button;
        }
        
        function createPaginationEllipsis() {
            const span = document.createElement('span');
            span.textContent = '...';
            span.className = 'relative inline-flex items-center px-4 py-2 text-sm font-semibold text-slate-700 ring-1 ring-inset ring-slate-300';
            return span;
        }
        
        // Show error message
        function showError(message) {
            const tbody = document.getElementById('tableBody');
            const loadingRow = document.getElementById('loadingRow');
            const emptyRow = document.getElementById('emptyRow');
            
            loadingRow.classList.add('hidden');
            emptyRow.classList.add('hidden');
            
            tbody.querySelectorAll('tr:not(#loadingRow):not(#emptyRow)').forEach(row => row.remove());
            
            const errorRow = document.createElement('tr');
            errorRow.innerHTML = `
                <td colspan="9" class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center gap-3">
                        <div class="rounded-full bg-red-100 p-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 text-red-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-base font-semibold text-slate-900">${message}</p>
                        </div>
                    </div>
                </td>
            `;
            tbody.appendChild(errorRow);
        }
        
        // Event listeners
        document.getElementById('applyFilter').addEventListener('click', () => {
            filters.start_date = document.getElementById('startDate').value;
            filters.end_date = document.getElementById('endDate').value;
            filters.status = document.getElementById('statusFilter').value;
            filters.search = document.getElementById('searchInput').value;
            loadData(1);
        });
        
        document.getElementById('resetFilter').addEventListener('click', () => {
            document.getElementById('startDate').value = '{{ date('Y-m-01') }}';
            document.getElementById('endDate').value = '{{ date('Y-m-d') }}';
            document.getElementById('statusFilter').value = 'all';
            document.getElementById('searchInput').value = '';
            
            filters = {
                start_date: '{{ date('Y-m-01') }}',
                end_date: '{{ date('Y-m-d') }}',
                status: 'all',
                search: ''
            };
            
            loadData(1);
        });
        
        document.getElementById('refreshBtn').addEventListener('click', () => {
            loadData(currentPage);
        });
        
        document.getElementById('exportBtn').addEventListener('click', () => {
            const params = new URLSearchParams(filters);
            window.location.href = `/dashboard/admin/report/pesanan/export?${params}`;
        });
        
        // Search on Enter
        document.getElementById('searchInput').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                document.getElementById('applyFilter').click();
            }
        });
        
        // Initial load
        loadData(1);
    </script>
</body>
</html>
