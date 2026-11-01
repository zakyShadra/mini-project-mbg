# PANTAU-MBG

Pelaporan dan Pemantauan Keamanan Makanan MBG - Mini Project Proyek 3, D3 Teknik Informatika.

- Nama: Zaky Shadra Ibnu Hibban
- NIM: 251511031
- Kelas: 2A - D3

## Kebutuhan Environment

- PHP ^8.3
- Composer
- Node.js & npm
- SQLite

## Langkah Instalasi

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

## Konfigurasi Database

Default menggunakan SQLite. Buat file databasenya:

```bash
touch database/database.sqlite
```

`.env` sudah default ke `DB_CONNECTION=sqlite`, tidak perlu diubah.

## Migration dan Seeding

```bash
php artisan migrate:fresh --seed
```

## Storage Link

Bukti laporan disimpan di disk `public`, perlu symlink:

```bash
php artisan storage:link
```

## Akun Demo

| Role | Username | Password |
|---|---|---|
| Reporter | zaky | zaky123 |
| Monitor | shadra | shadra123 |
| Koordinator | ice | ice123 |

## Menjalankan Aplikasi

```bash
npm run build
php artisan serve
```

Buka `http://localhost:8000`.
