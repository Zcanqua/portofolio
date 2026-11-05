import './bootstrap';

const loaderStartedAt = performance.now();
let loaderDismissed = false;

const dismissPageLoader = () => {
    if (loaderDismissed) return;
    loaderDismissed = true;

    const minimumDisplayTime = 650;
    const elapsed = performance.now() - loaderStartedAt;
    window.setTimeout(() => {
        document.body.classList.add('page-loaded');
        document.querySelector('#loader-wrapper')?.setAttribute('aria-hidden', 'true');
        window.setTimeout(() => {
            document.querySelector('.hero-title')?.classList.add('glitch-name');
        }, 1050);
    }, Math.max(0, minimumDisplayTime - elapsed));
};

if (document.readyState === 'complete') {
    dismissPageLoader();
} else {
    window.addEventListener('load', dismissPageLoader, { once: true });
    window.setTimeout(dismissPageLoader, 8000);
}

document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.querySelector('#hamburger');
    const nav = document.querySelector('#primary-navigation');
    const themeToggle = document.querySelector('#theme-toggle');
    const navLinks = document.querySelectorAll('.nav-link');
    const year = document.querySelector('#year');
    const themeMeta = document.querySelector('meta[name="theme-color"]');
    const profilePhotoForm = document.querySelector('#profile-photo-form');
    const profileImageInput = document.querySelector('#profile-image');
    const cropper = document.querySelector('#profile-cropper');
    const cropCanvas = document.querySelector('#profile-crop-canvas');
    const zoomControl = document.querySelector('#profile-zoom');
    const cropError = document.querySelector('#profile-crop-error');
    const savePhotoButton = document.querySelector('#save-profile-photo');

    if (profilePhotoForm && profileImageInput && cropper && cropCanvas && zoomControl && cropError && savePhotoButton) {
        const context = cropCanvas.getContext('2d');
        let selectedImage = null;
        let imageUrl = null;
        let zoom = 1;
        let offsetX = 0;
        let offsetY = 0;
        let dragStart = null;

        const cropScale = () => Math.max(
            cropCanvas.width / selectedImage.naturalWidth,
            cropCanvas.height / selectedImage.naturalHeight,
        ) * zoom;

        const constrainOffset = () => {
            const scale = cropScale();
            const horizontalLimit = Math.max(0, (selectedImage.naturalWidth * scale - cropCanvas.width) / 2);
            const verticalLimit = Math.max(0, (selectedImage.naturalHeight * scale - cropCanvas.height) / 2);
            offsetX = Math.max(-horizontalLimit, Math.min(horizontalLimit, offsetX));
            offsetY = Math.max(-verticalLimit, Math.min(verticalLimit, offsetY));
        };

        const drawCrop = () => {
            if (!context || !selectedImage) return;

            const scale = cropScale();
            const width = selectedImage.naturalWidth * scale;
            const height = selectedImage.naturalHeight * scale;
            context.clearRect(0, 0, cropCanvas.width, cropCanvas.height);
            context.save();
            context.beginPath();
            context.arc(cropCanvas.width / 2, cropCanvas.height / 2, cropCanvas.width / 2, 0, Math.PI * 2);
            context.clip();
            context.drawImage(
                selectedImage,
                (cropCanvas.width - width) / 2 + offsetX,
                (cropCanvas.height - height) / 2 + offsetY,
                width,
                height,
            );
            context.restore();
        };

        profileImageInput.addEventListener('change', () => {
            const file = profileImageInput.files?.[0];
            if (!file) return;

            selectedImage = null;
            savePhotoButton.disabled = true;
            savePhotoButton.textContent = 'Memuat foto...';
            if (imageUrl) URL.revokeObjectURL(imageUrl);
            imageUrl = URL.createObjectURL(file);
            selectedImage = new Image();
            selectedImage.onload = () => {
                zoom = 1;
                offsetX = 0;
                offsetY = 0;
                zoomControl.value = '1';
                cropper.classList.remove('hidden');
                cropError.classList.add('hidden');
                savePhotoButton.disabled = false;
                savePhotoButton.textContent = 'Simpan foto profil ↗';
                drawCrop();
            };
            selectedImage.onerror = () => {
                selectedImage = null;
                cropError.textContent = 'Foto tidak dapat dibuka. Silakan pilih file gambar lain.';
                cropError.classList.remove('hidden');
                cropper.classList.add('hidden');
                savePhotoButton.disabled = false;
                savePhotoButton.textContent = 'Simpan foto profil ↗';
            };
            selectedImage.src = imageUrl;
        });

        zoomControl.addEventListener('input', () => {
            zoom = Number(zoomControl.value);
            constrainOffset();
            drawCrop();
        });

        cropCanvas.addEventListener('pointerdown', (event) => {
            if (!selectedImage) return;
            cropCanvas.setPointerCapture(event.pointerId);
            dragStart = { x: event.clientX, y: event.clientY, offsetX, offsetY };
        });

        cropCanvas.addEventListener('pointermove', (event) => {
            if (!dragStart) return;
            const bounds = cropCanvas.getBoundingClientRect();
            offsetX = dragStart.offsetX + (event.clientX - dragStart.x) * cropCanvas.width / bounds.width;
            offsetY = dragStart.offsetY + (event.clientY - dragStart.y) * cropCanvas.height / bounds.height;
            constrainOffset();
            drawCrop();
        });

        const stopDragging = () => { dragStart = null; };
        cropCanvas.addEventListener('pointerup', stopDragging);
        cropCanvas.addEventListener('pointercancel', stopDragging);

        profilePhotoForm.addEventListener('submit', async (event) => {
            if (!selectedImage) return;

            event.preventDefault();
            savePhotoButton.disabled = true;
            savePhotoButton.textContent = 'Menyiapkan foto...';

            try {
                const blob = await new Promise((resolve, reject) => {
                    cropCanvas.toBlob((result) => {
                        if (result) resolve(result);
                        else reject(new Error('Gagal memproses crop foto.'));
                    }, 'image/jpeg', 0.92);
                });
                const transfer = new DataTransfer();
                transfer.items.add(new File([blob], 'profile-photo.jpg', { type: 'image/jpeg' }));
                profileImageInput.files = transfer.files;
                HTMLFormElement.prototype.submit.call(profilePhotoForm);
            } catch {
                cropError.textContent = 'Foto gagal diproses. Coba pilih file gambar lain.';
                cropError.classList.remove('hidden');
                savePhotoButton.disabled = false;
                savePhotoButton.textContent = 'Simpan foto profil ↗';
            }
        });
    }

    if (year) year.textContent = String(new Date().getFullYear());

    const syncThemeToggle = () => {
        const isLight = document.documentElement.dataset.theme === 'light';
        const nextThemeLabel = isLight ? 'Ganti ke mode gelap' : 'Ganti ke mode terang';
        themeToggle?.setAttribute('aria-label', nextThemeLabel);
        themeToggle?.setAttribute('title', nextThemeLabel);
        themeMeta?.setAttribute('content', isLight ? '#f3f2f6' : '#1b1b23');
    };

    syncThemeToggle();
    themeToggle?.addEventListener('click', () => {
        const nextTheme = document.documentElement.dataset.theme === 'light' ? 'dark' : 'light';
        document.documentElement.dataset.theme = nextTheme;
        localStorage.setItem('portfolio-theme', nextTheme);
        syncThemeToggle();
    });

    const setMenuOpen = (open) => {
        toggle?.setAttribute('aria-expanded', String(open));
        toggle?.setAttribute('aria-label', open ? 'Tutup navigasi' : 'Buka navigasi');
        nav?.classList.toggle('hidden', !open);
    };

    toggle?.addEventListener('click', () => {
        setMenuOpen(toggle.getAttribute('aria-expanded') !== 'true');
    });

    navLinks.forEach((link) => {
        link.addEventListener('click', () => setMenuOpen(false));
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') setMenuOpen(false);
    });

    const revealItems = document.querySelectorAll('.reveal');
    revealItems.forEach((item) => {
        const siblings = [...item.parentElement.children].filter((sibling) => sibling.classList.contains('reveal'));
        item.style.setProperty('--reveal-delay', `${Math.min(siblings.indexOf(item) * 90, 270)}ms`);
    });

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -35px 0px' });

        revealItems.forEach((item) => observer.observe(item));
    } else {
        revealItems.forEach((item) => item.classList.add('is-visible'));
    }

    const contactForm = document.querySelector('#contact-form');
    const formStatus = document.querySelector('#form-status');
    contactForm?.addEventListener('submit', (event) => {
        event.preventDefault();
        if (contactForm.reportValidity() && formStatus) {
            formStatus.textContent = 'Validasi berhasil. Pengiriman pesan akan tersedia pada milestone API.';
        }
    });
});
