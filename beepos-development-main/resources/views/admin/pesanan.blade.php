<!DOCTYPE html>
<html lang="id" class="h-full bg-linear-to-br from-slate-50 via-white to-slate-50">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>POS - Manajemen Pesanan</title>
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
	<style>
		/* Font smoothing and scroll behavior - not available in Tailwind */
		* { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
		.scroll-smooth { scroll-behavior: smooth; }
	</style>
</head>
<body class="h-full text-slate-800">
	<div class="min-h-screen flex">
		<x-admin.sidebar :menu="'Pesanan'" />
		
		<!-- Main Content Area -->
		<div class="flex-1 flex flex-col lg:ml-72">
			<!-- Modern Header with Glassmorphism -->
			<header class="sticky top-0 z-30 border-b border-slate-200/60 bg-white/80 backdrop-blur-xl shadow-sm">
				<div class="px-4 sm:px-6 lg:px-8">
					<div class="flex h-16 items-center justify-between gap-4">
						<!-- Title Section -->
						<div class="flex items-center gap-3">
							<!-- Sidebar toggle (desktop) -->
							<button type="button" data-sidebar-toggle aria-pressed="false" title="Sembunyikan/Tampilkan sidebar" class="hidden lg:inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white p-2 text-slate-600 shadow-sm transition hover:bg-slate-50 active:scale-95 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700/80">
								<!-- collapse icon (default) -->
								<svg data-icon="collapse" class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
									<path d="M3 5.25A2.25 2.25 0 015.25 3h13.5A2.25 2.25 0 0121 5.25v13.5A2.25 2.25 0 0118.75 21H5.25A2.25 2.25 0 013 18.75V5.25zM8.47 8.47a.75.75 0 011.06 0L12 10.94l2.47-2.47a.75.75 0 111.06 1.06L13.06 12l2.47 2.47a.75.75 0 11-1.06 1.06L12 13.06l-2.47 2.47a.75.75 0 11-1.06-1.06L10.94 12 8.47 9.53a.75.75 0 010-1.06z"/>
								</svg>
								<!-- expand icon (shown when collapsed) -->
								<svg data-icon="expand" class="hidden size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
									<path d="M3 5.25A2.25 2.25 0 015.25 3h13.5A2.25 2.25 0 0121 5.25v13.5A2.25 2.25 0 0118.75 21H5.25A2.25 2.25 0 013 18.75V5.25zM8.47 12a.75.75 0 01.75-.75h5.56a.75.75 0 010 1.5H9.22A.75.75 0 018.47 12z"/>
								</svg>
							</button>
							<div class="flex size-11 items-center justify-center rounded-xl bg-linear-to-br from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/30 ring-1 ring-primary-600/10">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
									<path d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"/>
								</svg>
							</div>
							<div class="hidden sm:block">
								<h1 class="text-lg font-bold text-slate-900">Point of Sale</h1>
								<p class="text-xs text-slate-500">Kelola transaksi dan pesanan harian</p>
							</div>
						</div>

						<!-- Actions -->
						<div class="flex items-center gap-3">
							<div id="clock" class="hidden rounded-lg bg-slate-100/80 px-3 py-2 text-sm font-semibold tabular-nums text-slate-700 lg:block">--:--</div>
							<button id="openOrders" type="button" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:bg-slate-50 hover:shadow active:scale-95 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700/80">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-primary-600">
									<path d="M3 3.75A.75.75 0 013.75 3h16.5a.75.75 0 01.75.75V6a.75.75 0 01-.75.75H3.75A.75.75 0 013 6V3.75zM3 10.5A.75.75 0 013.75 9.75h16.5a.75.75 0 01.75.75v2.25a.75.75 0 01-.75.75H3.75A.75.75 0 013 12.75V10.5zm0 6.75A.75.75 0 013.75 16.5h16.5a.75.75 0 01.75.75V21a.75.75 0 01-.75.75H3.75A.75.75 0 013 21v-2.25z"/>
								</svg>
								<span class="hidden sm:inline">Pesanan Terakhir</span>
								<span class="sm:hidden">Riwayat</span>
							</button>
						</div>
					</div>
				</div>
			</header>

			<!-- Content -->
			<main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
				<div class="mx-auto max-w-[1800px]">
					<div class="grid grid-cols-1 gap-5 lg:grid-cols-3 xl:grid-cols-7">
					
					<!-- Products / Catalog Section -->
					<section class="lg:col-span-2 xl:col-span-5">
						<div class="flex h-full flex-col overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
							
							<!-- Search & Filter Bar -->
							<div class="border-b border-slate-200 bg-white p-4">
								<div class="space-y-3">
									<!-- Search Input -->
									<div class="relative">
										<div class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
											<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
												<path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd"/>
											</svg>
										</div>
										<input id="search" type="search" placeholder="Cari menu..." class="w-full rounded-lg border-slate-300 bg-slate-50 py-2.5 pl-10 pr-4 text-sm placeholder:text-slate-400 transition-all focus:border-primary-500 focus:bg-white focus:ring-2 focus:ring-primary-500/20" />
									</div>
									
									<!-- Category Filters -->
									<div class="flex flex-wrap gap-2">
										<button data-category="all" class="cat-btn btn-hover rounded-lg bg-primary-600 px-4 py-2 text-sm font-medium text-white shadow-sm shadow-primary-500/20">
											Semua
										</button>
										<button data-category="makanan" class="cat-btn btn-hover rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:border-primary-300 hover:bg-primary-50">
											Makanan
										</button>
										<button data-category="minuman" class="cat-btn btn-hover rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:border-primary-300 hover:bg-primary-50">
											Minuman
										</button>
										<button data-category="lainnya" class="cat-btn btn-hover rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:border-primary-300 hover:bg-primary-50">
											Lainnya
										</button>
									</div>
								</div>
							</div>

							<!-- Product Grid -->
							<div id="productGrid" class="scrollbar-custom grid max-h-[calc(100vh-320px)] grow auto-rows-min grid-cols-2 gap-3 overflow-auto bg-slate-50 p-4 sm:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">
								<!-- Rendered by JS -->
							</div>
						</div>
					</section>

				<!-- Cart / Checkout -->
				<aside class="lg:col-span-1 xl:col-span-2">
					<div class="sticky top-20 flex flex-col overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
						<!-- Cart Header -->
						<div class="border-b border-slate-200 bg-slate-50 px-4 py-3">
							<h2 class="text-base font-semibold text-slate-900">Keranjang</h2>
							<p class="text-xs text-slate-500 mt-0.5">Pesanan saat ini</p>
						</div>
						
						<!-- Cart Items -->
						<div class="scrollbar-custom overflow-auto bg-white" style="max-height: calc(100vh - 620px); min-height: 200px;">
							<div id="emptyState" class="flex flex-col items-center justify-center py-12 px-4">
								<div class="mb-3 grid size-14 place-items-center rounded-full bg-slate-100">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="size-7 text-slate-400">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 1 0 0 6m9-6a3 3 0 1 0 0 6M7.5 14.25h9M7.5 14.25L5.106 5.272A1.125 1.125 0 0 0 3.986 4.5H2.25m16.5 9.75L20.613 7.5H6.741"/>
									</svg>
								</div>
								<p class="text-center text-sm font-medium text-slate-600">Belum ada pesanan</p>
								<p class="text-center text-xs text-slate-400 mt-1">Pilih menu untuk memulai</p>
							</div>
							<div id="cartList" class="hidden space-y-2 p-3"></div>
						</div>

						<!-- Cart Footer / Checkout -->
						<div class="border-t border-slate-200 bg-slate-50 p-4 space-y-3">
							<!-- Customer & Notes -->
							<div class="space-y-2">
								<div>
									<label class="text-xs font-medium text-slate-600 mb-1 block">Nama Pelanggan</label>
									<input id="customer" type="text" class="w-full rounded-lg border-slate-300 bg-white py-2 px-3 text-sm transition-all focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20" placeholder="Contoh: Budi" />
								</div>
								<div>
									<label class="text-xs font-medium text-slate-600 mb-1 block">Catatan</label>
									<input id="note" type="text" class="w-full rounded-lg border-slate-300 bg-white py-2 px-3 text-sm transition-all focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20" placeholder="Catatan tambahan" />
								</div>
							</div>

							<!-- Discount & Tax -->
							<div class="grid grid-cols-2 gap-2">
								<div>
									<label class="text-xs font-medium text-slate-600 mb-1 block">Diskon (Rp)</label>
									<input id="discount" type="number" min="0" value="0" class="w-full rounded-lg border-slate-300 bg-white py-2 px-3 text-sm transition-all focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20" />
								</div>
								<div class="flex items-end">
									<label class="inline-flex items-center gap-2 text-sm font-medium text-slate-700 cursor-pointer">
										<input id="taxToggle" type="checkbox" class="rounded border-slate-300 text-primary-600 transition-all focus:ring-2 focus:ring-primary-500/20"> 
										<span>Pajak 10%</span>
									</label>
								</div>
							</div>

							<!-- Totals -->
							<div class="space-y-2 rounded-lg bg-white border border-slate-200 p-3 text-sm">
								<div class="flex justify-between text-slate-600">
									<span>Subtotal</span>
									<span id="subtotal" class="font-semibold tabular-nums">Rp0</span>
								</div>
								<div class="flex justify-between text-slate-600">
									<span>Diskon</span>
									<span id="discountLbl" class="font-semibold tabular-nums text-rose-600">- Rp0</span>
								</div>
								<div class="flex justify-between text-slate-600">
									<span>Pajak</span>
									<span id="taxLbl" class="font-semibold tabular-nums">Rp0</span>
								</div>
								<div class="flex justify-between border-t border-slate-200 pt-2 text-base font-bold">
									<span>Total</span>
									<span id="grandTotal" class="tabular-nums text-primary-600">Rp0</span>
								</div>
							</div>

							<!-- Cash & Change -->
							<div class="space-y-2">
								<div>
									<label class="text-xs font-medium text-slate-600 mb-1 block">Uang Diterima</label>
									<input id="cash" type="number" min="0" value="0" class="w-full rounded-lg border-slate-300 bg-white py-2 px-3 text-sm font-semibold transition-all focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20" />
								</div>
								<div class="flex items-center justify-between rounded-lg bg-emerald-50 border border-emerald-200 px-3 py-2">
									<span class="text-xs font-medium text-emerald-700">Kembalian</span>
									<span id="change" class="text-base font-bold tabular-nums text-emerald-700">Rp0</span>
								</div>
							</div>

							<!-- Action Buttons -->
							<div class="grid grid-cols-3 gap-2 pt-1">
								<button id="draftBtn" class="btn-hover inline-flex items-center justify-center gap-1.5 rounded-lg border border-slate-300 bg-white py-2.5 text-sm font-medium text-slate-700 transition-all hover:bg-slate-50">
									<svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
										<path fill-rule="evenodd" d="M10 3a.75.75 0 01.75.75v6.5h6.5a.75.75 0 010 1.5h-6.5v6.5a.75.75 0 01-1.5 0v-6.5h-6.5a.75.75 0 010-1.5h6.5v-6.5A.75.75 0 0110 3z" clip-rule="evenodd"/>
									</svg>
									<span class="hidden xl:inline">Draf</span>
								</button>
								<button id="cancelBtn" class="btn-hover inline-flex items-center justify-center gap-1.5 rounded-lg border border-rose-300 bg-rose-50 py-2.5 text-sm font-medium text-rose-700 transition-all hover:bg-rose-100">
									<svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
										<path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"/>
									</svg>
									<span class="hidden xl:inline">Batal</span>
								</button>
								<button id="payBtn" class="btn-hover inline-flex items-center justify-center gap-1.5 rounded-lg bg-primary-600 py-2.5 text-sm font-semibold text-white shadow-md shadow-primary-500/30 transition-all hover:bg-primary-700 disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none" disabled>
									<svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
										<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
									</svg>
									<span>Bayar</span>
								</button>
							</div>
						</div>
					</div>
				</aside>
			</div>
		</main>
	</div>

	<!-- Modal: Detail Pesanan -->
	<div id="detailModal" class="fixed inset-0 z-50 hidden">
		<div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeDetailModal()"></div>
		<div class="flex items-center justify-center min-h-screen p-4">
			<div class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full transform transition-all animate-slide-up">
				<!-- Modal Header -->
				<div class="border-b border-slate-200 px-6 py-4">
					<div class="flex items-center justify-between">
						<div>
							<h3 class="text-lg font-bold text-slate-900">Detail Pesanan</h3>
							<p id="detailOrderId" class="text-sm text-slate-500 mt-0.5">Order ID: -</p>
						</div>
						<button onclick="closeDetailModal()" class="rounded-lg p-2 text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-600">
							<svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
								<path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"/>
							</svg>
						</button>
					</div>
				</div>

				<!-- Modal Body -->
				<div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto scrollbar-custom">
					<!-- Customer Info -->
					<div class="grid grid-cols-2 gap-4">
						<div>
							<label class="text-xs font-medium text-slate-600 block mb-1">Customer</label>
							<p id="detailCustomer" class="text-sm font-semibold text-slate-900">-</p>
						</div>
						<div>
							<label class="text-xs font-medium text-slate-600 block mb-1">Tanggal</label>
							<p id="detailDate" class="text-sm font-semibold text-slate-900">-</p>
						</div>
					</div>

					<!-- Items List -->
					<div>
						<label class="text-xs font-medium text-slate-600 block mb-2">Item Pesanan</label>
						<div id="detailItemsList" class="space-y-2">
							<!-- Items will be populated here -->
						</div>
					</div>

					<!-- Payment Info -->
					<div class="rounded-lg border border-slate-200 p-4 space-y-2">
						<div class="flex justify-between text-sm">
							<span class="text-slate-600">Subtotal:</span>
							<span id="detailSubtotal" class="font-semibold">Rp 0</span>
						</div>
						<div class="flex justify-between text-sm">
							<span class="text-slate-600">Diskon:</span>
							<span id="detailDiscountAmt" class="font-semibold text-rose-600">- Rp 0</span>
						</div>
						<div class="flex justify-between text-base font-bold border-t pt-2">
							<span>Total:</span>
							<span id="detailTotal" class="text-primary-600">Rp 0</span>
						</div>
						<div id="detailPaymentInfo" class="hidden border-t pt-2 space-y-1 text-sm">
							<div class="flex justify-between">
								<span class="text-slate-600">Metode Pembayaran:</span>
								<span id="detailPaymentMethod" class="font-semibold">-</span>
							</div>
							<div id="detailCashInfo" class="hidden space-y-1">
								<div class="flex justify-between">
									<span class="text-slate-600">Uang Diterima:</span>
									<span id="detailCashReceived" class="font-semibold">Rp 0</span>
								</div>
								<div class="flex justify-between">
									<span class="text-slate-600">Kembalian:</span>
									<span id="detailChangeAmount" class="font-semibold text-emerald-600">Rp 0</span>
								</div>
							</div>
							<div id="detailQrisInfo" class="hidden">
								<div class="flex justify-between">
									<span class="text-slate-600">Reference:</span>
									<span id="detailPaymentRef" class="font-mono text-xs">-</span>
								</div>
							</div>
						</div>
					</div>
				</div>

			<!-- Modal Footer -->
			<div class="border-t border-slate-200 px-6 py-4 bg-slate-50">
				<div class="flex gap-3">
					<button onclick="printOrderReceipt()" class="flex-1 rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white transition-all hover:bg-primary-700 flex items-center justify-center gap-2">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
							<path fill-rule="evenodd" d="M5 2.75C5 1.784 5.784 1 6.75 1h6.5c.966 0 1.75.784 1.75 1.75v3.552c.377.046.752.097 1.126.153A2.212 2.212 0 0118 8.653v4.097A2.25 2.25 0 0115.75 15h-.241l.305 1.984A1.75 1.75 0 0114.084 19H5.915a1.75 1.75 0 01-1.73-2.016L4.492 15H4.25A2.25 2.25 0 012 12.75V8.653c0-1.082.775-2.034 1.874-2.198.374-.056.75-.107 1.127-.153L5 6.25v-3.5zm8.5 3.397a41.533 41.533 0 00-7 0V2.75a.25.25 0 01.25-.25h6.5a.25.25 0 01.25.25v3.397zM6.608 12.5a.25.25 0 00-.247.212l-.693 4.5a.25.25 0 00.247.288h8.17a.25.25 0 00.246-.288l-.692-4.5a.25.25 0 00-.247-.212H6.608z" clip-rule="evenodd" />
						</svg>
						Cetak Struk
					</button>
					<button onclick="closeDetailModal()" class="flex-1 rounded-lg bg-slate-600 px-4 py-2.5 text-sm font-semibold text-white transition-all hover:bg-slate-700">
						Tutup
					</button>
				</div>
			</div>
		</div>
	</div>
</div>	<!-- Modal: Ubah Status -->
	<div id="statusModal" class="fixed inset-0 z-50 hidden">
		<div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeStatusModal()"></div>
		<div class="flex items-center justify-center min-h-screen p-4">
			<div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all animate-slide-up">
				<!-- Modal Header -->
				<div class="border-b border-slate-200 px-6 py-4">
					<div class="flex items-center justify-between">
						<div>
							<h3 class="text-lg font-bold text-slate-900">Ubah Status Pesanan</h3>
							<p id="statusOrderId" class="text-sm text-slate-500 mt-0.5">Order ID: -</p>
						</div>
						<button onclick="closeStatusModal()" class="rounded-lg p-2 text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-600">
							<svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
								<path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"/>
							</svg>
						</button>
					</div>
				</div>

				<!-- Modal Body -->
				<div class="p-6 space-y-4">
					<div>
						<label class="text-sm font-medium text-slate-700 block mb-2">Pilih Status Baru</label>
						<select id="newStatus" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
							<option value="draft">Draft</option>
							<option value="pending">Pending</option>
							<option value="paid">Paid (Lunas)</option>
							<option value="cancelled">Cancelled (Dibatalkan)</option>
						</select>
					</div>
					<div class="rounded-lg bg-blue-50 border border-blue-200 p-4">
						<div class="flex gap-3">
							<svg class="size-5 text-blue-600 shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
								<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
							</svg>
							<div class="text-sm text-blue-900">
								<p class="font-medium mb-1">Status Pesanan:</p>
								<ul class="space-y-1 text-xs">
									<li><strong>Draft:</strong> Pesanan tersimpan, belum dibayar</li>
									<li><strong>Pending:</strong> Menunggu konfirmasi pembayaran</li>
									<li><strong>Paid:</strong> Pembayaran sudah lunas</li>
									<li><strong>Cancelled:</strong> Pesanan dibatalkan</li>
								</ul>
							</div>
						</div>
					</div>
				</div>

				<!-- Modal Footer -->
				<div class="border-t border-slate-200 px-6 py-4 bg-slate-50 flex gap-3">
					<button onclick="closeStatusModal()" class="flex-1 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition-all hover:bg-slate-50">
						Batal
					</button>
					<button onclick="saveStatusChange()" class="flex-1 rounded-lg bg-primary-600 px-4 py-2.5 text-sm font-semibold text-white transition-all hover:bg-primary-700">
						Simpan
					</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal: Payment Method Selection -->
	<div id="paymentModal" class="fixed inset-0 z-50 hidden">
		<div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closePaymentModal()"></div>
		<div class="flex items-center justify-center min-h-screen p-4">
			<div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full transform transition-all animate-slide-up">
				<!-- Modal Header -->
				<div class="border-b border-slate-200 px-6 py-4">
					<div class="flex items-center justify-between">
						<div>
							<h3 class="text-lg font-bold text-slate-900">Pilih Metode Pembayaran</h3>
							<p class="text-sm text-slate-500 mt-0.5">Bagaimana pelanggan akan membayar?</p>
						</div>
						<button onclick="closePaymentModal()" class="rounded-lg p-2 text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-600">
							<svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
								<path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"/>
							</svg>
						</button>
					</div>
				</div>
				
				<!-- Modal Body -->
				<div class="p-6 space-y-4">
					<!-- Order Summary -->
					<div class="rounded-xl bg-linear-to-br from-primary-50 to-primary-100/50 border border-primary-200 p-4">
						<div class="flex items-center justify-between mb-3">
							<span class="text-sm font-medium text-primary-900">Total Pembayaran</span>
							<span id="modalTotal" class="text-2xl font-bold text-primary-600">Rp 0</span>
						</div>
						<div class="space-y-1.5 text-xs text-primary-800">
							<div class="flex justify-between">
								<span>Subtotal:</span>
								<span id="modalSubtotal" class="font-semibold">Rp 0</span>
							</div>
							<div class="flex justify-between">
								<span>Diskon:</span>
								<span id="modalDiscount" class="font-semibold text-rose-600">- Rp 0</span>
							</div>
							<div class="flex justify-between">
								<span>Pajak:</span>
								<span id="modalTax" class="font-semibold">Rp 0</span>
							</div>
						</div>
					</div>

					<!-- Payment Methods -->
					<div class="space-y-3">
						<p class="text-sm font-semibold text-slate-700">Metode Pembayaran</p>
						
						<!-- Cash Payment -->
						<button onclick="selectPaymentMethod('cash')" class="payment-method-btn group w-full flex items-center gap-4 rounded-xl border-2 border-slate-200 bg-white p-4 text-left transition-all hover:border-emerald-500 hover:bg-emerald-50 active:scale-[0.98]">
							<div class="flex size-12 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 transition-colors group-hover:bg-emerald-600 group-hover:text-white">
								<svg class="size-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
									<path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 01-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004zM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 01-.921.42z" />
									<path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v.816a3.836 3.836 0 00-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 01-.921-.421l-.879-.66a.75.75 0 00-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 001.5 0v-.81a4.124 4.124 0 001.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 00-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 00.933-1.175l-.415-.33a3.836 3.836 0 00-1.719-.755V6z" clip-rule="evenodd" />
								</svg>
							</div>
							<div class="flex-1">
								<div class="font-semibold text-slate-900 group-hover:text-emerald-700">Cash / Tunai</div>
								<div class="text-sm text-slate-500 group-hover:text-emerald-600">Pembayaran dengan uang tunai</div>
							</div>
							<svg class="size-5 text-slate-400 group-hover:text-emerald-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
								<path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
							</svg>
						</button>

						<!-- QRIS Payment -->
						<button onclick="selectPaymentMethod('qris')" class="payment-method-btn group w-full flex items-center gap-4 rounded-xl border-2 border-slate-200 bg-white p-4 text-left transition-all hover:border-blue-500 hover:bg-blue-50 active:scale-[0.98]">
							<div class="flex size-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600 transition-colors group-hover:bg-blue-600 group-hover:text-white">
								<svg class="size-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
									<path fill-rule="evenodd" d="M3 4.875C3 3.839 3.84 3 4.875 3h4.5c1.036 0 1.875.84 1.875 1.875v4.5c0 1.036-.84 1.875-1.875 1.875h-4.5A1.875 1.875 0 013 9.375v-4.5zM4.875 4.5a.375.375 0 00-.375.375v4.5c0 .207.168.375.375.375h4.5a.375.375 0 00.375-.375v-4.5a.375.375 0 00-.375-.375h-4.5zm7.875.375c0-1.036.84-1.875 1.875-1.875h4.5C20.16 3 21 3.84 21 4.875v4.5c0 1.036-.84 1.875-1.875 1.875h-4.5a1.875 1.875 0 01-1.875-1.875v-4.5zm1.875-.375a.375.375 0 00-.375.375v4.5c0 .207.168.375.375.375h4.5a.375.375 0 00.375-.375v-4.5a.375.375 0 00-.375-.375h-4.5zM6 6.75A.75.75 0 016.75 6h.75a.75.75 0 01.75.75v.75a.75.75 0 01-.75.75h-.75A.75.75 0 016 7.5v-.75zm9.75 0A.75.75 0 0116.5 6h.75a.75.75 0 01.75.75v.75a.75.75 0 01-.75.75h-.75a.75.75 0 01-.75-.75v-.75zM3 14.625c0-1.036.84-1.875 1.875-1.875h4.5c1.036 0 1.875.84 1.875 1.875v4.5c0 1.035-.84 1.875-1.875 1.875h-4.5A1.875 1.875 0 013 19.125v-4.5zm1.875-.375a.375.375 0 00-.375.375v4.5c0 .207.168.375.375.375h4.5a.375.375 0 00.375-.375v-4.5a.375.375 0 00-.375-.375h-4.5zm7.875-.75a.75.75 0 01.75-.75h.75a.75.75 0 01.75.75v.75a.75.75 0 01-.75.75h-.75a.75.75 0 01-.75-.75v-.75zm6 0a.75.75 0 01.75-.75h.75a.75.75 0 01.75.75v.75a.75.75 0 01-.75.75h-.75a.75.75 0 01-.75-.75v-.75zM6 16.5a.75.75 0 01.75-.75h.75a.75.75 0 01.75.75v.75a.75.75 0 01-.75.75h-.75a.75.75 0 01-.75-.75v-.75zm9.75 0a.75.75 0 01.75-.75h.75a.75.75 0 01.75.75v.75a.75.75 0 01-.75.75h-.75a.75.75 0 01-.75-.75v-.75zm-3 3a.75.75 0 01.75-.75h.75a.75.75 0 01.75.75v.75a.75.75 0 01-.75.75h-.75a.75.75 0 01-.75-.75v-.75zm6 0a.75.75 0 01.75-.75h.75a.75.75 0 01.75.75v.75a.75.75 0 01-.75.75h-.75a.75.75 0 01-.75-.75v-.75z" clip-rule="evenodd" />
								</svg>
							</div>
							<div class="flex-1">
								<div class="font-semibold text-slate-900 group-hover:text-blue-700">QRIS</div>
								<div class="text-sm text-slate-500 group-hover:text-blue-600">Scan QR Code dengan e-wallet</div>
							</div>
							<svg class="size-5 text-slate-400 group-hover:text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
								<path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
							</svg>
						</button>
					</div>
				</div>

				<!-- Modal Footer -->
				<div class="border-t border-slate-200 px-6 py-4 bg-slate-50 rounded-b-2xl">
					<button onclick="closePaymentModal()" class="w-full rounded-lg border border-slate-300 bg-white py-2.5 text-sm font-semibold text-slate-700 transition-all hover:bg-slate-50 active:scale-[0.98]">
						Batal
					</button>
				</div>
			</div>
		</div>
	</div>

		<!-- Slide-over: Recent Orders -->
		<div id="ordersPanel" class="fixed inset-0 z-50 hidden" aria-hidden="true">
			<div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" onclick="document.getElementById('ordersPanel').classList.add('hidden')"></div>
			<div class="absolute right-0 top-0 h-full w-full max-w-md bg-white shadow-2xl border-l border-slate-200 flex flex-col slide-in sm:max-w-lg">
				<div class="flex items-center justify-between border-b border-slate-200 p-4">
					<div>
						<h3 class="text-lg font-semibold text-slate-900">Pesanan Terakhir</h3>
						<p class="text-xs text-slate-500 mt-0.5">Riwayat transaksi hari ini</p>
					</div>
					<button id="closeOrders" class="rounded-lg p-2 text-slate-500 transition-colors hover:bg-slate-100">
						<svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
							<path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"/>
						</svg>
					</button>
				</div>
				<div id="ordersList" class="scrollbar-custom flex-1 overflow-auto p-4 space-y-3">
					<!-- Rendered by JS -->
				</div>
			</div>
		</div>

		<x-swal />
	</div>

	<script>
	;(() => {
		const fmt = new Intl.NumberFormat('id-ID');
		const money = (n=0) => `Rp${fmt.format(Math.max(0, Math.round(n)))}`;

		// Bootstrap data from backend (optional)
		const serverProducts = @json(isset($products) ? $products : []);
		const serverRecentOrders = @json(isset($recentOrders) ? $recentOrders : []);
		const endpoints = {
			create: "/dashboard/admin/pesanan/orders",
			recent: "/dashboard/admin/pesanan/recent",
		};
		const products = (Array.isArray(serverProducts) && serverProducts.length ? serverProducts : [
			{id:1,name:'Kopi Hitam',price:12000,category:'minuman'},
			{id:2,name:'Cappuccino',price:22000,category:'minuman'},
			{id:3,name:'Teh Manis',price:8000,category:'minuman'},
			{id:4,name:'Nasi Goreng',price:25000,category:'makanan'},
			{id:5,name:'Mie Goreng',price:23000,category:'makanan'},
			{id:6,name:'Roti Bakar',price:15000,category:'makanan'},
			{id:7,name:'Es Coklat',price:14000,category:'minuman'},
			{id:8,name:'Air Mineral',price:6000,category:'lainnya'},
		]).map(p => ({...p, price: Number(p.price)}));

		// State
		let state = {
			items: [], // {id,name,price,qty}
			discount: 0,
			tax: false,
			cash: 0,
			customer: '',
			note: '',
			orders: Array.isArray(serverRecentOrders) ? serverRecentOrders : []
		};

		// Elements
		const els = {
			search: document.getElementById('search'),
			grid: document.getElementById('productGrid'),
			empty: document.getElementById('emptyState'),
			list: document.getElementById('cartList'),
			subtotal: document.getElementById('subtotal'),
			discount: document.getElementById('discount'),
			discountLbl: document.getElementById('discountLbl'),
			taxToggle: document.getElementById('taxToggle'),
			taxLbl: document.getElementById('taxLbl'),
			grand: document.getElementById('grandTotal'),
			cash: document.getElementById('cash'),
			change: document.getElementById('change'),
			payBtn: document.getElementById('payBtn'),
			draftBtn: document.getElementById('draftBtn'),
			cancelBtn: document.getElementById('cancelBtn'),
			customer: document.getElementById('customer'),
			note: document.getElementById('note'),
			ordersPanel: document.getElementById('ordersPanel'),
			ordersList: document.getElementById('ordersList'),
			openOrders: document.getElementById('openOrders'),
			closeOrders: document.getElementById('closeOrders'),
		};

		// Live clock
		const clockEl = document.getElementById('clock');
		const tick = () => { if (clockEl) clockEl.textContent = new Date().toLocaleString('id-ID', {hour:'2-digit',minute:'2-digit', second:'2-digit', day:'2-digit', month:'2-digit', year:'numeric'}); };
		setInterval(tick, 1000); tick();

		// ===================================
		// PAYMENT EVENT POLLING (For Midtrans callback)
		// ===================================
		let lastEventTime = null;
		let processedEventIds = new Set(); // Track processed events to prevent duplicates

		async function pollPaymentEvents() {
			try {
				const url = lastEventTime 
					? `/api/midtrans/payment-events?since=${encodeURIComponent(lastEventTime)}`
					: '/api/midtrans/payment-events';
				
				const response = await fetch(url, {
					headers: { 'Accept': 'application/json' }
				});

				if (!response.ok) {
					console.warn('❌ Failed to fetch payment events:', response.status);
					return;
				}

				const data = await response.json();
				
				if (data.status === 'success' && data.events && data.events.length > 0) {
					console.log(`📥 Received ${data.events.length} payment event(s)`, data.events);
					
					// Process each event
					for (const event of data.events) {
						// Create unique event ID to prevent duplicate processing
						const eventId = `${event.payment_reference}-${event.timestamp}`;
						
						if (!processedEventIds.has(eventId)) {
							processedEventIds.add(eventId);
							console.log('🎯 Processing new event:', eventId);
							await handlePaymentSuccessEvent(event);
							
							// Update last event time
							lastEventTime = event.timestamp;
						} else {
							console.log('⏭️ Skipping duplicate event:', eventId);
						}
					}

					// Keep processedEventIds set manageable (last 100 events)
					if (processedEventIds.size > 100) {
						const arr = Array.from(processedEventIds);
						processedEventIds = new Set(arr.slice(-100));
					}
				} else {
					// Quiet polling - don't spam console
					if (data.events && data.events.length === 0) {
						// console.log('✓ Polling... No new events');
					}
				}
			} catch (error) {
				console.error('❌ Error polling payment events:', error);
			}
		}

		async function handlePaymentSuccessEvent(event) {
			console.log('🎉 Processing payment success event:', event);
			
			// Play TTS announcement immediately
			await playPaymentSuccessSound(
				event.total, 
				event.payment_method?.toUpperCase() || 'QRIS',
				event.customer || 'Customer'
			);

			// Refresh orders list to show updated status
			await loadRecent();

			// Show notification
			showPaymentNotification(event);
		}

		function showPaymentNotification(event) {
			const formattedAmount = new Intl.NumberFormat('id-ID', {
				style: 'currency',
				currency: 'IDR',
				minimumFractionDigits: 0
			}).format(event.total);

			// Create notification toast
			const notification = document.createElement('div');
			notification.className = 'fixed top-4 right-4 z-50 rounded-lg bg-green-50 border border-green-200 p-4 shadow-lg animate-slide-in-right max-w-md';
			notification.innerHTML = `
				<div class="flex items-start gap-3">
					<div class="flex-shrink-0">
						<svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
						</svg>
					</div>
					<div class="flex-1">
						<h3 class="text-sm font-semibold text-green-800">Pembayaran Diterima!</h3>
						<p class="mt-1 text-sm text-green-700">${formattedAmount} via ${event.payment_method?.toUpperCase()}</p>
						${event.customer ? `<p class="mt-0.5 text-xs text-green-600">Customer: ${event.customer}</p>` : ''}
					</div>
					<button onclick="this.closest('div[class*=fixed]').remove()" class="flex-shrink-0 text-green-400 hover:text-green-600">
						<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
						</svg>
					</button>
				</div>
			`;
			document.body.appendChild(notification);

			// Auto remove after 5 seconds
			setTimeout(() => {
				notification.style.opacity = '0';
				notification.style.transform = 'translateX(100%)';
				notification.style.transition = 'all 0.3s ease-out';
				setTimeout(() => notification.remove(), 300);
			}, 5000);
		}

		// Start polling every 3 seconds
		setInterval(pollPaymentEvents, 3000);
		// Initial poll
		pollPaymentEvents();

		// ===================================
		// AUDIO CONTEXT INITIALIZATION (Unlock autoplay)
		// ===================================
		let audioUnlocked = false;
		
		// Function to unlock audio on first user interaction
		function unlockAudio() {
			if (audioUnlocked) return;
			
			// Create a silent audio to unlock audio context
			const silentAudio = new Audio('data:audio/wav;base64,UklGRiQAAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQAAAAA=');
			silentAudio.play().then(() => {
				audioUnlocked = true;
				console.log('✅ Audio context unlocked for autoplay');
			}).catch(err => {
				console.warn('⚠️ Could not unlock audio:', err);
			});
		}
		
		// Unlock audio on first click, touch, or keypress
		['click', 'touchstart', 'keydown'].forEach(event => {
			document.addEventListener(event, unlockAudio, { once: true });
		});

		// Render products
		let activeCat = 'all';
		const renderProducts = () => {
			const q = (els.search.value || '').toLowerCase().trim();
			const data = products.filter(p => (activeCat==='all' || p.category===activeCat) && (!q || p.name.toLowerCase().includes(q)));
			els.grid.innerHTML = data.map(p => `
			  <button data-id="${p.id}" class="product-card group relative overflow-hidden rounded-lg border border-slate-200 bg-white text-left shadow-sm hover:border-primary-400 hover:shadow-md">
				<div class="relative aspect-square w-full overflow-hidden bg-slate-100">
					${p.image ? `
					  <img src="${p.image}" alt="${p.name}" class="absolute inset-0 size-full object-cover transition-transform duration-300 group-hover:scale-110"/>
					` : `
					  <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-50 text-slate-300 transition-colors group-hover:text-primary-400">
						<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' class='size-12 opacity-40' stroke-width='1.5'><path stroke-linecap='round' stroke-linejoin='round' d='M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'/></svg>
					  </div>
					`}
					<div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
					<div class="absolute bottom-1.5 left-1.5 rounded-md bg-black/60 backdrop-blur-sm px-2 py-0.5 text-[10px] font-medium uppercase tracking-wide text-white">
						${p.category}
					</div>
					<div class="absolute right-1.5 top-1.5 rounded-md bg-primary-600 px-2 py-1 text-xs font-bold text-white shadow-lg">
						${money(p.price)}
					</div>
				</div>
				<div class="flex items-center gap-2 p-2.5">
					<span class="flex-1 truncate text-sm font-medium text-slate-900">${p.name}</span>
					<div class="flex size-7 flex-shrink-0 items-center justify-center rounded-full bg-primary-100 text-primary-600 transition-all group-hover:bg-primary-600 group-hover:text-white group-hover:shadow-md">
						<svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
							<path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"/>
						</svg>
					</div>
				</div>
			  </button>
			`).join('');
		};
		renderProducts();

		// Product click -> add to cart
		els.grid.addEventListener('click', (e) => {
			const btn = e.target.closest('button[data-id]');
			if (!btn) return;
			const id = Number(btn.dataset.id);
			const prod = products.find(p => p.id === id);
			if (!prod) return;
			const existing = state.items.find(it => it.id === id);
			if (existing) existing.qty += 1; else state.items.push({id: prod.id, name: prod.name, price: prod.price, qty: 1, note: ''});
			renderCart();
		});

		// Categories
		document.querySelectorAll('.cat-btn').forEach(b => b.addEventListener('click', () => {
			document.querySelectorAll('.cat-btn').forEach(x => {
				x.classList.remove('bg-primary-600', 'text-white', 'shadow-sm', 'shadow-primary-500/20');
				x.classList.add('bg-white', 'border', 'border-slate-300', 'text-slate-700');
			});
			b.classList.remove('bg-white', 'border', 'border-slate-300', 'text-slate-700');
			b.classList.add('bg-primary-600', 'text-white', 'shadow-sm', 'shadow-primary-500/20');
			activeCat = b.dataset.category || 'all';
			renderProducts();
		}));

		// Search
		els.search.addEventListener('input', renderProducts);
		window.addEventListener('keydown', (ev) => { if (ev.ctrlKey && ev.key === '/') { ev.preventDefault(); els.search.focus(); } });

		// Render cart
		const renderCart = () => {
			const has = state.items.length > 0;
			els.empty.classList.toggle('hidden', has);
			els.list.classList.toggle('hidden', !has);
			els.list.innerHTML = state.items.map((it,idx) => `
				<div class="cart-item group flex flex-col gap-2 rounded-lg border border-slate-200 bg-white p-2.5 shadow-sm transition-all hover:border-primary-200 hover:shadow">
					<div class="flex items-center gap-2.5">
						<div class="flex-1 min-w-0">
							<div class="font-semibold text-sm text-slate-900 truncate">${it.name}</div>
							<div class="text-xs text-slate-500 mt-0.5">${money(it.price)} × ${it.qty}</div>
						</div>
						<div class="flex items-center gap-1.5 rounded-lg bg-slate-50 px-2 py-1 border border-slate-200">
							<button class="qty flex size-6 items-center justify-center rounded bg-white border border-slate-300 text-slate-700 transition-all hover:bg-slate-100 hover:border-slate-400 active:scale-95" data-idx="${idx}" data-act="dec">
								<svg class="size-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
									<path fill-rule="evenodd" d="M4 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H4.75A.75.75 0 014 10z" clip-rule="evenodd"/>
								</svg>
							</button>
							<div class="w-7 text-center text-sm font-bold tabular-nums text-slate-900">${it.qty}</div>
							<button class="qty flex size-6 items-center justify-center rounded bg-white border border-slate-300 text-slate-700 transition-all hover:bg-slate-100 hover:border-slate-400 active:scale-95" data-idx="${idx}" data-act="inc">
								<svg class="size-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
									<path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"/>
								</svg>
							</button>
						</div>
						<div class="w-20 text-right text-sm font-bold tabular-nums text-slate-900">${money(it.qty * it.price)}</div>
						<button class="remove flex size-7 items-center justify-center rounded-lg text-rose-500 transition-all hover:bg-rose-50 hover:text-rose-700 active:scale-95" data-idx="${idx}" title="Hapus item">
							<svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
								<path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd"/>
							</svg>
						</button>
					</div>
					<div class="w-full">
						<input 
							type="text" 
							placeholder="Catatan untuk item ini (opsional)..." 
							value="${it.note || ''}" 
							data-idx="${idx}"
							class="item-note w-full rounded-md border-slate-300 bg-slate-50 px-2.5 py-1.5 text-xs placeholder:text-slate-400 transition-all focus:border-primary-500 focus:bg-white focus:ring-2 focus:ring-primary-500/20"
						/>
					</div>
				</div>
			`).join('');
			calcTotals();
		};

		els.list.addEventListener('click', (e) => {
			const r = e.target.closest('button.remove');
			if (r) { const i = Number(r.dataset.idx); state.items.splice(i,1); renderCart(); return; }
			const q = e.target.closest('button.qty');
			if (q) {
				const i = Number(q.dataset.idx); const act = q.dataset.act;
				if (act==='inc') state.items[i].qty += 1; else state.items[i].qty = Math.max(1, state.items[i].qty - 1);
				renderCart();
			}
		});

		// Handle note input changes
		els.list.addEventListener('input', (e) => {
			const noteInput = e.target.closest('input.item-note');
			if (noteInput) {
				const idx = Number(noteInput.dataset.idx);
				if (state.items[idx]) {
					state.items[idx].note = noteInput.value;
				}
			}
		});

		// Totals
		const calcTotals = () => {
			const subtotal = state.items.reduce((s,it) => s + (it.price * it.qty), 0);
			const discount = Number(els.discount.value || 0);
			state.discount = Math.max(0, discount);
			const taxable = Math.max(0, subtotal - state.discount);
			const tax = els.taxToggle.checked ? taxable * 0.10 : 0;
			state.tax = els.taxToggle.checked;
			const grand = Math.max(0, taxable + tax);
			const cash = Number(els.cash.value || 0);
			state.cash = Math.max(0, cash);

			els.subtotal.textContent = money(subtotal);
			els.discountLbl.textContent = `- ${money(state.discount)}`;
			els.taxLbl.textContent = money(tax);
			els.grand.textContent = money(grand);
			els.change.textContent = money(cash - grand);
			// Enable pay button if there are items (will select payment method in modal)
			els.payBtn.disabled = !state.items.length;
		};

		['input','change'].forEach(ev => {
			els.discount.addEventListener(ev, calcTotals);
			els.taxToggle.addEventListener(ev, calcTotals);
			els.cash.addEventListener(ev, calcTotals);
		});

		els.customer.addEventListener('input', e => state.customer = e.target.value);
		els.note.addEventListener('input', e => state.note = e.target.value);

		// Draft, Cancel, Pay
		els.draftBtn.addEventListener('click', async () => {
			if (!state.items.length) { return Swal.fire({icon:'info', title:'Keranjang kosong', toast:true, position:'top-end', showConfirmButton:false, timer:3000}); }
			await apiPostOrder('draft');
			await loadRecent();
		});
		els.cancelBtn.addEventListener('click', async () => {
			if (!state.items.length) return;
			const res = await Swal.fire({ title:'Batalkan pesanan?', icon:'warning', showCancelButton:true, confirmButtonText:'Ya', cancelButtonText:'Tidak' });
			if (res?.isConfirmed) { clearCart(); Swal.fire({icon:'success', title:'Pesanan dibatalkan', toast:true, position:'top-end', showConfirmButton:false, timer:3000}); }
		});
		els.payBtn.addEventListener('click', async () => {
			if (!state.items.length) { return Swal.fire({icon:'info', title:'Keranjang kosong', toast:true, position:'top-end', showConfirmButton:false, timer:3000}); }
			// Show payment method modal
			openPaymentModal();
		});

		const clearCart = () => {
			state.items = []; els.discount.value = 0; els.taxToggle.checked = false; els.cash.value = 0; state.customer=''; state.note='';
			els.customer.value = ''; els.note.value = '';
			renderCart();
		};

		const currentOrder = (status='draft') => {
			const subtotal = state.items.reduce((s,it)=>s+it.price*it.qty,0);
			const disc = Math.max(0, Number(els.discount.value||0));
			const taxable = Math.max(0, subtotal - disc);
			const tax = els.taxToggle.checked ? taxable*0.1 : 0;
			const total = Math.max(0, taxable + tax);
			return {
				items: state.items, subtotal, discount: disc, tax, total,
				cash: Number(els.cash.value||0), change: Number(els.cash.value||0) - total,
				customer: state.customer, note: state.note, status,
				at: new Date().toISOString()
			};
		};

		async function apiPostOrder(status, paymentData = {}) {
			try {
				const token = document.querySelector('meta[name=csrf-token]')?.content || '';
				const payload = {
					status,
					note: state.note || null,
					customer: state.customer || null,
					discount: state.discount || null,
					items: state.items.map(it => ({ id: it.id, qty: it.qty, note: it.note || null })),
					...paymentData // Add payment information
				};
				const res = await fetch(endpoints.create, {
					method: 'POST',
					headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
					body: JSON.stringify(payload)
				});
				if (!res.ok) {
					const txt = await res.text();
					throw new Error(txt || 'Gagal menyimpan pesanan');
				}
				// Expect JSON response with order data
				let data = null;
				try { data = await res.json(); } catch(_) { /* ignore parse errors */ }
				Swal.fire({ icon: 'success', title: status === 'paid' ? 'Pesanan tersimpan' : 'Draf disimpan', toast:true, position:'top-end', showConfirmButton:false, timer:2500 });
				return data; // may be null if parsing failed
			} catch (err) {
				console.error(err);
				Swal.fire({ icon: 'error', title: 'Gagal menyimpan pesanan', toast:true, position:'top-end', showConfirmButton:false, timer:3000 });
			}
		}

		async function loadRecent() {
			try {
				const res = await fetch(endpoints.recent, { headers: { 'Accept': 'application/json' } });
				if (!res.ok) throw new Error('Gagal memuat riwayat');
				const data = await res.json();
				state.orders = Array.isArray(data) ? data : [];
				renderOrders();
			} catch (e) {
				console.error(e);
			}
		}

		// Orders slide-over
		const openOrders = async () => { els.ordersPanel.classList.remove('hidden'); await loadRecent(); };
		const closeOrders = () => { els.ordersPanel.classList.add('hidden'); };
		els.openOrders.addEventListener('click', openOrders);
		els.closeOrders.addEventListener('click', closeOrders);
		els.ordersPanel.addEventListener('click', (e)=>{ if (e.target === els.ordersPanel) closeOrders(); });

		const renderOrders = () => {
			const empty = !state.orders.length;
			els.ordersList.innerHTML = empty ? (
				`<div class="flex flex-col items-center justify-center py-16 text-slate-500">
					<div class="mx-auto mb-4 grid size-16 place-items-center rounded-full bg-slate-100">
						<svg class="size-8 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
							<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/>
						</svg>
					</div>
					<p class="text-center text-sm font-medium">Belum ada riwayat</p>
					<p class="text-center text-xs text-slate-400 mt-1">Pesanan akan muncul di sini setelah transaksi</p>
				</div>`
			) : state.orders.map((o, i) => {
				const hasItems = Array.isArray(o.items);
				const status = (o.status || '').toString().toLowerCase();
				const badge = status === 'paid' 
					? 'bg-emerald-100 text-emerald-700 border border-emerald-200' 
					: 'bg-amber-100 text-amber-700 border border-amber-200';
				const when = o.at ? new Date(o.at).toLocaleString('id-ID', {
					day: '2-digit',
					month: 'short',
					hour: '2-digit',
					minute: '2-digit'
				}) : '';
				const body = hasItems ? (o.items.map(it => `${it.name} × ${it.qty}`).join(', ')) : `${o.name || 'Item'} × ${o.qty || 1}`;
				const total = hasItems ? o.total : (o.total ?? 0);
				const customer = o.customer ? `<div class="text-xs text-slate-500 mt-1"><svg class="inline size-3 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z"/></svg>${o.customer}</div>` : '';
				return `
				<div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition-all hover:shadow-md">
					<div class="flex items-start justify-between border-b border-slate-100 bg-slate-50/50 p-3">
						<div>
							<div class="text-sm font-semibold text-slate-900">#${String(i+1).padStart(4,'0')}</div>
							<div class="mt-0.5 text-xs text-slate-500">${when}</div>
							${customer}
						</div>
						<span class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1 text-xs font-semibold ${badge}">
							${status === 'paid' ? '✓' : '○'} ${(status || 'DRAFT').toUpperCase()}
						</span>
					</div>
					<div class="p-3">
						<div class="text-xs text-slate-600 line-clamp-2">${body}</div>
						<div class="mt-3 flex items-center justify-between">
							<span class="text-xs font-medium text-slate-500">Total Pembayaran</span>
							<span class="text-base font-bold tabular-nums text-primary-600">${money(total)}</span>
						</div>
					</div>
				</div>`;
			}).join('');
		};

		// Initial
		renderCart();

		// Payment Modal Functions
		window.openPaymentModal = function() {
			const order = currentOrder('paid');
			document.getElementById('modalTotal').textContent = money(order.total);
			document.getElementById('modalSubtotal').textContent = money(order.subtotal);
			document.getElementById('modalDiscount').textContent = '- ' + money(order.discount);
			document.getElementById('modalTax').textContent = money(order.tax);
			document.getElementById('paymentModal').classList.remove('hidden');
		};

		window.closePaymentModal = function() {
			document.getElementById('paymentModal').classList.add('hidden');
		};

		window.selectPaymentMethod = async function(method) {
			if (method === 'cash') {
				// Process cash payment
				await processCashPayment();
			} else if (method === 'qris') {
				// Process QRIS payment with Midtrans
				await processQRISPayment();
			}
		};

		async function processCashPayment() {
			closePaymentModal();
			
			const cashAmount = Number(els.cash.value || 0);
			const order = currentOrder('paid');
			
			if (cashAmount < order.total) {
				return Swal.fire({
					icon: 'error',
					title: 'Uang Tidak Cukup',
					text: `Uang diterima kurang dari total ${money(order.total)}`
				});
			}
			
			const change = cashAmount - order.total;
			
			// Process order with cash payment data
			const paymentData = {
				payment_method: 'cash',
				cash_received: cashAmount,
				change_amount: change
			};
			const saved = await apiPostOrder('paid', paymentData);
			await playPaymentSuccessSound(order.total, 'Tunai');
			
			// Tanyakan apakah mau print receipt
			askPrintReceipt(saved, order, paymentData);
			
			clearCart();
			await loadRecent();
		}

		async function processQRISPayment() {
			closePaymentModal();
			
			const order = currentOrder('paid');
			
			// Show loading
			Swal.fire({
				title: 'Membuat QRIS...',
				html: 'Mohon tunggu sebentar',
				allowOutsideClick: false,
				didOpen: () => {
					Swal.showLoading();
				}
			});
			
			try {
				// Call Midtrans API to get snap token
				const response = await fetch('/api/payment/create-charge', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
						'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
					},
					body: JSON.stringify({
						amount: order.total,
						first_name: state.customer || 'Customer',
						last_name: '',
						email: 'customer@example.com',
						phone: '08123456789',
						order_id: 'ORD-' + Date.now()
					})
				});
				
				if (!response.ok) {
					throw new Error('Failed to create payment');
				}
				
				const snapToken = await response.json();
				
				// Close loading
			Swal.close();
			
			// Open Midtrans Snap with enabled payment methods
			window.snap.pay(snapToken, {
				enabledPayments: ['qris', 'other_qris', 'gopay', 'shopeepay', 'dana', 'ovo'],
				onSuccess: async function(result) {
					console.log('Payment success:', result);						// Save order as paid with QRIS payment data
						const paymentData = {
							payment_method: 'qris',
							payment_reference: result.transaction_id || result.order_id
						};
						
						const saved = await apiPostOrder('paid', paymentData);
						
						// Play local success sound immediately (do not depend on polling)
						try {
							await playPaymentSuccessSound(currentOrder('paid').total, 'QRIS', state.customer || 'Customer');
				} catch(e) { /* no-op */ }
				
				// Tanyakan apakah mau print receipt
				askPrintReceipt(saved, currentOrder('paid'), paymentData);
				
				clearCart();
				await loadRecent();
			},
			onPending: async function(result) {
				console.log('Payment pending:', result);						// Save order as pending with QRIS payment data
						const paymentData = {
							payment_method: 'qris',
							payment_reference: result.transaction_id || result.order_id
						};
						
						await apiPostOrder('pending', paymentData);
						
						Swal.fire({
							icon: 'info',
							title: 'Pembayaran Pending',
							html: `
								<div class="space-y-2">
									<p>Menunggu konfirmasi pembayaran</p>
									<p class="text-sm text-slate-600">Order ID: ${result.order_id || 'N/A'}</p>
									<p class="text-xs text-slate-500">Pesanan telah disimpan dengan status pending</p>
								</div>
							`,
							confirmButtonText: 'OK'
						});
						
						clearCart();
						await loadRecent();
					},
					onError: function(result) {
						console.log('Payment error:', result);
						Swal.fire({
							icon: 'error',
							title: 'Pembayaran Gagal',
							text: 'Terjadi kesalahan pada pembayaran',
							confirmButtonText: 'OK'
						});
					},
					onClose: function() {
						console.log('Payment popup closed');
					}
				});
				
			} catch (error) {
				console.error('QRIS Error:', error);
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'Gagal membuat QRIS. Silakan coba lagi.',
					confirmButtonText: 'OK'
				});
			}
		}

		// ===================================
		// PAYMENT SUCCESS SOUND (Local file)
		// ===================================
		/**
		 * Play a success chime from local assets when payment is successful.
		 * No external API is used.
		 * @param {number} amount - Total amount paid (unused, kept for compatibility)
		 * @param {string} paymentMethod - Payment method used (unused, kept for compatibility)
		 * @param {string} customerName - Customer name (unused, kept for compatibility)
		 */
		async function playPaymentSuccessSound(amount, paymentMethod = 'QRIS', customerName = 'Customer') {
			const soundUrl = "{{ asset('assets/audio/qris.m4a') }}";
			try {
				const audio = new Audio(soundUrl);
				audio.volume = 1.0;
				// Add listeners for diagnostics
				audio.addEventListener('canplaythrough', () => console.log('🎧 Sound ready to play:', soundUrl), { once: true });
				audio.addEventListener('error', () => console.warn('❌ Failed to load audio:', soundUrl));
				await audio.play();
				console.log('✅ Payment success sound played');
			} catch (playError) {
				console.warn('⚠️ Autoplay blocked or failed to play sound:', playError);
				// Fallback: show a small toast with manual play button
				const notification = document.createElement('div');
				notification.className = 'fixed top-4 right-4 z-50 rounded-lg bg-yellow-50 border border-yellow-200 p-4 shadow-lg animate-slide-in-right max-w-md';
				notification.innerHTML = `
					<div class="flex items-start gap-3">
						<div class="flex-shrink-0">
							<svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
							</svg>
						</div>
						<div class="flex-1">
							<h3 class="text-sm font-semibold text-yellow-800">Pembayaran Diterima!</h3>
							<button onclick="this.closest('[class*=fixed]').querySelector('audio').play(); this.closest('[class*=fixed]').remove();" 
							        class="mt-2 bg-yellow-500 hover:bg-yellow-600 text-white text-xs px-3 py-1 rounded">
								🔊 Putar Suara
							</button>
							<audio src="${soundUrl}" preload="auto"></audio>
						</div>
						<button onclick="this.closest('[class*=fixed]').remove()" class="flex-shrink-0 text-yellow-400 hover:text-yellow-600">
							<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
							</svg>
						</button>
					</div>
				`;
				document.body.appendChild(notification);
				// Auto remove after 10 seconds
				setTimeout(() => {
					notification.style.opacity = '0';
					notification.style.transform = 'translateX(100%)';
					notification.style.transition = 'all 0.3s ease-out';
					setTimeout(() => notification.remove(), 300);
				}, 10000);
			}
		}

	// =============================
	// RECEIPT GENERATION & PRINTING
	// =============================
	function askPrintReceipt(savedOrderResponse, localOrderSnapshot, paymentData) {
		try {
			console.log('=== PRINT RECEIPT DEBUG ===');
			console.log('savedOrderResponse:', savedOrderResponse);
			console.log('localOrderSnapshot:', localOrderSnapshot);
			console.log('paymentData:', paymentData);
			
			// Get order ID from response
			// Response bisa berbentuk: {ids: [1,2,3]} atau {id: 1} atau langsung object order
			let orderId = null;
			
			if (savedOrderResponse?.id) {
				orderId = savedOrderResponse.id;
				console.log('Got ID from savedOrderResponse.id:', orderId);
			} else if (savedOrderResponse?.ids && Array.isArray(savedOrderResponse.ids) && savedOrderResponse.ids.length > 0) {
				// Ambil ID pertama dari array
				orderId = savedOrderResponse.ids[0];
				console.log('Got ID from savedOrderResponse.ids[0]:', orderId);
			} else if (savedOrderResponse?.order_id) {
				orderId = savedOrderResponse.order_id;
				console.log('Got ID from savedOrderResponse.order_id:', orderId);
			}
			
			// Validasi order ID harus ada dan valid
			if (!orderId || orderId === 'temp' || orderId === 'N/A') {
				console.error('Invalid order ID:', orderId, 'Response:', savedOrderResponse);
				Swal.fire({ 
					icon:'error', 
					title:'Gagal mencetak struk', 
					text:'Order ID tidak valid. Pastikan order sudah tersimpan.' 
				});
				return;
			}
			
			// Tampilkan konfirmasi cetak struk
			Swal.fire({
				icon: 'success',
				title: 'Pesanan Berhasil Disimpan!',
				text: 'Apakah Anda ingin mencetak struk?',
				showCancelButton: true,
				confirmButtonText: '🖨️ Ya, Cetak Struk',
				cancelButtonText: '✕ Tidak',
				confirmButtonColor: '#667eea',
				cancelButtonColor: '#64748b',
				reverseButtons: true
			}).then((result) => {
				if (result.isConfirmed) {
					// User pilih cetak struk
					const receiptUrl = `/receipt/${orderId}?autoprint=1`;
					console.log('Opening receipt:', receiptUrl);
					
					// Untuk mobile: cek apakah device mobile
					const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
					
					if (isMobile) {
						// Di mobile: buka di tab yang sama untuk menghindari popup blocker
						window.location.href = receiptUrl;
					} else {
						// Di desktop: buka popup
						const popup = window.open(receiptUrl, '_blank', 'width=400,height=800');
						
						if (!popup) {
							console.error('Popup blocked!');
							Swal.fire({ 
								icon:'warning', 
								title:'Popup diblokir', 
								text:'Izinkan popup untuk mencetak struk.' 
							});
							return;
						}
						
						console.log('Popup opened successfully');
						popup.focus();
					}
				}
				// Jika user klik "Tidak", tidak ada aksi tambahan
			});
			
		} catch(err) {
			console.error('Print receipt error:', err);
			Swal.fire({ 
				icon:'error', 
				title:'Gagal mencetak struk', 
				text:'Terjadi kesalahan saat membuka struk: ' + err.message 
			});
		}
	}		// ===================================
		// ORDERS TABLE MANAGEMENT
		// ===================================
		let allOrders = [];
		let currentOrderPage = 1;
		let selectedOrderForStatus = null;
		let currentDetailOrderId = null;

		// Load all orders for table
		async function loadAllOrders(page = 1) {
			try {
				const res = await fetch(`/admin/pesanan/all?page=${page}`, { 
					headers: { 'Accept': 'application/json' } 
				});
				if (!res.ok) throw new Error('Gagal memuat pesanan');
				const data = await res.json();
				allOrders = data.data || [];
				renderOrdersTable(data);
			} catch (e) {
				console.error(e);
				document.getElementById('ordersLoadingRow').classList.add('hidden');
				document.getElementById('ordersEmptyRow').classList.remove('hidden');
			}
		}

		// Render orders table
		function renderOrdersTable(data) {
			const tbody = document.getElementById('ordersTableBody');
			const loadingRow = document.getElementById('ordersLoadingRow');
			const emptyRow = document.getElementById('ordersEmptyRow');
			
			loadingRow.classList.add('hidden');
			
			if (!allOrders.length) {
				emptyRow.classList.remove('hidden');
				tbody.querySelectorAll('tr:not(#ordersLoadingRow):not(#ordersEmptyRow)').forEach(tr => tr.remove());
				return;
			}
			
			emptyRow.classList.add('hidden');
			tbody.querySelectorAll('tr:not(#ordersLoadingRow):not(#ordersEmptyRow)').forEach(tr => tr.remove());
			
			allOrders.forEach(order => {
				// Build items description
				const itemsDesc = order.items ? order.items.map(item => `${item.name} (${item.qty}x)`).join(', ') : '-';
				const itemsCount = order.total_items || 1;
				
				const tr = document.createElement('tr');
				tr.className = 'hover:bg-slate-50 transition-colors';
				tr.innerHTML = `
					<td class="px-3 py-3 sm:px-6 sm:py-4 whitespace-nowrap">
						<div class="text-xs sm:text-sm font-semibold text-primary-600">#${order.order_id || '-'}</div>
					</td>
					<td class="px-3 py-3 sm:px-6 sm:py-4">
						<div class="text-xs sm:text-sm font-medium text-slate-900">${itemsDesc}</div>
						<div class="text-[10px] sm:text-xs text-slate-500 mt-0.5">${itemsCount} item${itemsCount > 1 ? 's' : ''}</div>
					</td>
					<td class="px-3 py-3 sm:px-6 sm:py-4 whitespace-nowrap">
						<div class="text-xs sm:text-sm text-slate-700">${order.customer || '-'}</div>
					</td>
					<td class="px-3 py-3 sm:px-6 sm:py-4 text-center whitespace-nowrap">
						<div class="inline-flex items-center justify-center rounded-full bg-slate-100 px-2 sm:px-2.5 py-0.5 sm:py-1 text-xs sm:text-sm font-semibold text-slate-700">${order.total_quantity || 0}</div>
					</td>
					<td class="px-3 py-3 sm:px-6 sm:py-4 text-right whitespace-nowrap">
						<div class="text-xs sm:text-sm font-bold text-slate-900">${money(order.total_price)}</div>
					</td>
					<td class="px-3 py-3 sm:px-6 sm:py-4 text-center whitespace-nowrap">
						${getStatusBadgeHTML(order.status)}
					</td>
					<td class="px-3 py-3 sm:px-6 sm:py-4 whitespace-nowrap">
						<div class="text-[10px] sm:text-xs text-slate-600">${formatDate(order.created_at)}</div>
					</td>
					<td class="px-3 py-3 sm:px-6 sm:py-4 whitespace-nowrap">
						<div class="flex items-center justify-center gap-1 sm:gap-2">
							<button onclick="viewOrderDetail(${order.id})" class="inline-flex items-center gap-1 rounded-lg bg-primary-50 px-2 py-1.5 sm:px-3 sm:py-1.5 text-xs font-semibold text-primary-700 transition-all hover:bg-primary-100" title="Lihat Detail">
								<svg class="size-3 sm:size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
									<path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
									<path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
								</svg>
								<span class="hidden sm:inline">Detail</span>
							</button>
							<button onclick="openStatusModal(${order.id}, '${order.status}')" class="inline-flex items-center gap-1 rounded-lg bg-amber-50 px-2 py-1.5 sm:px-3 sm:py-1.5 text-xs font-semibold text-amber-700 transition-all hover:bg-amber-100" title="Ubah Status">
								<svg class="size-3 sm:size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
									<path d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
									<path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
								</svg>
								<span class="hidden sm:inline">Ubah</span>
							</button>
						</div>
					</td>
				`;
				tbody.appendChild(tr);
			});
			
			// Update pagination info
			if (data.total) {
				document.getElementById('ordersShowingStart').textContent = data.from || 0;
				document.getElementById('ordersShowingEnd').textContent = data.to || 0;
				document.getElementById('ordersTotal').textContent = data.total || 0;
				renderOrdersPagination(data);
			}
		}

		// Render pagination
		function renderOrdersPagination(data) {
			const container = document.getElementById('ordersPaginationButtons');
			container.innerHTML = '';
			
			if (data.last_page <= 1) return;
			
			// Previous button
			const prevBtn = document.createElement('button');
			prevBtn.className = `px-2.5 py-1.5 sm:px-3 sm:py-2 rounded-lg text-xs sm:text-sm font-medium transition-all ${data.current_page === 1 ? 'bg-slate-100 text-slate-400 cursor-not-allowed' : 'bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 active:scale-95'}`;
			prevBtn.innerHTML = '<span class="hidden sm:inline">← Prev</span><span class="sm:hidden">←</span>';
			prevBtn.disabled = data.current_page === 1;
			prevBtn.onclick = () => !prevBtn.disabled && loadAllOrders(data.current_page - 1);
			container.appendChild(prevBtn);
			
			// Page numbers - show fewer on mobile
			const isMobile = window.innerWidth < 640;
			const maxVisible = isMobile ? 3 : 5;
			const halfVisible = Math.floor(maxVisible / 2);
			
			let startPage = Math.max(1, data.current_page - halfVisible);
			let endPage = Math.min(data.last_page, startPage + maxVisible - 1);
			
			// Adjust start if we're at the end
			if (endPage - startPage < maxVisible - 1) {
				startPage = Math.max(1, endPage - maxVisible + 1);
			}
			
			// First page + dots if needed
			if (startPage > 1) {
				const firstBtn = document.createElement('button');
				firstBtn.className = 'px-2.5 py-1.5 sm:px-3 sm:py-2 rounded-lg text-xs sm:text-sm font-medium bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 transition-all active:scale-95';
				firstBtn.textContent = '1';
				firstBtn.onclick = () => loadAllOrders(1);
				container.appendChild(firstBtn);
				
				if (startPage > 2) {
					const dots = document.createElement('span');
					dots.className = 'px-1 sm:px-2 text-slate-400 text-xs sm:text-sm';
					dots.textContent = '...';
					container.appendChild(dots);
				}
			}
			
			// Page numbers in range
			for (let i = startPage; i <= endPage; i++) {
				const pageBtn = document.createElement('button');
				pageBtn.className = `px-2.5 py-1.5 sm:px-3 sm:py-2 rounded-lg text-xs sm:text-sm font-medium transition-all ${i === data.current_page ? 'bg-primary-600 text-white shadow-md' : 'bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 active:scale-95'}`;
				pageBtn.textContent = i;
				pageBtn.onclick = () => loadAllOrders(i);
				container.appendChild(pageBtn);
			}
			
			// Last page + dots if needed
			if (endPage < data.last_page) {
				if (endPage < data.last_page - 1) {
					const dots = document.createElement('span');
					dots.className = 'px-1 sm:px-2 text-slate-400 text-xs sm:text-sm';
					dots.textContent = '...';
					container.appendChild(dots);
				}
				
				const lastBtn = document.createElement('button');
				lastBtn.className = 'px-2.5 py-1.5 sm:px-3 sm:py-2 rounded-lg text-xs sm:text-sm font-medium bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 transition-all active:scale-95';
				lastBtn.textContent = data.last_page;
				lastBtn.onclick = () => loadAllOrders(data.last_page);
				container.appendChild(lastBtn);
			}
			
			// Next button
			const nextBtn = document.createElement('button');
			nextBtn.className = `px-2.5 py-1.5 sm:px-3 sm:py-2 rounded-lg text-xs sm:text-sm font-medium transition-all ${data.current_page === data.last_page ? 'bg-slate-100 text-slate-400 cursor-not-allowed' : 'bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 active:scale-95'}`;
			nextBtn.innerHTML = '<span class="hidden sm:inline">Next →</span><span class="sm:hidden">→</span>';
			nextBtn.disabled = data.current_page === data.last_page;
			nextBtn.onclick = () => !nextBtn.disabled && loadAllOrders(data.current_page + 1);
			container.appendChild(nextBtn);
		}

		// Status badge HTML
		function getStatusBadgeHTML(status) {
			const badges = {
				'paid': '<span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2 sm:px-2.5 py-0.5 sm:py-1 text-[10px] sm:text-xs font-semibold text-green-800"><span class="size-1 sm:size-1.5 rounded-full bg-green-600"></span><span class="hidden xs:inline">Lunas</span><span class="xs:hidden">✓</span></span>',
				'pending': '<span class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-2 sm:px-2.5 py-0.5 sm:py-1 text-[10px] sm:text-xs font-semibold text-blue-800"><span class="size-1 sm:size-1.5 rounded-full bg-blue-600"></span><span class="hidden xs:inline">Pending</span><span class="xs:hidden">⏱</span></span>',
				'draft': '<span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2 sm:px-2.5 py-0.5 sm:py-1 text-[10px] sm:text-xs font-semibold text-amber-800"><span class="size-1 sm:size-1.5 rounded-full bg-amber-600"></span><span class="hidden xs:inline">Draft</span><span class="xs:hidden">📝</span></span>',
				'cancelled': '<span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-2 sm:px-2.5 py-0.5 sm:py-1 text-[10px] sm:text-xs font-semibold text-red-800"><span class="size-1 sm:size-1.5 rounded-full bg-red-600"></span><span class="hidden xs:inline">Batal</span><span class="xs:hidden">✕</span></span>'
			};
			return badges[status] || status;
		}

		// Format date
		function formatDate(dateString) {
			if (!dateString) return '-';
			const date = new Date(dateString);
			return date.toLocaleDateString('id-ID', { 
				day: '2-digit', 
				month: 'short', 
				year: 'numeric',
				hour: '2-digit',
				minute: '2-digit'
			});
		}

	// View order detail
	window.viewOrderDetail = async function(orderId) {
		try {
			currentDetailOrderId = orderId; // Store order ID for printing
			
			const res = await fetch(`/admin/pesanan/${orderId}`, {
				headers: { 'Accept': 'application/json' }
			});
			if (!res.ok) throw new Error('Gagal memuat detail');
			const order = await res.json();
			
			// Populate modal
			document.getElementById('detailOrderId').textContent = `Order ID: ${order.order_id || '-'}`;
			document.getElementById('detailCustomer').textContent = order.customer || '-';
			document.getElementById('detailDate').textContent = formatDate(order.created_at);
			
			// Display all items
			const itemsList = document.getElementById('detailItemsList');
			if (order.items && order.items.length > 0) {
				itemsList.innerHTML = order.items.map((item, index) => `
					<div class="rounded-lg border border-slate-200 p-3 bg-slate-50">
						<div class="flex items-start justify-between gap-3">
							<div class="flex-1 min-w-0">
								<div class="flex items-baseline gap-2">
									<span class="text-xs font-medium text-slate-500">${index + 1}.</span>
									<p class="font-semibold text-sm text-slate-900">${item.name}</p>
								</div>
								<p class="text-xs text-slate-600 mt-1">${money(item.price)} × ${item.qty}</p>
								${item.note ? `
									<div class="mt-2">
										<p class="text-xs font-medium text-slate-600 mb-1">Catatan:</p>
										<p class="text-xs text-slate-700 bg-amber-50 border border-amber-200 rounded px-2 py-1">${item.note}</p>
									</div>
								` : ''}
							</div>
							<div class="text-right flex-shrink-0">
								<p class="text-xs text-slate-600">Total</p>
								<p class="text-sm font-bold text-primary-600">${money(item.price * item.qty)}</p>
							</div>
						</div>
					</div>
				`).join('');
			} else {
				itemsList.innerHTML = '<p class="text-sm text-slate-500 text-center py-4">Tidak ada item</p>';
			}
			
			// Calculate totals
			const subtotal = order.subtotal || 0;
			const discount = order.discount || 0;
			const total = order.total_price || 0;
			
			document.getElementById('detailSubtotal').textContent = money(subtotal);
			document.getElementById('detailDiscountAmt').textContent = '- ' + money(discount);
			document.getElementById('detailTotal').textContent = money(total);
			
			// Payment info
			if (order.payment_method) {
				document.getElementById('detailPaymentInfo').classList.remove('hidden');
				document.getElementById('detailPaymentMethod').textContent = order.payment_method === 'cash' ? 'Tunai' : 'QRIS';
				
				if (order.payment_method === 'cash') {
					document.getElementById('detailCashInfo').classList.remove('hidden');
					document.getElementById('detailQrisInfo').classList.add('hidden');
					document.getElementById('detailCashReceived').textContent = money(order.cash_received || 0);
					document.getElementById('detailChangeAmount').textContent = money(order.change_amount || 0);
				} else {
					document.getElementById('detailCashInfo').classList.add('hidden');
					document.getElementById('detailQrisInfo').classList.remove('hidden');
					document.getElementById('detailPaymentRef').textContent = order.payment_reference || '-';
				}
			} else {
				document.getElementById('detailPaymentInfo').classList.add('hidden');
			}
			
			// Show modal
			document.getElementById('detailModal').classList.remove('hidden');
		} catch (error) {
			console.error(error);
			Swal.fire({
				icon: 'error',
				title: 'Error',
				text: 'Gagal memuat detail pesanan',
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000
			});
		}
	};

		// Close detail modal
		window.closeDetailModal = function() {
			currentDetailOrderId = null;
			document.getElementById('detailModal').classList.add('hidden');
		};

		// Print receipt from detail modal
		window.printOrderReceipt = function() {
			if (!currentDetailOrderId) {
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'Order ID tidak ditemukan',
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: 3000
				});
				return;
			}

			const receiptUrl = `/receipt/${currentDetailOrderId}?autoprint=1`;
			const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
			
			if (isMobile) {
				window.location.href = receiptUrl;
			} else {
				const popup = window.open(receiptUrl, '_blank', 'width=400,height=800');
				if (!popup) {
					Swal.fire({
						icon: 'warning',
						title: 'Popup diblokir',
						text: 'Izinkan popup untuk mencetak struk.',
						toast: true,
						position: 'top-end',
						showConfirmButton: false,
						timer: 3000
					});
				} else {
					popup.focus();
				}
			}
		};

		// Open status modal
		window.openStatusModal = function(orderId, currentStatus) {
			selectedOrderForStatus = orderId;
			document.getElementById('statusOrderId').textContent = `Order ID: Pesanan #${orderId}`;
			document.getElementById('newStatus').value = currentStatus;
			document.getElementById('statusModal').classList.remove('hidden');
		};

		// Close status modal
		window.closeStatusModal = function() {
			selectedOrderForStatus = null;
			document.getElementById('statusModal').classList.add('hidden');
		};

		// Save status change
		window.saveStatusChange = async function() {
			if (!selectedOrderForStatus) return;
			
			const newStatus = document.getElementById('newStatus').value;
			
			try {
				const res = await fetch(`/admin/pesanan/${selectedOrderForStatus}/status`, {
					method: 'PUT',
					headers: {
						'Content-Type': 'application/json',
						'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
					},
					body: JSON.stringify({ status: newStatus })
				});
				
				if (!res.ok) throw new Error('Gagal mengubah status');
				
				Swal.fire({
					icon: 'success',
					title: 'Status Diubah!',
					text: `Status pesanan berhasil diubah menjadi ${newStatus}`,
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: 3000
				});
				
				closeStatusModal();
				loadAllOrders(currentOrderPage);
			} catch (error) {
				console.error(error);
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'Gagal mengubah status pesanan',
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					timer: 3000
				});
			}
		};

		// Initial load
		loadAllOrders(1);

		// Refresh orders button - wait for DOM to be ready
		const refreshBtn = document.getElementById('refreshOrdersBtn');
		if (refreshBtn) {
			refreshBtn.addEventListener('click', () => {
				loadAllOrders(currentOrderPage);
			});
		}
	})();
	</script>

	<!-- ============================================ -->
	<!-- SECTION: DAFTAR PESANAN (ORDERS TABLE) -->
	<!-- ============================================ -->
	<section class="bg-white py-8 sm:py-12 lg:ml-72">
		<div class="mx-auto max-w-[1800px] px-4 sm:px-6 lg:px-8">
			<div class="rounded-xl sm:rounded-2xl bg-white shadow-lg sm:shadow-xl border border-slate-200 overflow-hidden">
				<!-- Header Section -->
				<div class="border-b border-slate-200 from-primary-50 to-white px-4 py-4 sm:px-6 sm:py-6">
					<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
						<div class="flex-1">
							<h2 class="text-xl sm:text-2xl font-bold text-slate-900 flex items-center gap-2 sm:gap-3">
								<div class="flex size-10 sm:size-12 items-center justify-center rounded-lg sm:rounded-xl bg-primary-600 text-white shadow-lg shrink-0">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 sm:size-6">
										<path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0118 9.375v9.375a3 3 0 003-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 00-.673-.05A3 3 0 0015 1.5h-1.5a3 3 0 00-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6zM13.5 3A1.5 1.5 0 0012 4.5h4.5A1.5 1.5 0 0015 3h-1.5z" clip-rule="evenodd" />
										<path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 013 20.625V9.375zm9.586 4.594a.75.75 0 00-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 00-1.06 1.06l1.5 1.5a.75.75 0 001.116-.062l3-3.75z" clip-rule="evenodd" />
									</svg>
								</div>
								<span class="truncate">Daftar Pesanan</span>
							</h2>
							<p class="text-xs sm:text-sm text-slate-600 mt-1 sm:mt-2 ml-12 sm:ml-15">Riwayat transaksi dan pesanan yang telah dibuat</p>
						</div>
						<button id="refreshOrdersBtn" class="inline-flex items-center justify-center gap-2 rounded-lg border border-primary-200 bg-white px-4 py-2 sm:px-5 sm:py-2.5 text-xs sm:text-sm font-semibold text-primary-700 shadow-sm transition-all hover:bg-primary-50 hover:border-primary-300 active:scale-95 w-full sm:w-auto">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 sm:size-5">
								<path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0112.548-3.364l1.903 1.903h-3.183a.75.75 0 100 1.5h4.992a.75.75 0 00.75-.75V4.356a.75.75 0 00-1.5 0v3.18l-1.9-1.9A9 9 0 003.306 9.67a.75.75 0 101.45.388zm15.408 3.352a.75.75 0 00-.919.53 7.5 7.5 0 01-12.548 3.364l-1.902-1.903h3.183a.75.75 0 000-1.5H2.984a.75.75 0 00-.75.75v4.992a.75.75 0 001.5 0v-3.18l1.9 1.9a9 9 0 0015.059-4.035.75.75 0 00-.53-.918z" clip-rule="evenodd" />
							</svg>
							<span>Refresh Data</span>
						</button>
					</div>
				</div>

				<!-- Table Section -->
				<div class="overflow-x-auto relative">
					<table class="w-full min-w-max">
						<thead class="sticky top-0 z-10 bg-slate-50 border-b border-slate-200/80 backdrop-blur supports-backdrop-filter:bg-slate-50/90">
							<tr>
								<th class="px-3 py-3 sm:px-6 sm:py-4 text-left text-[10px] sm:text-xs font-semibold uppercase tracking-wider text-slate-600 whitespace-nowrap">Order ID</th>
								<th class="px-3 py-3 sm:px-6 sm:py-4 text-left text-[10px] sm:text-xs font-semibold uppercase tracking-wider text-slate-600 whitespace-nowrap">Menu</th>
								<th class="px-3 py-3 sm:px-6 sm:py-4 text-left text-[10px] sm:text-xs font-semibold uppercase tracking-wider text-slate-600 whitespace-nowrap">Customer</th>
								<th class="px-3 py-3 sm:px-6 sm:py-4 text-center text-[10px] sm:text-xs font-semibold uppercase tracking-wider text-slate-600 whitespace-nowrap">Qty</th>
								<th class="px-3 py-3 sm:px-6 sm:py-4 text-right text-[10px] sm:text-xs font-semibold uppercase tracking-wider text-slate-600 whitespace-nowrap">Total</th>
								<th class="px-3 py-3 sm:px-6 sm:py-4 text-center text-[10px] sm:text-xs font-semibold uppercase tracking-wider text-slate-600 whitespace-nowrap">Status</th>
								<th class="px-3 py-3 sm:px-6 sm:py-4 text-left text-[10px] sm:text-xs font-semibold uppercase tracking-wider text-slate-600 whitespace-nowrap">Tanggal</th>
								<th class="px-3 py-3 sm:px-6 sm:py-4 text-center text-[10px] sm:text-xs font-semibold uppercase tracking-wider text-slate-600 whitespace-nowrap">Aksi</th>
							</tr>
						</thead>
						<tbody id="ordersTableBody" class="divide-y divide-slate-100 bg-white">
							<tr id="ordersLoadingRow">
								<td colspan="8" class="px-4 py-12 sm:px-6 sm:py-16 text-center">
									<div class="flex flex-col items-center justify-center gap-2 sm:gap-3 text-slate-500">
										<svg class="size-6 sm:size-8 animate-spin text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
											<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
											<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
										</svg>
										<p class="text-xs sm:text-sm font-medium">Memuat data pesanan...</p>
									</div>
								</td>
							</tr>
							<tr id="ordersEmptyRow" class="hidden">
								<td colspan="8" class="px-4 py-12 sm:px-6 sm:py-16 text-center">
									<div class="flex flex-col items-center justify-center text-slate-400">
										<svg class="mx-auto size-12 sm:size-16 mb-3 sm:mb-4 text-slate-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
											<path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
										</svg>
										<p class="text-sm sm:text-base font-semibold text-slate-600">Belum ada pesanan</p>
										<p class="text-xs sm:text-sm mt-1 sm:mt-2">Pesanan yang dibuat akan muncul di sini secara otomatis</p>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<!-- Pagination Section -->
				<div id="ordersPagination" class="border-t-2 border-slate-200 bg-slate-50/50 px-4 py-4 sm:px-6 sm:py-5">
					<div class="flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4">
						<div class="text-xs sm:text-sm text-slate-600 text-center sm:text-left">
							Menampilkan 
							<span id="ordersShowingStart" class="font-bold text-slate-900">0</span> - 
							<span id="ordersShowingEnd" class="font-bold text-slate-900">0</span> 
							dari 
							<span id="ordersTotal" class="font-bold text-primary-600">0</span> pesanan
						</div>
						<div id="ordersPaginationButtons" class="flex items-center gap-1 sm:gap-2 flex-wrap justify-center">
							<!-- Pagination buttons will be inserted here by JavaScript -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

</body>
</html>






