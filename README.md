# Laravel Skill Test – Post RESTful API

## Ringkasan untuk HR / Recruiter

Project ini adalah **Laravel Skill Test** untuk fitur CRUD Post dengan:

* Draft dan Scheduled Posts
* Autentikasi user (session & cookie)
* Hak akses: hanya author bisa update/delete
* Semua response berupa JSON
* Feature tests memastikan API berjalan sesuai requirement

**Yang bisa dinilai tanpa menjalankan Laravel:**

1. Struktur project (Laravel 12, folder `app/Http/Controllers`, `routes/`, `tests/Feature`)
2. Commit history dengan pesan jelas
3. Feature tests yang ada di `tests/Feature/PostTest.php`

> Jalankan `php artisan test` jika ingin mengecek semua test berjalan.

---

## 1. Tujuan Project

* RESTful API di Laravel
* Draft & Scheduled Posts
* Authentication & Authorization
* JSON responses
* Menulis feature tests

---

## 2. Persyaratan Sistem

* PHP 8.3
* Node.js v22
* Composer
* NPM / Yarn
* Database: SQLite (default) atau MySQL
* Laravel 12

---

## 3. Instalasi Project

1. **Clone repository**

```bash
git clone https://github.com/chandrakarim/laravel-skill-test.git
cd laravel-skill-test
```

2. **Install dependencies**

```bash
# PHP dependencies
composer install

# Node dependencies
npm install
```

3. **Copy file .env**

```bash
# Windows
copy .env.example .env

# Linux / Mac
cp .env.example .env
```

4. **Generate app key**

```bash
php artisan key:generate
```

5. **Migrasi dan seed database**

```bash
php artisan migrate --seed
```

---

## 4. Menjalankan Project

1. Jalankan server Laravel

```bash
php artisan serve
```

Buka browser: [http://127.0.0.1:8000](http://127.0.0.1:8000)

2. Compile frontend assets & hot-reload

```bash
npm run dev
```

Untuk build production:

```bash
npm run build
```

---

## 5. Fitur API

| Route       | Method | Keterangan                                                 |
| ----------- | ------ | ---------------------------------------------------------- |
| /posts      | GET    | List semua active posts, paginasi 20 per halaman           |
| /posts/{id} | GET    | Tampilkan single post jika aktif, 404 jika draft/scheduled |
| /posts      | POST   | Buat post baru (hanya user login)                          |
| /posts/{id} | PUT    | Update post (hanya author)                                 |
| /posts/{id} | DELETE | Hapus post (hanya author)                                  |

> Routes create dan edit hanya return string (posts.create / posts.edit) sesuai soal.

---

## 6. Feature Tests

```bash
php artisan test
```

Semua tests Post API lulus:

* Index hanya menampilkan active posts
* Show return 404 jika draft/scheduled
* Authenticated user bisa create post
* Hanya author bisa update/delete post

---

## 7. Testing API dengan Postman (Opsional)

Project sudah menyediakan **Postman Collection** untuk menguji semua route CRUD Post.

### 7.1 Setup Environment di Postman

Buat Environment baru dengan variable:

| Variable     | Keterangan                                         |
| ------------ | -------------------------------------------------- |
| `base_url`   | Misal: `http://127.0.0.1:8000`                     |
| `xsrf_token` | Akan diisi otomatis saat request `Get CSRF Cookie` |
| `post_id`    | Akan diisi otomatis setelah create post            |

---

### 7.2 Import Collection

> Import file JSON:
>
> * `Laravel Skill Test API.postman_collection`
> * `Laravel Skill Test.postman_environment`

Collection ini berisi request:

* **Get CSRF Cookie** → untuk mendapatkan `XSRF-TOKEN`
* **Login** → login user, simpan cookie session
* **Get Active Posts** → `GET /posts`
* **Create Post** → `POST /posts`
* **Update Post** → `PUT /posts/{{post_id}}`
* **Delete Post** → `DELETE /posts/{{post_id}}`

---

### 7.3 Urutan Menggunakan Request

1. Jalankan Laravel server:

```bash
php artisan serve
```

> Pastikan `base_url` di environment Postman sesuai dengan alamat server.

2. Jalankan request di Postman sesuai urutan berikut:

| Urutan | Request          | Keterangan                       |
| ------ | ---------------- | -------------------------------- |
| 1      | Get CSRF Cookie  | Ambil token CSRF                 |
| 2      | Login            | Login user, dapat cookie session |
| 3      | Get Active Posts | Ambil semua post aktif           |
| 4      | Create Post      | Buat post baru                   |
| 5      | Update Post      | Update post terakhir dibuat      |
| 6      | Delete Post      | Hapus post terakhir dibuat       |

> Variabel `xsrf_token` dan `post_id` otomatis diatur via **pre-request & test scripts**.
> Login harus dijalankan sebelum create/update/delete karena menggunakan **session Laravel**.

---

### 7.4 Tips

* Jalankan urutan request sesuai tabel agar variable otomatis terisi.
* Anda bisa memodifikasi `Create Post` untuk membuat post draft atau scheduled untuk testing lebih lanjut.
* Semua request akan menampilkan response JSON sesuai spec API Laravel Skill Test.

---

## 8. Catatan Penting

* `.env` tidak di-push ke GitHub demi keamanan
* Folder `vendor/` dan `node_modules/` tidak di-push
* Database sudah di-seed sample User & Post sehingga bisa langsung dicoba

---

## 9. Kesimpulan

* Jalankan `php artisan serve` untuk server Laravel
* Jalankan `npm run dev` untuk compile & hot-reload frontend assets
* Semua route Post API siap diuji dengan Postman atau feature tests
* Bisa dinilai oleh HR/recruiter tanpa setup Laravel
* Developer reviewer bisa langsung menjalankan project dan semua tests sudah lulus

---

## 10. Author

Nama: Chandra Karim
Repository: [https://github.com/chandrakarim/laravel-skill-test](https://github.com/chandrakarim/laravel-skill-test)
