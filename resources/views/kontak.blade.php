<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - Toko Kue Kharisma</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #f5deb3 0%, #f4d4a8 100%);
            min-height: 100vh;
        }

        /* Header */
        header {
            background: linear-gradient(135deg, #d4b896 0%, #c9a882 100%);
            padding: 15px clamp(15px, 4vw, 50px);
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .btn-back {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.3);
            border: none;
            padding: 8px 15px;
            border-radius: 10px;
            color: #2c2c2c;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.5);
            transform: translateX(-3px);
        }

        .btn-back svg {
            width: 20px;
            height: 20px;
            stroke: #2c2c2c;
            fill: none;
            stroke-width: 2.5;
        }

        .logo-section {
            display: flex;
            align-items: center;
        }

        .store-name {
            font-family: 'Brush Script MT', 'Lucida Handwriting', cursive;
            font-size: 28px;
            color: #2c2c2c;
            font-style: italic;
            font-weight: bold;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 10px;
            z-index: 1001;
        }

        .hamburger span {
            width: 30px;
            height: 3px;
            background: #4a4a4a;
            border-radius: 3px;
            transition: all 0.3s;
        }

        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg) translate(8px, 8px);
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(8px, -8px);
        }

        nav {
            display: flex;
            gap: 30px;
            align-items: center;
            transition: all 0.3s;
        }

      /* Gaya dasar link nav */
        nav a {
            color: #4a4a4a;
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            text-transform: capitalize; /* Biar huruf depan otomatis gede */
            position: relative; /* Penting untuk efek underline */
            padding: 5px 0;
            transition: color 0.3s ease;
        }

        /* Efek Underline yang mengalir dari tengah */
        nav a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: #8b7355;
            transition: all 0.3s ease-in-out;
            transform: translateX(-50%);
        }

        /* Warna & Underline saat Hover */
        nav a:hover {
            color: #2c2c2c;
        }

        nav a:hover::after {
            width: 100%;
        }

        /* Gaya untuk link yang sedang aktif (Kontak) */
        nav a.active {
            color: #8b7355;
        }

        nav a.active::after {
            width: 80%; /* Garis bawah tetap ada di menu aktif */
            background-color: #8b7355;
        }

        /* Tambahan: Sedikit animasi floating biar lebih 'hidup' */
        @keyframes navFloat {
            0% { transform: translateY(0); }
            50% { transform: translateY(-2px); }
            100% { transform: translateY(0); }
        }

        nav a:hover {
            animation: navFloat 1s ease-in-out infinite;
        }
        .header-icons {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .icon-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
        }

        .icon-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #2c2c2c;
            transition: transform 0.2s;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-btn svg {
            width: 26px;
            height: 26px;
            stroke: #2c2c2c;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .icon-btn:hover {
            transform: scale(1.1);
        }

        .icon-label {
            font-size: 10px;
            color: #4a4a4a;
            font-weight: 600;
        }

        .icon-wrapper {
            position: relative;
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #d32f2f;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 11px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Contact Container */
        .contact-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 50px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: start;
        }

        .contact-title {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 32px;
            font-weight: 600;
            color: #2c2c2c;
            margin-bottom: 40px;
        }

        .contact-title svg {
            width: 40px;
            height: 40px;
            stroke: #8b7355;
            fill: none;
            stroke-width: 2;
        }

        /* Contact Form */
        .contact-form {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            font-size: 16px;
            color: #8b7355;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .form-control {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            background: white;
            font-size: 15px;
            color: #2c2c2c;
            transition: all 0.3s;
            font-family: Arial, Helvetica, sans-serif;
        }

        .form-control:focus {
            outline: none;
            border-color: #8b7355;
            box-shadow: 0 0 0 3px rgba(139, 115, 85, 0.1);
            transform: translateY(-2px);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        .btn-submit {
            background: linear-gradient(135deg, #8b7355 0%, #6b5845 100%);
            color: white;
            border: none;
            padding: 15px 50px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 30px auto 0;
            box-shadow: 0 4px 15px rgba(139, 115, 85, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(139, 115, 85, 0.4);
        }

        .btn-submit svg {
            width: 20px;
            height: 20px;
            stroke: white;
            fill: none;
            stroke-width: 2;
        }

        /* Contact Info */
        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 25px;
            margin-top: 92px;
        }

        .info-card {
            display: flex;
            align-items: center;
            gap: 20px;
            background: rgba(255, 255, 255, 0.8);
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            min-height: 90px;
            transition: all 0.3s;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .info-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: linear-gradient(135deg, #8b7355 0%, #6b5845 100%);
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(139, 115, 85, 0.3);
        }

        .info-icon svg {
            width: 30px;
            height: 30px;
            stroke: white;
            fill: none;
            stroke-width: 2;
        }

        .info-details {
            flex: 1;
        }

        .info-label {
            font-size: 14px;
            color: #8b7355;
            font-weight: 600;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-text {
            font-size: 16px;
            color: #2c2c2c;
            line-height: 1.6;
            font-weight: 600;
        }

        .info-note {
            font-size: 13px;
            color: #6b6b6b;
            margin-top: 10px;
            line-height: 1.5;
        }

        .address-card {
            text-decoration: none;
        }

        .address-card .info-text {
            word-break: break-word;
        }

        /* Mobile Menu */
        .menu-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .menu-overlay.active {
            display: block;
        }

        @media (max-width: 968px) {
            .hamburger {
                display: flex;
            }

            nav {
                position: fixed;
                top: 0;
                right: -100%;
                width: 300px;
                height: 100vh;
                background: linear-gradient(135deg, #d4b896 0%, #c9a882 100%);
                flex-direction: column;
                justify-content: flex-start;
                padding: 80px 30px 30px;
                box-shadow: -5px 0 15px rgba(0, 0, 0, 0.2);
                z-index: 1000;
            }

            nav.active {
                right: 0;
            }

            nav a {
                font-size: 18px;
                padding: 15px 0;
                width: 100%;
                border-bottom: 1px solid rgba(74, 74, 74, 0.2);
            }

            .contact-container {
                grid-template-columns: 1fr;
                padding: 0 20px;
            }

            .contact-title {
                font-size: 24px;
            }

            .contact-form {
                padding: 30px 20px;
            }

            .header-icons {
                margin-left: auto;
                gap: 10px;
            }
        }

        @media (max-width: 480px) {
            .contact-container { padding: 0 15px; margin: 20px auto; }
            .contact-form { padding: 20px 15px; }
            .contact-title { font-size: 24px; }
        }
    </style>
</head>
<body>
    <!-- Menu Overlay -->
    <div class="menu-overlay" id="menuOverlay"></div>

    <!-- Header -->
    <header>
        <div class="header-left">
            <a href="/" class="btn-back">
                <svg viewBox="0 0 24 24">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
            <div class="logo-section">
                <span class="store-name">Toko kue kharisma</span>
            </div>
        </div>
        
 <nav id="navMenu">
    <a href="/" class="{{ Request::is('/') ? 'active' : '' }}">home</a>
    <a href="/menu" class="{{ Request::is('menu') ? 'active' : '' }}">menu</a>
    <a href="/riwayat" class="{{ Request::is('riwayat') ? 'active' : '' }}">riwayat</a>
    <a href="/kontak" class="{{ Request::is('kontak') ? 'active' : '' }}">kontak</a>
    <a href="/promo" class="{{ Request::is('promo') ? 'active' : '' }}">promo</a>
</nav>

        <div class="header-icons">
            <div class="icon-wrapper">
                <button type="button" class="icon-btn" title="Keranjang" onclick="window.location.href='/cart'">
                    <svg viewBox="0 0 24 24">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    <span class="cart-badge" id="cartBadge">0</span>
                </button>
                <span class="icon-label">Keranjang</span>
            </div>
            <div class="icon-wrapper">
                <button class="icon-btn" title="Profil" onclick="window.location.href='/profile'">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"></circle>
                        <circle cx="12" cy="10" r="3"></circle>
                        <path d="M6.168 18.849A4 4 0 0 1 10 16h4a4 4 0 0 1 3.834 2.855"></path>
                    </svg>
                </button>
                <span class="icon-label">Profil</span>
            </div>
            
            <!-- Hamburger Menu -->
            <div class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </header>

    <!-- Contact Container -->
    <div class="contact-container">
        <!-- Contact Form -->
        <div class="contact-left">
            <h1 class="contact-title">
                <svg viewBox="0 0 24 24">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
                Kontak kami
            </h1>

            <div class="contact-form">
                <form onsubmit="sendMessage(event)">
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" id="name" class="form-control" placeholder="Masukkan nama lengkap Anda" required>
                    </div>

                    <div class="form-group">
                        <label for="message">Pesan</label>
                        <textarea id="message" class="form-control" placeholder="Tulis pesan Anda di sini..." required></textarea>
                    </div>

                    <button type="submit" class="btn-submit">
                        <svg viewBox="0 0 24 24">
                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                        </svg>
                        Kirim pesan via WhatsApp
                    </button>
                </form>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="contact-info">
            <!-- Address -->
            <a href="https://www.google.com/maps/dir/?api=1&destination=Jl.+Pasar+Dramaga+No.74%2C+RT.002%2FRW.003%2C+Dramaga%2C+Kec.+Dramaga%2C+Bogor+Barat%2C+Jawa+Barat+16680" target="_blank" rel="noopener noreferrer" class="info-card address-card">
                <div class="info-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                </div>
                <div class="info-details">
                    <p class="info-label">Alamat</p>
                    <p class="info-text">
                        Jl. Pasar Dramaga No.74, RT.002/RW.003, Dramaga, Kec. Dramaga, Bogor Barat, Jawa Barat 16680
                    </p>
                    <p class="info-note">Klik alamat untuk membuka Google Maps dengan tujuan alamat ini.</p>
                </div>
            </a>

            <!-- Email -->
            <div class="info-card">
                <div class="info-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                </div>
                <div class="info-details">
                    <p class="info-label">Email</p>
                    <p class="info-text">kuekharisma@gmail.com</p>
                </div>
            </div>

            <!-- Business Hours -->
            <div class="info-card">
                <div class="info-icon">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12,6 12,12 16,14"></polyline>
                    </svg>
                </div>
                <div class="info-details">
                    <p class="info-label">Jam Buka</p>
                    <p class="info-text">
                        Senin - Sabtu: 08:00 - 20:00<br>
                        Minggu: 09:00 - 18:00
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Hamburger Menu Toggle
        const hamburger = document.getElementById('hamburger');
        const navMenu = document.getElementById('navMenu');
        const menuOverlay = document.getElementById('menuOverlay');

        hamburger.addEventListener('click', function() {
            hamburger.classList.toggle('active');
            navMenu.classList.toggle('active');
            menuOverlay.classList.toggle('active');
        });

        menuOverlay.addEventListener('click', function() {
            hamburger.classList.remove('active');
            navMenu.classList.remove('active');
            menuOverlay.classList.remove('active');
        });

        document.querySelectorAll('nav a').forEach(link => {
            link.addEventListener('click', function() {
                hamburger.classList.remove('active');
                navMenu.classList.remove('active');
                menuOverlay.classList.remove('active');
            });
        });

        // Send Message
        function sendMessage(event) {
            event.preventDefault();

            const phoneNumber = '6289636491354';
            const name = document.getElementById('name').value.trim();
            const message = document.getElementById('message').value.trim();

            const whatsappText = `Halo, saya ${name}.\n\nPesan: ${message}`;
            const whatsappURL = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(whatsappText)}`;

            window.open(whatsappURL, '_blank');
            event.target.reset();
        }

        // Update cart badge
        function updateCartBadge() {
            const badge = document.getElementById('cartBadge');
            if (badge) {
                fetch('/api/cart/count')
                    .then(response => response.json())
                    .then(data => {
                        if (data.count !== undefined) {
                            badge.textContent = data.count;
                        }
                    })
                    .catch(error => console.error('Error fetching cart count:', error));
            }
        }

        // Load cart count on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateCartBadge();
        });
    </script>
</body>
</html>
