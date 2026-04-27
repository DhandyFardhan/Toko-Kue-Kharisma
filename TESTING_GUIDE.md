# 🧪 Testing Guide - Toko Kue Kharisma

Panduan lengkap untuk menjalankan test suite dan uji level aplikasi.

---

## 📋 Daftar Isi

1. [Persiapan](#persiapan)
2. [Menjalankan Tests](#menjalankan-tests)
3. [Test Coverage](#test-coverage)
4. [Interpretasi Hasil](#interpretasi-hasil)
5. [Debugging Tips](#debugging-tips)

---

## 🚀 Persiapan

### 1. Install Dependencies

```bash
cd c:\laragon\www\Toko-Kue-Kharisma
composer install
```

### 2. Setup Database Testing

Database testing akan dibuat otomatis menggunakan SQLite in-memory. Tidak perlu konfigurasi khusus!

### 3. Setup Environment

Pastikan `.env` sudah ada dan valid:

```bash
php artisan tinker
```

---

## 🏃 Menjalankan Tests

### ✅ Run Semua Tests

```bash
php artisan test
```

**Output yang diharapkan:**
```
Tests:  25 passed
Time:   3.25s
```

### ✅ Run Tests Spesifik

#### Test Checkout Flow
```bash
php artisan test tests/Feature/CheckoutFlowTest.php
```

**Tests yang dijalankan:**
- ✓ User bisa checkout dengan COD
- ✓ User tidak bisa checkout tanpa alamat
- ✓ Keranjang tidak boleh kosong
- ✓ Total calculation benar
- ✓ Order items created correctly
- ✓ Cart cleared after checkout
- ✓ Invalid payment method rejected
- ✓ Notes saved correctly
- ✓ Order number unique
- ✓ Unauthenticated user cannot checkout

#### Test Midtrans Payment
```bash
php artisan test tests/Feature/MidtransPaymentTest.php
```

**Tests yang dijalankan:**
- ✓ QRIS checkout requires valid Midtrans keys
- ✓ Order created before token generation
- ✓ Midtrans fields saved correctly
- ✓ Item details format valid
- ✓ Transaction status mappings

#### Test Order Models
```bash
php artisan test tests/Unit/OrderModelTest.php
```

**Tests yang dijalankan:**
- ✓ Order has order items relationship
- ✓ Order belongs to user
- ✓ Order totals calculated correctly
- ✓ Order status validation
- ✓ Order number is unique
- ✓ Order items have relationships
- ✓ Order item subtotal calculation
- ✓ Order can have multiple items

---

## 📊 Test Coverage

### Feature Tests (CheckoutFlowTest.php)

| No | Test | Tipe | Status |
|----|------|------|--------|
| 1 | COD Checkout | Integration | ✅ |
| 2 | No Address | Validation | ✅ |
| 3 | Empty Cart | Validation | ✅ |
| 4 | Total Calculation | Business Logic | ✅ |
| 5 | Order Items Creation | Database | ✅ |
| 6 | Cart Cleared | State | ✅ |
| 7 | Invalid Payment | Validation | ✅ |
| 8 | Save Notes | Data Persistence | ✅ |
| 9 | Unique Order Number | Uniqueness | ✅ |
| 10 | Authentication | Security | ✅ |

### Midtrans Integration Tests (MidtransPaymentTest.php)

| No | Test | Tipe | Status |
|----|------|------|--------|
| 1 | Midtrans Keys Check | Configuration | ✅ |
| 2 | Order Creation | Pre-processing | ✅ |
| 3 | Fields Saved | Data Persistence | ✅ |
| 4 | Item Details Format | API Contract | ✅ |
| 5 | Status Mappings | Business Logic | ✅ |

### Unit Tests (OrderModelTest.php)

| No | Test | Model | Status |
|----|------|-------|--------|
| 1 | Relationships | Order | ✅ |
| 2 | User Relationship | Order | ✅ |
| 3 | Totals | Order | ✅ |
| 4 | Status Validation | Order | ✅ |
| 5 | Unique Number | Order | ✅ |
| 6 | Item Relationships | OrderItem | ✅ |
| 7 | Product Relationship | OrderItem | ✅ |
| 8 | Subtotal | OrderItem | ✅ |
| 9 | Multiple Items | Order | ✅ |

**Total Test Coverage: 25 tests**

---

## 📈 Interpretasi Hasil

### ✅ Test PASSED

Berarti fitur tersebut berfungsi sesuai dengan ekspektasi.

**Contoh output:**
```
✓ test_user_can_checkout_with_cod 0.25s
```

### ❌ Test FAILED

Berarti ada bug atau error pada kode.

**Contoh output:**
```
✗ test_user_can_checkout_with_cod
Expected: 200, Received: 500
```

Cara troubleshoot:
1. Baca error message dengan teliti
2. Cek stack trace
3. Buka file test untuk memahami ekspektasinya
4. Debug kode yang di-test

---

## 🔧 Debugging Tips

### 1. Lihat Detail Error

```bash
php artisan test --verbose
```

### 2. Test Spesifik Method

```bash
php artisan test --filter=test_user_can_checkout_with_cod
```

### 3. Stop Pada First Failure

```bash
php artisan test --stop-on-failure
```

### 4. Debug Output

Tambahkan di test:

```php
dump($response->json());
dd($order);
```

### 5. Check Database State

```bash
php artisan test --database=testing
php artisan tinker
Order::all();
```

---

## 🎯 Test Execution Example

### Scenario: Testing Checkout Flow Lengkap

```bash
# 1. Jalankan test checkout
php artisan test tests/Feature/CheckoutFlowTest.php

# 2. Jika ada error, lihat detail
php artisan test tests/Feature/CheckoutFlowTest.php --verbose

# 3. Test method spesifik
php artisan test --filter=test_order_total_calculation_is_correct

# 4. Check hasil
# Output: PASSED (jika sudah fix) atau FAILED (masih ada masalah)
```

---

## ✨ Next Steps

Setelah semua test PASSED:

1. ✅ Setup Midtrans credentials di `.env`
2. ✅ Test manual di browser
3. ✅ Run feature test untuk validate everything
4. ✅ Deploy ke production

---

## 📚 Resources

- [Laravel Testing Docs](https://laravel.com/docs/testing)
- [PHPUnit Documentation](https://phpunit.de/)
- [Midtrans Testing Guide](https://docs.midtrans.com/docs/sandbox-test-payment)

---

## 🆘 Troubleshooting

### Error: "SQLSTATE[HY000]"

**Solusi:**
```bash
php artisan migrate:fresh
php artisan config:cache
```

### Error: "Class not found"

**Solusi:**
```bash
composer dump-autoload
php artisan test
```

### Test Timeout

**Solusi:**
```bash
php artisan test --timeout=60
```

---

**Happy Testing! 🚀**
