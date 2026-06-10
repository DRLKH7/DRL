<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pilih Menu - {{ config('app.name', 'BeePOS') }}</title>
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
    <!-- Header -->
    <header class="sticky top-0 z-20 border-b border-slate-200 bg-white/80 backdrop-blur">
        <div class="mx-auto flex h-16 max-w-7xl items-center gap-3 px-4">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2">
                <span class="inline-grid size-9 place-items-center rounded-lg bg-primary-600 text-white shadow-lg shadow-primary-600/30">{{ substr(config('app.name', 'B'), 0, 1) }}</span>
                <span class="text-lg font-semibold">{{ config('app.name', 'BeePOS') }}</span>
            </a>

            <div class="hidden flex-1 items-center gap-3 sm:flex">
                <div class="relative w-full max-w-xl">
                    <input id="searchInput" type="text" placeholder="Cari menu..." class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 pl-9 text-sm placeholder-slate-400 shadow-sm outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20" />
                    <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 size-4 text-slate-400" viewBox="0 0 24 24" fill="currentColor"><path d="M15.5 14h-.79l-.28-.27a6.5 6.5 0 10-.71.71l.27.28v.79l5 5 1.5-1.5-5-5zM6.5 11a4.5 4.5 0 118.99 0A4.5 4.5 0 016.5 11z"/></svg>
                </div>
            </div>

            <div class="ml-auto flex items-center gap-2">
                <!-- Theme toggle for user pages -->
                <button type="button" data-theme-toggle aria-pressed="false" title="Ganti tema" class="hidden rounded-lg border border-slate-300 bg-white p-2 text-slate-600 shadow-sm hover:bg-slate-50 md:inline-flex dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700/80">
                    <!-- Moon icon (shown in light mode) -->
                    <svg data-theme-icon="moon" class="size-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z" />
                    </svg>
                    <!-- Sun icon (shown in dark mode) -->
                    <svg data-theme-icon="sun" class="hidden size-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M6.76 4.84l-1.8-1.79-1.41 1.41 1.79 1.8 1.42-1.42zM1 13h3v-2H1v2zm10 10h2v-3h-2v3zm9-10v-2h-3v2h3zM17.66 4.46l1.79-1.8-1.41-1.41-1.8 1.79 1.42 1.42zM4.84 17.24l-1.79 1.8 1.41 1.41 1.8-1.79-1.42-1.42zM20 20l-1.41-1.41-1.8 1.79 1.41 1.41L20 20zM12 6a6 6 0 100 12A6 6 0 0012 6z"/>
                    </svg>
                </button>
                <div class="hidden items-center gap-2 rounded-lg bg-slate-100 px-2.5 py-1.5 text-sm md:flex">
                    <span class="inline-flex items-center gap-1 text-slate-600">
                        <svg class="size-4 text-emerald-600" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="3"/></svg>
                        Meja: <strong class="ml-1">A1</strong>
                    </span>
                </div>
                <button id="openCartBtn" class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-3 py-2 text-sm font-medium text-white shadow-sm hover:bg-primary-700 md:hidden">
                    <svg class="size-4" viewBox="0 0 24 24" fill="currentColor"><path d="M7 4h-2l-1 2h2l3.6 7.59-1.35 2.45A2 2 0 009 19h9v-2H9.42a.25.25 0 01-.22-.37L10 14h7a2 2 0 001.8-1.1l3.58-6.49A1 1 0 0021.5 5H7.42l-.7-1.4A1 1 0 005 3H2v2h2.2l3.2 6.4-1.1 2.03A2 2 0 008 17h10v2H8a4 4 0 01-3.6-2.2L3 13H2V7h2v4h1l2.2 4.4A2 2 0 009 17h9"/></svg>
                    <span id="cartCountBadge" class="rounded bg-white/20 px-1.5">0</span>
                </button>

                <!-- Profile dropdown -->
                <div id="userMenuContainer" class="relative">
                    <button id="userMenuButton" type="button" class="inline-flex items-center gap-2 rounded-lg bg-slate-100 px-2.5 py-1.5 text-sm" onclick="toggleUserMenu()" aria-haspopup="menu" aria-expanded="false">
                        <span class="grid size-7 place-items-center overflow-hidden rounded-full bg-primary-600 text-white">
                            {{ mb_substr(optional(auth()->user())->name ?? 'A', 0, 1) }}
                        </span>
                        <span class="hidden sm:inline max-w-36 truncate">{{ optional(auth()->user())->name ?? 'Tamu' }}</span>
                        <svg class="size-4 text-slate-500" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"/></svg>
                    </button>

                    <div id="userMenu" class="invisible pointer-events-none absolute right-0 mt-2 w-56 translate-y-1 rounded-lg border border-slate-200 bg-white p-1 opacity-0 shadow-lg transition duration-150 ease-out">
                        <a href="#" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">
                            <svg class="size-4 text-slate-400" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 100-10 5 5 0 000 10zm-7 9a7 7 0 0114 0H5z"/></svg>
                            Profil saya
                        </a>
                        <a href="#" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">
                            <svg class="size-4 text-slate-400" viewBox="0 0 24 24" fill="currentColor"><path d="M3 6h18v2H3V6zm0 5h18v2H3v-2zm0 5h12v2H3v-2z"/></svg>
                            Pesanan saya
                        </a>
                        <a href="#" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm text-slate-700 hover:bg-slate-50">
                            <svg class="size-4 text-slate-400" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 100 20 10 10 0 000-20zm1 15h-2v-2h2v2zm1.07-7.75l-.9.92A2.5 2.5 0 0012 13h-1v-1a3.5 3.5 0 011.02-2.49l1.2-1.2a1 1 0 10-1.41-1.41l-1.2 1.2a5.5 5.5 0 00-1.61 3.9V14a1 1 0 001 1h2a1 1 0 001-1 4.5 4.5 0 011.32-3.18l1-1a3 3 0 10-4.24-4.24l-.88.88 1.42 1.42.88-.88a1 1 0 111.41 1.41z"/></svg>
                            Bantuan
                        </a>
                        <div class="my-1 h-px bg-slate-200"></div>
                        @if (Route::has('auth.logout'))
                            <a href="#" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium text-rose-600 hover:bg-rose-50" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <svg class="size-4" viewBox="0 0 24 24" fill="currentColor"><path d="M16 13v-2H7V8l-5 4 5 4v-3h9zM20 3h-8v2h8v14h-8v2h8a2 2 0 002-2V5a2 2 0 00-2-2z"/></svg>
                                Keluar
                            </a>
                            <form id="logout-form" method="POST" action="{{ route('auth.logout') }}" class="hidden">@csrf</form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Layout -->
    <div class="mx-auto grid max-w-7xl grid-cols-1 gap-6 px-4 py-4 md:grid-cols-3 lg:grid-cols-4">
        <!-- Main content: filters + grid -->
        <section class="md:col-span-2 lg:col-span-3">
            <!-- Category filters -->
            <div class="no-scrollbar sticky top-16 z-10 -mx-4 bg-slate-50/80 px-4 py-3 backdrop-blur">
                <div class="flex items-center gap-2 overflow-x-auto">
                    <button class="chip active" data-filter="all">Semua</button>
                    <button class="chip" data-filter="makanan">Makanan</button>
                    <button class="chip" data-filter="minuman">Minuman</button>
                    <button class="chip" data-filter="snack">Snack</button>
                    <button class="chip" data-filter="paket">Paket</button>
                </div>
            </div>

            <!-- Menu grid -->
            <div id="menuGrid" class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3 xl:grid-cols-4">
                <!-- Item cards (sample data) -->
                @php
                    $items = [
                        ['id'=>'1','name'=>'Nasi Goreng Spesial','price'=>25000,'cat'=>'makanan','img'=>'https://images.unsplash.com/photo-1552541703-a56f34f5f427?q=80&w=800&auto=format&fit=crop'],
                        ['id'=>'2','name'=>'Mie Ayam Bakso','price'=>22000,'cat'=>'makanan','img'=>'https://images.unsplash.com/photo-1550547660-d9450f859349?q=80&w=800&auto=format&fit=crop'],
                        ['id'=>'3','name'=>'Ayam Bakar Madu','price'=>32000,'cat'=>'makanan','img'=>'https://images.unsplash.com/photo-1604908177079-9d79cbd8112c?q=80&w=800&auto=format&fit=crop'],
                        ['id'=>'4','name'=>'Es Teh Manis','price'=>6000,'cat'=>'minuman','img'=>'https://images.unsplash.com/photo-1541976076758-347942db1970?q=80&w=800&auto=format&fit=crop'],
                        ['id'=>'5','name'=>'Jus Mangga','price'=>15000,'cat'=>'minuman','img'=>'https://images.unsplash.com/photo-1556679343-c7306c1976bc?q=80&w=800&auto=format&fit=crop'],
                        ['id'=>'6','name'=>'Kopi Susu','price'=>18000,'cat'=>'minuman','img'=>'https://images.unsplash.com/photo-1517705008128-361805f42e86?q=80&w=800&auto=format&fit=crop'],
                        ['id'=>'7','name'=>'French Fries','price'=>12000,'cat'=>'snack','img'=>'https://images.unsplash.com/photo-1550547660-d9450f859349?q=80&w=800&auto=format&fit=crop'],
                        ['id'=>'8','name'=>'Pisang Goreng','price'=>10000,'cat'=>'snack','img'=>'https://images.unsplash.com/photo-1617195737493-49bf4f25bbee?q=80&w=800&auto=format&fit=crop'],
                        ['id'=>'9','name'=>'Paket Hemat 1','price'=>45000,'cat'=>'paket','img'=>'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=800&auto=format&fit=crop'],
                        ['id'=>'10','name'=>'Paket Bento','price'=>52000,'cat'=>'paket','img'=>'https://images.unsplash.com/photo-1544025162-d76694265947?q=80&w=800&auto=format&fit=crop'],
                        ['id'=>'11','name'=>'Soto Ayam','price'=>24000,'cat'=>'makanan','img'=>'https://images.unsplash.com/photo-1604908177079-9d79cbd8112c?q=80&w=800&auto=format&fit=crop'],
                        ['id'=>'12','name'=>'Teh Tarik','price'=>16000,'cat'=>'minuman','img'=>'https://images.unsplash.com/photo-1541976076758-347942db1970?q=80&w=800&auto=format&fit=crop'],
                    ];
                @endphp

                @foreach ($items as $it)
                <article class="group rounded-xl border border-slate-200 bg-white shadow-sm hover:border-primary-300" data-name="{{ strtolower($it['name']) }}" data-category="{{ $it['cat'] }}">
                    <div class="aspect-square w-full overflow-hidden rounded-t-xl bg-slate-100">
                        <img src="{{ $it['img'] }}" alt="{{ $it['name'] }}" class="size-full object-cover transition group-hover:scale-105" />
                    </div>
                    <div class="p-3">
                        <h3 class="line-clamp-1 font-medium">{{ $it['name'] }}</h3>
                        <p class="mt-1 text-sm text-slate-600">Rp <span>{{ number_format($it['price'],0,',','.') }}</span></p>
                        <button class="btn-add mt-3 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary-600 px-3 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-primary-700" data-id="{{ $it['id'] }}" data-name="{{ $it['name'] }}" data-price="{{ $it['price'] }}">
                            <svg class="size-4" viewBox="0 0 24 24" fill="currentColor"><path d="M11 11V6h2v5h5v2h-5v5h-2v-5H6v-2z"/></svg>
                            Tambah
                        </button>
                    </div>
                </article>
                @endforeach
            </div>
        </section>

        <!-- Cart drawer (desktop) -->
        <aside id="cartAside" class="hidden md:block">
            <div class="sticky top-20 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <h2 class="font-semibold">Keranjang</h2>
                    <button id="clearCartBtn" class="text-sm text-rose-600 hover:text-rose-700">Bersihkan</button>
                </div>
                <ul id="cartList" class="mt-3 max-h-[50svh] space-y-3 overflow-auto pr-1"></ul>
                <div class="mt-4 border-t border-slate-200 pt-3">
                    <div class="flex items-center justify-between text-sm text-slate-600">
                        <span>Subtotal</span>
                        <span id="subtotalLabel">Rp 0</span>
                    </div>
                    <button id="checkoutBtn" class="mt-3 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-linear-to-r from-primary-600 to-fuchsia-600 px-3 py-2 text-sm font-medium text-white shadow-sm hover:opacity-95">
                        Checkout
                    </button>
                </div>
            </div>
        </aside>
    </div>

    <!-- Mobile Cart Sheet -->
    <div id="cartSheet" class="fixed inset-0 z-40 hidden">
        <div class="absolute inset-0 bg-slate-900/40" onclick="toggleCart(false)"></div>
        <div class="absolute bottom-0 left-0 right-0 rounded-t-2xl bg-white p-4 shadow-2xl">
            <div class="mx-auto max-w-2xl">
                <div class="flex items-center justify-between">
                    <h2 class="font-semibold">Keranjang</h2>
                    <div class="flex items-center gap-3">
                        <button id="clearCartBtnMobile" class="text-sm text-rose-600">Bersihkan</button>
                        <button class="rounded-lg bg-slate-100 p-2" onclick="toggleCart(false)">
                            <svg class="size-5" viewBox="0 0 24 24" fill="currentColor"><path d="M6 18 18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
                <ul id="cartListMobile" class="mt-3 max-h-[40svh] space-y-3 overflow-auto"></ul>
                <div class="mt-4 border-t border-slate-200 pt-3">
                    <div class="flex items-center justify-between text-sm text-slate-600">
                        <span>Subtotal</span>
                        <span id="subtotalLabelMobile">Rp 0</span>
                    </div>
                    <button id="checkoutBtnMobile" class="mt-3 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-linear-to-r from-primary-600 to-fuchsia-600 px-3 py-2 text-sm font-medium text-white shadow-sm hover:opacity-95">
                        Checkout
                    </button>
                </div>
            </div>
        </div>
    </div>

    <x-swal />

    <style>
        .chip { @apply rounded-full border border-slate-300 bg-white px-3 py-1.5 text-sm text-slate-700 shadow-sm hover:bg-slate-50; }
    .chip.active { @apply border-primary-300 bg-primary-50 text-primary-700; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <script>
    (function(){
        const fmt = new Intl.NumberFormat('id-ID');
        const cart = new Map();
        const els = {
            search: document.getElementById('searchInput'),
            chips: Array.from(document.querySelectorAll('.chip')),
            grid: document.getElementById('menuGrid'),
            cards: () => Array.from(document.querySelectorAll('#menuGrid article')),
            addBtns: () => Array.from(document.querySelectorAll('.btn-add')),
            asideList: document.getElementById('cartList'),
            asideSubtotal: document.getElementById('subtotalLabel'),
            sheet: document.getElementById('cartSheet'),
            sheetList: document.getElementById('cartListMobile'),
            sheetSubtotal: document.getElementById('subtotalLabelMobile'),
            openCartBtn: document.getElementById('openCartBtn'),
            cartCountBadge: document.getElementById('cartCountBadge'),
            clearCartBtn: document.getElementById('clearCartBtn'),
            clearCartBtnMobile: document.getElementById('clearCartBtnMobile'),
            checkoutBtn: document.getElementById('checkoutBtn'),
            checkoutBtnMobile: document.getElementById('checkoutBtnMobile'),
        };

        function toggleCart(open){
            if (window.matchMedia('(min-width: 768px)').matches) return; // only mobile
            if (open) {
                els.sheet.classList.remove('hidden');
            } else {
                els.sheet.classList.add('hidden');
            }
        }
        window.toggleCart = toggleCart;

        function updateBadges(){
            const totalQty = Array.from(cart.values()).reduce((s,i)=>s+i.qty,0);
            if (els.cartCountBadge) els.cartCountBadge.textContent = totalQty;
        }

        function renderCartList(targetList){
            const list = targetList;
            list.innerHTML = '';
            if (cart.size === 0){
                list.innerHTML = '<li class="text-sm text-slate-500">Keranjang kosong</li>';
                return;
            }
            cart.forEach(item => {
                const li = document.createElement('li');
                li.innerHTML = `
                    <div class="flex items-center gap-3">
                        <div class="grid size-10 place-items-center rounded-lg bg-slate-100 text-slate-500">${item.name.charAt(0)}</div>
                        <div class="flex-1">
                            <p class="text-sm font-medium">${item.name}</p>
                            <p class="text-xs text-slate-500">Rp ${fmt.format(item.price)}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button class="btn-dec rounded-md border border-slate-300 bg-white px-2 py-1 text-sm" data-id="${item.id}">-</button>
                            <span class="w-6 text-center text-sm">${item.qty}</span>
                            <button class="btn-inc rounded-md border border-slate-300 bg-white px-2 py-1 text-sm" data-id="${item.id}">+</button>
                            <button class="btn-del rounded-md bg-rose-50 px-2 py-1 text-sm text-rose-600" data-id="${item.id}">Hapus</button>
                        </div>
                    </div>`;
                list.appendChild(li);
            });
        }

        function render(){
            renderCartList(els.asideList);
            renderCartList(els.sheetList);
            const subtotal = Array.from(cart.values()).reduce((s,i)=>s+i.price*i.qty,0);
            els.asideSubtotal.textContent = 'Rp ' + fmt.format(subtotal);
            els.sheetSubtotal.textContent = 'Rp ' + fmt.format(subtotal);
            updateBadges();
        }

        function addToCart({id,name,price}){
            const item = cart.get(id) || {id,name,price,qty:0};
            item.qty += 1;
            cart.set(id, item);
            render();
            if (window.$swal) $swal.toast({ icon: 'success', title: `${name} ditambahkan` });
        }

        function changeQty(id, diff){
            const item = cart.get(id);
            if (!item) return;
            item.qty += diff;
            if (item.qty <= 0) cart.delete(id);
            render();
        }

        function removeItem(id){
            if (!cart.has(id)) return;
            cart.delete(id);
            render();
        }

        // Hook add buttons
        function bindAddButtons(){
            els.addBtns().forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = String(btn.dataset.id);
                    addToCart({ id, name: btn.dataset.name, price: Number(btn.dataset.price) });
                });
            });
        }

        // Delegate cart actions
        [els.asideList, els.sheetList].forEach(list => {
            list.addEventListener('click', (e) => {
                const t = e.target;
                const id = t.dataset.id;
                if (!id) return;
                if (t.classList.contains('btn-inc')) changeQty(id, +1);
                if (t.classList.contains('btn-dec')) changeQty(id, -1);
                if (t.classList.contains('btn-del')) removeItem(id);
            });
        });

        // Filters
        els.chips.forEach(ch => ch.addEventListener('click', () => {
            els.chips.forEach(c => c.classList.remove('active'));
            ch.classList.add('active');
            applyFilters();
        }));
        if (els.search) els.search.addEventListener('input', applyFilters);
        function applyFilters(){
            const q = (els.search?.value || '').trim().toLowerCase();
            const active = document.querySelector('.chip.active')?.dataset.filter || 'all';
            els.cards().forEach(card => {
                const name = card.dataset.name;
                const cat = card.dataset.category;
                const okQ = !q || name.includes(q);
                const okC = active === 'all' || cat === active;
                card.classList.toggle('hidden', !(okQ && okC));
            });
        }

        // Open cart (mobile)
        if (els.openCartBtn) els.openCartBtn.addEventListener('click', () => toggleCart(true));
        if (els.clearCartBtn) els.clearCartBtn.addEventListener('click', () => { cart.clear(); render(); });
        if (els.clearCartBtnMobile) els.clearCartBtnMobile.addEventListener('click', () => { cart.clear(); render(); });

        function doCheckout(){
            const subtotal = Array.from(cart.values()).reduce((s,i)=>s+i.price*i.qty,0);
            if (cart.size === 0) { if (window.$swal) $swal.toast({icon:'info', title:'Keranjang kosong'}); return; }
            const text = `Total Rp ${fmt.format(subtotal)} untuk ${Array.from(cart.values()).reduce((s,i)=>s+i.qty,0)} item.`;
            if (window.$swal) {
                $swal.confirm({ title: 'Konfirmasi pesanan', text }).then(r => {
                    if (r.isConfirmed) {
                        $swal.toast({ icon: 'success', title: 'Pesanan dibuat!' });
                        cart.clear();
                        render();
                        toggleCart(false);
                    }
                });
            }
        }
        if (els.checkoutBtn) els.checkoutBtn.addEventListener('click', doCheckout);
        if (els.checkoutBtnMobile) els.checkoutBtnMobile.addEventListener('click', doCheckout);

        bindAddButtons();
        applyFilters();
        render();
    })();

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
    </script>
</body>
</html>