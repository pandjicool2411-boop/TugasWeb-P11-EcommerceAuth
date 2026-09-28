# TugasWeb-P11-EcommerceAuth

Tugas Rutin 11 - E-Commerce Database + Secure Authentication (Laravel 10)

## Langkah Install
1. Clone repo ini
2. Jalankan `composer install`
3. Copy file `.env.example` menjadi `.env`
4. Buat database baru (misal `tugasweb_p11`), lalu sesuaikan `DB_DATABASE` di `.env`
5. Jalankan `php artisan key:generate`
6. Jalankan `npm install` lalu `npm run build`
7. Jalankan `php artisan migrate:fresh --seed`
8. Jalankan `php artisan serve`
9. Buka `http://127.0.0.1:8000`

## Bagian A - Database & Eloquent
- 7 tabel e-commerce: `categories`, `customers`, `products`, `addresses`, `orders`, `order_items`, `reviews` (lengkap dengan foreign key constraint)
- Seeder + factory: 54 produk realistis, 20 customer, order, dan 60 review
- Model dengan relationships (hasMany, belongsTo) dan scope `Product::available()`
- Dokumentasi 5 query Tinker ada di folder `docs/`

## Bagian B - Auth & Security
- Login, register, logout dengan Laravel Breeze
- Multi-role: `admin`, `editor`, `user` (kolom `role` di tabel `users`)
- Custom middleware `RoleMiddleware` (alias `role`)
- `PostPolicy` untuk otorisasi create, edit, dan delete
- Route protection dengan middleware `auth` dan `role`

## Akun Contoh
| Role | Email | Password |
|---|---|---|
| Admin | admin@example.com | password |
| Editor | editor@example.com | password |
| User | user@example.com | password |

## Hak Akses per Role
| Aksi | Admin | Editor | User |
|---|---|---|---|
| Lihat daftar post | Ya | Ya | Ya |
| Tambah post | Ya | Ya | Tidak (403) |
| Edit/hapus post | Semua post | Hanya milik sendiri | Tidak (403) |
| `/editor-area` | Ya | Ya | Tidak (403) |
| `/admin` | Ya | Tidak (403) | Tidak (403) |

## Struktur Folder Penting
- `database/migrations` - struktur 7 tabel e-commerce, tabel posts, dan kolom role
- `database/seeders/DatabaseSeeder.php` - data awal (akun, produk, order, review, post)
- `database/factories` - factory untuk data acak
- `app/Models` - model dan relationships
- `app/Http/Middleware/RoleMiddleware.php` - custom middleware role
- `app/Policies/PostPolicy.php` - aturan otorisasi post
- `app/Http/Controllers/PostController.php` - CRUD post dengan `authorizeResource`
- `routes/web.php` - route dan proteksinya
- `docs/` - screenshot query Tinker dan testing role