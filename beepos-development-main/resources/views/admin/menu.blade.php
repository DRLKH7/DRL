<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Manajemen Menu</title>
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
<body class="h-full text-slate-800">
	<div class="min-h-dvh flex flex-col">
		<!-- Top Bar -->

    <!-- Sidebar -->
    <x-admin.sidebar />
		<header class="border-b border-slate-200 bg-white/80 backdrop-blur supports-backdrop-filter:bg-white/60">
			<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-3 flex items-center gap-3">
				<div class="flex items-center gap-2">
					<div class="size-9 rounded-lg bg-primary-600 text-white grid place-items-center shadow-sm">MN</div>
					<div>
						<h1 class="text-base font-semibold">Manajemen Menu</h1>
						<p class="text-xs text-slate-500">Kelola makanan dan minuman</p>
					</div>
				</div>
				<div class="ms-auto flex items-center gap-2">
					<button id="addBtn" class="inline-flex items-center gap-2 rounded-md bg-primary-600 text-white px-3 py-2 text-sm font-semibold hover:bg-primary-700">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v12m6-6H6"/></svg>
						Tambah Item
					</button>
				</div>
			</div>
		</header>

		<!-- Controls -->
		<section class="mx-auto max-w-7xl w-full px-4 sm:px-6 lg:px-8 py-4">
			<div class="flex flex-col gap-3 sm:flex-row sm:items-center">
				<div class="relative grow">
					<input id="search" type="search" placeholder="Cari menu (Ctrl+/)" class="w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500 pe-10" />
					<div class="pointer-events-none absolute inset-y-0 right-2 flex items-center text-slate-400">
						<span class="text-xs bg-slate-100 rounded px-1.5 py-0.5">Ctrl + /</span>
					</div>
				</div>
				<div class="flex items-center gap-2">
					<select id="filterCategory" class="rounded-md border-slate-200 focus:border-primary-500 focus:ring-primary-500 text-sm">
						<option value="all">Semua Kategori</option>
						<option value="makanan">Makanan</option>
						<option value="minuman">Minuman</option>
						<option value="lainnya">Lainnya</option>
					</select>
					<select id="filterStatus" class="rounded-md border-slate-200 focus:border-primary-500 focus:ring-primary-500 text-sm">
						<option value="all">Semua Status</option>
						<option value="active">Aktif</option>
						<option value="inactive">Nonaktif</option>
					</select>
					<select id="sortBy" class="rounded-md border-slate-200 focus:border-primary-500 focus:ring-primary-500 text-sm">
						<option value="name-asc">Nama A→Z</option>
						<option value="name-desc">Nama Z→A</option>
						<option value="price-asc">Harga Terendah</option>
						<option value="price-desc">Harga Tertinggi</option>
					</select>
					<button id="toggleView" class="rounded-md border border-slate-200 bg-white px-3 py-2 text-sm font-medium hover:bg-slate-50" title="Ganti tampilan">Grid</button>
				</div>
			</div>
		</section>

		<!-- Content -->
		<main class="mx-auto max-w-7xl w-full px-4 sm:px-6 lg:px-8 pb-8">
			<div id="gridView" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
				@forelse ($menus as $it)
					@php
						$imageUrl = $it->image_path ? asset('storage/'.$it->image_path) : null;
						$active = ($it->status === 'ready' || $it->status === 'active');
					@endphp
					<div class="rounded-xl border border-slate-200 bg-white p-3 hover:shadow-sm">
						<div class="aspect-4/3 w-full rounded-lg overflow-hidden bg-slate-100/70 grid place-items-center text-slate-400 mb-2">
							@if($imageUrl)
								<img src="{{ $imageUrl }}" alt="{{ $it->name }}" class="w-full h-full object-cover" />
							@else
								<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' class='size-9 opacity-70'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M3 3h18M3 7h18M4 21h16l-2-10H6l-2 10z'/></svg>
							@endif
						</div>
						<div class="flex items-start gap-2">
							<div class="grow">
								<div class="font-medium leading-tight">{{ $it->name }}</div>
								<div class="text-xs text-slate-500">{{ $it->category->name ?? '—' }}</div>
							</div>
							<div class="text-right">
								<div class="text-sm font-semibold">Rp{{ number_format($it->price, 0, ',', '.') }}</div>
								<span class="text-[10px] inline-block rounded px-1.5 py-0.5 {{ $active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">{{ $active ? 'AKTIF' : 'NONAKTIF' }}</span>
							</div>
						</div>
						<div class="mt-3 flex items-center justify-end gap-2 text-sm">
							<button 
								data-id="{{ $it->id }}" 
								data-act="edit" 
								data-name="{{ $it->name }}"
								data-category-id="{{ $it->category_id }}"
								data-price="{{ (float) $it->price }}"
								data-desc="{{ $it->description }}"
								data-active="{{ ($it->status === 'ready' || $it->status === 'active') ? 1 : 0 }}"
								@if($imageUrl) data-image-url="{{ $imageUrl }}" @endif
								class="rounded-md border border-slate-200 px-2 py-1 hover:bg-slate-50">Ubah</button>
							<button data-id="{{ $it->id }}" data-act="delete" class="rounded-md border border-rose-200 text-rose-600 px-2 py-1 hover:bg-rose-50">Hapus</button>
						</div>
					</div>
				@empty
					<div class="col-span-full text-center py-12 text-slate-500">Tidak ada item.</div>
				@endforelse
			</div>

			<div id="listView" class="hidden overflow-hidden rounded-xl border border-slate-200 bg-white">
				<table class="min-w-full divide-y divide-slate-200">
					<thead class="bg-slate-50">
						<tr class="text-left text-xs font-semibold text-slate-600">
							<th class="px-4 py-3">Nama</th>
							<th class="px-4 py-3">Kategori</th>
							<th class="px-4 py-3">Harga</th>
							<th class="px-4 py-3">Status</th>
							<th class="px-4 py-3 text-right">Aksi</th>
						</tr>
					</thead>
					<tbody id="tableBody" class="divide-y divide-slate-200 bg-white text-sm">
						@forelse ($menus as $it)
							@php
								$imageUrl = $it->image_path ? asset('storage/'.$it->image_path) : null;
								$active = ($it->status === 'ready' || $it->status === 'active');
							@endphp
							<tr>
								<td class="px-4 py-3">
									<div class="flex items-center gap-3">
										<div class="size-10 rounded-md overflow-hidden bg-slate-100 shrink-0 grid place-items-center text-slate-300">
											@if($imageUrl)
												<img src="{{ $imageUrl }}" alt="{{ $it->name }}" class="w-full h-full object-cover" />
											@else
												<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' class='size-5 opacity-70'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M3 3h18M3 7h18M4 21h16l-2-10H6l-2 10z'/></svg>
											@endif
										</div>
										<div>
											<div class="font-medium leading-tight">{{ $it->name }}</div>
											<div class="text-xs text-slate-500">{{ $it->description ?? '' }}</div>
										</div>
									</div>
								</td>
								<td class="px-4 py-3">{{ $it->category->name ?? '—' }}</td>
								<td class="px-4 py-3">Rp{{ number_format($it->price, 0, ',', '.') }}</td>
								<td class="px-4 py-3">
									<span class="text-[10px] inline-block rounded px-2 py-0.5 {{ $active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">{{ $active ? 'AKTIF' : 'NONAKTIF' }}</span>
								</td>
								<td class="px-4 py-3 text-right">
									<button 
										data-id="{{ $it->id }}" 
										data-act="edit"
										data-name="{{ $it->name }}"
										data-category-id="{{ $it->category_id }}"
										data-price="{{ (float) $it->price }}"
										data-desc="{{ $it->description }}"
										data-active="{{ ($it->status === 'ready' || $it->status === 'active') ? 1 : 0 }}"
										@if($imageUrl) data-image-url="{{ $imageUrl }}" @endif
										class="rounded-md border border-slate-200 px-2 py-1 hover:bg-slate-50">Ubah</button>
									<button data-id="{{ $it->id }}" data-act="delete" class="rounded-md border border-rose-200 text-rose-600 px-2 py-1 hover:bg-rose-50">Hapus</button>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="5" class="px-4 py-6 text-center text-slate-500">Tidak ada item.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
			<div id="emptyState" class="hidden text-center py-12 text-slate-500">
				Tidak ada item yang cocok.
			</div>
		</main>

		<!-- Modal Add/Edit -->
		<div id="itemModal" class="fixed inset-0 z-40 hidden">
			<div class="absolute inset-0 bg-slate-900/30 backdrop-blur-sm"></div>
			<div class="absolute inset-0 flex items-end sm:items-center justify-center p-4">
				<div class="w-full sm:max-w-md bg-white rounded-xl shadow-xl border border-slate-200">
					<div class="p-4 border-b border-slate-200 flex items-center justify-between">
						<h3 id="modalTitle" class="text-sm font-semibold">Tambah Item</h3>
						<button id="closeModal" class="rounded-md p-1 hover:bg-slate-100">✕</button>
					</div>
					<div class="p-4">
						<div class="space-y-3">
							<!-- Upload Gambar -->
							<div>
								<label class="text-xs text-slate-500">Gambar Menu</label>
								<div id="dropZone" class="mt-1 group relative overflow-hidden rounded-lg border border-dashed border-slate-300 bg-slate-50/60 hover:border-primary-400 transition-colors">
									<input id="fImage" type="file" accept="image/*" class="absolute inset-0 size-full opacity-0 cursor-pointer" />
									<div id="imagePreview" class="aspect-4/3 w-full grid place-items-center text-slate-400">
										<div class="text-center px-4 py-6">
											<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="mx-auto size-8 opacity-70"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7.5A3.5 3.5 0 0 1 6.5 4h11A3.5 3.5 0 0 1 21 7.5V16a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V7.5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.5 11.5 11 14l3.5-3.5L20 16.5"/></svg>
											<div class="mt-2 text-sm">
												<span class="font-medium text-slate-700">Klik untuk unggah</span>
												<span class="text-slate-500"> atau seret & letakkan</span>
											</div>
											<p class="mt-1 text-xs text-slate-500">PNG, JPG, atau WEBP (maks. 2MB)</p>
										</div>
									</div>
									<div id="imageHolder" class="hidden relative">
										<img id="imageEl" alt="Preview gambar" class="block w-full aspect-4/3 object-cover" />
										<button id="removeImage" type="button" class="absolute top-2 right-2 rounded-md bg-white/90 shadow px-2 py-1 text-xs text-slate-700 hover:bg-white">Hapus</button>
									</div>
								</div>
							</div>
							<div>
								<label class="text-xs text-slate-500">Nama</label>
								<input id="fName" type="text" class="mt-1 w-full rounded-md border-slate-200 focus:border-primary-500 focus:ring-primary-500" placeholder="Contoh: Nasi Goreng" />
							</div>
							<div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
								<div>
									<label class="text-xs text-slate-500">Kategori</label>
									<select id="fCategory" class="mt-1 w-full rounded-md border-slate-200 focus:border-primary-500 focus:ring-primary-500">
										@if(isset($categories) && count($categories))
											@foreach($categories as $cat)
												<option value="{{ $cat->id }}">{{ $cat->name }}</option>
											@endforeach
										@else
											<option value="">(Belum ada kategori)</option>
										@endif
									</select>
								</div>
								<div>
									<label class="text-xs text-slate-500">Harga (Rp)</label>
									<input id="fPrice" type="number" min="0" value="0" class="mt-1 w-full rounded-md border-slate-200 focus:border-primary-500 focus:ring-primary-500" />
								</div>
							</div>
							<div>
								<label class="text-xs text-slate-500">Deskripsi (opsional)</label>
								<textarea id="fDesc" rows="2" class="mt-1 w-full rounded-md border-slate-200 focus:border-primary-500 focus:ring-primary-500" placeholder="Deskripsi singkat"></textarea>
							</div>
							<label class="inline-flex items-center gap-2 text-sm">
								<input id="fActive" type="checkbox" class="rounded border-slate-300 text-primary-600 focus:ring-primary-500" checked>
								Aktifkan item ini
							</label>
						</div>
						<div class="mt-4 grid grid-cols-2 gap-3">
							<button id="cancelForm" class="rounded-md border border-slate-200 bg-white px-3 py-2 text-sm font-medium hover:bg-slate-50">Batal</button>
							<button id="saveForm" class="rounded-md bg-primary-600 text-white px-3 py-2 text-sm font-semibold hover:bg-primary-700">Simpan</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<x-swal />
	</div>

	<script>
	;(() => {
		const fmt = new Intl.NumberFormat('id-ID');
		const money = (n=0) => `Rp${fmt.format(Math.max(0, Math.round(n)))}`;

		// State & elements
	let view = 'grid'; // 'grid' | 'list'
	let editingId = null;
			const els = {
			search: document.getElementById('search'),
			filterCategory: document.getElementById('filterCategory'),
			filterStatus: document.getElementById('filterStatus'),
			sortBy: document.getElementById('sortBy'),
			toggleView: document.getElementById('toggleView'),
			gridView: document.getElementById('gridView'),
			listView: document.getElementById('listView'),
			tableBody: document.getElementById('tableBody'),
			empty: document.getElementById('emptyState'),
			addBtn: document.getElementById('addBtn'),
			modal: document.getElementById('itemModal'),
			modalTitle: document.getElementById('modalTitle'),
			closeModal: document.getElementById('closeModal'),
			cancelForm: document.getElementById('cancelForm'),
			saveForm: document.getElementById('saveForm'),
				fName: document.getElementById('fName'),
			fCategory: document.getElementById('fCategory'),
			fPrice: document.getElementById('fPrice'),
			fDesc: document.getElementById('fDesc'),
			fActive: document.getElementById('fActive'),
				fImage: document.getElementById('fImage'),
				dropZone: document.getElementById('dropZone'),
				imagePreview: document.getElementById('imagePreview'),
				imageHolder: document.getElementById('imageHolder'),
				imageEl: document.getElementById('imageEl'),
				removeImage: document.getElementById('removeImage'),
		};

		const openModal = (item=null) => {
			editingId = item?.id ?? null;
			els.modalTitle.textContent = editingId ? 'Ubah Item' : 'Tambah Item';
			els.fName.value = item?.name ?? '';
			// default to first category option if available
			const defaultCat = els.fCategory.options?.[0]?.value || '';
			els.fCategory.value = item?.category_id ?? defaultCat;
			els.fPrice.value = item?.price ?? 0;
			els.fDesc.value = item?.desc ?? '';
			els.fActive.checked = item?.active ?? true;
			// set image preview
			if (item?.image_url) {
				els.imageEl.src = item.image_url;
				els.imageHolder.classList.remove('hidden');
				els.imagePreview.classList.add('hidden');
			} else {
				els.imageEl.src = '';
				els.imageHolder.classList.add('hidden');
				els.imagePreview.classList.remove('hidden');
			}
			els.modal.classList.remove('hidden');
		};
		const closeModalFn = () => els.modal.classList.add('hidden');

		els.addBtn.addEventListener('click', () => openModal());
		els.closeModal.addEventListener('click', closeModalFn);
		els.cancelForm.addEventListener('click', (e)=>{ e.preventDefault(); closeModalFn(); });
		els.modal.addEventListener('click', (e)=>{ if (e.target === els.modal) closeModalFn(); });


		// Events
	// Optional: bisa diaktifkan kalau nanti ada pencarian server-side.
	window.addEventListener('keydown', (ev) => { if (ev.ctrlKey && ev.key === '/') { ev.preventDefault(); els.search?.focus(); } });

		els.toggleView.addEventListener('click', () => {
			view = view === 'grid' ? 'list' : 'grid';
			els.toggleView.textContent = view === 'grid' ? 'Grid' : 'List';
			// hanya toggle tampilan; konten sudah ada dari Blade
		});

		const handleAction = async (id, act, dataset=null) => {
			if (act === 'edit') {
				const it = dataset ? {
					id,
					name: dataset.name || '',
					category_id: dataset.categoryId || '',
					price: Number(dataset.price || 0),
					desc: dataset.desc || '',
					active: dataset.active === '1' || dataset.active === 1,
					image_url: dataset.imageUrl || '',
				} : null;
				openModal(it);
			} else if (act === 'delete') {
				const res = await window.$swal?.confirm({ title: `Hapus item #${id}?`, text: 'Tindakan ini tidak dapat dibatalkan.', icon: 'warning' });
				if (res?.isConfirmed) {
					const fd = new FormData();
					fd.append('_token', document.querySelector('meta[name=csrf-token]').content);
					fd.append('_method', 'DELETE');
					const resp = await fetch(`/dashboard/admin/menu/${id}`, { method: 'POST', body: fd });
					if (resp.ok) {
						window.$swal?.toast({ icon:'success', title:'Item dihapus' });
						window.location.reload();
					} else {
						window.$swal?.toast({ icon:'error', title:'Gagal menghapus item' });
					}
				}
			}
		};

		// Delegation for grid and list buttons
		document.addEventListener('click', (e) => {
			const btn = e.target.closest('button[data-id][data-act]');
			if (!btn) return;
			const id = Number(btn.dataset.id);
			const act = btn.dataset.act;
			handleAction(id, act, btn.dataset);
		});

		// Image handlers
		const resetImage = () => {
			els.fImage.value = '';
			els.imageEl.src = '';
			els.imageHolder.classList.add('hidden');
			els.imagePreview.classList.remove('hidden');
		};

		const loadFileToPreview = (file) => {
			if (!file) return;
			const validTypes = ['image/jpeg','image/png','image/webp'];
			if (!validTypes.includes(file.type)) {
				window.$swal?.toast({icon:'error', title:'Format gambar tidak didukung'});
				return;
			}
			const max = 2 * 1024 * 1024; // 2MB
			if (file.size > max) {
				window.$swal?.toast({icon:'error', title:'Ukuran gambar maksimal 2MB'});
				return;
			}
			const reader = new FileReader();
			reader.onload = () => {
				els.imageEl.src = reader.result;
				els.imageHolder.classList.remove('hidden');
				els.imagePreview.classList.add('hidden');
			};
			reader.readAsDataURL(file);
		};

		els.fImage.addEventListener('change', (ev) => loadFileToPreview(ev.target.files?.[0]));
		els.removeImage.addEventListener('click', (ev) => { ev.preventDefault(); resetImage(); });
		// drag over style
		['dragenter','dragover'].forEach(evt => {
			els.dropZone.addEventListener(evt, (e)=>{ e.preventDefault(); e.stopPropagation(); els.dropZone.classList.add('border-primary-400','bg-primary-50/50'); });
		});
		['dragleave','drop'].forEach(evt => {
			els.dropZone.addEventListener(evt, (e)=>{ e.preventDefault(); e.stopPropagation(); els.dropZone.classList.remove('border-primary-400','bg-primary-50/50'); });
		});
		els.dropZone.addEventListener('drop', (e)=>{
			const file = e.dataTransfer?.files?.[0];
			if (file) loadFileToPreview(file);
		});

		els.saveForm.addEventListener('click', async (e) => {
			e.preventDefault();
			const name = (els.fName.value || '').trim();
			const categoryId = els.fCategory.value;
			const price = Math.max(0, Number(els.fPrice.value || 0));
			const desc = (els.fDesc.value || '').trim();
			const active = !!els.fActive.checked;
			const file = els.fImage.files?.[0];

			if (!name) { return window.$swal?.toast({icon:'error', title:'Nama wajib diisi'}); }
			if (!price) { return window.$swal?.toast({icon:'error', title:'Harga harus lebih dari 0'}); }

			const fd = new FormData();
			fd.append('_token', document.querySelector('meta[name=csrf-token]').content);
			fd.append('name', name);
			if (categoryId) fd.append('category_id', categoryId);
			fd.append('price', String(price));
			if (desc) fd.append('description', desc);
			fd.append('status', active ? 'active' : 'inactive');
			if (file) fd.append('image', file);

			const isEdit = !!editingId;
			let url = '/dashboard/admin/menu';
			let method = 'POST';
			if (isEdit) {
				url = `/dashboard/admin/menu/${editingId}`;
				fd.append('_method', 'PUT');
			}

			const resp = await fetch(url, { method, body: fd });
			if (resp.ok) {
				window.$swal?.toast({ icon:'success', title: isEdit ? 'Perubahan disimpan' : 'Item ditambahkan' });
				window.location.reload();
			} else {
				let msg = 'Gagal menyimpan data';
				try { const j = await resp.json(); msg = j.message || msg; } catch {}
				window.$swal?.toast({ icon:'error', title: msg });
			}
		});

		// Init: tidak ada render karena konten sudah dirender server-side
	})();
	</script>
</body>
</html>

