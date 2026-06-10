<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>POSApp – Point of Sale untuk Restoran/Kantin</title>
    <meta name="description" content="POSApp adalah sistem POS modern untuk restoran/kantin: kelola menu, kategori, transaksi, dan dashboard admin. Siap Laravel Sanctum.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-slate-50 text-slate-900" style="font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, 'Helvetica Neue', Arial">
    <!-- Header -->
    <header class="sticky top-0 z-40 bg-white/70 backdrop-blur border-b border-slate-200">
      <div class="max-w-7xl mx-auto px-4 py-3 flex items-center gap-6">
        <a href="#" class="text-2xl tracking-tight" style="font-family: 'Playfair Display', Georgia, 'Times New Roman', serif">POSApp</a>
        <nav class="hidden md:flex items-center gap-5 text-sm">
          <a href="#fitur" class="hover:text-slate-600 transition-colors">Fitur</a>
          <a href="#cara-kerja" class="hover:text-slate-600 transition-colors">Cara Kerja</a>
          <a href="#demo" class="hover:text-slate-600 transition-colors">Demo</a>
          <a href="#kontak" class="hover:text-slate-600 transition-colors">Kontak</a>
        </nav>
        <div class="ml-auto flex items-center gap-2">
          <a data-testid="landing-cta-get-started" href="./posapp.html" class="px-4 py-2 rounded-full bg-sky-600 text-white hover:bg-sky-700 shadow-sm transition-colors">Coba Sekarang</a>
          <a data-testid="landing-cta-admin-demo" href="./posapp.html#admin" class="px-4 py-2 rounded-full border border-slate-200 hover:bg-slate-50 transition-colors">Demo Admin</a>
        </div>
      </div>
    </header>

    <!-- Hero -->
    <section class="relative overflow-hidden">
  <div class="absolute inset-0 bg-linear-to-b from-primary-50 to-transparent"></div>
      <div class="relative max-w-7xl mx-auto px-4 py-16 md:py-24 grid lg:grid-cols-2 gap-10 items-center">
        <div>
          <h1 class="text-4xl sm:text-5xl lg:text-6xl leading-tight" style="font-family: 'Playfair Display', Georgia, 'Times New Roman', serif">Point of Sale modern untuk restoran & kantin</h1>
          <p class="mt-4 text-slate-600 text-base md:text-lg">Kelola menu, stok, transaksi, dan laporan penjualan dalam satu tempat. Siap integrasi Laravel Sanctum.</p>
          <div class="mt-6 flex flex-wrap gap-3">
            <a data-testid="hero-cta-start" href="./posapp.html" class="px-5 py-3 rounded-full bg-emerald-600 text-white hover:bg-emerald-700 shadow transition-colors">Mulai Gratis</a>
            <a data-testid="hero-cta-learn" href="#fitur" class="px-5 py-3 rounded-full border border-slate-200 hover:bg-white transition-colors">Lihat Fitur</a>
          </div>
          <div class="mt-4 text-xs text-slate-500">Login demo admin: admin@gmail.com / admin123</div>
        </div>
        <div class="relative">
          <div class="rounded-2xl bg-white p-4 shadow-lg ring-1 ring-slate-900/5">
            <div class="h-64 md:h-80 rounded-xl bg-gradient-to-b from-white via-slate-50 to-slate-100 flex items-center justify-center">
              <div class="text-center">
                <div class="text-sm text-slate-500">Tangkapan Layar</div>
                <div class="mt-2 font-semibold">Dashboard & Katalog Menu</div>
              </div>
            </div>
          </div>
          <div class="absolute -bottom-6 -left-6 hidden md:flex items-center gap-2 px-4 py-3 rounded-xl bg-white shadow ring-1 ring-slate-900/5">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-sky-600"><path d="M12 3a9 9 0 100 18 9 9 0 000-18zm1 13H8v-2h5v2zm3-4H8V8h8v4z"/></svg>
            <div class="text-sm"><span class="font-semibold">Realtime</span> statistik penjualan</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Features -->
    <section id="fitur" class="py-14">
      <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl sm:text-4xl" style="font-family: 'Playfair Display', Georgia, 'Times New Roman', serif">Fitur Utama</h2>
        <p class="mt-2 text-slate-600 max-w-2xl">Semua yang Anda butuhkan untuk operasional POS: role admin & user, katalog, keranjang, checkout, transaksi, dan laporan.</p>
        <div class="mt-8 grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
          <div class="rounded-2xl p-5 bg-white shadow ring-1 ring-slate-900/5">
            <div class="flex items-center gap-3"><span class="text-emerald-600">◆</span><div class="font-semibold">Role-based Access</div></div>
            <p class="mt-2 text-sm text-slate-600">Admin & User dengan proteksi halaman dan aksi.</p>
          </div>
          <div class="rounded-2xl p-5 bg-white shadow ring-1 ring-slate-900/5">
            <div class="flex items-center gap-3"><span class="text-sky-600">◆</span><div class="font-semibold">Katalog Menu</div></div>
            <p class="mt-2 text-sm text-slate-600">Grid menu dengan pencarian & filter kategori.</p>
          </div>
          <div class="rounded-2xl p-5 bg-white shadow ring-1 ring-slate-900/5">
            <div class="flex items-center gap-3"><span class="text-rose-600">◆</span><div class="font-semibold">Keranjang & Checkout</div></div>
            <p class="mt-2 text-sm text-slate-600">Proses pembelian cepat, stok berkurang otomatis.</p>
          </div>
          <div class="rounded-2xl p-5 bg-white shadow ring-1 ring-slate-900/5">
            <div class="flex items-center gap-3"><span class="text-primary-600">◆</span><div class="font-semibold">Laporan Penjualan</div></div>
            <p class="mt-2 text-sm text-slate-600">Harian, mingguan, bulanan, serta menu terlaris.</p>
          </div>
          <div class="rounded-2xl p-5 bg-white shadow ring-1 ring-slate-900/5">
            <div class="flex items-center gap-3"><span class="text-amber-600">◆</span><div class="font-semibold">Export PDF/Excel</div></div>
            <p class="mt-2 text-sm text-slate-600">Siap diintegrasikan ke laporan keuangan.</p>
          </div>
          <div class="rounded-2xl p-5 bg-white shadow ring-1 ring-slate-900/5">
            <div class="flex items-center gap-3"><span class="text-slate-700">◆</span><div class="font-semibold">Sanctum-ready</div></div>
            <p class="mt-2 text-sm text-slate-600">Autentikasi aman via Laravel Sanctum.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- How it works -->
    <section id="cara-kerja" class="py-14 bg-white">
      <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl sm:text-4xl" style="font-family: 'Playfair Display', Georgia, 'Times New Roman', serif">Cara Kerja</h2>
        <div class="mt-8 grid md:grid-cols-3 gap-6">
          <div class="rounded-2xl p-6 bg-white shadow ring-1 ring-slate-900/5">
            <div class="text-sm text-slate-500">Langkah 1</div>
            <div class="mt-1 font-semibold">Masuk</div>
            <p class="mt-2 text-sm text-slate-600">Login admin untuk mengelola menu & kategori. User untuk pembelian.</p>
          </div>
          <div class="rounded-2xl p-6 bg-white shadow ring-1 ring-slate-900/5">
            <div class="text-sm text-slate-500">Langkah 2</div>
            <div class="mt-1 font-semibold">Kelola Katalog</div>
            <p class="mt-2 text-sm text-slate-600">Tambah menu, atur harga & stok, kategorikan item.</p>
          </div>
          <div class="rounded-2xl p-6 bg-white shadow ring-1 ring-slate-900/5">
            <div class="text-sm text-slate-500">Langkah 3</div>
            <div class="mt-1 font-semibold">Transaksi</div>
            <p class="mt-2 text-sm text-slate-600">User checkout, transaksi tercatat otomatis.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Demo CTA -->
    <section id="demo" class="py-14">
      <div class="max-w-7xl mx-auto px-4 grid md:grid-cols-2 gap-8 items-center">
        <div>
          <h3 class="text-3xl" style="font-family: 'Playfair Display', Georgia, 'Times New Roman', serif">Coba Demo Sekarang</h3>
          <p class="mt-2 text-slate-600">Gunakan kredensial demo admin: admin@gmail.com / admin123</p>
          <div class="mt-5 flex gap-3">
            <a data-testid="landing-cta-demo-admin" href="./posapp.html" class="px-5 py-3 rounded-full bg-neutral-900 text-white hover:bg-black shadow transition-colors">Buka Demo Admin</a>
            <a data-testid="landing-cta-open-app" href="./posapp.html" class="px-5 py-3 rounded-full border border-slate-200 hover:bg-white transition-colors">Buka Aplikasi</a>
          </div>
        </div>
        <div class="rounded-2xl p-4 bg-white shadow ring-1 ring-slate-900/5">
          <div class="h-64 rounded-xl bg-gradient-to-br from-white to-slate-100 flex items-center justify-center text-slate-500">Preview Aplikasi</div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="border-t border-slate-200 bg-white">
      <div class="max-w-7xl mx-auto px-4 py-8 flex flex-col md:flex-row gap-4 items-center justify-between">
        <div class="text-sm text-slate-600">© <span data-testid="landing-copyright-year"></span> POSApp. Semua hak dilindungi.</div>
        <div class="flex items-center gap-3 text-sm">
          <a href="#fitur" class="hover:text-slate-600 transition-colors">Fitur</a>
          <a href="#cara-kerja" class="hover:text-slate-600 transition-colors">Cara Kerja</a>
          <a href="#demo" class="hover:text-slate-600 transition-colors">Demo</a>
        </div>
      </div>
    </footer>

    <script>
      document.querySelector('[data-testid="landing-copyright-year"]').textContent = new Date().getFullYear();
    </script>
  </body>
</html>