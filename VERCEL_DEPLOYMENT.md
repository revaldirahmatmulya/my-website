# Panduan Deploy Laravel ke Vercel

Repository ini telah dikonfigurasi dan dioptimasi secara penuh agar **siap dideploy ke Vercel (*Ready to Deploy*)**.

---

## 🚀 Langkah Cepat Deploy ke Vercel

### 1. Push Perubahan ke GitHub
Pastikan seluruh file konfigurasi terbaru sudah di-commit dan di-push ke repository GitHub Anda:
```bash
git add .
git commit -m "chore: setup Vercel serverless deployment"
git push origin main
```

---

### 2. Import Project di Vercel Dashboard
1. Buka [vercel.com](https://vercel.com) dan login dengan akun GitHub Anda.
2. Klik tombol **"Add New..."** lalu pilih **"Project"**.
3. Cari repository `revaldirahmatmulya/my-website` dan klik **"Import"**.

---

### 3. Konfigurasi Project di Vercel
Pada halaman import:
- **Framework Preset**: Biarkan **Other** (karena ditangani oleh `vercel.json`).
- **Root Directory**: `./` (default).
- **Build and Output Settings**: Otomatis dibaca dari `vercel.json` (`npm run build` dan `public`).

---

### 4. Tambahkan Environment Variables (Wajib & Rekomendasi)
Buka bagian **Environment Variables** di Vercel dan tambahkan variabel berikut:

| Nama Variabel | Contoh Nilai | Keterangan |
|---|---|---|
| `APP_NAME` | `Revaldi Portfolio` | Nama aplikasi |
| `APP_ENV` | `production` | Mode production |
| `APP_KEY` | `base64:1crb4ggKg/KjO6AMe/3SND69UXCKe/0HaE0v4Qg5dEc=` | Kunci enkripsi Laravel (salin dari `.env` lokal Anda) |
| `APP_DEBUG` | `false` | Matikan debug untuk keamanan |
| `APP_URL` | `https://nama-project-anda.vercel.app` | Domain Vercel Anda |
| `ARTISAN_KEY` | `rahasia-migrasi-2026` *(buat kata sandi acak)* | Kunci rahasia untuk memicu migrasi via browser |
| `ADMIN_EMAIL` | `admin@example.com` | Email login admin portofolio |
| `ADMIN_PASSWORD` | `password_anda_disini` | Password login admin portofolio |
| `PORTFOLIO_NAME` | `Revaldi Rahmat Mulya` | Nama yang tampil di landing page |

---

### 5. Klik "Deploy"
Vercel akan secara otomatis:
1. Menjalankan `npm install` dan `npm run build` untuk mengompilasi file Tailwind CSS & Vite.
2. Mengunduh dependensi PHP dengan runtime `vercel-php@0.9.0`.
3. Men-deploy aplikasi Anda ke jaringan global Vercel Edge.

---

## 🗄️ Manajemen Database

### Opsi A: Default SQLite (Instan & Tanpa Setup Eksternal)
- Jika Anda tidak mengisi variabel database eksternal, aplikasi akan otomatis menggunakan SQLite di `/tmp/database.sqlite`.
- Pada *cold start*, aplikasi otomatis memuat data proyek bawaan sehingga website langsung tampil indah tanpa error database.

### Opsi B: MongoDB Atlas (NoSQL Cloud - Sangat Disarankan)
Runtime `vercel-php@0.9.0` telah menyertakan ekstensi PHP `mongodb` secara bawaan. Anda dapat langsung menghubungkan cluster MongoDB Atlas gratis (*M0 Free Tier*):

Tambahkan variabel berikut di Vercel Dashboard (**Settings > Environment Variables**):
```env
DB_CONNECTION=mongodb
MONGODB_URI="mongodb+srv://<username>:<password>@cluster0.xxxxx.mongodb.net/?retryWrites=true&w=majority"
MONGODB_DATABASE=portfolio
```

Untuk menguji koneksi MongoDB Atlas langsung dari Vercel melalui browser:
```
https://nama-project-anda.vercel.app/artisan/mongodb-test?key=NILAI_ARTISAN_KEY_ANDA
```

### Opsi C: Relational Cloud Database (PostgreSQL / MySQL)
Jika menggunakan PostgreSQL atau MySQL eksternal (Supabase, Neon.tech, Aiven):
```env
DB_CONNECTION=pgsql
DB_HOST=aws-0-ap-southeast-1.pooler.supabase.com
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres.xxxx
DB_PASSWORD=password_db_anda
```

---

## ⚡ Menjalankan Migrasi di Vercel (Artisan Runner)

Karena Vercel tidak menyediakan terminal SSH, kami telah menyediakan route aman untuk menjalankan perintah Artisan langsung dari browser dengan proteksi parameter `?key=`:

- **Jalankan Migrasi:**
  ```
  https://nama-project-anda.vercel.app/artisan/migrate?key=NILAI_ARTISAN_KEY_ANDA
  ```
- **Jalankan Seeder (Admin & Project Default):**
  ```
  https://nama-project-anda.vercel.app/artisan/db-seed?key=NILAI_ARTISAN_KEY_ANDA
  ```
- **Cek Status Migrasi:**
  ```
  https://nama-project-anda.vercel.app/artisan/migrate-status?key=NILAI_ARTISAN_KEY_ANDA
  ```
- **Clear Cache:**
  ```
  https://nama-project-anda.vercel.app/artisan/optimize-clear?key=NILAI_ARTISAN_KEY_ANDA
  ```

> [!CAUTION]
> Endpoint `/artisan/*` **hanya** dapat diakses jika nilai query parameter `?key=` sama persis dengan variabel `ARTISAN_KEY` yang Anda tentukan di Vercel. Jangan bagikan `ARTISAN_KEY` kepada pihak luar.
