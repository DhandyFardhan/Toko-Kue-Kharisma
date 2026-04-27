<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Toko Kue Kharisma</title>
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
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
                        <input type="text" name="name" class="form-control" value="{{ $user->name ?? 'Dandi Adrian' }}">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email ?? 'dandi1@gmail.com' }}">
                        </div>
                        <div class="form-group">
                            <label>Nomor WhatsApp</label>
                            <input type="text" name="phone" class="form-control" placeholder="0812xxxx" value="{{ $user->phone ?? '' }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="birthdate" class="form-control" value="{{ $user->birthdate ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="gender" class="form-control">
                                <option value="Laki-laki" {{ ($user->gender ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ ($user->gender ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn-save">Simpan Perubahan Profil</button>
                </form>
            </section>

            <section id="address" class="content-section">
                <h2 class="section-title">Alamat Pengiriman</h2>
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf @method('PUT')
                    
                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <textarea id="address_text" name="address" class="form-control" rows="3" placeholder="Masukkan alamat lengkap atau cari di peta...">{{ $user->address ?? '' }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Titik Koordinat (Geser pin pada peta)</label>
                        <div id="map"></div>
                        <input type="hidden" name="latitude" id="lat" value="{{ $user->latitude ?? '' }}">
                        <input type="hidden" name="longitude" id="lng" value="{{ $user->longitude ?? '' }}">
                    </div>

                    <button type="submit" class="btn-save">Simpan Alamat Saja</button>
                </form>
            </section>

            <section id="settings" class="content-section">
                <h2 class="section-title">Keamanan & Password</h2>
                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf @method('PUT')
                    
                    <div class="form-group">
                        <label>Password Lama</label>
                        <input type="password" name="old_password" class="form-control" placeholder="Masukkan password saat ini">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Password Baru</label>
                            <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter">
                        </div>
                        <div class="form-group">
                            <label>Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                        </div>
                    </div>

                    <button type="submit" class="btn-save">Update Password</button>
                </form>
            </section>

            <section id="orders" class="content-section">
                <h2 class="section-title">Riwayat Pesanan</h2>
                @forelse($orders as $order)
                <div style="background: #f9f9f9; border-radius: 12px; padding: 20px; margin-bottom: 15px; border-left: 5px solid #8b7355;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                        <span style="font-weight: 600; color: #2c2c2c;">{{ $order->order_number }}</span>
                        <span style="font-size: 13px; background: 
                            @if($order->status === 'pending') #ffc107
                            @elseif($order->status === 'paid') #28a745
                            @elseif($order->status === 'shipped') #17a2b8
                            @else #6c757d
                            @endif; 
                            color: white; padding: 5px 12px; border-radius: 20px;">{{ ucfirst($order->status) }}</span>
                    </div>
                    <div style="font-size: 13px; color: #666; margin-bottom: 12px;">
                        <p style="margin: 5px 0;"><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
                        <p style="margin: 5px 0;"><strong>Total:</strong> Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                        <p style="margin: 5px 0;"><strong>Metode Pembayaran:</strong> {{ ucfirst($order->payment_method) }}</p>
                        <p style="margin: 5px 0;"><strong>Alamat:</strong> {{ $order->delivery_address }}</p>
                    </div>
                    <div style="padding-top: 10px; border-top: 1px solid #eee;">
                        <strong style="font-size: 13px; color: #2c2c2c;">Item Pesanan:</strong>
                        <ul style="margin: 8px 0 0 20px; font-size: 13px; color: #666;">
                            @foreach($order->orderItems as $item)
                            <li>{{ $item->product->name ?? 'Produk Terhapus' }} x{{ $item->quantity }} - Rp {{ number_format($item->subtotal, 0, ',', '.') }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @empty
                <div style="text-align:center; padding:50px 0; border: 2px dashed #ddd; border-radius: 15px;">
                    <p style="color: #999; font-weight: 600;">Belum ada pesanan yang ditemukan.</p>
                </div>
                @endforelse
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