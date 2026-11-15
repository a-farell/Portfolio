# Portofolio CV Pribadi

Website CV/portofolio dengan **CodeIgniter 4**, PHP 8.4, dan MySQL. Data profil, pendidikan, pengalaman, keahlian, pencapaian, proyek, dan tautan sosial dibaca dari tabel database yang saling berelasi; view tidak menyimpan isi CV secara hardcoded.

## Persyaratan

- PHP 8.4 dengan ekstensi `intl`, `mbstring`, dan `mysqli`
- Composer
- MySQL atau MariaDB

## Menjalankan secara lokal

1. Buat database MySQL, misalnya `uts_portfolio`.
2. Salin file konfigurasi contoh dan isi pengaturan koneksi:

   ```powershell
   Copy-Item env .env
   ```

   Atur setidaknya `app.baseURL` dan `database.default.*` di `.env`, misalnya:

   ```ini
   CI_ENVIRONMENT = development
   app.baseURL = 'http://localhost:8080/'
   database.default.hostname = localhost
   database.default.database = uts_portfolio
   database.default.username = root
   database.default.password =
   database.default.DBDriver = MySQLi
   database.default.port = 3306
   ```

3. Pasang dependensi, buat tabel, dan masukkan data contoh:

   ```sh
   composer install
   php spark migrate --all
   php spark db:seed PortfolioSeeder
   ```

4. Jalankan server pengembangan:

   ```sh
   php spark serve
   ```

   Buka `http://localhost:8080`.

Seed berisi **data contoh**. Ganti dengan data pribadi sebelum dipublikasikan. Konten selanjutnya dapat dikelola melalui phpMyAdmin atau alat database lainnya.

## Panel admin

Setelah menjalankan migrasi **atau mengimpor dump SQL**, buat akun admin pertama melalui terminal lokal:

```sh
php spark admin:create
```

Perintah akan meminta email dan kata sandi admin. Tidak ada akun bawaan atau pendaftaran publik. Masuk melalui `/admin/login`; setelah masuk, panel dapat mengelola profil dan semua data portofolio. Foto profil, gambar proyek, dan sertifikat dapat diunggah langsung (maksimal 5 MB per file). File tersimpan di `public/assets/uploads/`.

## Impor melalui phpMyAdmin

File [database/uts_portfolio.sql](database/uts_portfolio.sql) berisi struktur tabel dan data contoh, tanpa kredensial koneksi dan tanpa perintah membuat database.

1. Buat database MySQL kosong bernama `uts_portfolio` (atau nama lain) dengan collation `utf8mb4_unicode_ci`.
2. Pilih database tersebut di phpMyAdmin, buka tab **Import**, pilih `database/uts_portfolio.sql`, lalu klik **Import**.
3. Isi pengaturan koneksi di `.env` agar sesuai dengan nama database dan user MySQL yang dibuat.

Dump ini berisi `DROP TABLE IF EXISTS`; impor hanya ke database kosong atau database yang memang siap ditimpa.

## Struktur data

- `profiles`: informasi utama dan kontak.
- `education`, `experiences`, `skills`, `achievements`, `projects`, `social_links`: data CV turunan yang terhubung ke `profiles` melalui `profile_id`.
- `admin_users`: akun admin dengan kata sandi yang disimpan dalam bentuk hash.

Setiap entri turunan memiliki `sort_order` agar urutannya dapat diatur tanpa mengubah view.

Untuk menampilkan gambar proyek, simpan gambar di `public/assets/images/projects/`, lalu isi kolom `projects.image_url` dengan path seperti `assets/images/projects/website.jpg`. Untuk tautan sertifikat di bagian Milestones, isi `achievements.certificate_url` dengan URL sertifikat atau path file yang disimpan di folder `public/`.

## Deploy ke hosting

1. Pastikan hosting menyediakan PHP 8.4, ekstensi `mysqli`, dan MySQL/MariaDB.
2. Buat database dan user melalui cPanel, lalu beri user tersebut hak akses ke database.
3. Pilih salah satu cara menyiapkan tabel:
   - Impor `database/uts_portfolio.sql` melalui phpMyAdmin seperti petunjuk di atas; atau
   - Buat `.env` terlebih dahulu, lalu jalankan migrasi dan seeder dari terminal hosting:

     ```sh
     php spark migrate --all
     php spark db:seed PortfolioSeeder
     ```

4. Deploy kode dan dependensi Composer (`composer install --no-dev --optimize-autoloader`). Jangan unggah `.env` lokal ke repositori atau hosting.
5. Salin `env` menjadi `.env`, lalu isi konfigurasi produksi. Contoh:

   ```ini
   CI_ENVIRONMENT = production
   app.baseURL = 'https://subdomain.domainanda.com/'
   database.default.hostname = localhost
   database.default.database = username_uts_portfolio
   database.default.username = username_dbuser
   database.default.password = ganti_dengan_password_database
   database.default.DBDriver = MySQLi
   database.default.port = 3306
   database.default.charset = utf8mb4
   database.default.DBCollat = utf8mb4_unicode_ci
   ```

   Ganti nama database, user, password, hostname, dan URL dengan nilai yang ditampilkan cPanel. Pada banyak hosting, nama database dan user memiliki prefiks akun cPanel.
6. Arahkan document root subdomain ke folder `public/`, bukan root proyek. Pastikan folder `writable/` dapat ditulis oleh PHP.

File `.env` dibaca oleh konfigurasi CodeIgniter di `app/Config/Database.php`; gunakan kredensial yang sama dengan database yang dibuat atau dipilih di phpMyAdmin.

## Fitur

- Layout responsif dengan bagian tentang, pendidikan, pengalaman, keahlian, proyek, pencapaian, dan kontak.
- Tombol **Unduh CV** membuka dialog cetak browser sehingga dapat disimpan sebagai PDF.
- Semua teks dan tautan personal berasal dari database.
