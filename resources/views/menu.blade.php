<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Menu - Toko Kue Kharisma</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

body {
    font-family: Arial, Helvetica, sans-serif;
    background: #F3DEBA; /* Warna krem hangat halaman home */
}

        /* Header */
        header {
            background: linear-gradient(135deg, rgba(212, 184, 150, 0.95) 0%, rgba(201, 168, 130, 0.95) 100%);
    backdrop-filter: blur(8px); /* Memberikan efek kaca */
            padding: 15px clamp(15px, 4vw, 50px);
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1002;
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

       /* Cari bagian ini di dalam tag <style> */
.store-name {
    font-family: 'Brush Script MT', 'Lucida Handwriting', cursive;
    font-size: 28px;
    color: #2c2c2c;
    font-style: italic;
    font-weight: bold;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    
    /* TAMBAHKAN BARIS INI */
    transition: all 0.3s ease;
    cursor: default;
    display: inline-block;
}

/* TAMBAHKAN BLOK BARU INI DI BAWAHNYA */
.store-name:hover {
    transform: skewX(-10deg) scale(1.05); /* Miring + sedikit membesar */
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    color: #5d4d3c; /* Sedikit berubah warna saat hover */
}

        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 10px;
            z-index: 1002;
            position: relative;
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

       /* Update Navigasi agar lebih hidup */
nav {
    display: flex;
    gap: 30px;
    align-items: center;
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
            position: relative;
            z-index: 1002;
        }

        .icon-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            position: relative;
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

        /* Menu Section */
        .menu-section {
            padding: 50px;
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .menu-header {
            text-align: center;
            margin-bottom: 40px;
        }

      .menu-title {
    font-family: 'Georgia', serif; /* Pakai serif biar lebih elegan */
    font-size: 38px;
    position: relative;
    display: inline-block;
    padding-bottom: 10px;
}

.menu-title::after {
    content: '🍰'; /* Ikon kue kecil sebagai pemanis */
    position: absolute;
    bottom: -15px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 20px;
}

/* Tambahkan garis di bawah subtitle */
.menu-subtitle {
    margin-top: 15px;
    font-style: italic;
    opacity: 0.8;
}

        /* Category Filter */
        .category-filter {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .category-btn {
            background: white;
            border: 2px solid #8b7355;
            padding: 10px 25px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            color: #8b7355;
            cursor: pointer;
            transition: all 0.3s;
        }

        .category-btn:hover, .category-btn.active {
            background: #8b7355;
            color: white;
        }

        /* Menu Grid */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
        }

        .table-controls {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 25px;
            align-items: center;
        }

        .search-input {
            width: 100%;
            max-width: 420px;
            padding: 12px 16px;
            border-radius: 12px;
            border: 1px solid #c8b097;
            font-size: 15px;
            outline: none;
            transition: border-color 0.2s ease;
        }

        .search-input:focus {
            border-color: #8b7355;
        }

        .pagination-info {
            color: #4a4a4a;
            font-weight: 600;
            font-size: 14px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        @media (max-width: 1100px) {
            .products-grid { grid-template-columns: repeat(3, 1fr); }
        }

        @media (max-width: 768px) {
            .products-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 480px) {
            .products-grid { grid-template-columns: 1fr; }
        }

        .pagination-buttons {
            display: flex;
            gap: 12px;
            margin-top: 30px;
            justify-content: center;
        }

        .pagination-buttons button {
            background: #8b7355;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.2s ease, transform 0.2s ease;
        }

        .pagination-buttons button:disabled {
            background: #cfc0b1;
            cursor: not-allowed;
        }

        .pagination-buttons button:hover:not(:disabled) {
            transform: translateY(-1px);
        }

        .btn-add-cart {
            background: #8b7355;
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            color: white;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s;
        }

        .btn-add-cart svg {
            width: 18px;
            height: 18px;
            stroke: white;
            fill: none;
            stroke-width: 2;
        }

        .btn-add-cart:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }
.product-card {
    /* Menggunakan warna cokelat muda/tan dari home */
    background: #D9C19D; 
    border: none; /* Hilangkan border agar lebih clean seperti home */
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-8px);
    background: #E4D0B2; 
    /* Bayangan hitam yang lebih tegas di sekeliling kartu */
    box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.8), 0 15px 35px rgba(0, 0, 0, 0.2);
    border-color: transparent; /* Supaya tidak bertabrakan dengan shadow */
}
.product-card:active {
    transform: scale(0.96) translateY(-4px); /* Kartu seolah tertekan ke dalam */
    box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.9); /* Garis hitam jadi lebih tebal */
    transition: all 0.1s ease;
}
 .product-image-container {
    background: #FFFFFF;
    border-radius: 15px;
    padding: 10px;
    margin-bottom: 15px;
    height: 180px; /* Sedikit lebih pendek agar proporsional */
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
        .product-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        .product-info {
            text-align: center;
        }

        .product-name {
            font-size: 18px;
            font-weight: 600;
            color: #2c2c2c;
            margin-bottom: 8px;
        }

        .product-description {
            font-size: 13px;
            color: #6b6b6b;
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .product-price {
            font-size: 18px;
            color: #2c2c2c;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .product-actions {
            display: flex;
            justify-content: center;
            align-items: center;
        }
.btn-add-cart {
    background: #8B735B; /* Cokelat tua khas Toko Kue Kharisma */
    border: none;
    border-radius: 25px;
    padding: 10px 20px;
    color: white;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.3s;
    width: 100%; /* Agar tombol memenuhi lebar kartu */
}

.btn-add-cart:hover {
    background: #7A6652;
    transform: scale(1.02);
}
        .btn-add-cart svg {
            width: 18px;
            height: 18px;
            stroke: white;
            fill: none;
            stroke-width: 2;
        }

        .btn-add-cart:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        .btn-add-cart .loading {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-add-cart .loading::after {
            content: '';
            width: 16px;
            height: 16px;
            border: 2px solid #ffffff;
            border-top: 2px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Mobile Menu */
        .menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 0.3s, visibility 0.3s;
        }

        .menu-overlay.active {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        @media (max-width: 968px) {
            .hamburger {
                display: flex;
            }

            header {
                padding: 15px 20px;
            }

            .header-left {
                gap: 10px;
            }

            .btn-back {
                padding: 6px 12px;
                font-size: 14px;
            }

            .store-name {
                font-size: 20px;
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
                z-index: 1001;
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

            .menu-section {
                padding: 30px 20px;
            }

            .menu-grid {
                grid-template-columns: 1fr;
            }

            .header-icons {
                margin-left: auto;
                gap: 10px;
            }
        }

        @media (max-width: 480px) {
            .products-grid { grid-template-columns: repeat(2, 1fr); gap: 15px; }
            .menu-section { padding: 20px 15px; }
            .menu-title { font-size: 24px; }
        }
        .product-image {
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
    border-radius: 10px;
    transition: transform 0.5s ease; /* Tambahkan transisi ini */
}

.product-card:hover .product-image {
    transform: scale(1.1); /* Zoom in 10% */
}
.btn-add-cart {
    /* ... kode lama kamu ... */
    position: relative;
    overflow: hidden;
}

.btn-add-cart:hover {
    background: #5d4d3c;
    letter-spacing: 0.5px; /* Teks sedikit melebar */
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.btn-add-cart:active {
    transform: scale(0.95); /* Efek tertekan saat diklik */
}
.search-input {
    /* ... kode lama kamu ... */
    transition: all 0.3s ease;
}

.search-input:focus {
    border-color: #8b7355;
    box-shadow: 0 0 0 4px rgba(139, 115, 85, 0.2); /* Efek ring di sekitar input */
    max-width: 450px; /* Sedikit memanjang saat diketik */
}
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.product-card {
    animation: fadeInUp 0.6s ease backwards;
}

/* Memberikan jeda tiap kartu (Staggered Animation) */
.product-card:nth-child(1) { animation-delay: 0.1s; }
.product-card:nth-child(2) { animation-delay: 0.2s; }
.product-card:nth-child(3) { animation-delay: 0.3s; }
.product-card:nth-child(4) { animation-delay: 0.4s; }
        
.store-name {
    /* ... kode lama kamu ... */
    transition: all 0.3s ease;
    cursor: default;
    display: inline-block;
}

.store-name:hover {
    transform: skewX(-5deg); /* Sedikit miring gaya kaligrafi saat di-hover */
    text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
}
                                            
                                            /* Modal Detail Produk */
.modal {
    display: none;
    position: fixed;
    z-index: 2000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.7);
    backdrop-filter: blur(5px);
    align-items: center;
    justify-content: center;
}

.modal-content {
    background: #F3DEBA;
    padding: 30px;
    border-radius: 20px;
    width: 95%; 
    max-width: 750px; /* INI KUNCINYA: Diperlebar dari 600px ke 850px */
    position: relative;
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    display: flex;
    flex-direction: column;
    gap: 20px;
    animation: zoomIn 0.3s ease;
}

    @keyframes zoomIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}

.close-modal {
    position: absolute;
    right: 20px;
    top: 15px;
    font-size: 30px;
    cursor: pointer;
    color: #8b7355;
}

.modal-body {
    display: flex;
    gap: 20px;
}

@media (max-width: 600px) {
    .modal-body { flex-direction: column; }
}

/* Cari dan ganti .modal-img kamu dengan ini */
.modal-img {
    width: 300px; /* Ukuran gambar diperbesar sedikit */
    height: 300px;
    object-fit: cover;
    border-radius: 15px;
    flex-shrink: 0; /* Supaya gambar tidak mengecil saat teks banyak */
}
/* Pastikan deskripsi punya ruang yang cukup */
.product-description-text {
    color: #555;
    line-height: 1.6;
    text-align: justify;
    margin-bottom: 20px;
    min-height: 4.8em; /* Ini untuk memaksa minimal sekitar 3 baris */
    max-height: 6.4em; /* Ini untuk maksimal sekitar 4 baris */
    overflow: hidden;
}

/* Container baru untuk baris bawah */
.modal-footer-actions {
    display: flex;
    flex-direction: row; /* Berjejer ke samping */
    gap: 15px;
    align-items: center;
    border-top: 1px solid rgba(139, 115, 85, 0.1);
    padding-top: 20px;
}    


    </style>
</head>
<body>
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
                <button class="icon-btn" title="Keranjang" onclick="window.location.href='/cart'">
                    <svg viewBox="0 0 24 24">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    <span class="cart-badge" id="cartBadge">{{ $cartCount ?? 0 }}</span>
                </button>
                <span class="icon-label">Keranjang</span>
            </div>
            <div class="icon-wrapper">
                <button class="icon-btn" title="Profil" onclick="window.location.href='/login'">
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

    <!-- Menu Overlay -->
    <div class="menu-overlay" id="menuOverlay"></div>

    <!-- Menu Section -->
    <section class="menu-section">
        <div class="menu-header">
            <h1 class="menu-title">Menu Kue Kami</h1>
            <p class="menu-subtitle">Pilih kue tradisional favorit Anda</p>
        </div>

        <div class="table-controls">
            <input type="text" id="productSearch" class="search-input" placeholder="Cari produk..." autocomplete="off">
            <div class="pagination-info" id="paginationInfo">Menampilkan 0 produk</div>
        </div>

        <div class="products-grid" id="productsGrid"></div>

        <div class="pagination-buttons">
            <button id="prevPage" onclick="changePage(-1)" disabled>Prev</button>
            <button id="nextPage" onclick="changePage(1)" disabled>Next</button>
        </div>
    </section>

    <script>
        let cartCount = 0;

        // Hamburger Menu Toggle
        const hamburger = document.getElementById('hamburger');
        const navMenu = document.getElementById('navMenu');
        const menuOverlay = document.getElementById('menuOverlay');

        // Ensure menu is closed on page load
        document.addEventListener('DOMContentLoaded', function() {
            hamburger.classList.remove('active');
            navMenu.classList.remove('active');
            menuOverlay.classList.remove('active');
        });

        hamburger.addEventListener('click', function(e) {
            e.stopPropagation();
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

        // Add to Cart
        function addToCart(btn, productId, itemName, price) {
            // Pastikan productId adalah integer
            const id = parseInt(productId);
            if (isNaN(id)) {
                console.error('Invalid product ID:', productId);
                showNotification('ID produk tidak valid', 'error');
                return;
            }

            // Disable button temporarily
            btn.disabled = true;
            btn.innerHTML = '<span class="loading">Menambah...</span>';

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            console.log('Adding to cart from menu:', { productId: id, itemName, csrfToken });

            // AJAX request to add to cart
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken || '',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: id,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    // Update cart badge
                    document.getElementById('cartBadge').textContent = data.data.total_items;

                    // Show success notification
                    showNotification(`${itemName} berhasil ditambahkan ke keranjang!`, 'success');
                } else {
                    // Show error notification
                    console.error('Add to cart failed:', data.message);
                    showNotification(data.message || 'Gagal menambahkan ke keranjang', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
            })
            .finally(() => {
                // Re-enable button
                btn.disabled = false;
                btn.innerHTML = `
                    <svg viewBox="0 0 24 24">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    Keranjang
                `;
            });
        }

        // Notification System
        function showNotification(message, type = 'success') {
            const colors = {
                success: '#4caf50',
                error: '#f44336',
                warning: '#ff9800',
                info: '#2196f3'
            };

            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 100px;
                right: 30px;
                background: ${colors[type]};
                color: white;
                padding: 15px 25px;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.3);
                z-index: 10000;
                animation: slideIn 0.3s ease-out;
                font-weight: 600;
                max-width: 400px;
            `;

            const icon = type === 'success' ? '✓' : type === 'error' ? '✕' : 'ℹ';
            notification.innerHTML = `
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 18px;">${icon}</span>
                    <span>${message}</span>
                </div>
            `;

            const style = document.createElement('style');
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

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease-out';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }

        // View Cart
        function viewCart() {
            window.location.href = '/cart';
        }

        const menuProducts = {!! json_encode($products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'category' => $product->category,
                'image_url' => $product->image_url,
            ];
        })->toArray()) !!};
        let currentPage = 1;
        const perPage = 8;
        let filteredProducts = [...menuProducts];

        function formatCurrency(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(value);
        }

        function renderGrid() {
            const grid = document.getElementById('productsGrid');
            grid.innerHTML = '';

            const start = (currentPage - 1) * perPage;
            const pageItems = filteredProducts.slice(start, start + perPage);

            if (pageItems.length === 0) {
                grid.innerHTML = '<p style="text-align:center;color:#7a6c5b;padding:40px;grid-column:1/-1;">Tidak ada produk ditemukan.</p>';
            } else {
                pageItems.forEach(product => {
const card = document.createElement('div');
card.className = 'product-card';
card.innerHTML = `
    <div class="product-image-container" onclick="showDetail(${product.id})" style="cursor:pointer;">
        <img src="${product.image_url ?? '/images/products/default.jpg'}" alt="${product.name}" class="product-image">
    </div>
    <div class="product-info">
        <h3 class="product-name" onclick="showDetail(${product.id})" style="cursor:pointer;">${product.name}</h3>
        <p class="product-price">Rp ${Number(product.price).toLocaleString('id-ID')}</p>
        <div class="product-actions">
            <button class="btn-add-cart">
                <svg viewBox="0 0 24 24">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                Masukkan ke keranjang
            </button>
        </div>
    </div>
`;

                    const button = card.querySelector('.btn-add-cart');
                    button.addEventListener('click', function() {
                        addToCart(this, product.id, product.name, product.price);
                    });

                    grid.appendChild(card);
                });
            }

            const pageCount = Math.max(1, Math.ceil(filteredProducts.length / perPage));
            document.getElementById('paginationInfo').textContent = `Halaman ${currentPage} dari ${pageCount} · ${filteredProducts.length} produk`;
            document.getElementById('prevPage').disabled = currentPage <= 1;
            document.getElementById('nextPage').disabled = currentPage >= pageCount;
        }

        function changePage(direction) {
            const pageCount = Math.max(1, Math.ceil(filteredProducts.length / perPage));
            currentPage = Math.min(pageCount, Math.max(1, currentPage + direction));
            renderGrid();
        }

        function filterProducts() {
            const searchValue = document.getElementById('productSearch').value.trim().toLowerCase();
            filteredProducts = menuProducts.filter(product => {
                const searchData = `${product.name} ${product.description || ''} ${product.price}`.toLowerCase();
                return searchData.includes(searchValue);
            });
            currentPage = 1;
            renderGrid();
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('productSearch').addEventListener('input', filterProducts);
            renderGrid();
        });
                                            
function showDetail(productId) {
    const product = menuProducts.find(p => p.id === productId);
    if (!product) return;

    const modal = document.getElementById('productModal');
    const modalBody = document.getElementById('modalBody');

    // Kumpulan variasi kalimat promosi supaya tidak bosan
    const variasiTeks = [
        "Dibuat dengan resep rahasia keluarga Kharisma yang dijaga kemurniannya. Menggunakan bahan pilihan untuk tekstur yang pas di lidah.",
        "Camilan legendaris yang cocok menemani waktu santai Anda. Tanpa bahan pengawet dan dijamin fresh setiap hari langsung dari dapur kami.",
        "Menghadirkan cita rasa tradisional yang otentik dalam setiap gigitan. Sangat lembut, manisnya pas, dan bikin ketagihan siapa saja.",
        "Kue istimewa yang diproses secara higienis menggunakan bahan-bahan premium. Pilihan terbaik untuk hidangan acara keluarga atau arisan."
    ];

    // Pilih teks secara acak berdasarkan ID produk supaya konsisten tapi beda antar produk
    const indexAcak = productId % variasiTeks.length;
    const extraDesc = variasiTeks[indexAcak];

    // Gabungkan deskripsi asli database dengan teks acak tadi
    let descAsli = product.description || `${product.name} yang enak dan lezat.`;
    let fullDescription = `${descAsli} ${extraDesc}`;

    modalBody.innerHTML = `
        <img src="${product.image_url ?? '/images/products/default.jpg'}" class="modal-img">
        <div style="flex: 1; display: flex; flex-direction: column;">
            <h2 style="color: #2c2c2c; margin-bottom: 5px; font-size: 1.8rem;">${product.name}</h2>
            
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 10px; color: #777; font-size: 0.95rem;">
                <div style="display: flex; align-items: center; gap: 4px;">
                    <span style="color: #ff9800; font-size: 1.2rem;">★</span> 
                    <span style="font-weight: bold; color: #333;">4.8</span> 
                    <span>(2.2k ulasan)</span>
                </div>
                <div style="display: flex; align-items: center; gap: 6px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    <span>5.4k dilihat</span>
                </div>
            </div>

            <p style="color: #8b7355; font-weight: bold; font-size: 1.6rem; margin-bottom: 15px;">
                Rp ${Number(product.price).toLocaleString('id-ID')}
            </p>
            
            <div style="flex-grow: 1;">
                <h4 style="color: #4a4a4a; margin-bottom: 5px;">Deskripsi Produk:</h4>
                <p class="product-description-text" style="
                    color: #555; 
                    line-height: 1.6; 
                    text-align: justify; 
                    margin-bottom: 20px;
                    display: -webkit-box;
                    -webkit-line-clamp: 4;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                    min-height: 6.4em;
                ">
                    ${fullDescription}
                </p>
            </div>
            
            <div class="modal-footer-actions" style="display: flex; flex-direction: row; gap: 15px; align-items: center; border-top: 1px solid rgba(139, 115, 85, 0.1); padding-top: 20px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <label style="color: #555; font-weight: 600; white-space: nowrap;">Jumlah:</label>
                    <input type="number" id="detailQty" value="1" min="1" 
                        style="width: 70px; padding: 12px; border-radius: 12px; border: 1.5px solid #d4b896; text-align: center; background: white;">
                </div>
                <button class="btn-add-cart" style="flex: 1; padding: 15px; height: 50px;" 
                    onclick="closeModal(); addToCart(this, ${product.id}, '${product.name}', ${product.price})">
                    Tambah ke Keranjang
                </button>
            </div>
        </div>
    `;

    modal.style.display = 'flex';
}

function closeModal() {
    document.getElementById('productModal').style.display = 'none';
}

// Tutup modal jika klik di luar kotak putih
window.onclick = function(event) {
    const modal = document.getElementById('productModal');
    if (event.target == modal) {
        closeModal();
    }
}
    </script>
                                            <div id="productModal" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal()">&times;</span>
        <div class="modal-body" id="modalBody">
            </div>
    </div>
</div>
</body>
</html>
