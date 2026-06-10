<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Masuk - {{ config('app.name', 'Laravel') }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-dvh bg-linear-to-br from-primary-50 via-sky-50 to-white">
  <!-- Background decoration -->
  <div aria-hidden="true" class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
  <div class="absolute -top-24 -right-32 h-72 w-72 rounded-full bg-primary-400/20 blur-3xl"></div>
    <div class="absolute -bottom-24 -left-32 h-72 w-72 rounded-full bg-fuchsia-400/20 blur-3xl"></div>
  </div>

  <div class="grid min-h-dvh grid-cols-1 lg:grid-cols-2">
    <!-- Left visual panel -->
    <section
  class="hidden lg:flex items-center justify-center p-12 bg-linear-to-br from-primary-600 via-violet-600 to-fuchsia-600 text-white relative">
      <div
        class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1514933651103-005eec06c04b?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=1074')] opacity-10 bg-cover bg-center">
      </div>
      <div class="relative max-w-lg">
        <div class="mb-8 inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-sm">
          <span class="size-2 rounded-full bg-emerald-300"></span>
          <span>Selamat datang di BeePOS</span>
        </div>
        <h1 class="text-4xl font-semibold leading-tight">
          <span class="text-orange-400 font-black">BeePOS</span> Solusi pintar untuk manajemen restoran Kamu
        </h1>
        <p class="mt-4 text-white/80">
          Data pesanan, stok, dan transaksi dikelola otomatis dan aman dalam satu platform.
        </p>
      </div>
    </section>

    <!-- Right form panel -->
    <main class="flex items-center justify-center p-6 lg:p-12">
      <div class="w-full max-w-md">
        <div class="mb-8 text-center">
          <h2 class="mt-6 text-2xl font-semibold text-slate-900">Masuk ke akun Anda</h2>
          <p class="mt-1 text-slate-600">Silakan masukkan kredensial Anda di bawah ini</p>
        </div>

        @if (session('status'))
          <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('status') }}
          </div>
        @endif

        <div class="rounded-2xl border border-slate-200/70 bg-white p-6 shadow-lg shadow-slate-200/30">
          <form method="POST" action="{{ route('auth.login') }}" novalidate>
            @csrf
            <div>
              <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
              <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email"
                autofocus
                class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-900 placeholder-slate-400 shadow-sm outline-none transition focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20"
                placeholder="nama@domain.com" />
              @error('email')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
              @enderror
            </div>

            <div class="mt-4">
              <div class="flex items-center justify-between">
                <label for="password" class="block text-sm font-medium text-slate-700">Kata sandi</label>
                @if (Route::has('password.request'))
                  <a href="{{ route('password.request') }}"
                    class="text-sm font-medium text-primary-600 hover:text-primary-700">Lupa kata sandi?</a>
                @endif
              </div>
              <div class="relative mt-1">
                <input id="password" name="password" type="password" required autocomplete="current-password"
                  class="block w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 pr-11 text-slate-900 placeholder-slate-400 shadow-sm outline-none transition focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20"
                  placeholder="••••••••" />
                <button type="button" title="Tampilkan/Sembunyikan kata sandi"
                  class="absolute inset-y-0 right-0 grid w-10 place-items-center text-slate-500 hover:text-slate-700"
                  onclick="(function(btn){ const i=document.getElementById('password'); if(!i) return; i.type = i.type==='password'?'text':'password'; btn.setAttribute('aria-pressed', i.type==='text'); })(this)">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                    <path d="M12 5c-7 0-10 7-10 7s3 7 10 7 10-7 10-7-3-7-10-7Zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10Z" />
                  </svg>
                </button>
              </div>
              @error('password')
                <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
              @enderror
            </div>

            <div class="mt-4 flex items-center justify-between">
              <label class="inline-flex items-center gap-3 text-sm text-slate-700">
                <input id="remember" name="remember" type="checkbox"
                  class="size-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500" {{ old('remember') ? 'checked' : '' }}>
                Ingat saya
              </label>
            </div>

            <button type="submit"
              class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary-600 px-4 py-2.5 font-medium text-white shadow-lg shadow-primary-600/30 transition hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500/40">
              Masuk
            </button>

            @if (Route::has('register'))
              <p class="mt-6 text-center text-sm text-slate-600">
                Belum punya akun?
                {{-- <a href="{{ route('register') }}" class="font-medium text-primary-600 hover:text-primary-700">Daftar
                  sekarang</a> --}}
              </p>
            @endif
          </form>

          <!-- Divider -->
          <div class="mt-6 flex items-center gap-4">
            <div class="h-px w-full bg-slate-200"></div>
            <span class="text-xs text-slate-500">atau</span>
            <div class="h-px w-full bg-slate-200"></div>
          </div>

          <div class="mt-4 grid grid-cols-1 gap-3">
            <a href="#"
              class="inline-flex items-center justify-center gap-3 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">
              <img alt="Google" class="size-5" src="https://www.svgrepo.com/show/475656/google-color.svg" />
              Masuk dengan Google
            </a>
          </div>
        </div>

        <p class="mt-8 text-center text-xs text-slate-500">Dengan masuk, Anda menyetujui Ketentuan dan Kebijakan
          Privasi.</p>
      </div>
    </main>
  </div>
  <x-swal />
</body>

</html>