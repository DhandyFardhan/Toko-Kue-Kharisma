<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Promo - Toko Kue Kharisma</title>
    <style>
        /* --- CSS TETAP SAMA SEPERTI SEBELUMNYA --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, Helvetica, sans-serif; background: #f5deb3; }
        header { 
            background: linear-gradient(135deg, #d4b896 0%, #c9a882 100%); 
            padding: 15px clamp(15px, 4vw, 50px); 
            display: flex; justify-content: space-between; align-items: center; 
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); position: sticky; top: 0; z-index: 1000;
        }
        .header-left { display: flex; align-items: center; gap: 20px; }
        .btn-back { 
            display: flex; align-items: center; gap: 10px; background: rgba(255, 255, 255, 0.3); 
            border: none; padding: 8px 15px; border-radius: 10px; color: #2c2c2c; 
            font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.3s; text-decoration: none; 
        }
        .btn-back:hover { background: rgba(255, 255, 255, 0.5); transform: translateX(-3px); }
        .btn-back svg { width: 20px; height: 20px; stroke: #2c2c2c; fill: none; stroke-width: 2.5; }
        .store-name { font-family: 'Brush Script MT', cursive; font-size: 28px; color: #2c2c2c; font-weight: bold; }
        nav { display: flex; gap: 30px; align-items: center; }
        nav a { 
            color: #4a4a4a; text-decoration: none; font-size: 15px; font-weight: 600; 
            position: relative;
            transition: all 0.3s ease;
            padding-bottom: 5px;
        }
        nav a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: #2c2c2c;
            transition: width 0.3s ease;
        }
        nav a:hover::after {
            width: 100%;
        }
        nav a.active { 
            color: #2c2c2c; 
        }
        nav a.active::after {
            width: 100%;
        }
        .header-icons { display: flex; gap: 20px; align-items: center; }
        .icon-wrapper { display: flex; flex-direction: column; align-items: center; position: relative; }
        .icon-btn { background: none; border: none; cursor: pointer; transition: transform 0.2s; }
        .icon-btn svg { width: 26px; height: 26px; stroke: #2c2c2c; fill: none; stroke-width: 2; }
        .cart-badge { 
            position: absolute; top: -5px; right: -5px; background: #d32f2f; color: white; 
            border-radius: 50%; width: 18px; height: 18px; font-size: 11px; 
            display: flex; align-items: center; justify-content: center; font-weight: bold;
        }
        .icon-label { font-size: 10px; font-weight: 600; color: #4a4a4a; }
        .promo-packages { padding: 50px; max-width: 1400px; margin: 0 auto; }
        .section-title { 
            text-align: center; font-size: 28px; color: #8b7355; margin-bottom: 10px; 
            font-weight: 700;
            animation: fadeInDown 0.6s ease-out;
        }
        .section-divider { 
            width: 150px; height: 3px; background: linear-gradient(90deg, transparent, #d32f2f, transparent); 
            margin: 0 auto 40px;
            animation: scaleIn 0.6s ease-out 0.2s backwards;
        }
        
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes scaleIn {
            from { transform: scaleX(0); }
            to { transform: scaleX(1); }
        }
        .packages-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; }
        .package-card { 
            background: linear-gradient(135deg, #d4b896 0%, #c9a882 100%); 
            border-radius: 20px; padding: 25px; text-align: center; position: relative;
            transition: all 0.3s ease; box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            animation: slideUp 0.5s ease-out;
        }
        .package-card:hover { 
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.2);
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .discount-badge { 
            position: absolute; top: 15px; right: 15px; background: #d32f2f; color: white; 
            padding: 5px 12px; border-radius: 20px; font-weight: bold; font-size: 12px; 
        }
        .package-image-container { background: white; border-radius: 15px; padding: 10px; margin-bottom: 15px; height: 200px; overflow: hidden; display: flex; align-items: center; justify-content: center; }
        .package-image { max-width: 100%; height: auto; border-radius: 10px; }
        .package-name { font-size: 20px; margin-bottom: 10px; color: #2c2c2c; }
        .package-description { font-size: 14px; color: #4a4a4a; margin-bottom: 15px; min-height: 40px; }
        .original-price { text-decoration: line-through; color: #8b7355; margin-right: 10px; font-size: 14px; }
        .discount-price { font-size: 20px; font-weight: bold; color: #2c2c2c; }
        .btn-buy-package { 
            background: white; border: 2px solid #2c2c2c; border-radius: 25px; 
            padding: 10px 20px; cursor: pointer; font-weight: 600; 
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .btn-buy-package::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: #2c2c2c;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.3s, height 0.3s;
            z-index: 0;
        }
        .btn-buy-package:hover::before {
            width: 300px;
            height: 300px;
        }
        .btn-buy-package:hover {
            color: white;
        }
        .btn-buy-package span {
            position: relative;
            z-index: 1;
        }

        /* Info Box untuk Persyaratan Promo - IMPROVED */
        .promo-info-box {
            background: linear-gradient(135deg, #fff4e6 0%, #ffe8cc 100%);
            border-left: 6px solid #d32f2f;
            padding: 24px 28px;
            border-radius: 12px;
            margin-bottom: 40px;
            box-shadow: 0 4px 16px rgba(211, 47, 47, 0.15);
            animation: slideInDown 0.5s ease-out;
            position: relative;
            overflow: hidden;
        }
        .promo-info-box::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: rgba(211, 47, 47, 0.05);
            border-radius: 50%;
            transform: translate(50%, -50%);
        }
        .promo-info-box h3 {
            color: #d32f2f;
            margin-bottom: 12px;
            font-size: 18px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            position: relative;
            z-index: 1;
        }
        .promo-info-box p {
            color: #4a4a4a;
            font-size: 15px;
            line-height: 1.7;
            font-weight: 500;
            position: relative;
            z-index: 1;
        }
        .promo-info-box strong {
            color: #d32f2f;
            font-weight: 700;
        }
        
        @keyframes slideInDown {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Hamburger untuk Mobile */
        .hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; }
        .hamburger span { width: 25px; height: 3px; background: #2c2c2c; }
        
        @media (max-width: 768px) {
            nav { display: none; } /* Sembunyikan nav di mobile, bisa kembangkan menu sidebar nanti */
            .hamburger { display: flex; }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-left">
            <a href="/" class="btn-back">
                <svg viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Kembali
            </a>
            <span class="store-name">Toko kue kharisma</span>
        </div>
        
        <nav>
            <a href="/">home</a>
            <a href="/menu">menu</a>
            <a href="/kontak">kontak</a>
            <a href="/promo" class="active">promo</a>
        </nav>

        <div class="header-icons">
            <div class="icon-wrapper">
                <button class="icon-btn" onclick="window.location.href='/cart'">
                    <svg viewBox="0 0 24 24">
                        <circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    <span class="cart-badge" id="cartBadge">0</span>
                </button>
                <span class="icon-label">Keranjang</span>
            </div>
            <div class="icon-wrapper">
                <button class="icon-btn" onclick="window.location.href='/login'">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="10" r="3"></circle>
                        <path d="M6.168 18.849A4 4 0 0 1 10 16h4a4 4 0 0 1 3.834 2.855"></path>
                    </svg>
                </button>
                <span class="icon-label">Profil</span>
            </div>
            <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
        </div>
    </header>

    <section class="promo-packages">
        <h2 class="section-title">Paket Promo Spesial</h2>
        <div class="section-divider"></div>

        <div class="promo-info-box">
            <h3>⚠️ Persyaratan Promo</h3>
            <p>Promo ini berlaku jika Anda telah membeli minimal <strong>2 produk</strong> dari bagian <strong>Menu</strong> kami. Diskon eksklusif ini adalah apresiasi kami untuk pelanggan setia!</p>
        </div>

        <div class="packages-grid">
            <div class="package-card">
                <div class="discount-badge">Diskon 20%</div>
                <div class="package-image-container">
                    <img src="/images/products/pasar.jpg" alt="Paket A" class="package-image">
                </div>
                <h3 class="package-name">Paketan Hemat A</h3>
                <p class="package-description">Dadar Gulung, Lemper, Putu Ayu, Lupis, Kue Apem</p>
                <div class="package-price">
                    <span class="original-price">Rp 25.000</span>
                    <span class="discount-price">Rp 20.000</span>
                </div>
               <button class="btn-buy-package" onclick="addToCart(901, 20000, 'Paketan Hemat A')">
    <span>MASUKKAN KE KERANJANG</span>
</button>
            </div>

            <div class="package-card">
                <div class="discount-badge">Diskon 20%</div>
                <div class="package-image-container">
                    <img src="/images/products/keren.jpg" alt="Paket B" class="package-image">
                </div>
                <h3 class="package-name">Paketan Hemat B</h3>
                <p class="package-description">Talam Suji, Pepe Hijau, Pepe Pelangi, Ongol-Ongol, Kue Lumpur</p>
                <div class="package-price">
                    <span class="original-price">Rp 25.000</span>
                    <span class="discount-price">Rp 20.000</span>
                </div>
                <button class="btn-buy-package" onclick="addToCart(902, 20000, 'Paketan Hemat B')">
    <span>MASUKKAN KE KERANJANG</span>
</button>
            </div>

            <div class="package-card">
                <div class="discount-badge">Diskon 20%</div>
                <div class="package-image-container">
                    <img src="/images/products/gacor.jpg" alt="Paket C" class="package-image">
                </div>
                <h3 class="package-name">Paketan Hemat C</h3>
                <p class="package-description">Bolu Pelangi, Pie Buah, Pie Brownies, Risoles, Pastel</p>
                <div class="package-price">
                    <span class="original-price">Rp 25.000</span>
                    <span class="discount-price">Rp 20.000</span>
                </div>
                <button class="btn-buy-package" onclick="addToCart(903, 20000, 'Paketan Hemat C')">
    <span>MASUKKAN KE KERANJANG</span>
</button>
            </div>
        </div>
    </section>

    <script>
        // 1. Fungsi Tambah ke Keranjang
        function addToCart(productId, promoPrice, packageName) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            if (!csrfToken) {
                console.error('CSRF token not found');
                showNotification('Gagal: Token keamanan tidak ditemukan', 'error');
                return;
            }

            console.log('Adding to cart:', { productId, promoPrice, packageName, csrfToken });
            
            fetch("/cart/add", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1,
                    price: promoPrice,
                    name: packageName 
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                
                if (response.status === 401) {
                    showNotification('Silakan login terlebih dahulu', 'error');
                    setTimeout(() => {
                        window.location.href = "{{ route('login') }}";
                    }, 1500);
                    return null;
                }
                
                if (!response.ok) {
                    return response.text().then(text => {
                        console.error('Response error:', text);
                        throw new Error(`HTTP ${response.status}: ${text}`);
                    });
                }
                
                return response.json();
            })
            .then(data => {
                if (data) {
                    console.log('Response data:', data);
                    if (data.success) {
                        showNotification('✅ ' + (data.message || 'Berhasil ditambah ke keranjang'), 'success');
                        updateCartBadge();
                    } else {
                        showNotification(data.message || 'Gagal menambahkan ke keranjang', 'error');
                    }
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                showNotification('❌ Terjadi kesalahan: ' + error.message, 'error');
            });
        }

        // 2. Update Badge Keranjang
        function updateCartBadge() {
            const badge = document.getElementById('cartBadge');
            if (!badge) return;
            
            fetch('/api/cart/count')
                .then(response => {
                    if (!response.ok) throw new Error('Failed to fetch cart count');
                    return response.json();
                })
                .then(data => {
                    if (data && data.count !== undefined) {
                        badge.textContent = data.count;
                    }
                })
                .catch(err => console.log('Cart count error:', err));
        }

        // 3. Sistem Notifikasi Pop-up
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            const bgColor = type === 'success' ? '#4caf50' : '#f44336';
            const borderColor = type === 'success' ? '#45a049' : '#e53935';
            
            notification.style.cssText = `
                position: fixed; top: 20px; right: 20px; 
                background: ${bgColor}; color: white; 
                padding: 16px 24px; border-radius: 8px; 
                z-index: 9999; box-shadow: 0 6px 20px rgba(0,0,0,0.3);
                font-weight: 500; font-size: 14px;
                animation: slideIn 0.3s ease-in-out;
                border-left: 4px solid ${borderColor};
                max-width: 400px;
                word-wrap: break-word;
            `;
            notification.textContent = message;

            // Tambahkan animation CSS
            if (!document.querySelector('style[data-notification]')) {
                const style = document.createElement('style');
                style.setAttribute('data-notification', 'true');
                style.textContent = `
                    @keyframes slideIn {
                        from { transform: translateX(400px); opacity: 0; }
                        to { transform: translateX(0); opacity: 1; }
                    }
                    @keyframes slideOut {
                        from { transform: translateX(0); opacity: 1; }
                        to { transform: translateX(400px); opacity: 0; }
                    }
                `;
                document.head.appendChild(style);
            }

            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease-in-out';
                setTimeout(() => notification.remove(), 300);
            }, 4000);
        }

        // Load awal
        document.addEventListener('DOMContentLoaded', updateCartBadge);
    </script>
</body>
</html>