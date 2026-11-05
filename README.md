## Sedikit tutor dariku :D

1. Pasang dependensi PHP dan JavaScript:

   ```sh
   composer install
   npm install
   ```

2. Salin `.env.example` menjadi `.env`, lalu buat application key:

   ```sh
   php artisan key:generate
   ```

3. Secara default aplikasi menggunakan SQLite. Buat file database kosong dan jalankan migrasi:

   ```sh
   php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
   php artisan migrate
   ```

4. Sebelum membuat akun administrator dan password kalian bisa membuat file .env dengan cara
   ```sh
   echo "PORT=3000" >> .env
   ```

Untuk membuat akun administrator, atur `ADMIN_USERNAME` dan `ADMIN_PASSWORD` di `.env`, lalu jalankan:

   ```sh
   php artisan db:seed
   ```

   Tambahkan proyek dan sertifikat melalui dashboard admin setelah masuk.

5. Jalankan aset frontend dan server:

   ```sh
   npm run build
   php artisan serve
   ```

Jangan commit `.env`, database lokal, log, sesi, maupun file cache. Gunakan `.env.example` sebagai template konfigurasi; sesuaikan `APP_URL` hanya untuk lingkungan deployment.


# JANGAN LUPA NYALAIN LOCALHOST KALIAN YA :D
