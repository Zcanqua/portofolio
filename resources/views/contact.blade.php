<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Hubungi Ricky Kurniawan melalui WhatsApp, Instagram, Telegram, atau email.">
    <meta name="theme-color" content="#090b12">
    <title>Kontak — Ricky Kurniawan</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen overflow-x-hidden bg-ink font-sans leading-relaxed text-slate-100 antialiased">
    <header class="sticky top-0 z-50 border-b border-white/10 bg-ink/90 backdrop-blur-xl">
        <nav class="relative mx-auto flex max-w-7xl items-center justify-between px-5 py-4 lg:px-8" aria-label="Navigasi utama">
            <a class="flex items-center gap-3 font-display text-lg font-bold tracking-tight" href="{{ route('home') }}#home">
                <img class="size-10 rounded-xl object-cover" src="{{ asset('images/favicon.png') }}" alt="" width="40" height="40">
                <span>Ricky Kurniawan</span>
            </a>
            <button class="inline-flex size-11 flex-col items-center justify-center gap-1.5 rounded-xl border border-white/10 text-slate-100 hover:border-brand/50 lg:hidden" id="hamburger" type="button" aria-label="Buka navigasi" aria-expanded="false" aria-controls="primary-navigation">
                <span class="h-0.5 w-5 rounded bg-current"></span><span class="h-0.5 w-5 rounded bg-current"></span><span class="h-0.5 w-5 rounded bg-current"></span>
            </button>
            <div class="nav-links absolute left-5 right-5 top-full z-50 hidden flex-col gap-1 rounded-2xl border border-white/10 bg-panel p-3 shadow-2xl lg:static lg:flex lg:flex-row lg:items-center lg:gap-1 lg:border-0 lg:bg-transparent lg:p-0 lg:shadow-none" id="primary-navigation">
                <a class="rounded-full px-4 py-2 text-sm text-slate-300 transition hover:bg-white/5 hover:text-brand" href="{{ route('home') }}#about">About</a>
                <a class="rounded-full px-4 py-2 text-sm text-slate-300 transition hover:bg-white/5 hover:text-brand" href="{{ route('home') }}#skills">Skills</a>
                <a class="rounded-full px-4 py-2 text-sm text-slate-300 transition hover:bg-white/5 hover:text-brand" href="{{ route('home') }}#projects">Projects</a>
                <a class="rounded-full px-4 py-2 text-sm text-slate-300 transition hover:bg-white/5 hover:text-brand" href="{{ route('home') }}#experience">Experience</a>
                <a class="rounded-full px-4 py-2 text-sm text-slate-300 transition hover:bg-white/5 hover:text-brand" href="{{ route('contact') }}">Contact</a>
                <a class="ml-1 rounded-full bg-brand px-5 py-2.5 text-sm font-bold text-ink" href="{{ route('home') }}#home">Kembali ke beranda</a>
            </div>
        </nav>
    </header>

    <main class="mx-auto max-w-7xl px-5 py-16 sm:py-24 lg:px-8">
        <section class="reveal mx-auto max-w-3xl text-center">
            <h1 class="font-display text-4xl font-bold leading-tight tracking-tight sm:text-6xl">
                Hubungi <span class="text-brand">Saya</span>
            </h1>
        </section>

        <section class="mx-auto mt-10 grid max-w-4xl grid-cols-1 gap-4 sm:grid-cols-2" aria-label="Pilihan kontak">
            <a class="contact-card reveal flex min-h-28 items-center gap-4 rounded-2xl border border-white/10 bg-panel p-5 transition hover:-translate-y-1 hover:border-brand/40 hover:shadow-xl" href="https://wa.me/6285187094538?text=Halo%20Ricky%2C%20saya%20menghubungi%20Anda%20dari%20portofolio." target="_blank" rel="noopener noreferrer">
                <span class="grid size-12 shrink-0 place-items-center rounded-xl border border-brand/20 bg-brand/10">
                    <img class="size-7" src="{{ asset('images/contact-icons/whatsapp.svg') }}" alt="" aria-hidden="true" width="28" height="28">
                </span>
                <span class="min-w-0 flex-1"><strong class="block font-display text-lg">WhatsApp</strong></span><span class="text-brand" aria-hidden="true">↗</span>
            </a>
            <a class="contact-card reveal flex min-h-28 items-center gap-4 rounded-2xl border border-white/10 bg-panel p-5 transition hover:-translate-y-1 hover:border-brand/40 hover:shadow-xl" href="https://instagram.com/rkykrnwn22_" target="_blank" rel="noopener noreferrer">
                <span class="grid size-12 shrink-0 place-items-center rounded-xl border border-brand/20 bg-brand/10">
                    <img class="size-7" src="{{ asset('images/contact-icons/instagram.svg') }}" alt="" aria-hidden="true" width="28" height="28">
                </span>
                <span class="min-w-0 flex-1"><strong class="block font-display text-lg">Instagram</strong></span><span class="text-brand" aria-hidden="true">↗</span>
            </a>
            <a class="contact-card reveal flex min-h-28 items-center gap-4 rounded-2xl border border-white/10 bg-panel p-5 transition hover:-translate-y-1 hover:border-brand/40 hover:shadow-xl" href="https://t.me/YoJinnns" target="_blank" rel="noopener noreferrer">
                <span class="grid size-12 shrink-0 place-items-center rounded-xl border border-brand/20 bg-brand/10">
                    <img class="size-7" src="{{ asset('images/contact-icons/telegram.svg') }}" alt="" aria-hidden="true" width="28" height="28">
                </span>
                <span class="min-w-0 flex-1"><strong class="block font-display text-lg">Telegram</strong></span><span class="text-brand" aria-hidden="true">↗</span>
            </a>
            <a class="contact-card reveal flex min-h-28 items-center gap-4 rounded-2xl border border-white/10 bg-panel p-5 transition hover:-translate-y-1 hover:border-brand/40 hover:shadow-xl" href="mailto:ricky_sakurniawan@teknokrat.ac.id">
                <span class="grid size-12 shrink-0 place-items-center rounded-xl border border-brand/20 bg-brand/10">
                    <img class="size-7" src="{{ asset('images/contact-icons/gmail.jpg') }}" alt="" aria-hidden="true" width="28" height="28">
                </span>
                <span class="min-w-0 flex-1"><strong class="block font-display text-lg">Email</strong></span><span class="text-brand" aria-hidden="true">↗</span>
            </a>
        </section>

        <a class="mx-auto mt-10 block w-fit text-sm font-semibold text-brand hover:text-white" href="{{ route('home') }}#home">← Kembali ke beranda</a>
    </main>

    <footer class="mx-auto grid max-w-7xl grid-cols-1 gap-5 border-t border-white/10 px-5 py-8 text-sm text-slate-400 sm:grid-cols-2 lg:grid-cols-3 lg:px-8">
        <a class="font-display font-bold text-slate-100" href="{{ route('home') }}">Ricky Kurniawan<span class="text-brand">.</span></a>
        <nav class="flex flex-wrap gap-x-5 gap-y-2" aria-label="Tautan cepat">
            <a class="hover:text-brand" href="{{ route('home') }}#about">About</a><a class="hover:text-brand" href="{{ route('home') }}#projects">Projects</a><a class="hover:text-brand" href="{{ route('contact') }}">Contact</a>
            <a class="hover:text-brand" href="https://github.com/usernotfound77" target="_blank" rel="noopener noreferrer">GitHub</a>
            <a class="hover:text-brand" href="https://www.linkedin.com/in/ricky-kurniawan-510969289" target="_blank" rel="noopener noreferrer">LinkedIn</a>
        </nav>
        <p class="sm:col-span-2 lg:col-span-1 lg:text-right">© <span id="year"></span> Ricky Kurniawan. All rights reserved.</p>
    </footer>
</body>
</html>
