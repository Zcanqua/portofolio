<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1b1b23">
    <title>Kelola Proyek — Admin Ricky Kurniawan</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-dashboard min-h-screen bg-ink font-sans text-slate-100 antialiased">
    <header class="admin-header sticky top-0 z-30 border-b border-white/10 backdrop-blur-xl">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-5 py-4 lg:px-8">
            <div>
                <a class="flex items-center gap-3" href="{{ route('admin.projects.index') }}">
                    <span class="admin-brand-mark grid size-11 place-items-center rounded-2xl font-display text-sm font-bold">RK</span>
                    <span><span class="block text-[.65rem] font-bold tracking-[.22em] text-brand">RUANG KREATOR</span><span class="mt-0.5 block font-display text-lg font-bold">Portfolio studio</span></span>
                </a>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button class="admin-logout rounded-xl border border-white/15 px-4 py-2.5 text-sm font-semibold transition" type="submit"><span aria-hidden="true">↗</span> Keluar</button>
            </form>
        </div>
    </header>

    <main class="admin-main mx-auto max-w-7xl px-5 py-10 lg:px-8">
        <section class="admin-welcome mb-8 overflow-hidden rounded-[2rem] border border-white/10 p-7 sm:p-10">
            <div class="relative z-10 flex flex-col justify-between gap-8 md:flex-row md:items-end">
                <div>
                    <p class="inline-flex items-center gap-2 rounded-full border border-emerald-300/20 bg-emerald-300/10 px-3 py-1.5 text-xs font-bold tracking-widest text-emerald-200"><span class="size-2 rounded-full bg-emerald-300"></span> DASHBOARD ADMIN</p>
                    <h1 class="mt-5 max-w-2xl font-display text-3xl font-bold leading-tight sm:text-5xl">Karya bagus dimulai<br><span class="admin-welcome-accent">dari sini.</span></h1>
                    <p class="mt-4 max-w-xl text-sm leading-6 text-slate-400 sm:text-base">Atur identitas visual dan proyek yang tampil di portofolio publikmu.</p>
                </div>
                <div class="admin-overview-grid grid grid-cols-2 gap-3 sm:min-w-64">
                    <div class="admin-overview-item rounded-2xl border border-white/10 p-4"><span class="text-xs text-slate-400">Proyek aktif</span><strong class="mt-1 block font-display text-2xl">{{ count($projects) }}</strong></div>
                    <div class="admin-overview-item rounded-2xl border border-white/10 p-4"><span class="text-xs text-slate-400">Status studio</span><strong class="mt-1 block text-sm text-emerald-300">● Online</strong></div>
                </div>
            </div>
        </section>

        @if (session('status'))
            <p class="mb-6 rounded-xl border border-emerald-400/30 bg-emerald-400/10 p-4 text-sm text-emerald-200" role="status">{{ session('status') }}</p>
        @endif

        @if (session('error'))
            <p class="mb-6 rounded-xl border border-rose-400/30 bg-rose-400/10 p-4 text-sm text-rose-200" role="alert">{{ session('error') }}</p>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-rose-400/30 bg-rose-400/10 p-4 text-sm text-rose-200" role="alert">
                <p class="font-bold">Periksa kembali data proyek:</p>
                <ul class="mt-2 list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="admin-panel mb-8 rounded-3xl border border-white/10 bg-panel p-6 sm:p-8">
            <div class="admin-section-heading">
                <span class="admin-section-icon" aria-hidden="true">01</span>
                <div><p class="text-xs font-bold tracking-[.18em] text-brand">IDENTITAS VISUAL</p><h2 class="mt-1 font-display text-xl font-bold">Foto profil</h2></div>
            </div>
            <div class="mt-6 grid items-center gap-8 lg:grid-cols-[220px_1fr]">
                <div class="grid justify-items-center gap-3">
                    <img class="admin-profile-preview size-48 rounded-full border border-white/10 bg-ink object-cover object-[center_35%] shadow-2xl" src="{{ asset($profileImage) }}" alt="Foto profil saat ini" id="current-profile-preview">
                    <span class="text-xs text-slate-400">Tampilan potong bulat</span>
                </div>
                <form class="grid gap-4" action="{{ route('admin.profile.photo') }}" method="POST" enctype="multipart/form-data" id="profile-photo-form">
                    @csrf
                    <div>
                        <label class="mb-2 block text-sm font-semibold" for="profile-image">Pilih foto baru</label>
                        <input class="admin-field file:mr-3 file:rounded-lg file:border-0 file:bg-brand file:px-3 file:py-2 file:font-bold file:text-ink" id="profile-image" name="profile_image" type="file" accept=".jpg,.jpeg,.png,.webp" required>
                        <p class="mt-2 text-xs text-slate-400">JPG, PNG, atau WebP · Maks. 5 MB</p>
                    </label>
                    </div>
                    <div class="profile-cropper hidden" id="profile-cropper">
                        <div class="flex flex-col items-center gap-5 sm:flex-row">
                            <canvas class="profile-crop-canvas" id="profile-crop-canvas" width="360" height="360" aria-label="Pratinjau crop foto profil yang bisa digeser"></canvas>
                            <div class="grid w-full gap-3">
                                <label class="text-sm font-semibold" for="profile-zoom">Perbesar / perkecil</label>
                                <input class="w-full accent-emerald-300" id="profile-zoom" type="range" min="1" max="3" step="0.01" value="1">
                                <p class="text-xs leading-5 text-slate-400">Geser foto di dalam lingkaran untuk mengatur posisinya. Gunakan slider untuk zoom.</p>
                                <p class="hidden text-sm text-rose-300" id="profile-crop-error" role="alert"></p>
                            </div>
                        </div>
                    </div>
                    <button class="admin-primary-button w-fit rounded-xl px-5 py-3 font-bold transition hover:-translate-y-0.5" id="save-profile-photo" type="submit">Simpan foto profil <span aria-hidden="true">↗</span></button>
                </form>
            </div>
        </section>

        <section class="admin-panel rounded-3xl border border-white/10 bg-panel p-6 sm:p-8">
            <div class="admin-section-heading">
                <span class="admin-section-icon" aria-hidden="true">02</span>
                <div><p class="text-xs font-bold tracking-[.18em] text-brand">KATALOG</p><h2 class="mt-1 font-display text-xl font-bold">Tambah proyek</h2></div>
            </div>
            <form class="mt-6 grid gap-5 md:grid-cols-2" action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label class="grid gap-2 text-sm font-medium" for="new-title">Nama proyek
                    <input class="admin-field" id="new-title" name="title" value="{{ old('title') }}" maxlength="120" required>
                </label>
                <label class="grid gap-2 text-sm font-medium" for="new-category">Status / kategori
                    <input class="admin-field" id="new-category" name="category" value="{{ old('category') }}" maxlength="80" placeholder="Contoh: ON PROGRESS" required>
                </label>
                <label class="grid gap-2 text-sm font-medium md:col-span-2" for="new-description">Deskripsi
                    <textarea class="admin-field" id="new-description" name="description" rows="3" maxlength="1500" required>{{ old('description') }}</textarea>
                </label>
                <label class="grid gap-2 text-sm font-medium" for="new-url">Tautan proyek (opsional)
                    <input class="admin-field" id="new-url" name="url" type="url" value="{{ old('url') }}" maxlength="2048" placeholder="https://...">
                </label>
                <label class="grid gap-2 text-sm font-medium" for="new-technologies">Teknologi (pisahkan dengan koma)
                    <input class="admin-field" id="new-technologies" name="technologies" value="{{ old('technologies') }}" maxlength="500" placeholder="Laravel, PHP, MySQL">
                </label>
                <label class="grid gap-2 text-sm font-medium" for="new-image-alt">Deskripsi foto untuk aksesibilitas
                    <input class="admin-field" id="new-image-alt" name="image_alt" value="{{ old('image_alt') }}" maxlength="180" required>
                </label>
                <label class="grid gap-2 text-sm font-medium" for="new-image">Foto proyek (JPG, PNG, atau WebP, maks. 5 MB)
                    <input class="admin-field file:mr-3 file:rounded-lg file:border-0 file:bg-brand file:px-3 file:py-2 file:font-bold file:text-ink" id="new-image" name="image" type="file" accept=".jpg,.jpeg,.png,.webp" required>
                </label>
                <button class="w-fit rounded-xl bg-brand px-5 py-3 font-bold text-ink transition hover:-translate-y-0.5 hover:bg-white md:col-span-2" type="submit">Tambah proyek</button>
            </form>
        </section>

        <section class="mt-12">
            <div class="mb-6 flex items-end justify-between gap-4">
                <div>
                    <p class="text-xs font-bold tracking-[.2em] text-brand">03 / PORTOFOLIO</p>
                    <h2 class="mt-1 font-display text-2xl font-bold">Proyek saat ini</h2>
                </div>
                <span class="text-sm text-slate-400">{{ count($projects) }} proyek</span>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                @forelse ($projects as $project)
                    <article class="rounded-3xl border border-white/10 bg-panel p-5 sm:p-7">
                        @if ($project['image'] !== '')
                            <img class="mb-5 max-h-72 w-full rounded-2xl bg-white object-contain" src="{{ asset($project['image']) }}" alt="{{ $project['image_alt'] }}" loading="lazy">
                        @endif
                        <form class="grid gap-4 sm:grid-cols-2" action="{{ route('admin.projects.update', $project['id']) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <label class="grid gap-2 text-sm font-medium" for="title-{{ $project['id'] }}">Nama proyek
                                <input class="admin-field" id="title-{{ $project['id'] }}" name="title" value="{{ $project['title'] }}" maxlength="120" required>
                            </label>
                            <label class="grid gap-2 text-sm font-medium" for="category-{{ $project['id'] }}">Status / kategori
                                <input class="admin-field" id="category-{{ $project['id'] }}" name="category" value="{{ $project['category'] }}" maxlength="80" required>
                            </label>
                            <label class="grid gap-2 text-sm font-medium sm:col-span-2" for="description-{{ $project['id'] }}">Deskripsi
                                <textarea class="admin-field" id="description-{{ $project['id'] }}" name="description" rows="3" maxlength="1500" required>{{ $project['description'] }}</textarea>
                            </label>
                            <label class="grid gap-2 text-sm font-medium" for="url-{{ $project['id'] }}">Tautan proyek (opsional)
                                <input class="admin-field" id="url-{{ $project['id'] }}" name="url" type="url" value="{{ $project['url'] }}" maxlength="2048" placeholder="https://...">
                            </label>
                            <label class="grid gap-2 text-sm font-medium" for="technologies-{{ $project['id'] }}">Teknologi (pisahkan dengan koma)
                                <input class="admin-field" id="technologies-{{ $project['id'] }}" name="technologies" value="{{ implode(', ', $project['technologies']) }}" maxlength="500">
                            </label>
                            <label class="grid gap-2 text-sm font-medium sm:col-span-2" for="image-alt-{{ $project['id'] }}">Deskripsi foto
                                <input class="admin-field" id="image-alt-{{ $project['id'] }}" name="image_alt" value="{{ $project['image_alt'] }}" maxlength="180" required>
                            </label>
                            <label class="grid gap-2 text-sm font-medium sm:col-span-2" for="image-{{ $project['id'] }}">Ganti foto (opsional, maks. 5 MB)
                                <input class="admin-field file:mr-3 file:rounded-lg file:border-0 file:bg-brand file:px-3 file:py-2 file:font-bold file:text-ink" id="image-{{ $project['id'] }}" name="image" type="file" accept=".jpg,.jpeg,.png,.webp">
                            </label>
                            <button class="w-fit rounded-xl bg-brand px-4 py-2.5 font-bold text-ink transition hover:bg-white" type="submit">Simpan perubahan</button>
                        </form>
                        <form class="mt-3 border-t border-white/10 pt-3" action="{{ route('admin.projects.destroy', $project['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="rounded-lg px-3 py-2 text-sm font-semibold text-rose-300 transition hover:bg-rose-400/10" type="submit">Hapus proyek</button>
                        </form>
                    </article>
                @empty
                    <p class="rounded-2xl border border-dashed border-white/15 p-8 text-slate-400">Belum ada proyek. Gunakan formulir di atas untuk menambahkan proyek.</p>
                @endforelse
            </div>
        </section>

        <section class="admin-panel mt-12 rounded-3xl border border-white/10 bg-panel p-6 sm:p-8">
            <div class="admin-section-heading">
                <span class="admin-section-icon" aria-hidden="true">04</span>
                <div><p class="text-xs font-bold tracking-[.18em] text-brand">PENCAPAIAN</p><h2 class="mt-1 font-display text-xl font-bold">Sertifikat & penghargaan</h2></div>
            </div>
            <p class="mt-3 max-w-2xl text-sm text-slate-400">Tambahkan pelatihan, sertifikat, atau penghargaan. Sertifikat yang disimpan akan langsung tampil pada bagian Certificates di halaman portofolio.</p>

            <form class="mt-6 grid gap-5 rounded-2xl border border-white/10 bg-black/10 p-5 md:grid-cols-2" action="{{ route('admin.certificates.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label class="grid gap-2 text-sm font-medium" for="new-certificate-title">Nama sertifikat
                    <input class="admin-field" id="new-certificate-title" name="title" value="{{ old('title') }}" maxlength="160" placeholder="Contoh: Web Development Fundamentals" required>
                </label>
                <label class="grid gap-2 text-sm font-medium" for="new-certificate-issuer">Penerbit
                    <input class="admin-field" id="new-certificate-issuer" name="issuer" value="{{ old('issuer') }}" maxlength="120" placeholder="Contoh: Dicoding" required>
                </label>
                <label class="grid gap-2 text-sm font-medium" for="new-certificate-year">Tahun
                    <input class="admin-field" id="new-certificate-year" name="year" type="number" min="1900" max="{{ now()->year + 10 }}" value="{{ old('year', now()->year) }}" required>
                </label>
                <label class="grid gap-2 text-sm font-medium" for="new-certificate-url">Tautan verifikasi (opsional)
                    <input class="admin-field" id="new-certificate-url" name="url" type="url" value="{{ old('url') }}" maxlength="2048" placeholder="https://...">
                </label>
                <label class="grid gap-2 text-sm font-medium md:col-span-2" for="new-certificate-description">Keterangan (opsional)
                    <textarea class="admin-field" id="new-certificate-description" name="description" rows="2" maxlength="1000" placeholder="Ringkasan materi atau pencapaian">{{ old('description') }}</textarea>
                </label>
                <label class="grid gap-2 text-sm font-medium md:col-span-2" for="new-certificate-image">Gambar sertifikat (opsional, JPG/PNG/WebP maks. 5 MB)
                    <input class="admin-field file:mr-3 file:rounded-lg file:border-0 file:bg-brand file:px-3 file:py-2 file:font-bold file:text-ink" id="new-certificate-image" name="image" type="file" accept=".jpg,.jpeg,.png,.webp">
                </label>
                <button class="admin-primary-button w-fit rounded-xl px-5 py-3 font-bold transition hover:-translate-y-0.5 md:col-span-2" type="submit">Tambah sertifikat <span aria-hidden="true">↗</span></button>
            </form>

            <div class="mt-8 grid gap-5 lg:grid-cols-2">
                @forelse ($certificates as $certificate)
                    <article class="admin-certificate-card rounded-2xl border border-white/10 p-5">
                        <div class="mb-5 flex items-center gap-4">
                            @if ($certificate->image)
                                <img class="size-20 rounded-xl bg-white object-cover" src="{{ asset($certificate->image) }}" alt="Pratinjau {{ $certificate->title }}" loading="lazy">
                            @else
                                <span class="admin-certificate-placeholder grid size-20 place-items-center rounded-xl text-2xl" aria-hidden="true">✦</span>
                            @endif
                            <div><p class="text-xs font-bold tracking-widest text-brand">{{ $certificate->year }} · SERTIFIKAT</p><h3 class="mt-1 font-display font-bold">{{ $certificate->title }}</h3><p class="mt-1 text-sm text-slate-400">{{ $certificate->issuer }}</p></div>
                        </div>
                        <form class="grid gap-4 sm:grid-cols-2" action="{{ route('admin.certificates.update', $certificate->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <label class="grid gap-2 text-sm font-medium" for="certificate-title-{{ $certificate->id }}">Nama
                                <input class="admin-field" id="certificate-title-{{ $certificate->id }}" name="title" value="{{ $certificate->title }}" maxlength="160" required>
                            </label>
                            <label class="grid gap-2 text-sm font-medium" for="certificate-issuer-{{ $certificate->id }}">Penerbit
                                <input class="admin-field" id="certificate-issuer-{{ $certificate->id }}" name="issuer" value="{{ $certificate->issuer }}" maxlength="120" required>
                            </label>
                            <label class="grid gap-2 text-sm font-medium" for="certificate-year-{{ $certificate->id }}">Tahun
                                <input class="admin-field" id="certificate-year-{{ $certificate->id }}" name="year" type="number" min="1900" max="{{ now()->year + 10 }}" value="{{ $certificate->year }}" required>
                            </label>
                            <label class="grid gap-2 text-sm font-medium" for="certificate-url-{{ $certificate->id }}">Tautan verifikasi
                                <input class="admin-field" id="certificate-url-{{ $certificate->id }}" name="url" type="url" value="{{ $certificate->url }}" maxlength="2048" placeholder="https://...">
                            </label>
                            <label class="grid gap-2 text-sm font-medium sm:col-span-2" for="certificate-description-{{ $certificate->id }}">Keterangan
                                <textarea class="admin-field" id="certificate-description-{{ $certificate->id }}" name="description" rows="2" maxlength="1000">{{ $certificate->description }}</textarea>
                            </label>
                            <label class="grid gap-2 text-sm font-medium sm:col-span-2" for="certificate-image-{{ $certificate->id }}">Ganti gambar (opsional, maks. 5 MB)
                                <input class="admin-field file:mr-3 file:rounded-lg file:border-0 file:bg-brand file:px-3 file:py-2 file:font-bold file:text-ink" id="certificate-image-{{ $certificate->id }}" name="image" type="file" accept=".jpg,.jpeg,.png,.webp">
                            </label>
                            <button class="admin-primary-button w-fit rounded-xl px-4 py-2.5 font-bold transition hover:bg-white" type="submit">Simpan perubahan</button>
                        </form>
                        <form class="mt-3 border-t border-white/10 pt-3" action="{{ route('admin.certificates.destroy', $certificate->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="rounded-lg px-3 py-2 text-sm font-semibold text-rose-300 transition hover:bg-rose-400/10" type="submit">Hapus sertifikat</button>
                        </form>
                    </article>
                @empty
                    <p class="rounded-2xl border border-dashed border-white/15 p-6 text-sm text-slate-400">Belum ada sertifikat. Tambahkan sertifikat pertama melalui formulir di atas.</p>
                @endforelse
            </div>
        </section>
    </main>
</body>
</html>
