<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Riwayat Pemesanan - Toko Kue Kharisma</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

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

        .header-left { display: flex; align-items: center; gap: 20px; }

        .btn-back {
            display: flex; align-items: center; gap: 10px;
            background: rgba(255,255,255,0.3); border: none;
            padding: 8px 15px; border-radius: 10px;
            color: #2c2c2c; font-size: 15px; font-weight: 600;
            cursor: pointer; transition: all 0.3s; text-decoration: none;
        }
        .btn-back:hover { background: rgba(255,255,255,0.5); transform: translateX(-3px); }
        .btn-back svg { width: 20px; height: 20px; stroke: #2c2c2c; fill: none; stroke-width: 2.5; }

        .store-name {
            font-family: 'Brush Script MT', cursive;
            font-size: 28px; color: #2c2c2c;
            font-style: italic; font-weight: bold;
        }

        .hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; padding: 10px; z-index: 1001; }
        .hamburger span { width: 30px; height: 3px; background: #4a4a4a; border-radius: 3px; transition: all 0.3s; }

        nav { display: flex; gap: 30px; align-items: center; transition: all 0.3s; }
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

        .header-icons { display: flex; gap: 20px; align-items: center; }
        .icon-wrapper { display: flex; flex-direction: column; align-items: center; gap: 3px; position: relative; }
        .icon-btn { background: none; border: none; cursor: pointer; color: #2c2c2c; transition: transform 0.2s; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; }
        .icon-btn svg { width: 26px; height: 26px; stroke: #2c2c2c; fill: none; stroke-width: 2; }
        .icon-label { font-size: 10px; color: #4a4a4a; font-weight: 600; }
        .cart-badge { position: absolute; top: -5px; right: -5px; background: #d32f2f; color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 11px; font-weight: bold; display: flex; align-items: center; justify-content: center; }

        /* Main */
        .riwayat-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 0 50px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 600;
            color: #2c2c2c;
            margin-bottom: 30px;
        }

        /* Order Card — sama dengan profile */
        .order-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 4px solid #8b7355;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .order-id { font-size: 16px; font-weight: 600; color: #2c2c2c; }

        .order-status {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-completed  { background: #4caf50; color: white; }
        .status-processing { background: #ff9800; color: white; }
        .status-pending    { background: #9e9e9e; color: white; }
        .status-cancelled  { background: #d32f2f; color: white; }

        .order-items { font-size: 14px; color: #6b6b6b; margin-bottom: 10px; }

        .order-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 10px;
            border-top: 1px solid #e0e0e0;
        }

        .order-date  { font-size: 13px; color: #8b7355; }
        .order-total { font-size: 16px; font-weight: 600; color: #2c2c2c; }

        .btn-review {
            margin-top: 12px;
            width: 100%;
            padding: 10px;
            background: #8b7355;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s;
        }
        .btn-review:hover { background: #6b5845; transform: translateY(-2px); }
        .btn-review svg { width: 16px; height: 16px; stroke: white; fill: none; stroke-width: 2; }

        /* Review Modal */
        .review-modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 1000; align-items: center; justify-content: center; }
        .review-modal.active { display: flex; }
        .review-modal-content { background: white; border-radius: 20px; padding: 35px 30px; max-width: 500px; width: 90%; max-height: 90vh; overflow-y: auto; box-shadow: 0 10px 40px rgba(0,0,0,0.3); }
        .review-modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .review-modal-title { font-size: 22px; font-weight: 600; color: #2c2c2c; }
        .btn-close-review { background: none; border: none; font-size: 26px; color: #8b7355; cursor: pointer; }
        .stars-input { display: flex; gap: 8px; font-size: 36px; margin-bottom: 20px; }
        .star { cursor: pointer; color: #e0e0e0; transition: color 0.2s; }
        .star.active { color: #ffd700; }
        .review-form-group { margin-bottom: 15px; }
        .review-form-group label { display: block; font-size: 14px; font-weight: 600; color: #4a4a4a; margin-bottom: 6px; }
        .review-form-control { width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 14px; color: #2c2c2c; transition: border-color 0.3s; font-family: Arial, sans-serif; }
        .review-form-control:focus { outline: none; border-color: #8b7355; }
        textarea.review-form-control { resize: vertical; min-height: 100px; }
        .btn-submit-review { width: 100%; background: #8b7355; color: white; border: none; padding: 14px; border-radius: 10px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s; margin-top: 10px; }
        .btn-submit-review:hover { background: #6b5845; }

        /* Mobile */
        .menu-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 999; }
        .menu-overlay.active { display: block; }

        @media (max-width: 768px) {
            header { padding: 15px 20px; }
            .riwayat-container { padding: 0 20px; }
            .hamburger { display: flex; }
            nav { position: fixed; top: 0; right: -100%; width: 300px; height: 100vh; background: linear-gradient(135deg, #d4b896 0%, #c9a882 100%); flex-direction: column; justify-content: flex-start; padding: 80px 30px 30px; box-shadow: -5px 0 15px rgba(0,0,0,0.2); z-index: 1000; }
            nav.active { right: 0; }
            nav a { font-size: 18px; padding: 15px 0; width: 100%; border-bottom: 1px solid rgba(74,74,74,0.2); }
            .order-header { flex-direction: column; align-items: flex-start; gap: 8px; }
            .header-icons { margin-left: auto; gap: 10px; }
        }

        @media (max-width: 480px) {
            .riwayat-container { padding: 0 15px; margin: 20px auto; }
            .page-title { font-size: 22px; }
            .order-card { padding: 15px; }
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
        <div class="hamburger" id="hamburger">
    <span></span>
    <span></span>
    <span></span>
</div>
<div class="menu-overlay" id="menuOverlay"></div>
        
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
        </div>
    </header>

    <!-- Main Content -->
    <div class="riwayat-container">
        <h1 class="page-title">Riwayat Pemesanan</h1>
        <div id="orderHistoryContainer">
        @forelse($orders as $order)
        <div class="order-card">
            <div class="order-header">
                <span class="order-id">#{{ $order->order_number }}</span>
                @php
                    $statusMap = [
                        'pending'     => ['label' => 'Menunggu Verifikasi', 'class' => 'status-pending'],
                        'paid'        => ['label' => 'Dibayar',             'class' => 'status-processing'],
                        'verified'    => ['label' => 'Diverifikasi',        'class' => 'status-processing'],
                        'in_progress' => ['label' => 'Diproses',            'class' => 'status-processing'],
                        'completed'   => ['label' => 'Selesai',             'class' => 'status-completed'],
                        'cancelled'   => ['label' => 'Dibatalkan',          'class' => 'status-cancelled'],
                    ];
                    $s = $statusMap[$order->status] ?? ['label' => ucfirst($order->status), 'class' => 'status-pending'];
                @endphp
                <span class="order-status {{ $s['class'] }}">{{ $s['label'] }}</span>
            </div>

            <div class="order-items">
                @foreach($order->orderItems as $item)
                    {{ $item->quantity }}x {{ $item->product->name ?? '-' }}<br>
                @endforeach
            </div>

            <div class="order-footer">
                <span class="order-date">{{ $order->created_at->format('d F Y') }}</span>
                <span class="order-total">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>

            @if($order->status === 'completed')
            @if(in_array($order->order_number, $reviewedOrders))
            <div style="margin-top:12px;padding:10px;background:#f5f5f0;border-radius:10px;text-align:center;font-size:14px;color:#8b7355;font-weight:600;">
                ✓ Sudah diberi ulasan
            </div>
            @else
            <button class="btn-review" onclick="openReviewModal('{{ $order->order_number }}')">
                <svg viewBox="0 0 24 24">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                </svg>
                Beri Ulasan
            </button>
            @endif
            @endif
        </div>
        @empty
        <div style="text-align:center;padding:60px 20px;background:white;border-radius:20px;">
            <svg viewBox="0 0 24 24" style="width:80px;height:80px;stroke:#d4b896;fill:none;stroke-width:1.5;margin-bottom:20px;">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <h3 style="font-size:20px;color:#2c2c2c;margin-bottom:10px;">Belum Ada Pesanan</h3>
            <p style="font-size:15px;color:#6b6b6b;margin-bottom:20px;">Anda belum memiliki riwayat pesanan</p>
            <button onclick="window.location.href='/menu'" style="background:#8b7355;color:white;border:none;padding:12px 30px;border-radius:25px;font-size:15px;font-weight:600;cursor:pointer;">Mulai Belanja</button>
        </div>
        @endforelse
        </div>
    </div>

    <script>
        // Hamburger Menu
        const hamburger = document.getElementById('hamburger');
        const navMenu = document.getElementById('navMenu');
        const menuOverlay = document.getElementById('menuOverlay');

        if (hamburger && navMenu && menuOverlay) {
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

        // Render order history from JSON response
        function renderOrderHistory(orders) {
            const container = document.getElementById('orderHistoryContainer');
            if (!container) {
                return;
            }

            if (!orders || orders.length === 0) {
                container.innerHTML = `
                    <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 20px;">
                        <svg viewBox="0 0 24 24" style="width: 80px; height: 80px; stroke: #d4b896; fill: none; stroke-width: 1.5; margin-bottom: 20px;">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        <h3 style="font-size: 20px; color: #2c2c2c; margin-bottom: 10px;">Belum Ada Pesanan</h3>
                        <p style="font-size: 15px; color: #6b6b6b; margin-bottom: 20px;">Anda belum memiliki riwayat pesanan</p>
                        <button onclick="window.location.href='/menu'" style="
                            background: #8b7355;
                            color: white;
                            border: none;
                            padding: 12px 30px;
                            border-radius: 25px;
                            font-size: 15px;
                            font-weight: 600;
                            cursor: pointer;
                        ">Mulai Belanja</button>
                    </div>
                `;
                return;
            }

            const markup = orders.map(order => {
                const step1Status = ['verified', 'in_progress', 'completed'].includes(order.status) ? 'completed' : (order.status === 'pending' ? 'active' : '');
                const step2Status = ['in_progress', 'completed'].includes(order.status) ? 'completed' : (order.status === 'verified' ? 'active' : '');
                const step3Status = order.status === 'completed' ? 'completed' : '';

                const step1Title = order.status === 'pending' ? 'Menunggu Verifikasi' : 'Pesanan telah diverifikasi';
                const step1Desc = order.status === 'pending' ? 'Bukti pembayaran sedang dicek admin' : 'Pesanan telah dikonfirmasi admin';
                const step2Title = order.status === 'in_progress' ? 'Pesanan sedang dibuat' : 'Pesanan sedang dibuat oleh penjual';
                const step3Title = order.status === 'completed' ? 'Pesanan telah diterima' : 'Pesanan selesai, menuju lokasi';
                const step3Desc = order.status === 'completed' ? 'Terima kasih telah berbelanja di toko kami!' : 'Pesanan akan segera dikirim ke alamat Anda';

                const itemsHtml = order.order_items.map(item => `${item.quantity}x ${item.name}`).join('<br>');

                return `
                    <div class="order-card">
                        <div class="order-header">
                            <div>
                                <div class="order-id">#${order.order_number}</div>
                                <div class="order-date">${order.created_at}</div>
                            </div>
                        </div>

                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-icon ${step1Status}">
                                    <svg viewBox="0 0 24 24">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                                <div class="timeline-content">
                                    <div class="timeline-title">${step1Title}</div>
                                    <div class="timeline-description">${step1Desc}</div>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-icon ${step2Status}">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                    </svg>
                                </div>
                                <div class="timeline-content">
                                    <div class="timeline-title">${step2Title}</div>
                                    <div class="timeline-description">Pesanan Anda sedang dalam proses pembuatan</div>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-icon ${step3Status}">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                    </svg>
                                </div>
                                <div class="timeline-content">
                                    <div class="timeline-title">${step3Title}</div>
                                    <div class="timeline-description">${step3Desc}</div>
                                </div>
                            </div>
                        </div>

                        <div class="order-items">
                            <div class="order-items-title">Detail Pesanan:</div>
                            <div class="order-items-list">${itemsHtml}</div>
                        </div>

                        <div class="order-total">
                            <span class="total-label">Total Pembayaran:</span>
                            <span class="total-amount">Rp ${Number(order.total).toLocaleString('id-ID')}</span>
                        </div>
                    </div>
                `;
            }).join('');

            container.innerHTML = markup;
        }

     

        // Load cart count on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateCartBadge();
        });
    </script>

    <!-- Review Modal -->
    <div class="review-modal" id="reviewModal">
        <div class="review-modal-content">
            <div class="review-modal-header">
                <h2 class="review-modal-title">Beri Ulasan</h2>
                <button class="btn-close-review" onclick="closeReviewModal()">×</button>
            </div>

            <p style="font-size:13px;color:#8b7355;margin-bottom:15px;" id="reviewOrderLabel"></p>

            <div>
                <label style="font-size:14px;font-weight:600;color:#4a4a4a;display:block;margin-bottom:8px;">Rating</label>
                <div class="stars-input" id="starsInput">
                    <span class="star" onclick="setRating(1)">★</span>
                    <span class="star" onclick="setRating(2)">★</span>
                    <span class="star" onclick="setRating(3)">★</span>
                    <span class="star" onclick="setRating(4)">★</span>
                    <span class="star" onclick="setRating(5)">★</span>
                </div>
                <input type="hidden" id="ratingValue" value="0">
            </div>

            <div class="review-form-group">
                <label for="reviewName">Nama</label>
                <input type="text" id="reviewName" class="review-form-control" placeholder="Nama Anda" value="{{ auth()->user()->name ?? '' }}">
            </div>

            <div class="review-form-group">
                <label for="reviewText">Ulasan</label>
                <textarea id="reviewText" class="review-form-control" placeholder="Ceritakan pengalaman Anda..."></textarea>
            </div>

            <button class="btn-submit-review" onclick="submitReview()">Kirim Ulasan</button>
        </div>
    </div>

    <script>
        let currentOrderNumber = '';

        function openReviewModal(orderNumber) {
            currentOrderNumber = orderNumber;
            document.getElementById('reviewOrderLabel').textContent = 'Pesanan #' + orderNumber;
            document.getElementById('reviewModal').classList.add('active');
        }

        function closeReviewModal() {
            document.getElementById('reviewModal').classList.remove('active');
            document.getElementById('reviewText').value = '';
            document.getElementById('ratingValue').value = '0';
            document.querySelectorAll('.star').forEach(s => s.classList.remove('active'));
            currentOrderNumber = '';
        }

        document.getElementById('reviewModal').addEventListener('click', function(e) {
            if (e.target === this) closeReviewModal();
        });

        function setRating(rating) {
            document.getElementById('ratingValue').value = rating;
            document.querySelectorAll('.star').forEach((star, i) => {
                star.classList.toggle('active', i < rating);
            });
        }

        function submitReview() {
            const rating = document.getElementById('ratingValue').value;
            const name   = document.getElementById('reviewName').value.trim();
            const review = document.getElementById('reviewText').value.trim();

            if (rating === '0') { alert('Silakan pilih rating terlebih dahulu!'); return; }
            if (!name)          { alert('Nama tidak boleh kosong.'); return; }
            if (!review)        { alert('Ulasan tidak boleh kosong.'); return; }

            const btn = document.querySelector('.btn-submit-review');
            btn.textContent = 'Mengirim...';
            btn.disabled = true;

            fetch('/reviews', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ name, rating: parseInt(rating), review, order_number: currentOrderNumber })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    closeReviewModal();
                    showNotif('Ulasan berhasil dikirim. Terima kasih!', 'success');
                } else {
                    showNotif(data.message || 'Gagal mengirim ulasan.', 'error');
                }
            })
            .catch(() => showNotif('Terjadi kesalahan, coba lagi.', 'error'))
            .finally(() => { btn.textContent = 'Kirim Ulasan'; btn.disabled = false; });
        }

        function showNotif(message, type) {
            const el = document.createElement('div');
            el.style.cssText = `position:fixed;top:100px;right:30px;background:${type==='success'?'#4caf50':'#f44336'};color:white;padding:15px 25px;border-radius:10px;box-shadow:0 5px 15px rgba(0,0,0,0.3);z-index:10000;font-weight:600;`;
            el.textContent = message;
            document.body.appendChild(el);
            setTimeout(() => el.remove(), 3500);
        }
    </script>
</body>
</html>
