# Microservice_Flight

## 📁 Folder Structure

```
.
├── user-service/                # Service User (Laravel)
├── flight-service/              # Service Penerbangan (Laravel)
├── booking-service/             # Service Booking (Laravel)
├── customer-support-service/    # Service Customer Support (Laravel)
├── kel-lain/                    # Service eksternal ( complaint)
├── flight-book-frontend/        # Frontend (React/Vite)
├── docker-compose.yml           # Docker Compose file
├── README.md                    # Dokumentasi ini
```

---

## ⚙️ Installation

### 1. Clone Repository
```bash
git clone <repo-url>
cd Microservice_Flight
```

### 2. Copy & Edit .env
Untuk setiap service Laravel:
```bash
cp .env copy .env
# Edit konfigurasi DB & APP_KEY jika perlu
```

### 3. Install Dependency
Untuk setiap service Laravel:
```bash
composer install
```

### 4. Jalankan Docker
```bash
docker-compose up -d
```

### 5. Migrasi Database
Untuk setiap service Laravel:
```bash
php artisan migrate
```

---

## 📄 API Documentation (Postman)

- Import file Postman collection (jika ada) ke Postman.
- Endpoint utama tiap service:
  - **User Service:** `http://localhost:8001/graphql`
  - **Flight Service:** `http://localhost:8002/graphql`
  - **Booking Service:** `http://localhost:8003/graphql`
  - **Customer Support Service:** `http://localhost:8004/graphql`
  - **Kel-lain:** (lihat dokumentasi di folder kel-lain)

**Contoh Query GraphQL:**
```graphql
query {
  getAllFlights {
    id
    name
    departure
    arrival
  }
}
```

---

## 🛠️ Daftar Layanan (Backend Services)

| Service                    | Deskripsi                                      | Port   |
|----------------------------|------------------------------------------------|--------|
| user-service               | Manajemen user (register, login, dsb)          | 8001   |
| flight-service             | Manajemen data penerbangan                     | 8002   |
| booking-service            | Manajemen pemesanan tiket                      | 8003   |
| customer-support-service   | Komplain & support pelanggan, consume kel-lain | 8004   |
| kel-lain                   | Service eksternal (notifikasi complaint)       | -      |

---

## 🚀 Teknologi yang Digunakan

- **Laravel** (PHP) - Backend utama tiap service
- **GraphQL** - API utama antar service
- **Docker & Docker Compose** - Orkestrasi container
- **MySQL** - Database
- **Postman** - Dokumentasi & testing API
- **React + Vite** - Frontend (flight-book-frontend)

---

## ▶️ Langkah Menjalankan Aplikasi

1. **Pastikan Docker & Composer sudah terinstall**
2. **Jalankan Docker Compose**
   ```bash
   docker-compose up -d
   ```
3. **Masuk ke masing-masing folder service, install dependency & migrate**
   ```bash
   composer install
   php artisan migrate
   ```
4. **Jalankan service Laravel (jika tidak pakai Docker)**
   ```bash
   php artisan serve --port=800X
   ```
5. **Akses GraphQL Playground**
   - `http://localhost:8001/graphql` (User)
   - `http://localhost:8002/graphql` (Flight)
   - dst.

---

---

> **Catatan:**  
> - Pastikan semua service sudah berjalan sebelum melakukan integrasi.
> - Untuk detail endpoint, cek folder `graphql/schema/` dan `graphql/resolvers/` di masing-masing service.