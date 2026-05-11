<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profil - Toko Kue Kharisma</title>
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --bg-original: #f5deb3;
            --primary-brown: #8b7355;
            --text-dark: #2c2c2c;
            --white: #ffffff;
            --accent: #bc6c25;
            --shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg-original);
            color: var(--text-dark);
        }

        /* HEADER MODERN & HIDUP */
        header {
            background: linear-gradient(135deg, #d4b896 0%, #c9a882 100%);
            padding: 15px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .btn-back {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.4);
            padding: 8px 18px;
            border-radius: 50px;
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s ease;
            border: 1px solid rgba(255,255,255,0.5);
        }

        .btn-back:hover {
            background: var(--white);
            transform: translateX(-5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .btn-back svg { width: 18px; height: 18px; stroke-width: 3; }

        .store-logo {
            font-family: 'Brush Script MT', cursive;
            font-size: 30px;
            color: var(--text-dark);
        }

        /* CONTAINER */
        .profile-container {
            max-width: 1200px; margin: 40px auto; padding: 0 20px;
            display: grid; grid-template-columns: 320px 1fr; gap: 30px;
        }

        /* SIDEBAR */
        .profile-sidebar {
            background: linear-gradient(135deg, #d4b896 0%, #c9a882 100%);
            border-radius: 20px; padding: 30px; box-shadow: var(--shadow);
            height: fit-content; text-align: center;
        }

        .avatar-wrapper {
            position: relative; width: 120px; height: 120px; margin: 0 auto 20px;
        }
        
        .profile-avatar {
            width: 100%; height: 100%; border-radius: 50%;
            background: #444; overflow: hidden; border: 4px solid white;
            display: flex; align-items: center; justify-content: center;
        }

        .profile-avatar img { width: 100%; height: 100%; object-fit: cover; }
        
        .upload-hint {
            position: absolute; bottom: 0; right: 0;
            background: var(--primary-brown); color: white;
            width: 35px; height: 35px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; border: 2px solid white;
        }

        .profile-menu { list-style: none; margin-top: 25px; text-align: left; }
        
        .profile-menu a {
            display: flex; align-items: center; gap: 12px;
            padding: 14px 15px; background: rgba(255, 255, 255, 0.2);
            border-radius: 12px; text-decoration: none; color: var(--text-dark);
            font-weight: 600; margin-bottom: 10px; transition: 0.3s;
        }
        
        .profile-menu a.active, .profile-menu a:hover { 
            background: white; 
            transform: translateX(8px); 
        }

        /* CONTENT */
        .profile-content {
            background: white; border-radius: 25px; padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .content-section { display: none; animation: fadeIn 0.4s ease; }
        .content-section.active { display: block; }
        @keyframes fadeIn { from {opacity: 0; transform: translateY(10px);} to {opacity: 1; transform: translateY(0);} }

        .section-title {
            font-size: 26px; color: var(--primary-brown);
            margin-bottom: 30px; padding-bottom: 10px;
            border-bottom: 3px solid var(--bg-original);
        }

        /* FORMS */
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; }
        
        .form-control {
            width: 100%; padding: 12px 15px; border: 2px solid #f0f0f0;
            border-radius: 10px; transition: 0.3s;
        }
        
        .form-control:focus { border-color: var(--primary-brown); outline: none; background: #fffcf8; }

        .btn-save {
            background: var(--primary-brown); color: white;
            border: none; padding: 14px 35px; border-radius: 10px;
            cursor: pointer; font-weight: 700; transition: 0.3s;
            box-shadow: 0 4px 10px rgba(139, 115, 85, 0.3);
        }

        .btn-save:hover { background: var(--accent); transform: translateY(-2px); }

        #map { height: 350px; width: 100%; border-radius: 15px; border: 2px solid #f0f0f0; margin-top: 10px; }

        @media (max-width: 968px) {
            .profile-container { grid-template-columns: 1fr; }
            .form-row { grid-template-columns: 1fr; }
        }

        /* Styling Input Group agar Icon & Input Menyatu */
.input-group {
    display: flex;
    align-items: stretch;
    background: #f0f0f0;
    border-radius: 10px;
    overflow: hidden;
    border: 2px solid #f0f0f0;
    transition: 0.3s;
}

.input-group:focus-within {
    border-color: var(--primary-brown);
    background: #fffcf8;
}

.input-group-text {
    display: flex;
    align-items: center;
    padding: 0 15px;
    background: transparent;
    color: var(--primary-brown);
    font-size: 18px;
}

.input-group .form-control {
    border: none !important; /* Hilangkan border asli input */
    background: transparent !important;
}


    </style>
</head>
<body>

    <header>
        <div class="header-left">
            <a href="/" class="btn-back">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path></svg>
                Kembali
            </a>
        </div>
        <div class="store-logo">Toko Kue Kharisma</div>
        <div style="width: 100px;"></div>
    </header>

    <div class="profile-container">
        <aside class="profile-sidebar">
            <div class="avatar-wrapper">
                <div class="profile-avatar" id="avatarPreview">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name ?? 'Dandi Adrian') }}&background=8b7355&color=fff" alt="Avatar">
                </div>
                <label for="avatarInput" class="upload-hint">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                </label>
            </div>
            
            <h2 id="sideName" style="font-weight: 800;">{{ $user->name ?? 'Dandi Adrian' }}</h2>
            <p style="font-size: 13px; opacity: 0.8; margin-bottom: 20px;">Member Toko Kue Kharisma</p>

            <ul class="profile-menu">
                <li><a href="#info" onclick="showSection('info')" id="menu-info" class="active">Info Profil</a></li>
                <li><a href="#orders" onclick="showSection('orders')" id="menu-orders">Riwayat Pesanan</a></li>
                <li><a href="#address" onclick="showSection('address')" id="menu-address">Alamat Pengiriman</a></li>
                <li><a href="#settings" onclick="showSection('settings')" id="menu-settings">Keamanan</a></li>
            </ul>

            <form action="{{ route('logout') }}" method="POST" style="margin-top: 20px;">
                @csrf
                <button type="submit" style="width:100%; padding:12px; background:#d32f2f; color:white; border:none; border-radius:10px; cursor:pointer; font-weight:600;">Keluar Akun</button>
            </form>
        </aside>

        <main class="profile-content">
            <section id="info" class="content-section active">
                <h2 class="section-title">Informasi Lengkap Profil</h2>
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    
                    <input type="file" id="avatarInput" name="photo" style="display:none" accept="image/*">

                    <div class="form-group">
    <label>Nama Lengkap</label>
    <div class="input-group">
        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
        <input type="text" name="name" class="form-control" value="{{ $user->name ?? 'Dandi Adrian' }}">
    </div>
</div>

<div class="form-row">
    <div class="form-group">
        <label>Email</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope-at-fill"></i></span>
            <input type="email" name="email" class="form-control" value="{{ $user->email ?? 'dandi1@gmail.com' }}">
        </div>
    </div>
    <div class="form-group">
        <label>Nomor WhatsApp</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-whatsapp"></i></span>
            <input type="text" name="phone" class="form-control" placeholder="0812xxxx" value="{{ $user->phone ?? '' }}">
        </div>
    </div>
</div>

<div class="form-row">
    <div class="form-group">
        <label>Tanggal Lahir</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
            <input type="date" name="birthdate" class="form-control" value="{{ $user->birthdate ?? '' }}">
        </div>
    </div>
    <div class="form-group">
        <label>Jenis Kelamin</label>
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-gender-ambiguous"></i></span>
            <select name="gender" class="form-control">
                <option value="Laki-laki" {{ ($user->gender ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ ($user->gender ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>
    </div>
</div>

<button type="submit" class="btn-save">
    <i class="bi bi-check-circle-fill me-2"></i> Simpan Perubahan Profil
</button>
                </form>
                
            </section>
<section id="settings" class="content-section">
    <h2 class="section-title">Keamanan & Password</h2>
    <form action="{{ route('profile.password') }}" method="POST">
        @csrf 
        @method('PUT')
        
        <div class="form-group">
            <label>Password Saat Ini</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-shield-lock-fill"></i></span>
                <input type="password" name="old_password" class="form-control" placeholder="Masukkan password lama kamu">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Password Baru</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter">
                </div>
            </div>
            
            <div class="form-group">
                <label>Konfirmasi Password Baru</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-patch-check-fill"></i></span>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                </div>
            </div>
        </div>

        <div style="background: #fff3cd; color: #856404; padding: 15px; border-radius: 10px; margin-bottom: 20px; font-size: 13px; display: flex; align-items: center; gap: 10px;">
            <i class="bi bi-exclamation-triangle-fill" style="font-size: 20px;"></i>
            <span>Gunakan password yang kuat agar akunmu tetap aman. Jangan berikan password kepada siapapun.</span>
        </div>

        <button type="submit" class="btn-save">
            <i class="bi bi-shield-check me-2"></i> Perbarui Keamanan
        </button>
    </form>
</section>
<section id="address" class="content-section">
    <h2 class="section-title">Alamat Pengiriman</h2>
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf 
        @method('PUT')
        
    <div class="form-group">
    <label>Alamat Lengkap</label>
    <div class="input-group" style="align-items: flex-start;">
        <span class="input-group-text" style="padding-top: 12px;"><i class="bi bi-geo-alt-fill"></i></span>
        <textarea id="address_text" name="address" class="form-control" rows="3" 
            placeholder="Masukkan alamat lengkap...">{{ $user->address ?? '' }}</textarea>
    </div>

@if($user->address)
<div style="margin-top: 12px; display: flex; align-items: center; background: #fff9f0; padding: 10px; border-radius: 8px; border: 1px dashed #de5246;">
    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($user->address) }}" 
       target="_blank" 
       title="Lihat di Google Maps"
       style="color: #de5246; font-size: 24px; text-decoration: none; display: flex; align-items: center;">
        <i class="bi bi-geo-alt-fill"></i>
    </a>
    
    <i class="bi bi-arrow-left-short" style="font-size: 20px; color: #de5246; margin-left: 5px;"></i>

    <span style="font-size: 12px; color: #666; font-weight: 500;">
        Klik icon merah untuk melihat lokasi di Google Maps
    </span>
</div>
@endif
<div style="margin-top: 25px; padding: 15px; background-color: #fdf2e2; border-radius: 12px; border: 1px solid #e9d7c3;">
    <h6 style="color: #855c33; font-weight: bold; font-size: 14px; margin-bottom: 10px;">
        <i class="bi bi-truck me-2"></i> Info Pengiriman Kharisma
    </h6>
    <ul style="font-size: 12px; color: #5d4037; list-style: none; padding-left: 0; margin-bottom: 0;">
        <li class="mb-2"><i class="bi bi-check2-circle me-2 text-success"></i> <strong>Area Bogor:</strong> Estimasi 20-40 menit sampai.</li>
        <li class="mb-2"><i class="bi bi-check2-circle me-2 text-success"></i> <strong>Luar Bogor:</strong> Menggunakan ekspedisi reguler (6-12 Jam).</li>
        <li><i class="bi bi-info-circle me-2 text-primary"></i> Pastikan titik Maps sudah sesuai dengan alamat rumah Anda.</li>
    </ul>
</div>

</div>


        <button type="submit" class="btn-save">
            <i class="bi bi-geo-fill me-2"></i> Simpan Alamat & Lokasi
        </button>
    </form>
</section>
 <section id="orders" class="content-section">
    <h2 class="section-title" style="margin-bottom: 25px; color: #5d4037; font-weight: 800;">Riwayat Pesanan</h2>
    
    @forelse($orders as $order)
    <div style="background: #f4f4f4; border-radius: 16px; padding: 24px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: transform 0.2s ease; border: 1px solid #e0e0e0;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e0e0e0; padding-bottom: 15px; margin-bottom: 15px;">
            <div>
                <span style="font-size: 12px; color: #888; text-transform: uppercase; letter-spacing: 1px; display: block;">ID Pesanan</span>
                <span style="font-weight: 700; color: #2c2c2c; font-size: 16px;">#{{ $order->order_number }}</span>
            </div>
        <span style="font-size: 12px; font-weight: 700; padding: 8px 16px; border-radius: 12px; display: flex; align-items: center; gap: 8px;
                @if($order->status === 'pending') background: #ff9500; color: #ff9100;
                @elseif($order->status === 'in_progress') background: #ffa24c; color: #000000;
                @elseif($order->status === 'shipped') background: #0095ff; color: #000000;
                @elseif($order->status === 'completed') background: #b6ff7a; color: #000000fd;
                @else background: #f90025; color: #000000;
                @endif">
                
                @if($order->status === 'pending') <i class="bi bi-hourglass-split"></i> Menunggu
                @elseif($order->status === 'in_progress') <i class="bi bi-check-all"></i> Proses
                @elseif($order->status === 'shipped') <i class="bi bi-truck"></i> Dikirim
                @elseif($order->status === 'completed') <i class="bi bi-stars"></i> Selesai
                @else <i class="bi bi-x-circle-fill"></i> Dibatalkan
                @endif
            </span>
        </div>

       <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="background: #ffe4e1; padding: 10px; border-radius: 12px; color: #ff6b6b;"><i class="bi bi-calendar-check-fill"></i></div>
                <div>
                    <p style="margin: 0; font-size: 10px; color: #999; text-transform: uppercase;">Tanggal</p>
                    <p style="margin: 0; font-size: 13px; color: #333; font-weight: 700;">{{ $order->created_at->format('d M Y') }}</p>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="background: #e0f2fe; padding: 10px; border-radius: 12px; color: #0284c7;"><i class="bi bi-credit-card-2-back-fill"></i></div>
                <div>
                    <p style="margin: 0; font-size: 10px; color: #999; text-transform: uppercase;">Metode</p>
                    <p style="margin: 0; font-size: 13px; color: #333; font-weight: 700;">{{ strtoupper($order->payment_method) }}</p>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="background: #f0fdf4; padding: 10px; border-radius: 12px; color: #16a34a;"><i class="bi bi-cash-stack"></i></div>
                <div>
                    <p style="margin: 0; font-size: 10px; color: #999; text-transform: uppercase;">Total</p>
                    <p style="margin: 0; font-size: 15px; color: #8b7355; font-weight: 800;">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
       <div style="background: #fff; border: 1px solid #eee; padding: 15px; border-radius: 12px; margin-bottom: 20px; position: relative; overflow: hidden;">
            <div style="position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: #bc9c78;"></div>
            <p style="margin: 0 0 5px 0; font-size: 11px; font-weight: 800; color: #bc9c78;"><i class="bi bi-geo-alt-fill me-1"></i> TUJUAN PENGIRIMAN</p>
            <p style="margin: 0; font-size: 13px; color: #555; line-height: 1.5;">{{ $order->delivery_address }}</p>
        </div>

       <div style="padding-top: 15px; border-top: 1px dashed #ccc;">
            <p style="margin: 0 0 10px 0; font-size: 12px; font-weight: 700; color: #444;"><i class="bi bi-bag-check-fill me-2" style="color: #bc9c78;"></i>Daftar Belanja:</p>
            <ul style="margin: 0; padding: 0; list-style: none;">
                @foreach($order->orderItems as $item)
                <li style="display: flex; justify-content: space-between; font-size: 13px; color: #555; margin-bottom: 8px;">
                    <span><i class="bi bi-egg-fill me-2" style="color: #ffd54f;"></i>{{ $item->product->name }} <strong style="color: #bc9c78;">x{{ $item->quantity }}</strong></span>
                    <span style="font-weight: 700; color: #333;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @empty
    <div style="text-align:center; padding:60px; background: #f8f9fa; border-radius: 20px; border: 2px dashed #dee2e6;">
        <i class="bi bi-cart-x" style="font-size: 50px; color: #ced4da;"></i>
        <p style="margin-top: 15px; color: #adb5bd; font-weight: 600;">Belum ada pesanan nih, abangkuh!</p>
    </div>
    @endforelse
</section>
</section>
        </main>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Tab System
        function showSection(sectionId) {
            document.querySelectorAll('.content-section').forEach(s => s.classList.remove('active'));
            document.querySelectorAll('.profile-menu a').forEach(a => a.classList.remove('active'));
            document.getElementById(sectionId).classList.add('active');
            document.getElementById('menu-' + sectionId).classList.add('active');
            if(sectionId === 'address') { 
                setTimeout(() => { map.invalidateSize(); }, 300); 
            }
        }

        // Preview Foto Profil
        document.getElementById('avatarInput').addEventListener('change', function(e) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById('avatarPreview').innerHTML = `<img src="${reader.result}">`;
            }
            reader.readAsDataURL(e.target.files[0]);
        });

        // Map System
        let map, marker;
        document.addEventListener('DOMContentLoaded', function() {
            const savedLat = parseFloat(document.getElementById('lat').value) || -6.5971;
            const savedLng = parseFloat(document.getElementById('lng').value) || 106.8060;

            map = L.map('map').setView([savedLat, savedLng], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
            marker = L.marker([savedLat, savedLng], {draggable: true}).addTo(map);

            function updateCoords(lat, lng) {
                document.getElementById('lat').value = lat;
                document.getElementById('lng').value = lng;
            }

            marker.on('dragend', function() {
                const pos = marker.getLatLng();
                updateCoords(pos.lat, pos.lng);
            });

            map.on('click', (e) => {
                marker.setLatLng(e.latlng);
                updateCoords(e.latlng.lat, e.latlng.lng);
            });

            // Auto Search Alamat
            let timer;
            document.getElementById('address_text').addEventListener('input', function() {
                clearTimeout(timer);
                timer = setTimeout(async () => {
                    const query = this.value;
                    if (query.length < 5) return;
                    try {
                        const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`);
                        const data = await res.json();
                        if (data.length > 0) {
                            const { lat, lon } = data[0];
                            map.setView([lat, lon], 16);
                            marker.setLatLng([lat, lon]);
                            updateCoords(lat, lon);
                        }
                    } catch (e) { console.error(e); }
                }, 1000);
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Notifikasi Sukses (Profil, Alamat, Password)
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2500,
                background: '#f5deb3',
                iconColor: '#8b7355'
            });
        @endif

        // Notifikasi Password Salah
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: "{{ session('error') }}",
                confirmButtonColor: '#8b7355'
            });
        @endif
    });
</script>
</body>
</html>