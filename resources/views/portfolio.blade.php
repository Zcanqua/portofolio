<!DOCTYPE html>
<html lang="id" class="scroll-smooth no-js" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portofolio Ricky Kurniawan, mahasiswa Informatika Universitas Teknokrat Indonesia.">
    <meta name="theme-color" content="#1b1b23">
    <title>Ricky Kurniawan — Portofolio</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        document.documentElement.classList.replace('no-js', 'js');
        document.documentElement.dataset.theme = localStorage.getItem('portfolio-theme') || 'dark';
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="portfolio-page overflow-x-hidden bg-ink font-sans leading-relaxed text-slate-100 antialiased">
    <div id="loader-wrapper" role="status" aria-label="Memuat portofolio Ricky Kurniawan">
        <div class="loader-content">
            <div id="loader" aria-hidden="true"></div>
            <p class="loader-name">Ricky Kurniawan<span>.</span></p>
            <p class="loader-caption">Menyiapkan portofolio</p>
        </div>
        <div class="loader-section section-left" aria-hidden="true"></div>
        <div class="loader-section section-right" aria-hidden="true"></div>
    </div>
    <header class="site-header sticky top-0 z-50 border-b border-white/10 bg-ink/90 backdrop-blur-xl">
        <nav class="relative mx-auto flex max-w-7xl items-center justify-between px-5 py-4 lg:px-8" aria-label="Navigasi utama">
            <a class="flex items-center gap-3 font-display text-lg font-bold tracking-tight" href="#home" aria-label="Ricky Kurniawan, ke halaman utama">
                <img class="size-10 rounded-xl object-cover" src="{{ asset('images/favicon.png') }}" alt="" width="40" height="40">
                <span class="hidden sm:inline">Ricky Kurniawan</span>
                <span class="sr-only">Ricky Kurniawan</span>
            </a>
            <button class="inline-flex size-11 flex-col items-center justify-center gap-1.5 rounded-xl border border-white/10 text-slate-100 hover:border-brand/50 lg:hidden" id="hamburger" type="button" aria-label="Buka navigasi" aria-expanded="false" aria-controls="primary-navigation">
                <span class="h-0.5 w-5 rounded bg-current"></span><span class="h-0.5 w-5 rounded bg-current"></span><span class="h-0.5 w-5 rounded bg-current"></span>
            </button>
            <div class="absolute left-5 right-5 top-full z-50 hidden flex-col gap-1 rounded-2xl border border-white/10 bg-panel p-3 shadow-2xl lg:static lg:flex lg:flex-row lg:items-center lg:gap-1 lg:border-0 lg:bg-transparent lg:p-0 lg:shadow-none" id="primary-navigation">
                <a class="nav-link rounded-full px-4 py-2 text-sm text-slate-300 transition hover:bg-white/5 hover:text-brand" href="#about">About</a>
                <a class="nav-link rounded-full px-4 py-2 text-sm text-slate-300 transition hover:bg-white/5 hover:text-brand" href="#skills">Skills</a>
                <a class="nav-link rounded-full px-4 py-2 text-sm text-slate-300 transition hover:bg-white/5 hover:text-brand" href="#projects">Projects</a>
                <a class="nav-link rounded-full px-4 py-2 text-sm text-slate-300 transition hover:bg-white/5 hover:text-brand" href="#experience">Experience</a>
                <a class="nav-link rounded-full px-4 py-2 text-sm text-slate-300 transition hover:bg-white/5 hover:text-brand" href="#certificates">Certificates</a>
                <a class="nav-link rounded-full px-4 py-2 text-sm text-slate-300 transition hover:bg-white/5 hover:text-brand" href="{{ route('contact') }}">Contact</a>
                <button class="theme-toggle" id="theme-toggle" type="button" aria-label="Ganti ke mode terang" title="Ganti ke mode terang">
                    <svg class="theme-icon theme-icon-sun" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2m0 16v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42"/></svg>
                    <svg class="theme-icon theme-icon-moon" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M20.2 15.1A8.5 8.5 0 0 1 8.9 3.8 8.5 8.5 0 1 0 20.2 15.1Z"/></svg>
                    <span class="sr-only">Ganti tema</span>
                </button>
                <a class="ml-1 rounded-full bg-brand px-5 py-2.5 text-sm font-bold text-ink transition hover:-translate-y-0.5 hover:bg-white" href="{{ route('contact') }}">Let's talk <span aria-hidden="true">↗</span></a>
            </div>
        </nav>
    </header>

    <main>
        <section class="portfolio-hero relative mx-auto grid min-h-[calc(100svh-73px)] max-w-7xl grid-cols-1 items-center gap-10 px-5 py-16 md:py-20 lg:grid-cols-2 lg:gap-16 lg:px-8" id="home">
            <div class="hero-copy reveal order-2 lg:order-1">
                <p class="hero-student-badge mb-5 inline-flex items-center gap-2 rounded-full border px-4 py-2 text-xs font-semibold tracking-widest"><span class="hero-student-dot size-2 rounded-full"></span>PROGRAMMER</p>
                <h1 class="hero-title font-display text-5xl font-bold leading-[1.05] tracking-[-.055em] text-brand sm:text-6xl lg:text-7xl">RICKY <span>KURNIAWAN</span></h1>
                <h2 class="mt-5 max-w-xl font-display text-xl font-medium text-slate-200 sm:text-2xl"><span class="text-brand">Mahasiswa</span></h2>
                <p class="mt-5 max-w-xl text-base text-slate-400 sm:text-lg">Saya mahasiswa semester 5 di Universitas Teknokrat Indonesia yang tertarik pada pengembangan web, aplikasi, dan desain antarmuka. Saya senang belajar teknologi baru dan membangun solusi digital yang berguna.</p>
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <span class="inline-flex cursor-not-allowed items-center justify-center gap-2 rounded-xl border border-white/10 px-6 py-3 font-semibold text-slate-500" aria-disabled="true" title="File CV belum tersedia">Download CV <span aria-hidden="true">↓</span><small class="text-xs">(belum tersedia)</small></span>
                    <a class="hero-work-link inline-flex items-center justify-center gap-2 rounded-xl border border-white/15 px-6 py-3 font-semibold text-slate-100 transition hover:-translate-y-0.5 hover:border-brand hover:text-brand" href="#projects">Lihat Proyek <span aria-hidden="true">↘</span></a>
                </div>
            </div>
            <div class="hero-visual reveal order-1 mx-auto lg:order-2">
                <div class="hero-photo-frame relative grid size-64 place-items-center border border-brand/25 bg-gradient-to-br from-accent/25 via-panel to-brand/20 p-3 shadow-[0_0_100px_rgba(139,240,208,.12)] sm:size-80 lg:size-[26rem]" aria-label="Foto profil dalam bingkai animasi">
                    <div class="hero-photo-inner grid size-full place-items-center overflow-hidden border-4 border-ink bg-[#f2d323]">
                        <img class="h-full w-full object-cover object-[center_35%]" src="{{ asset($profileImage) }}" alt="Foto profil Ricky Kurniawan" fetchpriority="high">
                    </div>
                </div>
            </div>
            <aside class="hero-socials" aria-label="Tautan sosial">
                <a href="https://github.com/Zcanqua" target="_blank" rel="noopener noreferrer" aria-label="GitHub">
                    <img src="{{ asset('images/contact-icons/github.svg') }}" alt="" width="22" height="22">
                </a>
                <a href="https://www.linkedin.com/in/ricky-kurniawan-510969289" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                    <img src="{{ asset('images/contact-icons/linkedin.svg') }}" alt="" width="22" height="22">
                </a>
                <a href="mailto:ricky_sakurniawan@teknokrat.ac.id" aria-label="Email">
                    <img src="{{ asset('images/contact-icons/email.svg') }}" alt="" width="22" height="22">
                </a>
            </aside>
            <a class="hero-scroll" href="#projects"><span>Scroll to explore</span><span aria-hidden="true">↓</span></a>
        </section>

        <section class="focus-strip border-y border-white/10 bg-panel/70" aria-label="Fokus">
            <div class="mx-auto grid max-w-7xl grid-cols-1 gap-5 px-5 py-7 text-center sm:grid-cols-3 lg:grid-cols-4 lg:px-8">
                <div><p class="font-display text-xl font-bold text-brand">Web</p><p class="text-sm text-slate-400">Web development</p></div>
                <div><p class="font-display text-xl font-bold text-brand">Mobile</p><p class="text-sm text-slate-400">Mobile application</p></div>
                <div><p class="font-display text-xl font-bold text-brand">UI/UX</p><p class="text-sm text-slate-400">Interface design</p></div>
                <p class="hidden self-center text-sm text-slate-300 lg:block">Belajar terus. <span class="text-brand">Membangun dengan tujuan.</span></p>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-5 py-20 sm:py-28 lg:px-8" id="about">
            <div class="reveal max-w-3xl">
                <p class="mb-3 text-xs font-bold tracking-[.2em] text-brand"> ABOUT ME</p>
                <h2 class="font-display text-3xl font-bold tracking-tight sm:text-5xl">Pikiran ingin tahu.<br><span class="text-slate-500">Senang membangun.</span></h2>
            </div>
            <div class="mt-10 grid grid-cols-1 gap-8 lg:grid-cols-2">
                <article class="reveal rounded-3xl border border-white/10 bg-panel p-6 sm:p-8">
                    <p class="text-lg leading-relaxed text-slate-200">Saya percaya teknologi terbaik bukan hanya terlihat menarik, tetapi juga <span class="font-semibold text-brand">memecahkan masalah nyata.</span></p>
                    <p class="mt-5 text-slate-400">Saat ini saya mengembangkan kemampuan pemrograman dan perancangan pengalaman pengguna. Saya senang mengeksplorasi ide, belajar dari proses, lalu mengubahnya menjadi karya yang dapat digunakan.</p>
                    <a class="mt-7 inline-flex font-semibold text-brand hover:text-white" href="{{ route('contact') }}">Mari terhubung <span class="ml-2">↗</span></a>
                </article>
                <article class="reveal rounded-3xl border border-white/10 bg-[#0d1019] p-6 sm:p-8" aria-label="Ringkasan profil dalam format kode">
                    <p class="mb-5 flex items-center gap-2 text-xs text-slate-500"><span class="size-2 rounded-full bg-rose-400"></span><span class="size-2 rounded-full bg-amber-300"></span><span class="size-2 rounded-full bg-brand"></span><span class="ml-2">profile.js</span></p>
                    <pre class="overflow-x-auto text-sm leading-7 text-slate-300"><code><span class="text-accent">const</span> developer = {
  name: <span class="text-brand">'Ricky Kurniawan'</span>,
  study: <span class="text-brand">'Informatika, Semester 5'</span>,
  campus: <span class="text-brand">'Universitas Teknokrat Indonesia'</span>,
  focus: [<span class="text-brand">'Web'</span>, <span class="text-brand">'Mobile'</span>, <span class="text-brand">'UI/UX'</span>],
  mindset: <span class="text-brand">'Always learning'</span>
};</code></pre>
                </article>
            </div>
        </section>

        <section class="border-y border-white/10 bg-panel/40" id="skills">
            <div class="mx-auto max-w-7xl px-5 py-20 sm:py-28 lg:px-8">
                <div class="reveal">
                    <p class="mb-3 text-xs font-bold tracking-[.2em] text-brand">SKILLS</p>
                    <h2 class="font-display text-3xl font-bold tracking-tight sm:text-5xl">Teknologi yang<br><span class="text-slate-500">sedang saya dalami.</span></h2>
                </div>
                <div class="mt-10 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    <article class="reveal rounded-2xl border border-white/10 bg-panel p-6"><h3 class="font-display font-bold text-brand">Frontend</h3><div class="mt-4 flex flex-wrap gap-2"><span class="skill-chip">HTML5</span><span class="skill-chip">CSS3</span><span class="skill-chip">JavaScript</span><span class="skill-chip">Tailwind CSS</span></div></article>
                    <article class="reveal rounded-2xl border border-white/10 bg-panel p-6"><h3 class="font-display font-bold text-brand">Backend</h3><div class="mt-4 flex flex-wrap gap-2"><span class="skill-chip">PHP</span><span class="skill-chip">Laravel</span></div></article>
                    <article class="reveal rounded-2xl border border-white/10 bg-panel p-6"><h3 class="font-display font-bold text-brand">Database</h3><div class="mt-4 flex flex-wrap gap-2"><span class="skill-chip">MySQL</span></div></article>
                    <article class="reveal rounded-2xl border border-white/10 bg-panel p-6"><h3 class="font-display font-bold text-brand">Tools</h3><div class="mt-4 flex flex-wrap gap-2"><span class="skill-chip">Git</span><span class="skill-chip">GitHub</span><span class="skill-chip">VS Code</span><span class="skill-chip">Figma</span></div></article>
                </div>
            </div>
        </section>

        <section class="work-section mx-auto max-w-7xl px-5 py-20 sm:py-28 lg:px-8" id="projects">
            <div class="reveal flex flex-col justify-between gap-5 md:flex-row md:items-end">
                <div><p class="mb-3 text-xs font-bold tracking-[.2em] text-brand">PROJECTS</p><h2 class="font-display text-3xl font-bold tracking-tight sm:text-5xl">Proyek yang membuat<br><span class="text-slate-500">ide jadi nyata.</span></h2></div>
                <p class="max-w-md text-slate-400">Beberapa proyek web dan aplikasi yang ditampilkan dalam portofolio.</p>
            </div>
            <div class="mt-10 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($projects as $project)
                    <article class="project-card reveal overflow-hidden rounded-3xl border border-white/10 bg-panel transition duration-300 hover:-translate-y-1 hover:border-brand/40 hover:shadow-xl">
                        @if ($project['image'] !== '')
                            <img class="project-image" src="{{ asset($project['image']) }}" alt="{{ $project['image_alt'] }}" loading="lazy">
                        @else
                            <div class="project-image-placeholder grid aspect-video w-full place-content-center text-center font-display text-2xl font-bold" role="img" aria-label="Belum ada gambar untuk {{ $project['title'] }}">{{ $project['title'] }}</div>
                        @endif
                        <div class="p-6">
                            <p class="text-xs font-bold tracking-widest text-brand">{{ $project['category'] }}</p>
                            <h3 class="mt-2 font-display text-xl font-bold">{{ $project['title'] }}</h3>
                            <p class="mt-3 min-h-16 text-sm text-slate-400">{{ $project['description'] }}</p>
                            @if ($project['technologies'] !== [])
                                <div class="mt-4 flex flex-wrap gap-2">
                                    @foreach ($project['technologies'] as $technology)
                                        <span class="skill-chip">{{ $technology }}</span>
                                    @endforeach
                                </div>
                            @endif
                            <div class="mt-6 flex gap-4 border-t border-white/10 pt-4 text-sm">
                                @if ($project['url'] !== '')
                                    <a class="inline-flex items-center gap-2 font-semibold text-brand transition hover:text-slate-100" href="{{ $project['url'] }}" target="_blank" rel="noopener noreferrer">Buka {{ $project['title'] }} <span aria-hidden="true">↗</span></a>
                                @else
                                    <span class="text-slate-500" aria-disabled="true">Live Demo belum tersedia</span>
                                    <span class="text-slate-500" aria-disabled="true">Repo belum tersedia</span>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <p class="text-slate-400">Belum ada proyek yang ditambahkan.</p>
                @endforelse
            </div>
        </section>

        <section class="border-y border-white/10 bg-panel/40" id="experience">
            <div class="mx-auto max-w-7xl px-5 py-20 sm:py-28 lg:px-8">
                <div class="reveal"><p class="mb-3 text-xs font-bold tracking-[.2em] text-brand">EXPERIENCE</p><h2 class="font-display text-3xl font-bold tracking-tight sm:text-5xl">Terus belajar dengan<br><span class="text-slate-500">membangun sesuatu.</span></h2></div>
                <div class="mt-10 max-w-3xl border-l-2 border-brand/40 pl-6 sm:pl-8">
                    <article class="timeline-entry reveal relative pb-10"><span class="absolute -left-[2.05rem] top-1 size-4 rounded-full border-4 border-ink bg-brand sm:-left-[2.55rem]"></span><p class="text-xs font-bold tracking-widest text-brand">SAAT INI</p><h3 class="mt-2 font-display text-xl font-bold">Mahasiswa Informatika — Semester 5</h3><p class="mt-1 text-slate-300">Universitas Teknokrat Indonesia</p><p class="mt-3 text-sm text-slate-400">Mempelajari pemrograman, basis data, rekayasa perangkat lunak, dan pengembangan aplikasi.</p></article>
                    <article class="timeline-entry reveal relative"><span class="absolute -left-[2.05rem] top-1 size-4 rounded-full border-4 border-ink bg-accent sm:-left-[2.55rem]"></span><p class="text-xs font-bold tracking-widest text-accent">PROYEK AKADEMIK & MANDIRI</p><h3 class="mt-2 font-display text-xl font-bold">Latihan pengembangan aplikasi</h3><p class="mt-1 text-slate-300">Pengalaman berbasis proyek</p><p class="mt-3 text-sm text-slate-400">Berlatih membangun aplikasi web dan mobile, mengintegrasikan API, dan merancang antarmuka melalui proyek yang ditampilkan di portofolio.</p></article>
                </div>
                <p class="mt-5 text-sm text-slate-500">Pengalaman organisasi dan magang belum dicantumkan.</p>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-5 py-20 sm:py-28 lg:px-8" id="certificates">
            <div class="reveal"><p class="mb-3 text-xs font-bold tracking-[.2em] text-brand">CERTIFICATES</p><h2 class="font-display text-3xl font-bold tracking-tight sm:text-5xl">Pelatihan &<br><span class="text-slate-500">penghargaan.</span></h2></div>
            @if ($certificates->isEmpty())
                <div class="reveal mt-8 rounded-2xl border border-dashed border-white/15 bg-panel/50 p-6 text-slate-400 sm:p-8">
                    <p class="font-semibold text-slate-200">Belum ada sertifikat atau penghargaan yang dicantumkan.</p>
                    <p class="mt-2 text-sm">Sertifikat yang ditambahkan melalui dashboard admin akan tampil di sini.</p>
                </div>
            @else
                <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($certificates as $certificate)
                        <article class="certificate-card reveal overflow-hidden rounded-3xl border border-white/10 bg-panel transition duration-300 hover:-translate-y-1 hover:border-brand/40 hover:shadow-xl">
                            @if ($certificate->image)
                                @if ($certificate->url)
                                    <a class="certificate-image-link" href="{{ $certificate->url }}" target="_blank" rel="noopener noreferrer" aria-label="Lihat sertifikat {{ $certificate->title }}">
                                @endif
                                <img class="certificate-image" src="{{ asset($certificate->image) }}" alt="Sertifikat {{ $certificate->title }}" loading="lazy">
                                @if ($certificate->url)
                                    </a>
                                @endif
                            @else
                                <div class="certificate-placeholder grid aspect-[16/10] place-items-center" aria-hidden="true">
                                    <span class="certificate-award-icon">✦</span>
                                </div>
                            @endif
                            <div class="p-6">
                                <p class="text-xs font-bold tracking-widest text-brand">{{ $certificate->year }} · SERTIFIKAT</p>
                                <h3 class="mt-2 font-display text-xl font-bold">{{ $certificate->title }}</h3>
                                <p class="mt-2 text-sm font-medium text-slate-300">{{ $certificate->issuer }}</p>
                                @if ($certificate->description)
                                    <p class="mt-3 text-sm text-slate-400">{{ $certificate->description }}</p>
                                @endif
                                @if ($certificate->url)
                                    <div class="mt-5 border-t border-white/10 pt-4">
                                        <a class="inline-flex items-center gap-2 text-sm font-semibold text-brand transition hover:text-slate-100" href="{{ $certificate->url }}" target="_blank" rel="noopener noreferrer">Lihat sertifikat <span aria-hidden="true">↗</span></a>
                                    </div>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>

    </main>

    <footer class="site-footer mx-auto grid max-w-7xl grid-cols-1 gap-6 px-5 py-8 text-sm text-slate-400 sm:grid-cols-2 lg:grid-cols-3 lg:px-8">
        <a class="font-display font-bold text-slate-100" href="#home">Ricky Kurniawan</span></a>
        <nav class="flex flex-wrap gap-x-5 gap-y-2" aria-label="Tautan cepat">
            <a class="hover:text-brand" href="#about">About</a><a class="hover:text-brand" href="{{ route('contact') }}">Contact</a>
            <a class="hover:text-brand" href="https://github.com/Zcanqua" target="_blank" rel="noopener noreferrer">GitHub</a>
            <a class="hover:text-brand" href="https://www.linkedin.com/in/ricky-kurniawan-510969289" target="_blank" rel="noopener noreferrer">LinkedIn</a>
        </nav>
        <p class="sm:col-span-2 lg:col-span-1 lg:text-right">© <span id="year"></span> RICKY KURNIAWAN. ALL RIGHTS RESERVED.</p>
    </footer>
</body>
</html>
