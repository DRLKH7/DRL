<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Manajemen Kategori</title>
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
		<x-admin.sidebar />

		<header class="border-b border-slate-200 bg-white/80 backdrop-blur supports-backdrop-filter:bg-white/60">
			<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-3 flex items-center gap-3">
				<div class="flex items-center gap-2">
					<div class="size-9 rounded-lg bg-primary-600 text-white grid place-items-center shadow-sm">KT</div>
					<div>
						<h1 class="text-base font-semibold">Manajemen Kategori</h1>
						<p class="text-xs text-slate-500">Kelola kategori menu</p>
					</div>
				</div>
				<div class="ms-auto flex items-center gap-2">
					<button id="addBtn" class="inline-flex items-center gap-2 rounded-md bg-primary-600 text-white px-3 py-2 text-sm font-semibold hover:bg-primary-700">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v12m6-6H6"/></svg>
						Tambah Kategori
					</button>
				</div>
			</div>
		</header>

		<section class="mx-auto max-w-7xl w-full px-4 sm:px-6 lg:px-8 py-4">
			<div class="flex flex-col gap-3 sm:flex-row sm:items-center">
				<div class="relative grow">
					<input id="search" type="search" placeholder="Cari kategori (Ctrl+/)" class="w-full rounded-lg border-slate-200 focus:border-primary-500 focus:ring-primary-500 pe-10" />
					<div class="pointer-events-none absolute inset-y-0 right-2 flex items-center text-slate-400">
						<span class="text-xs bg-slate-100 rounded px-1.5 py-0.5">Ctrl + /</span>
					</div>
				</div>
				<div class="flex items-center gap-2">
					<select id="sortBy" class="rounded-md border-slate-200 focus:border-primary-500 focus:ring-primary-500 text-sm">
						<option value="name-asc">Nama A→Z</option>
						<option value="name-desc">Nama Z→A</option>
						<option value="count-desc">Terbanyak Menu</option>
						<option value="count-asc">Tersedikit Menu</option>
					</select>
					<button id="toggleView" class="rounded-md border border-slate-200 bg-white px-3 py-2 text-sm font-medium hover:bg-slate-50" title="Ganti tampilan">Grid</button>
				</div>
			</div>
		</section>

		<main class="mx-auto max-w-7xl w-full px-4 sm:px-6 lg:px-8 pb-8">
			<div id="gridView" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
				@forelse(($categories ?? []) as $cat)
					<div class="rounded-xl border border-slate-200 bg-white p-3 hover:shadow-sm">
						<div class="flex items-start gap-3">
							<div class="size-10 rounded-md bg-primary-50 text-primary-700 grid place-items-center">{{ strtoupper(substr(($cat->name ?? ''),0,1)) }}</div>
							<div class="grow">
								<div class="font-medium leading-tight">{{ $cat?->name }}</div>
								<div class="text-xs text-slate-500">{{ $cat?->description ?? '—' }}</div>
							</div>
							<div class="text-right">
								<div class="text-[11px] text-slate-500">Menu</div>
								<div class="text-sm font-semibold">{{ $cat?->menus_count ?? 0 }}</div>
							</div>
						</div>
						<div class="mt-3 flex items-center justify-end gap-2 text-sm">
							<button 
								data-id="{{ $cat?->id }}" 
								data-act="edit"
								data-name="{{ $cat?->name }}"
								data-desc="{{ $cat?->description }}"
								class="rounded-md border border-slate-200 px-2 py-1 hover:bg-slate-50">Ubah</button>
							<button data-id="{{ $cat?->id }}" data-act="delete" class="rounded-md border border-rose-200 text-rose-600 px-2 py-1 hover:bg-rose-50">Hapus</button>
						</div>
					</div>
				@empty
					<div class="col-span-full text-center py-12 text-slate-500">Belum ada kategori.</div>
				@endforelse
			</div>

			<div id="listView" class="hidden overflow-hidden rounded-xl border border-slate-200 bg-white">
				<table class="min-w-full divide-y divide-slate-200">
					<thead class="bg-slate-50">
						<tr class="text-left text-xs font-semibold text-slate-600">
							<th class="px-4 py-3">Nama</th>
							<th class="px-4 py-3">Deskripsi</th>
							<th class="px-4 py-3">Jumlah Menu</th>
							<th class="px-4 py-3 text-right">Aksi</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-slate-200 bg-white text-sm">
						@forelse(($categories ?? []) as $cat)
							<tr>
								<td class="px-4 py-3 font-medium">{{ $cat?->name }}</td>
								<td class="px-4 py-3 text-slate-600">{{ $cat?->description ?? '—' }}</td>
								<td class="px-4 py-3">{{ $cat?->menus_count ?? 0 }}</td>
								<td class="px-4 py-3 text-right">
									<button 
										data-id="{{ $cat?->id }}" 
										data-act="edit"
										data-name="{{ $cat?->name }}"
										data-desc="{{ $cat?->description }}"
										class="rounded-md border border-slate-200 px-2 py-1 hover:bg-slate-50">Ubah</button>
									<button data-id="{{ $cat?->id }}" data-act="delete" class="rounded-md border border-rose-200 text-rose-600 px-2 py-1 hover:bg-rose-50">Hapus</button>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="4" class="px-4 py-6 text-center text-slate-500">Belum ada kategori.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</main>

		<!-- Modal Add/Edit -->
		<div id="catModal" class="fixed inset-0 z-40 hidden">
			<div class="absolute inset-0 bg-slate-900/30 backdrop-blur-sm"></div>
			<div class="absolute inset-0 flex items-end sm:items-center justify-center p-4">
				<div class="w-full sm:max-w-md bg-white rounded-xl shadow-xl border border-slate-200">
					<div class="p-4 border-b border-slate-200 flex items-center justify-between">
						<h3 id="modalTitle" class="text-sm font-semibold">Tambah Kategori</h3>
						<button id="closeModal" class="rounded-md p-1 hover:bg-slate-100">✕</button>
					</div>
					<div class="p-4 space-y-3">
						<div>
							<label class="text-xs text-slate-500">Nama</label>
							<input id="fName" type="text" class="mt-1 w-full rounded-md border-slate-200 focus:border-primary-500 focus:ring-primary-500" placeholder="Contoh: Makanan" />
						</div>
						<div>
							<label class="text-xs text-slate-500">Slug</label>
							<input id="fSlug" type="text" class="mt-1 w-full rounded-md border-slate-200 bg-slate-50 text-slate-500" readonly />
						</div>
						<div>
							<label class="text-xs text-slate-500">Deskripsi (opsional)</label>
							<textarea id="fDesc" rows="2" class="mt-1 w-full rounded-md border-slate-200 focus:border-primary-500 focus:ring-primary-500" placeholder="Deskripsi singkat"></textarea>
						</div>
						<div class="grid grid-cols-2 gap-3 pt-2">
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
		let view = 'grid';
		let editingId = null;
		const els = {
			search: document.getElementById('search'),
			sortBy: document.getElementById('sortBy'),
			toggleView: document.getElementById('toggleView'),
			gridView: document.getElementById('gridView'),
			listView: document.getElementById('listView'),
			addBtn: document.getElementById('addBtn'),
			modal: document.getElementById('catModal'),
			modalTitle: document.getElementById('modalTitle'),
			closeModal: document.getElementById('closeModal'),
			cancelForm: document.getElementById('cancelForm'),
			saveForm: document.getElementById('saveForm'),
			fName: document.getElementById('fName'),
			fSlug: document.getElementById('fSlug'),
			fDesc: document.getElementById('fDesc'),
		};

		const slugify = (s='') => s
			.toString()
			.normalize('NFKD')
			.replace(/[\u0300-\u036f]/g, '')
			.toLowerCase()
			.replace(/[^a-z0-9]+/g, '-')
			.replace(/^-+|-+$/g, '')
			.substring(0, 100);

		const openModal = (item=null) => {
			editingId = item?.id ?? null;
			els.modalTitle.textContent = editingId ? 'Ubah Kategori' : 'Tambah Kategori';
			els.fName.value = item?.name ?? '';
			els.fDesc.value = item?.desc ?? '';
			els.fSlug.value = slugify(els.fName.value);
			els.modal.classList.remove('hidden');
		};
		const closeModalFn = () => els.modal.classList.add('hidden');

		els.addBtn.addEventListener('click', () => openModal());
		els.closeModal.addEventListener('click', closeModalFn);
		els.cancelForm.addEventListener('click', (e)=>{ e.preventDefault(); closeModalFn(); });
		els.modal.addEventListener('click', (e)=>{ if (e.target === els.modal) closeModalFn(); });

		els.fName.addEventListener('input', () => { els.fSlug.value = slugify(els.fName.value); });

		window.addEventListener('keydown', (ev) => { if (ev.ctrlKey && ev.key === '/') { ev.preventDefault(); els.search?.focus(); } });
		els.toggleView.addEventListener('click', () => {
			view = view === 'grid' ? 'list' : 'grid';
			els.toggleView.textContent = view === 'grid' ? 'Grid' : 'List';
			els.gridView.classList.toggle('hidden', view !== 'grid');
			els.listView.classList.toggle('hidden', view !== 'list');
		});

		const handleAction = async (id, act, dataset=null) => {
			if (act === 'edit') {
				const it = dataset ? {
					id,
					name: dataset.name || '',
					desc: dataset.desc || '',
				} : null;
				openModal(it);
			} else if (act === 'delete') {
				const res = await window.$swal?.confirm({ title: `Hapus kategori ini?`, text: 'Tindakan ini tidak dapat dibatalkan.', icon: 'warning' });
				if (res?.isConfirmed) {
					const fd = new FormData();
					fd.append('_token', document.querySelector('meta[name=csrf-token]').content);
					fd.append('_method', 'DELETE');
					const resp = await fetch(`/dashboard/admin/kategori/${id}`, { method: 'POST', body: fd });
					if (resp.ok) { window.$swal?.toast({ icon:'success', title:'Kategori dihapus' }); window.location.reload(); }
					else { window.$swal?.toast({ icon:'error', title:'Gagal menghapus kategori' }); }
				}
			}
		};

		document.addEventListener('click', (e) => {
			const btn = e.target.closest('button[data-id][data-act]');
			if (!btn) return;
			const id = Number(btn.dataset.id);
			const act = btn.dataset.act;
			handleAction(id, act, btn.dataset);
		});

		els.saveForm.addEventListener('click', async (e) => {
			e.preventDefault();
			const name = (els.fName.value || '').trim();
			const desc = (els.fDesc.value || '').trim();
			if (!name) { return window.$swal?.toast({icon:'error', title:'Nama wajib diisi'}); }

			const fd = new FormData();
			fd.append('_token', document.querySelector('meta[name=csrf-token]').content);
			fd.append('name', name);
			if (desc) fd.append('description', desc);

			const isEdit = !!editingId;
			let url = '/dashboard/admin/kategori';
			let method = 'POST';
			if (isEdit) { url = `/dashboard/admin/kategori/${editingId}`; fd.append('_method', 'PUT'); }

			const resp = await fetch(url, { method, body: fd });
			if (resp.ok) { window.$swal?.toast({ icon:'success', title: isEdit ? 'Perubahan disimpan' : 'Kategori ditambahkan' }); window.location.reload(); }
			else {
				let msg = 'Gagal menyimpan data';
				try { const j = await resp.json(); msg = j.message || msg; } catch {}
				window.$swal?.toast({ icon:'error', title: msg });
			}
		});
	})();
	</script>
</body>
</html>

