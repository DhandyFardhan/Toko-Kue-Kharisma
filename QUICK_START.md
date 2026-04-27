# ⚡ Quick Start Guide

Panduan cepat untuk fix error Midtrans dan testing aplikasi.

---

## 🔴 Problem: Undefined Array Key 10023

Error ini terjadi karena **Midtrans API Keys kosong** di `.env` file.

---

## ✅ Solusi (5 Langkah Mudah)

### Step 1️⃣: Daftar Midtrans

1. Buka: https://dashboard.sandbox.midtrans.com
2. Klik **SIGN UP**
3. Isi form dengan email & password Anda
4. Verifikasi email

**Expected:** Email verification sent ✓

---

### Step 2️⃣: Ambil API Keys

1. Login ke dashboard Midtrans
2. Di sidebar kiri, pilih **SETTINGS**
3. Pilih **API KEYS**
4. Di tab **SANDBOX**, copy:
   - **Server Key** (untuk backend)
   - **Client Key** (untuk frontend)

**Expected:** 2 keys sudah di-copy ✓

---

### Step 3️⃣: Setup `.env` File

1. Buka file: `c:\laragon\www\Toko-Kue-Kharisma\.env`
2. Cari bagian Midtrans:
   ```
   MIDTRANS_IS_PRODUCTION=false
   MIDTRANS_SERVER_KEY=
   MIDTRANS_CLIENT_KEY=
   ```
3. Paste keys yang di-copy:
   ```
   MIDTRANS_IS_PRODUCTION=false
   MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxxxxxx
   MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxxxxxx
   ```
4. **Save file** (Ctrl+S)

**Expected:** File tersimpan ✓

---

### Step 4️⃣: Clear Cache Laravel

Di terminal, jalankan:

```bash
cd c:\laragon\www\Toko-Kue-Kharisma
php artisan config:cache
php artisan cache:clear
php artisan migrate:fresh --seed
```

**Expected:** Output menunjukkan seed data created ✓

---

### Step 5️⃣: Test di Browser

1. **Refresh halaman** (Ctrl+Shift+R for hard refresh)
2. **Login** ke aplikasi
3. **Add produk** ke keranjang
4. **Go to checkout**
5. **Select "Bayar dengan QRIS"**
6. **Klik tombol "Bayar dengan QRIS"**

**Expected:** Snap modal Midtrans muncul (bukan error) ✅

---

## 🧪 Testing (Opsional tapi Recommended)

### Run Semua Tests

```bash
cd c:\laragon\www\Toko-Kue-Kharisma
php artisan test
```

**Expected Output:**
```
✓ CheckoutFlowTest ............ 10 tests passed
✓ MidtransPaymentTest ......... 5 tests passed
✓ OrderModelTest .............. 10 tests passed

Tests:  25 passed (xxx ms)
```

### Run Tests Specific

**Test Checkout:**
```bash
php artisan test tests/Feature/CheckoutFlowTest.php
```

**Test Midtrans:**
```bash
php artisan test tests/Feature/MidtransPaymentTest.php
```

**Test Models:**
```bash
php artisan test tests/Unit/OrderModelTest.php
```

---

## 📊 Dokumentasi Lengkap

Ada **3 dokumen** baru di project:

1. **SETUP_MIDTRANS.md** - Detail setup Midtrans
2. **TESTING_GUIDE.md** - Guide lengkap untuk testing
3. **PROJECT_AUDIT.md** - Audit report lengkap

Buka file-file ini untuk informasi lebih detail.

---

## 🆘 Troubleshooting

### Error: "Still getting undefined array key 10023"

**Checklist:**
- [ ] API keys sudah di-copy dengan benar (tidak ada space)
- [ ] `.env` file sudah di-save
- [ ] `php artisan config:cache` sudah di-run
- [ ] Halaman di-refresh (Ctrl+Shift+R)

**Solusi:**
```bash
# Clear everything
php artisan config:cache
php artisan cache:clear
php artisan route:cache
php artisan view:cache

# Restart Laravel dev server
# (Jika menggunakan php artisan serve)
Ctrl+C, kemudian jalankan lagi
```

### Error: "Snap Midtrans belum termuat"

**Penyebab:** JavaScript error  
**Solusi:**
```bash
# Check browser console (F12)
# Reload halaman
php artisan view:cache
```

### Tests tidak berjalan

**Penyebab:** Database testing issue  
**Solusi:**
```bash
php artisan migrate:fresh --env=testing
php artisan test
```

---

## ✨ Features yang Sudah Ready

- ✅ User login/register
- ✅ Browse products
- ✅ Add to cart
- ✅ Checkout (COD)
- ✅ Checkout (QRIS - setelah setup Midtrans)
- ✅ Order history
- ✅ Payment proof upload
- ✅ Admin dashboard (Filament)

---

## 🎯 Success Criteria

Setelah ikuti guide ini, Anda seharusnya:

- ✅ Tidak dapat error "Undefined array key 10023"
- ✅ Bisa membuka Snap modal untuk QRIS payment
- ✅ Semua 25 tests passing
- ✅ Aplikasi siap untuk development lebih lanjut

---

## 📞 Next Steps

1. **Test manual di browser** - verify semuanya berfungsi
2. **Run automated tests** - ensure no regressions
3. **Setup production** - ketika siap deploy
4. **Monitor payments** - check Midtrans dashboard

---

## 📚 Useful Commands

```bash
# Jalankan development server
php artisan serve

# Jalankan semua tests
php artisan test

# Check specific test
php artisan test --filter=test_name

# Reset database dan seed
php artisan migrate:fresh --seed

# Clear all caches
php artisan config:clear && php artisan cache:clear

# Check Laravel version
php artisan --version

# Run specific migration
php artisan migrate --path=/database/migrations/migration_file.php

# Create new migration
php artisan make:migration create_table_name

# Generate test data
php artisan tinker
>>> User::factory(10)->create();
```

---

**Happy testing! 🚀**
