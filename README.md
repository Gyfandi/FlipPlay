# 🎬 FlipPlay

**FlipPlay** adalah REST API berbasis Laravel untuk mengelola data media hiburan, meliputi Anime, Manga, dan Light Novel.

Project ini dikembangkan sebagai implementasi pemrograman berorientasi objek (OOP), REST API, validasi data, serta relasi database menggunakan Laravel Eloquent ORM.

## ✨ Fitur

- **CRUD Media:** Menambahkan, menampilkan, memperbarui, dan menghapus data media.
- **Multi-jenis Media:** Mendukung Anime, Manga, dan Light Novel.
- **Relasi Database:** Setiap media memiliki detail sesuai jenisnya.
- **Validasi Request:** Memastikan data yang diterima sesuai aturan.
- **Database Transaction:** Menjaga konsistensi data ketika melakukan operasi penyimpanan dan pembaruan.
- **Cascade Delete:** Menghapus detail terkait secara otomatis ketika data media dihapus.

## 🛠️ Teknologi

- PHP
- Laravel
- MySQL
- Laravel Eloquent ORM
- REST API
- Postman

## 🗄️ Struktur Database

Project ini menggunakan empat tabel utama untuk pengelolaan media dan satu tabel pivot.

| Tabel | Fungsi |
|---|---|
| `media` | Menyimpan informasi utama media |
| `anime_details` | Menyimpan jumlah episode Anime |
| `manga_details` | Menyimpan jumlah volume Manga |
| `light_novel_details` | Menyimpan jumlah chapter Light Novel |
| `media_user` | Tabel pivot relasi Media dan User |

### Relasi

- `Media` memiliki relasi One-to-One (`HasOne`) dengan `AnimeDetail`.
- `Media` memiliki relasi One-to-One (`HasOne`) dengan `MangaDetail`.
- `Media` memiliki relasi One-to-One (`HasOne`) dengan `LightNovelDetail`.
- Tabel detail memiliki relasi `BelongsTo` terhadap `Media`.
- `Media` memiliki relasi Many-to-Many (`BelongsToMany`) dengan `User` melalui tabel pivot `media_user`.

## 🚀 Instalasi dan Menjalankan Project

### 1. Clone Repository

```bash
git clone https://github.com/Gyfandi/FlipPlay.git
```

### 2. Masuk ke Direktori Project

```bash
cd FlipPlay
```

### 3. Install Dependencies

```bash
composer install
```

### 4. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`.

```bash
cp .env.example .env
```

Untuk Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Konfigurasi Database

Buat database MySQL dengan nama:

```text
flipplay_db
```

Sesuaikan konfigurasi database pada file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=flipplay_db
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan username dan password dengan konfigurasi MySQL lokal.

### 7. Jalankan Migration

```bash
php artisan migrate
```

### 8. Jalankan Laravel

```bash
php artisan serve
```

API dapat diakses melalui:

```text
http://127.0.0.1:8000/api
```

## 📡 Dokumentasi Endpoint API

Base URL:

```text
http://127.0.0.1:8000/api
```

| Method | Endpoint | Fungsi |
|---|---|---|
| GET | `/media` | Mengambil seluruh data media |
| POST | `/media` | Menambahkan media baru |
| GET | `/media/{id}` | Mengambil detail media berdasarkan ID |
| PUT/PATCH | `/media/{id}` | Memperbarui data media |
| DELETE | `/media/{id}` | Menghapus data media |

### Contoh Request

#### 1. Menambahkan Anime

**POST** `/media`

```json
{
    "title": "Demon Slayer",
    "type": "anime",
    "release_year": 2019,
    "anime_detail": {
        "episodes": 26
    }
}
```

#### 2. Menambahkan Manga

**POST** `/media`

```json
{
    "title": "Naruto",
    "type": "manga",
    "release_year": 1999,
    "manga_detail": {
        "volumes": 72
    }
}
```

#### 3. Menambahkan Light Novel

**POST** `/media`

```json
{
    "title": "Re:Zero",
    "type": "light_novel",
    "release_year": 2014,
    "light_novel_detail": {
        "chapters": 100
    }
}
```

#### 4. Memperbarui Data

**PUT** `/media/{id}`

Contoh memperbarui data Anime:

```json
{
    "title": "Demon Slayer Updated",
    "type": "anime",
    "release_year": 2019,
    "anime_detail": {
        "episodes": 30
    }
}
```

#### 5. Menghapus Data

**DELETE** `/media/{id}`

Menghapus data media berdasarkan ID. Detail yang terhubung akan ikut terhapus melalui mekanisme cascade delete.

## 📋 HTTP Response Status

| Status Code | Keterangan |
|---|---|
| 200 OK | Request berhasil |
| 201 Created | Data berhasil dibuat |
| 404 Not Found | Data tidak ditemukan |
| 422 Unprocessable Entity | Validasi request gagal |

Untuk pengujian endpoint, gunakan Postman dengan header:

```text
Accept: application/json
Content-Type: application/json
```

## 🧪 Pengujian

Pengujian API dilakukan menggunakan Postman, mencakup:

- Pengambilan seluruh data media.
- Penambahan Anime, Manga, dan Light Novel.
- Pengambilan detail media berdasarkan ID.
- Pembaruan data dan perubahan jenis media.
- Penghapusan media dan pemeriksaan cascade delete.
- Pengujian validasi terhadap request yang tidak sesuai.

## 📂 Struktur Project

```text
FlipPlay/
├── app/
│   ├── Http/
│   │   ├── Controllers/Api/
│   │   │   └── MediaController.php
│   │   ├── Requests/
│   │   │   ├── StoreMediaRequest.php
│   │   │   └── UpdateMediaRequest.php
│   │   └── Resources/
│   │       └── MediaResource.php
│   └── Models/
│       ├── Media.php
│       ├── AnimeDetail.php
│       ├── MangaDetail.php
│       ├── LightNovelDetail.php
│       └── User.php
├── database/
│   └── migrations/
├── routes/
│   └── api.php
├── .env.example
├── composer.json
└── README.md
```

## 👨‍💻 Repository

GitHub: https://github.com/Gyfandi/FlipPlay

---

**FlipPlay**  
*Laravel REST API Project*
