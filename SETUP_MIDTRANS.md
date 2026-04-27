# Setup Midtrans untuk Testing

## Step 1: Daftar di Midtrans Sandbox

1. Buka https://dashboard.sandbox.midtrans.com
2. Register akun baru dengan email Anda
3. Verifikasi email
4. Login ke dashboard

## Step 2: Ambil API Keys

1. Di dashboard, pergi ke **Settings → API Keys**
2. Copy **Server Key** dan **Client Key** (Sandbox)
3. Jangan gunakan Production key di mode development!

## Step 3: Set di .env File

Buka `c:\laragon\www\Toko-Kue-Kharisma\.env` dan tambahkan:

```
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_SERVER_KEY=Your_Sandbox_Server_Key_Here
MIDTRANS_CLIENT_KEY=Your_Sandbox_Client_Key_Here
```

**Contoh:**
```
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxxxxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxxxxxx
```

## Step 4: Clear Cache Laravel

```bash
cd c:\laragon\www\Toko-Kue-Kharisma
php artisan config:cache
php artisan cache:clear
```

## Step 5: Test di Browser

1. Refresh halaman (Ctrl+Shift+R)
2. Login ke toko
3. Tambah produk ke keranjang
4. Klik "Bayar dengan QRIS"
5. Snap modal seharusnya muncul ✅

## Troubleshooting

Jika masih error, cek:
- [ ] API Keys sudah benar (tidak ada spasi)
- [ ] Mode Sandbox dipilih (is_production=false)
- [ ] Cache Laravel sudah di-clear
- [ ] Koneksi internet aktif
- [ ] Laragon Apache dan MySQL running

## Dokumentasi Midtrans

- Sandbox Dashboard: https://dashboard.sandbox.midtrans.com
- API Docs: https://docs.midtrans.com
- Testing Cards: https://docs.midtrans.com/docs/sandbox-test-payment
