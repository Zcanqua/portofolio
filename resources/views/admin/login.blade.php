<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1b1b23">
    <title>Admin — Ricky Kurniawan</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-ink font-sans text-slate-100 antialiased">
    <main class="mx-auto flex min-h-screen max-w-lg items-center px-5 py-12">
        <section class="w-full rounded-3xl border border-white/10 bg-panel p-7 shadow-2xl sm:p-9">
            <p class="text-xs font-bold tracking-[.2em] text-brand">LOGIN</p>

            @if (! $configured)
                <p class="mt-6 rounded-xl border border-amber-400/30 bg-amber-400/10 p-4 text-sm text-amber-200">
                    Akun admin belum tersedia. Jalankan <code>php artisan db:seed</code> untuk membuat akun administrator.
                </p>
            @endif

            <form class="mt-7 grid gap-5" action="{{ route('admin.authenticate') }}" method="POST">
                @csrf
                <label class="grid gap-2 text-sm font-medium" for="identifier">Username atau email
                    <input class="w-full rounded-xl border border-white/10 bg-ink px-4 py-3 text-slate-100 placeholder:text-slate-500 focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20" id="identifier" name="identifier" type="text" autocomplete="username" required>
                </label>
                <label class="grid gap-2 text-sm font-medium" for="password">Kata sandi
                    <input class="w-full rounded-xl border border-white/10 bg-ink px-4 py-3 text-slate-100 placeholder:text-slate-500 focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20" id="password" name="password" type="password" autocomplete="current-password" required>
                </label>
                @error('identifier')<p class="text-sm text-rose-300">{{ $message }}</p>@enderror
                <button class="rounded-xl bg-brand px-5 py-3 font-bold text-ink transition hover:-translate-y-0.5 hover:bg-white disabled:cursor-not-allowed disabled:opacity-50" type="submit" @disabled(! $configured)>Masuk</button>
            </form>

            <a class="mt-6 inline-flex text-sm font-semibold text-slate-400 transition hover:text-brand" href="{{ route('home') }}">← Kembali ke portofolio</a>
        </section>
    </main>
</body>
</html>
