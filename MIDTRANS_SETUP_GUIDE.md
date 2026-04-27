# Panduan Konfigurasi Midtrans QRIS

## Daftar Masalah yang Sudah Diperbaiki

✅ **Snap Script Tidak Termuat** 
- Masalah: `window.snap` tidak terdefinisi
- Solusi: Ditambahkan script Midtrans ke `resources/views/cart.blade.php`

✅ **Error 401: Access Denied**
- Masalah: "Unauthorized transaction, please check client or server key"
- Solusi: Validasi Midtrans key di OrderController

✅ **Undefined Array Key**
- Masalah: Error saat membuat QRIS transaction
- Solusi: Ditambahkan error handling dan logging

## Langkah Setup Midtrans (Jika Belum Berhasil)

### 1. Daftar Akun Midtrans
- Buka https://dashboard.midtrans.com
- Daftar akun baru
- Verifikasi email

### 2. Dapatkan API Keys
- Login ke Midtrans Dashboard
- Pergi ke Settings > API Keys
- Copy:
  - **Server Key** (untuk backend)
  - **Client Key** (untuk frontend)

### 3. Update .env
Edit `.env` dan sesuaikan dengan keys Anda:

```env
MIDTRANS_SERVER_KEY=SB-Mid-server-XXXXXXXXXXXXXX
MIDTRANS_CLIENT_KEY=SB-Mid-client-XXXXXXXXXXXXXXXX
MIDTRANS_IS_PRODUCTION=false
```

**PENTING**: Gunakan Sandbox key (SB-) untuk testing, bukan Production key!

### 4. Cek Konfigurasi
Jalankan command di terminal Laravel:

```bash
php artisan tinker
>>> config('midtrans.server_key')
>>> config('midtrans.client_key')
>>> config('midtrans.is_production')
```

Pastikan semuanya sudah benar.

### 5. Test QRIS Payment

1. Buka `/menu` dan tambahkan produk ke keranjang
2. Pergi ke `/cart`
3. Klik "Checkout"
4. Pilih metode "QRIS"
5. Klik "Bayar Sekarang"
6. QR code akan muncul di popup

### 6. Testing Pembayaran Sandbox

**Untuk test pembayaran tanpa biaya:**

- Gunakan aplikasi pembayaran test (sandbox)
- Atau buka Midtrans Sandbox Dashboard untuk simulasi

## Troubleshooting

### Error: "Snap Midtrans belum termuat"
- **Penyebab**: Script Snap tidak termuat
- **Solusi**: Refresh halaman atau cek network tab di DevTools
- **Cek**: Chrome DevTools > Network > cari `snap.js`

### Error: "Access denied due to unauthorized transaction"
- **Penyebab**: API key tidak valid atau tidak sesuai
- **Solusi**: 
  1. Verify keys di Midtrans Dashboard
  2. Update .env dengan keys yang benar
  3. Pastikan `MIDTRANS_IS_PRODUCTION=false` untuk Sandbox

### Error: "Undefined array key 10023"
- **Penyebab**: Masalah internal Midtrans library
- **Solusi**:
  1. Pastikan library Midtrans terinstall: `composer require midtrans/midtrans-php`
  2. Jalankan `composer update`
  3. Clear cache: `php artisan cache:clear`

### QR Code Tidak Muncul
- Check browser console untuk error
- Pastikan ada internet connection
- Cek `.env` sudah valid

## File yang Dimodifikasi

- `resources/views/cart.blade.php` - Ditambahkan Snap script
- `app/Http/Controllers/OrderController.php` - Ditambahkan validasi & error handling
- `.env` - Pastikan Midtrans keys sudah diset

## Debugging Tips

1. **Enable Debug Mode** di `.env`:
   ```env
   APP_DEBUG=true
   ```

2. **Cek Error Log** di `storage/logs/laravel.log`

3. **Test dengan artisan tinker**:
   ```bash
   php artisan tinker
   >>> use App\Models\Order;
   >>> use Midtrans\Config as MidtransConfig;
   >>> use Midtrans\Snap;
   >>> MidtransConfig::$serverKey = config('midtrans.server_key');
   >>> // Test getSnapToken
   ```

4. **Chrome DevTools**:
   - Open DevTools (F12)
   - Console tab untuk JavaScript errors
   - Network tab untuk API calls

## Kontak Support

Jika masih ada error, cek:
- Midtrans Status: https://midtrans-id.statuspage.io
- GitHub Issue: https://github.com/verifone/midtrans-php/issues
