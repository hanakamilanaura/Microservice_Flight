# Microservice_Flight

Proyek ini adalah sistem microservice berbasis Laravel yang terdiri dari beberapa service utama, saling terhubung menggunakan API (REST/GraphQL) dan dijalankan menggunakan Docker. Setiap service dapat **provide** (menyediakan) dan **consume** (mengakses) data ke/dari service lain, termasuk ke service eksternal di folder `kel-lain`.

## Daftar Service Laravel

- **user-service**  
  Mengelola data user (registrasi, login, dsb).

- **flight-service**  
  Mengelola data penerbangan (jadwal, maskapai, dsb).  
  Provide data penerbangan ke service lain, dan consume data user/booking jika diperlukan.

- **booking-service**  
  Mengelola pemesanan tiket.  
  Consume data penerbangan dan user, serta provide data booking ke service lain.

- **customer-support-service**  
  Mengelola komplain dan support pelanggan.  
  Consume data booking/user, dan provide notifikasi/response ke service lain.

- **kel-lain**  
  Service eksternal (bisa third-party atau service lain di luar ekosistem utama) yang dapat diakses oleh service lain melalui API.

## Teknologi yang Digunakan

- **Laravel** (PHP) untuk masing-masing service
- **GraphQL** untuk komunikasi data (lihat folder `graphql/` di tiap service)
- **Docker** untuk containerisasi dan orkestrasi service
- **REST API** (opsional, jika ada endpoint REST)
- **MySQL** sebagai database utama (bisa diatur di `.env` masing-masing service)

## Cara Menjalankan Project

1. **Clone repository ini**
2. **Copy file `.env copy` menjadi `.env`** di setiap service, lalu sesuaikan konfigurasi database dan key.
3. **Jalankan Docker**  
   ```bash
   docker-compose up -d
   ```
4. **Install dependency di masing-masing service**  
   Masuk ke folder service, lalu:
   ```bash
   composer install
   ```
5. **Migrasi database**  
   Di masing-masing service:
   ```bash
   php artisan migrate
   ```
6. **Jalankan service Laravel**  
   Di masing-masing service:
   ```bash
   php artisan serve --port=xxxx
   ```
   (Ganti `xxxx` dengan port yang diinginkan, misal 8001, 8002, dst.)

7. **Akses GraphQL Playground**  
   Biasanya di endpoint `/graphql` atau `/api/graphql` pada masing-masing service.

## Contoh Skema Interaksi

- **booking-service** akan melakukan request ke **flight-service** untuk mendapatkan data penerbangan saat user melakukan booking.
- **customer-support-service** akan mengakses **booking-service** untuk mendapatkan detail booking saat ada komplain.
- Semua service bisa saling mengkonsumsi data dari **kel-lain** jika dibutuhkan (misal, untuk validasi eksternal).

## Struktur Folder

- `user-service/`
- `flight-service/`
- `booking-service/`
- `customer-support-service/`
- `kel-lain/`
- `flight-book-frontend/` (Frontend, jika ada)

## Catatan

- Pastikan semua service sudah berjalan sebelum melakukan testing integrasi.
- Untuk pengaturan lebih lanjut, cek file `.env` di masing-masing service.
- Dokumentasi endpoint GraphQL bisa dilihat di folder `graphql/schema/` dan `graphql/resolvers/` pada tiap service.