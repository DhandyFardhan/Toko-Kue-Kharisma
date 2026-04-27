    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Keranjang Belanja - Toko Kue Kharisma</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: Arial, Helvetica, sans-serif;
                background: #f5deb3;
            }

            /* Header */
            header {
                background: linear-gradient(135deg, #d4b896 0%, #c9a882 100%);
                padding: 15px clamp(15px, 4vw, 50px);
                display: flex;
                justify-content: space-between;
                align-items: center;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                position: sticky;
                top: 0;
                z-index: 100;
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

            nav a {
                color: #4a4a4a;
                text-decoration: none;
                font-size: 15px;
                font-weight: 600;
                transition: color 0.3s;
            }

            nav a:hover {
                color: #2c2c2c;
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

            /* Cart Container */
            .cart-container {
                max-width: 1200px;
                margin: 50px auto;
                padding: 0 50px;
                display: grid;
                grid-template-columns: 1fr 400px;
                gap: 30px;
            }

            .cart-title {
                font-size: 28px;
                font-weight: 600;
                color: #2c2c2c;
                margin-bottom: 30px;
            }

            /* Cart Items */
            .cart-items {
                background: white;
                border-radius: 20px;
                padding: 30px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            }

            .empty-cart {
                text-align: center;
                padding: 60px 20px;
            }

            .empty-cart svg {
                width: 100px;
                height: 100px;
                stroke: #d4b896;
                fill: none;
                stroke-width: 1.5;
                margin-bottom: 20px;
            }

            .empty-cart-text {
                font-size: 18px;
                color: #8b7355;
                margin-bottom: 20px;
            }

            .btn-shop-now {
                background: #8b7355;
                color: white;
                border: none;
                padding: 12px 30px;
                border-radius: 25px;
                font-size: 15px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s;
            }

            .btn-shop-now:hover {
                background: #6b5845;
            }

            .cart-item {
                display: flex;
                gap: 20px;
                padding: 20px;
                border-bottom: 1px solid #f0f0f0;
                position: relative;
            }

            .cart-item:last-child {
                border-bottom: none;
            }

            .item-image {
                width: 100px;
                height: 100px;
                border-radius: 10px;
                object-fit: cover;
                background: #f5f5f0;
            }

            .item-details {
                flex: 1;
            }

            .item-name {
                font-size: 18px;
                font-weight: 600;
                color: #2c2c2c;
                margin-bottom: 5px;
            }

            .item-price {
                font-size: 16px;
                color: #8b7355;
                margin-bottom: 15px;
            }

            .item-controls {
                display: flex;
                align-items: center;
                gap: 15px;
            }

            .quantity-control {
                display: flex;
                align-items: center;
                gap: 10px;
                background: #f5f5f0;
                border-radius: 25px;
                padding: 5px 15px;
            }

            .qty-btn {
                background: none;
                border: none;
                font-size: 18px;
                font-weight: bold;
                color: #8b7355;
                cursor: pointer;
                width: 25px;
                height: 25px;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: color 0.3s;
            }

            .qty-btn:hover {
                color: #2c2c2c;
            }

            .qty-display {
                font-size: 16px;
                font-weight: 600;
                color: #2c2c2c;
                min-width: 30px;
                text-align: center;
            }

            .btn-remove {
                background: none;
                border: none;
                color: #d32f2f;
                font-size: 14px;
                font-weight: 600;
                cursor: pointer;
                transition: color 0.3s;
            }

            .btn-remove:hover {
                color: #b71c1c;
            }

            .item-subtotal {
                position: absolute;
                top: 20px;
                right: 20px;
                font-size: 18px;
                font-weight: 600;
                color: #2c2c2c;
            }

            /* Cart Summary */
            .cart-summary {
                background: linear-gradient(135deg, #d4b896 0%, #c9a882 100%);
                border-radius: 20px;
                padding: 30px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                height: fit-content;
                position: sticky;
                top: 100px;
            }

            .summary-title {
                font-size: 20px;
                font-weight: 600;
                color: #2c2c2c;
                margin-bottom: 20px;
            }

            .summary-row {
                display: flex;
                justify-content: space-between;
                margin-bottom: 15px;
                font-size: 15px;
                color: #4a4a4a;
            }

            .summary-row.total {
                padding-top: 15px;
                border-top: 2px solid rgba(44, 44, 44, 0.2);
                font-size: 18px;
                font-weight: 600;
                color: #2c2c2c;
            }

            .btn-checkout {
                width: 100%;
                background: #2c2c2c;
                color: white;
                border: none;
                padding: 15px;
                border-radius: 10px;
                font-size: 16px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s;
                margin-top: 20px;
            }

            .btn-checkout:hover {
                background: #000;
                transform: translateY(-2px);
            }

            .btn-continue {
                width: 100%;
                background: white;
                color: #2c2c2c;
                border: 2px solid #2c2c2c;
                padding: 12px;
                border-radius: 10px;
                font-size: 15px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s;
                margin-top: 10px;
            }

            .btn-continue:hover {
                background: #f5f5f0;
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

            /* Checkout Modal */
            .checkout-modal {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.6);
                z-index: 1000;
                align-items: center;
                justify-content: center;
                overflow-y: auto;
                padding: 20px;
            }

            .checkout-modal.active {
                display: flex;
            }

            .checkout-modal-content {
                background: white;
                border-radius: 20px;
                padding: 30px;
                max-width: 600px;
                width: 100%;
                max-height: 90vh;
                overflow-y: auto;
                position: relative;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
                animation: slideUp 0.3s ease-out;
            }

            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(50px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .checkout-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 25px;
                padding-bottom: 15px;
                border-bottom: 2px solid #f0f0f0;
            }

            .checkout-title {
                font-size: 24px;
                font-weight: 600;
                color: #2c2c2c;
            }

            .btn-close-modal {
                background: transparent;
                border: 2px solid #d1b47c;
                color: #4a4a4a;
                width: 40px;
                height: 40px;
                border-radius: 12px;
                font-size: 22px;
                line-height: 1;
                cursor: pointer;
                transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .btn-close-modal:hover {
                background: #d1b47c;
                color: white;
                transform: scale(1.05);
            }

            .checkout-section {
                margin-bottom: 25px;
            }

            .section-title-small {
                font-size: 16px;
                font-weight: 600;
                color: #2c2c2c;
                margin-bottom: 15px;
            }

            .form-group {
                margin-bottom: 15px;
            }

            .form-group label {
                display: block;
                font-size: 14px;
                font-weight: 600;
                color: #4a4a4a;
                margin-bottom: 8px;
            }

            .form-input {
                width: 100%;
                padding: 12px 15px;
                border: 2px solid #e0e0e0;
                border-radius: 10px;
                font-size: 14px;
                color: #2c2c2c;
                transition: border-color 0.3s;
                font-family: Arial, Helvetica, sans-serif;
            }

            .form-input:focus {
                outline: none;
                border-color: #8b7355;
            }

            .payment-methods {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }

            .payment-option {
                border: 2px solid #e0e0e0;
                border-radius: 10px;
                padding: 12px;
                cursor: pointer;
                transition: all 0.3s;
                display: flex;
                align-items: center;
            }

            .payment-option:hover {
                border-color: #8b7355;
                background: #f5f5f0;
            }

            .payment-option input[type="radio"] {
                margin-right: 10px;
                cursor: pointer;
            }

            .payment-option input[type="radio"]:checked + .payment-info {
                color: #8b7355;
                font-weight: 600;
            }

            .payment-info {
                display: flex;
                align-items: center;
                gap: 10px;
                flex: 1;
            }

            .payment-logo {
                width: 35px;
                height: 25px;
                border-radius: 5px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 11px;
                font-weight: bold;
            }

            .checkout-summary {
                background: #f5f5f0;
                padding: 15px;
                border-radius: 10px;
            }

            .checkout-alert {
                background: #fff4e5;
                border: 1px solid #f0c27b;
                color: #6b4f1d;
                padding: 15px;
                border-radius: 12px;
                margin-top: 15px;
                font-size: 14px;
                line-height: 1.5;
            }

            .checkout-summary .summary-row {
                display: flex;
                justify-content: space-between;
                margin-bottom: 10px;
                font-size: 14px;
                color: #4a4a4a;
            }

            .checkout-summary .summary-row.total {
                padding-top: 10px;
                border-top: 2px solid #e0e0e0;
                font-size: 18px;
                font-weight: 600;
                color: #2c2c2c;
                margin-bottom: 0;
            }

            .btn-submit-checkout {
                width: 100%;
                background: #8b7355;
                color: white;
                border: none;
                padding: 15px;
                border-radius: 10px;
                font-size: 16px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s;
                margin-top: 20px;
            }

            .btn-submit-checkout:hover {
                background: #6b5845;
                transform: translateY(-2px);
            }

            @media (max-width: 768px) {
                .payment-methods {
                    grid-template-columns: 1fr;
                }
            }

            /* Delete Confirmation Modal */
            .delete-modal {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.6);
                z-index: 1000;
                align-items: center;
                justify-content: center;
            }

            .delete-modal.active {
                display: flex;
            }

            .delete-modal-content {
                background: white;
                border-radius: 20px;
                padding: 40px;
                max-width: 400px;
                width: 90%;
                text-align: center;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
                animation: scaleIn 0.3s ease-out;
            }

            @keyframes scaleIn {
                from {
                    opacity: 0;
                    transform: scale(0.8);
                }
                to {
                    opacity: 1;
                    transform: scale(1);
                }
            }

            .delete-icon {
                width: 80px;
                height: 80px;
                margin: 0 auto 20px;
                background: #ffebee;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .delete-icon svg {
                width: 45px;
                height: 45px;
                stroke: #d32f2f;
                fill: none;
                stroke-width: 2.5;
            }

            .delete-title {
                font-size: 22px;
                font-weight: 600;
                color: #2c2c2c;
                margin-bottom: 10px;
            }

            .delete-message {
                font-size: 15px;
                color: #6b6b6b;
                margin-bottom: 25px;
                line-height: 1.5;
            }

            .delete-product-name {
                color: #d32f2f;
                font-weight: 600;
            }

            .delete-actions {
                display: flex;
                gap: 10px;
                justify-content: center;
            }

            .btn-cancel {
                flex: 1;
                background: #f5f5f0;
                color: #4a4a4a;
                border: none;
                padding: 12px 20px;
                border-radius: 10px;
                font-size: 15px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s;
            }

            .btn-cancel:hover {
                background: #e0e0e0;
            }

            .btn-confirm-delete {
                flex: 1;
                background: #d32f2f;
                color: white;
                border: none;
                padding: 12px 20px;
                border-radius: 10px;
                font-size: 15px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s;
            }

            .btn-confirm-delete:hover {
                background: #b71c1c;
                transform: translateY(-2px);
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

                .cart-container {
                    grid-template-columns: 1fr;
                    padding: 0 20px;
                }

                .cart-summary {
                    position: static;
                }

                .item-subtotal {
                    position: static;
                    margin-top: 10px;
                }

                .header-icons {
                    margin-left: auto;
                    gap: 10px;
                }
            }

            @media (max-width: 480px) {
                .cart-container { padding: 0 15px; margin: 20px auto; }
                .cart-items { padding: 20px 15px; }
                .cart-summary { padding: 20px 15px; }
                .item-name { font-size: 15px; }
                .checkout-modal-content { padding: 20px 15px; }
            }
        </style>
    </head>
    <body>
        <!-- Midtrans Snap Script -->
        @if(!config('midtrans.is_production'))
            <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
        @else
            <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
        @endif
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
                <a href="/">home</a>
                <a href="/menu">menu</a>
                <a href="/kontak">kontak</a>
                <a href="/promo">promo</a>
            </nav>

            <div class="header-icons">
                <div class="icon-wrapper">
                    <button class="icon-btn" title="Keranjang" onclick="window.location.href='/cart'">
                        <svg viewBox="0 0 24 24">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        <span class="cart-badge" id="cartBadge">{{ $totalItems }}</span>
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

        <!-- Cart Container -->
        <div class="cart-container">
            <!-- Cart Items -->
            <div class="cart-items">
                <h1 class="cart-title">Keranjang Belanja</h1>

                <div id="cartItemsContainer">
                    @forelse($cartItems as $item)
                    @php
                        // Handle package items (product_id 100-102)
                        $packageNames = [
                            100 => 'Paketan Hemat A',
                            101 => 'Paketan Hemat B',
                            102 => 'Paketan Hemat C'
                        ];
                        $isPackage = in_array($item->product_id, [100, 101, 102]);
                        $itemName = $isPackage ? $packageNames[$item->product_id] : $item->product->name;
                        $itemPrice = $item->price; // Gunakan harga yang disimpan di cart
                        $itemImage = $isPackage ? 'https://images.unsplash.com/photo-1571115177098-24ec42ed204d?w=200' : ($item->product->image_url ?? 'https://images.unsplash.com/photo-1621303837174-89787a7d4729?w=200');
                    @endphp
                    <div class="cart-item" data-id="{{ $item->product_id }}" data-price="{{ $itemPrice }}">
                        <img src="{{ $itemImage }}" alt="{{ $itemName }}" class="item-image">
                        <div class="item-details">
                            <h3 class="item-name">{{ $itemName }}</h3>
                            <p class="item-price">Rp {{ number_format($itemPrice, 0, ',', '.') }}</p>
                            <div class="item-controls">
                                <div class="quantity-control">
                                    <button class="qty-btn" onclick="decreaseQty({{ $item->product_id }})">−</button>
                                    <span class="qty-display" id="qty-{{ $item->product_id }}" onclick="editQty({{ $item->product_id }})">{{ $item->quantity }}</span>
                                    <button class="qty-btn" onclick="increaseQty({{ $item->product_id }})">+</button>
                                </div>
                                <button class="btn-remove" onclick="removeItem({{ $item->product_id }})">Hapus</button>
                            </div>
                        </div>
                        <div class="item-subtotal" id="subtotal-{{ $item->product_id }}">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                    </div>
                    @empty
                    <div class="empty-cart">
                        <svg viewBox="0 0 24 24">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        <p class="empty-cart-text">Keranjang belanja Anda masih kosong</p>
                        <button class="btn-shop-now" onclick="window.location.href='/menu'">Belanja Sekarang</button>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="cart-summary">
                <h2 class="summary-title">Ringkasan Belanja</h2>
                
                <div class="summary-row">
                    <span>Subtotal (<span id="totalItems">{{ $totalItems }}</span> item)</span>
                    <span id="subtotalAmount">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                </div>
                
                <div class="summary-row">
                    <span>Ongkos Kirim</span>
                    <span id="shippingCost">Rp 5.000</span>
                </div>

                <div class="summary-row">
                    <span>Diskon</span>
                    <span id="discount" style="color: #d32f2f;">- Rp 0</span>
                </div>

                <div class="summary-row total">
                    <span>Total</span>
                    <span id="totalAmount">Rp {{ number_format($totalPrice + 5000, 0, ',', '.') }}</span>
                </div>

                <button class="btn-checkout" onclick="showCheckoutModal()">Checkout</button>
                <button class="btn-continue" onclick="window.location.href='/menu'">Lanjut Belanja</button>
            </div>
        </div>

        <!-- Checkout Modal -->
        <div class="checkout-modal" id="checkoutModal">
    <div class="checkout-modal-content">
        <div class="checkout-header">
            <h2 class="checkout-title">Checkout</h2>
            <button class="btn-close-modal" onclick="closeCheckoutModal()">×</button>
        </div>

        <form id="checkoutForm" onsubmit="processCheckout(event)">
            @csrf
            <div class="checkout-section">
                <h3 class="section-title-small">Metode Pembayaran</h3>
                <div class="payment-methods">
                    <label class="payment-option">
                        <input type="radio" name="payment" value="qris" required checked>
                        <div class="payment-info">
                            <div class="payment-logo" style="background: #1a1919;">QR</div>
                            <span>QRIS</span>
                        </div>
                    </label>

                    <label class="payment-option">
                        <input type="radio" name="payment" value="cod" required>
                        <div class="payment-info">
                            <div class="payment-logo" style="background: #4caf50;">COD</div>
                            <span>Bayar di Tempat</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="checkout-section">
                
                <div class="form-group">
                    <label>Alamat Pengiriman</label>
                    <div style="padding: 10px; background: #f9f9f9; border-radius: 8px; border: 1px solid #eee; font-size: 0.9rem; color: #555;">
                        <strong>Dikirim ke:</strong><br>
                        {{ auth()->user()->address ?? 'Alamat belum diatur di profil' }}
                        <input type="hidden" name="address" value="{{ auth()->user()->address }}">
                    </div>
                    <small style="color: #888; font-size: 0.75rem; margin-top: 5px; display: block;">
                        Ingin ganti alamat? Ubah di menu <a href="/profile" style="color: #8b7355; text-decoration: underline;">Profil</a>
                    </small>
                </div>
                
                <div class="form-group">
                    <label>Catatan Pesanan (Opsional)</label>
                    <input type="text" class="form-input" name="notes" placeholder="Contoh: Titip di satpam / Jangan terlalu manis">
                </div>
            </div>

            <div class="checkout-summary">
                <div class="summary-row">
                    <span>Total Pembayaran</span>
                    <span id="finalAmountDisplay" style="font-weight: bold; color: #8b7355;">Rp {{ number_format($totalPrice + 5000, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="checkout-alert">
                ⚠️ etimasi waktu pemerosesan pesanan adalah 1-2hari. Terimakasih atas kesabaran dan kepercayaan Anda! 🙏
            </div>

            <button type="submit" class="btn-submit-checkout" id="submitPayment">Konfirmasi Pesanan</button>
        </form>
    </div>
</div>

       <div class="delete-modal" id="deleteModal">
    <div class="delete-modal-content">
        <img id="deleteProductImage" src="" style="width: 80px; margin-bottom: 10px; display: none;">
        <h3 class="delete-title">Hapus <span id="deleteProductName"></span>?</h3>
        <p class="delete-message">Apakah Anda yakin ingin menghapus <span id="deleteProductQty"></span> item ini?</p>
        <div class="delete-actions">
            <button class="btn-cancel" onclick="closeDeleteModal()">Batal</button>
            <button class="btn-confirm-delete" onclick="confirmDelete()">Ya, Hapus</button>
        </div>
    </div>
</div>

        <script>
            let itemToDelete = null;

            // CSRF Token untuk AJAX
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

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

            // AJAX Helper Function
            function makeAjaxRequest(url, method = 'POST', data = {}) {
                return fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: method !== 'GET' ? JSON.stringify(data) : undefined
                })
                .then(response => response.json())
                .catch(error => {
                    console.error('AJAX Error:', error);
                    showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
                    return { success: false };
                });
            }

            // Increase Quantity
            function increaseQty(productId) {
                const currentQty = parseInt(document.getElementById(`qty-${productId}`).textContent);
                updateCartItem(productId, currentQty + 1);
            }

            // Decrease Quantity
            function decreaseQty(productId) {
                const currentQty = parseInt(document.getElementById(`qty-${productId}`).textContent);
                if (currentQty > 1) {
                    updateCartItem(productId, currentQty - 1);
                }
            }

            // Update Cart Item via AJAX
            function updateCartItem(productId, quantity) {
                makeAjaxRequest('/cart/update', 'POST', {
                    product_id: productId,
                    quantity: quantity
                })
                .then(response => {
                    if (response.success) {
                        // Update UI
                        document.getElementById(`qty-${productId}`).textContent = quantity;

                        // Update subtotal
                        const itemElement = document.querySelector(`[data-id="${productId}"]`);
                        const price = parseInt(itemElement.getAttribute('data-price'));
                        const subtotal = quantity * price;
                        document.getElementById(`subtotal-${productId}`).textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;

                        // jika response data tersedia, update summary dari server
                        if (response.data) {
                            updateCartSummary(response.data);
                        } else {
                            recalcCartTotals();
                        }

                        showNotification('Keranjang berhasil diperbarui', 'success');
                    } else {
                        showNotification(response.message || 'Gagal memperbarui keranjang', 'error');
                    }
                })
                .catch(error => {
                    console.error('Update error:', error);
                    showNotification('Terjadi kesalahan saat memperbarui keranjang', 'error');
                });
            }

            function updateCartSummary(data) {
                if (!data) {
                    recalcCartTotals();
                    return;
                }

                const totalItems = data.total_items || 0;
                const totalPrice = data.total_price || 0;
                const shipping = 5000;
                const discountText = document.getElementById('discount')?.textContent || '0';
                const discountAmount = parseInt(discountText.replace(/[^0-9]/g, '')) || 0;
                const total = totalPrice + shipping - discountAmount;

                document.getElementById('totalItems').textContent = totalItems;
                document.getElementById('cartBadge').textContent = totalItems;
                document.getElementById('subtotalAmount').textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;
                document.getElementById('totalAmount').textContent = `Rp ${total.toLocaleString('id-ID')}`;
            }

            function recalcCartTotals() {
                const cartItems = document.querySelectorAll('.cart-item');
                let totalItems = 0;
                let totalPrice = 0;

                cartItems.forEach(item => {
                    const qty = parseInt(item.querySelector('.qty-display').textContent) || 0;
                    const price = parseInt(item.getAttribute('data-price')) || 0;
                    totalItems += qty;
                    totalPrice += qty * price;
                });

                const shipping = 5000;
                const discountText = document.getElementById('discount')?.textContent || '0';
                const discountAmount = parseInt(discountText.replace(/[^0-9]/g, '')) || 0;
                const total = totalPrice + shipping - discountAmount;

                document.getElementById('totalItems').textContent = totalItems;
                document.getElementById('cartBadge').textContent = totalItems;
                document.getElementById('subtotalAmount').textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;
                document.getElementById('totalAmount').textContent = `Rp ${total.toLocaleString('id-ID')}`;
            }

            function editQty(productId) {
                const qtyDisplay = document.getElementById(`qty-${productId}`);
                const currentQty = parseInt(qtyDisplay.textContent);
                const input = document.createElement('input');

                input.type = 'number';
                input.min = '1';
                input.value = currentQty;
                input.style.width = '50px';
                input.style.textAlign = 'center';
                input.style.border = '1px solid #ccc';
                input.style.borderRadius = '6px';
                input.style.padding = '2px 4px';

                function commitQty() {
                    const newQty = parseInt(input.value);
                    if (!newQty || newQty < 1) {
                        showNotification('Jumlah tidak boleh kurang dari 1', 'error');
                        qtyDisplay.textContent = currentQty;
                    } else if (newQty !== currentQty) {
                        updateCartItem(productId, newQty);
                    } else {
                        qtyDisplay.textContent = currentQty;
                    }

                    input.remove();
                }

                input.addEventListener('blur', commitQty);
                input.addEventListener('keydown', event => {
                    if (event.key === 'Enter') {
                        commitQty();
                    } else if (event.key === 'Escape') {
                        qtyDisplay.textContent = currentQty;
                        input.remove();
                    }
                });

                qtyDisplay.textContent = '';
                qtyDisplay.appendChild(input);
                input.focus();
                input.select();
            }

            // Remove Item
            function removeItem(productId) {
                const itemElement = document.querySelector(`[data-id="${productId}"]`);
                if (!itemElement) return;

                const productName = itemElement.querySelector('.item-name')?.textContent || '';
                const quantity = itemElement.querySelector('.qty-display')?.textContent || '1';
                const imageUrl = itemElement.querySelector('.item-image')?.src || '';

                itemToDelete = productId;

                document.getElementById('deleteProductName').textContent = productName;
                document.getElementById('deleteProductQty').textContent = quantity;

                const img = document.getElementById('deleteProductImage');
                if (imageUrl) {
                    img.src = imageUrl;
                    img.style.display = 'block';
                } else {
                    img.style.display = 'none';
                }

                document.getElementById('deleteModal').classList.add('active');
            }

            function closeDeleteModal() {
                document.getElementById('deleteModal').classList.remove('active');
                itemToDelete = null;
            }

            function confirmDelete() {
                if (itemToDelete) {
                    makeAjaxRequest('/cart/remove', 'POST', {
                        product_id: itemToDelete
                    })
                    .then(response => {
                        if (response.success) {
                            // Remove item from UI immediately with animation
                            const itemElement = document.querySelector(`[data-id="${itemToDelete}"]`);
                            if (itemElement) {
                                itemElement.style.transition = 'all 0.3s ease-out';
                                itemElement.style.opacity = '0';
                                itemElement.style.transform = 'translateX(-100%)';

                                setTimeout(() => {
                                    itemElement.remove();
                                }, 300);
                            }

                            // Update cart summary
                            updateCartSummary(response.data);

                            // Tutup modal setelah berhasil dihapus
                            closeDeleteModal();

                            // Check if cart is now empty after animation
                            setTimeout(() => {
                                const remainingItems = document.querySelectorAll('.cart-item');
                                if (remainingItems.length === 0) {
                                    showEmptyCart();
                                }
                            }, 350);

                            showNotification('Produk berhasil dihapus dari keranjang', 'success');
                        } else {
                            showNotification(response.message || 'Gagal menghapus produk', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Remove error:', error);
                        showNotification('Terjadi kesalahan saat menghapus produk', 'error');
                    });
                }
            }

            // Show Empty Cart
            function showEmptyCart() {
                document.getElementById('cartItemsContainer').innerHTML = `
                    <div class="empty-cart">
                        <svg viewBox="0 0 24 24">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        <p class="empty-cart-text">Keranjang belanja Anda masih kosong</p>
                        <button class="btn-shop-now" onclick="window.location.href='/menu'">Belanja Sekarang</button>
                    </div>
                `;
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

            // Close modal when clicking outside
            document.getElementById('deleteModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeDeleteModal();
                }
            });

            // Checkout
            function checkout() {
                // Check if user is logged in (simulate with localStorage)
                const isLoggedIn = localStorage.getItem('isLoggedIn');
                
                if (!isLoggedIn) {
                    // Show login required modal
                    showLoginRequiredModal();
                } else {
                    // Show checkout modal
                    showCheckoutModal();
                }
            }

          function showCheckoutModal() {
    // 1. Ambil nilai subtotal dari ringkasan belanja
    const subtotalElement = document.getElementById('subtotalAmount');
    if (!subtotalElement) return;

    const subtotal = parseInt(subtotalElement.textContent.replace(/[^0-9]/g, ''));
    
    // 2. Update display di dalam modal (Gunakan ID yang benar: finalAmountDisplay)
    const displayElement = document.getElementById('finalAmountDisplay');
    if (displayElement) {
        displayElement.textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
    }

    // 3. Tampilkan modal
    const modal = document.getElementById('checkoutModal');
    if (modal) {
        modal.classList.add('active');
    }
}

// Tambahkan pengecekan login yang lebih aman untuk Laravel
function checkout() {
    // Karena kamu pakai middleware 'auth' di Laravel, 
    // sebenarnya modal ini hanya akan muncul jika user sudah login.
    showCheckoutModal();
}

            function closeCheckoutModal() {
                document.getElementById('checkoutModal').classList.remove('active');
            }

            // Close modal when clicking outside
            document.getElementById('checkoutModal')?.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeCheckoutModal();
                }
            });

            function processCheckout(event) {
                event.preventDefault();
                
                const formData = new FormData(event.target);
                const paymentMethod = formData.get('payment');
                
                // Close checkout modal
                closeCheckoutModal();
                
                // Show payment instruction modal
                showPaymentInstructionModal(paymentMethod, formData);
            }

            function showPaymentInstructionModal(paymentMethod, formData) {
                const modal = document.createElement('div');
                modal.id = 'paymentInstructionModal';
                modal.style.cssText = `
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.6);
                    z-index: 10000;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    overflow-y: auto;
                    padding: 20px;
                `;

                const paymentInfo = getPaymentInfo(paymentMethod);
                const total = parseInt(document.getElementById('totalAmount').textContent.replace(/[^0-9]/g, ''));

                modal.innerHTML = `
                    <div style="
                        background: white;
                        border-radius: 20px;
                        padding: 30px;
                        max-width: 500px;
                        width: 100%;
                        max-height: 90vh;
                        overflow-y: auto;
                        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
                        animation: slideUp 0.3s ease-out;
                    ">
                        <div style="text-align: center; margin-bottom: 25px;">
                            <div style="
                                width: 80px;
                                height: 80px;
                                margin: 0 auto 15px;
                                background: ${paymentInfo.color};
                                border-radius: 50%;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                color: white;
                                font-size: 32px;
                                font-weight: bold;
                            ">${paymentInfo.icon}</div>
                            <h3 style="font-size: 22px; font-weight: 600; color: #2c2c2c; margin-bottom: 5px;">
                                ${paymentInfo.name}
                            </h3>
                            <p style="font-size: 14px; color: #6b6b6b;">
                                Total Pembayaran: <strong style="color: #8b7355;">Rp ${total.toLocaleString('id-ID')}</strong>
                            </p>
                        </div>

                        ${paymentInfo.instruction}

                        ${paymentMethod !== 'cod' ? `
                            <div style="background: #f5f5f0; padding: 20px; border-radius: 10px; margin: 20px 0;">
                                <h4 style="font-size: 14px; font-weight: 600; color: #2c2c2c; margin-bottom: 15px;">
                                    ${paymentMethod === 'qris' ? 'Pembayaran QRIS (Midtrans Sandbox)' : 'Upload Bukti Pembayaran'}
                                </h4>
                                ${paymentMethod === 'qris' ? `
                                    <p style="font-size: 13px; color: #4a4a4a; line-height: 1.6;">
                                        Setelah klik tombol di bawah, sistem akan membuka QRIS asli dari Midtrans (Sandbox).<br>
                                        Status order akan otomatis berubah menjadi <strong>PAID</strong> setelah Midtrans mengirim webhook.
                                    </p>
                                ` : `
                                    <input type="file" id="proofFile" accept="image/*" style="
                                        width: 100%;
                                        padding: 10px;
                                        border: 2px dashed #8b7355;
                                        border-radius: 10px;
                                        cursor: pointer;
                                        font-size: 14px;
                                    " required>
                                    <p style="font-size: 12px; color: #6b6b6b; margin-top: 8px;">
                                        Format: JPG, PNG (Max 5MB)
                                    </p>
                                `}
                            </div>

                            <button onclick="submitPaymentProof('${paymentMethod}', ${total})" style="
                                width: 100%;
                                background: #8b7355;
                                color: white;
                                border: none;
                                padding: 15px;
                                border-radius: 10px;
                                font-size: 16px;
                                font-weight: 600;
                                cursor: pointer;
                                margin-bottom: 10px;
                            ">${paymentMethod === 'qris' ? 'Bayar dengan QRIS' : 'Kirim Bukti Pembayaran'}</button>
                        ` : `
                            <button onclick="submitPaymentProof('${paymentMethod}', ${total})" style="
                                width: 100%;
                                background: #8b7355;
                                color: white;
                                border: none;
                                padding: 15px;
                                border-radius: 10px;
                                font-size: 16px;
                                font-weight: 600;
                                cursor: pointer;
                                margin-bottom: 10px;
                            ">Konfirmasi Pesanan</button>
                        `}
                        
                        <button onclick="document.getElementById('paymentInstructionModal').remove()" style="
                            width: 100%;
                            background: white;
                            color: #4a4a4a;
                            border: 2px solid #e0e0e0;
                            padding: 12px;
                            border-radius: 10px;
                            font-size: 15px;
                            font-weight: 600;
                            cursor: pointer;
                        ">Batal</button>
                    </div>
                `;

                document.body.appendChild(modal);
            }
            

            function getPaymentInfo(method) {
                const info = {
                    'qris': {
                        name: 'QRIS',
                        icon: 'QR',
                        color: '#8b7355',
                        instruction: `
                            <div style="background: #f5f5f0; padding: 20px; border-radius: 10px; margin-bottom: 20px;">
                                <h4 style="font-size: 14px; font-weight: 600; color: #2c2c2c; margin-bottom: 15px;">
                                    Cara Pembayaran:
                                </h4>
                                <ol style="padding-left: 20px; font-size: 14px; color: #4a4a4a; line-height: 1.8;">
                                    <li>Buka aplikasi pembayaran Anda</li>
                                    <li>Pilih menu "Scan" atau "Bayar"</li>
                                    <li>Klik tombol <strong>Bayar dengan QRIS</strong>, lalu scan QR yang muncul dari Midtrans</li>
                                </ol>
                                <div style="margin-top: 12px; font-size: 13px; color: #6b6b6b; line-height: 1.6;">
                                    QRIS akan tampil di popup Midtrans (Sandbox). Setelah pembayaran berhasil, status pesanan akan otomatis berubah menjadi <strong>PAID</strong>.
                                </div>
                            </div>
                        `
                    },
                    'cod': {
                        name: 'Bayar di Tempat (COD)',
                        icon: 'COD',
                        color: '#4caf50',
                        instruction: `
                            <div style="background: #e8f5e9; padding: 20px; border-radius: 10px; margin-bottom: 20px; border-left: 4px solid #4caf50;">
                                <h4 style="font-size: 14px; font-weight: 600; color: #2c2c2c; margin-bottom: 15px;">
                                    Bayar di Tempat (COD)
                                </h4>
                                <p style="font-size: 14px; color: #4a4a4a; line-height: 1.8; margin-bottom: 15px;">
                                    Anda memilih pembayaran tunai saat pesanan diterima. Pastikan uang pas sesuai total pembayaran.
                                </p>
                                <div style="background: #e8f5e9; padding: 15px; border-radius: 10px; border-left: 4px solid #4caf50;">
                                    <p style="font-size: 13px; color: #2c2c2c; line-height: 1.6;">
                                        <strong>Catatan:</strong> Untuk COD, tidak perlu upload bukti pembayaran. Pesanan akan langsung diproses.
                                    </p>
                                </div>
                            </div>
                        `,
                    },
                    'bank_transfer': {
                        name: 'Transfer Bank Manual',
                        icon: '🏦',
                        color: '#2196F3',
                        instruction: `
                            <div style="background: #e3f2fd; padding: 20px; border-radius: 10px; margin-bottom: 20px; border-left: 4px solid #2196F3;">
                                <h4 style="font-size: 14px; font-weight: 600; color: #2c2c2c; margin-bottom: 15px;">
                                    Transfer Bank Manual
                                </h4>
                                <div style="background: #fff3cd; padding: 15px; border-radius: 10px; margin-bottom: 15px; border-left: 4px solid #ffc107;">
                                    <p style="font-size: 13px; color: #856404; line-height: 1.6; margin-bottom: 10px;">
                                        <strong>📍 Rekening Tujuan:</strong><br>
                                        Bank: <strong>BCA</strong><br>
                                        No. Rekening: <strong>1234567890</strong><br>
                                        Atas Nama: <strong>Toko Kue Kharisma</strong>
                                    </p>
                                </div>
                                <ol style="padding-left: 20px; font-size: 14px; color: #4a4a4a; line-height: 1.8;">
                                    <li>Transfer ke rekening BCA di atas</li>
                                    <li>Simpan bukti transfer (screenshot/foto)</li>
                                    <li>Upload bukti di halaman berikutnya</li>
                                    <li>Admin akan verifikasi pembayaran Anda</li>
                                </ol>
                            </div>
                        `
                    }
                };

                return info[method] || info['qris'];
            }

            async function submitPaymentProof(paymentMethod, total) {
                const fileInput = document.getElementById('proofFile');
                
                // Untuk bank transfer: wajib upload bukti.
                // Untuk QRIS Midtrans: tidak perlu upload file sama sekali.
                if (paymentMethod === 'bank_transfer' && (!fileInput || !fileInput.files[0])) {
                    showWarningModal();
                    return;
                }

                const btn = event.target;
                btn.textContent = 'Mengirim...';
                btn.disabled = true;

                // Ambil catatan dari form checkout
                const notes = document.querySelector('#checkoutForm textarea[name="notes"]')?.value || '';

                try {
                    // 1) Buat order dulu
                    const checkoutRes = await fetch('/checkout', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            payment_method: paymentMethod,
                            notes: notes,
                        }),
                    });

                    let checkoutData;
                    try {
                        checkoutData = await checkoutRes.json();
                    } catch (err) {
                        btn.textContent = paymentMethod === 'qris' ? 'Bayar dengan QRIS' : (paymentMethod === 'cod' ? 'Konfirmasi Pesanan' : 'Kirim Bukti Pembayaran');
                        btn.disabled = false;
                        showNotification('Server error. Pastikan Midtrans library sudah di-install dan key sudah diisi.', 'error');
                        return;
                    }

                    if (!checkoutData.success) {
                        if (checkoutData.require_address) {
                            btn.textContent = paymentMethod === 'cod' ? 'Konfirmasi Pesanan' : 'Kirim Bukti Pembayaran';
                            btn.disabled = false;
                            const instrModal = document.getElementById('paymentInstructionModal');
                            if (instrModal) instrModal.remove();
                            closeCheckoutModal();
                            showAddressRequiredModal();
                            return;
                        }

                        btn.textContent = paymentMethod === 'qris' ? 'Bayar dengan QRIS' : (paymentMethod === 'cod' ? 'Konfirmasi Pesanan' : 'Kirim Bukti Pembayaran');
                        btn.disabled = false;
                        showNotification(checkoutData.message || 'Gagal membuat pesanan', 'error');
                        return;
                    }

                    // 2) Kalau bank transfer: arahkan ke halaman upload bukti yang benar (form lengkap)
                    if (paymentMethod === 'bank_transfer' && checkoutData.redirect) {
                        window.location.href = checkoutData.redirect;
                        return;
                    }

                    // 3) QRIS Midtrans: buka Snap (QRIS asli dari Midtrans Sandbox)
                    if (paymentMethod === 'qris') {
                        if (!checkoutData.snap_token) {
                            btn.textContent = 'Bayar dengan QRIS';
                            btn.disabled = false;
                            showNotification(checkoutData.message || 'Gagal membuat transaksi Midtrans', 'error');
                            return;
                        }

                        if (!window.snap || typeof window.snap.pay !== 'function') {
                            btn.textContent = 'Bayar dengan QRIS';
                            btn.disabled = false;
                            showNotification('Snap Midtrans belum termuat. Refresh halaman dan coba lagi.', 'error');
                            return;
                        }

                        btn.textContent = 'Membuka QRIS...';

                        window.snap.pay(checkoutData.snap_token, {
                            onSuccess: function () {
                                showNotification('Pembayaran berhasil. Menunggu webhook Midtrans...', 'success');
                            },
                            onPending: function () {
                                showNotification('Menunggu pembayaran...', 'info');
                            },
                            onError: function () {
                                showNotification('Pembayaran gagal. Silakan coba lagi.', 'error');
                            },
                            onClose: function () {
                                btn.textContent = 'Bayar dengan QRIS';
                                btn.disabled = false;
                            },
                        });
                        return;
                    }

                    // 4) UI cleanup + sukses modal (sesuai logic lama)
                    const instrModal = document.getElementById('paymentInstructionModal');
                    if (instrModal) instrModal.remove();

                    const badge = document.getElementById('cartBadge');
                    if (badge) badge.textContent = '0';

                    const cartContainer = document.getElementById('cartItemsContainer');
                    if (cartContainer) {
                        cartContainer.innerHTML = `
                            <div class="empty-cart">
                                <svg viewBox="0 0 24 24">
                                    <circle cx="9" cy="21" r="1"></circle>
                                    <circle cx="20" cy="21" r="1"></circle>
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                </svg>
                                <p class="empty-cart-text">Keranjang belanja Anda masih kosong</p>
                                <button class="btn-shop-now" onclick="window.location.href='/menu'">Belanja Sekarang</button>
                            </div>
                        `;
                    }

                    const totalItems = document.getElementById('totalItems');
                    const subtotalAmount = document.getElementById('subtotalAmount');
                    const totalAmount = document.getElementById('totalAmount');
                    if (totalItems) totalItems.textContent = '0';
                    if (subtotalAmount) subtotalAmount.textContent = 'Rp 0';
                    if (totalAmount) totalAmount.textContent = 'Rp 5.000';

                    showSuccessOrderModal(paymentMethod, total, checkoutData.order_number, checkoutData);
                } catch (e) {
                    btn.textContent = paymentMethod === 'qris' ? 'Bayar dengan QRIS' : (paymentMethod === 'cod' ? 'Konfirmasi Pesanan' : 'Kirim Bukti Pembayaran');
                    btn.disabled = false;
                    showNotification('Terjadi kesalahan: ' + (e?.message || 'unknown'), 'error');
                }
            }

            function showWarningModal() {
                const modal = document.createElement('div');
                modal.id = 'warningModal';
                modal.style.cssText = `
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.6);
                    z-index: 10001;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    animation: fadeIn 0.3s ease-out;
                `;

                modal.innerHTML = `
                    <div style="
                        background: white;
                        border-radius: 20px;
                        padding: 40px;
                        max-width: 400px;
                        width: 90%;
                        text-align: center;
                        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
                        animation: shakeAndScale 0.5s ease-out;
                    ">
                        <div style="
                            width: 80px;
                            height: 80px;
                            margin: 0 auto 20px;
                            background: #fff3e0;
                            border-radius: 50%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            animation: pulse 1.5s infinite;
                        ">
                            <svg viewBox="0 0 24 24" style="width: 50px; height: 50px; stroke: #ff9800; fill: none; stroke-width: 2.5;">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                        </div>
                        <h3 style="font-size: 22px; font-weight: 600; color: #2c2c2c; margin-bottom: 10px;">
                            Bukti Pembayaran Diperlukan
                        </h3>
                        <p style="font-size: 15px; color: #6b6b6b; margin-bottom: 25px; line-height: 1.6;">
                            Silakan upload bukti pembayaran terlebih dahulu agar pesanan Anda dapat diproses.
                        </p>
                        <div style="background: #fff3e0; padding: 15px; border-radius: 10px; margin-bottom: 25px; border-left: 4px solid #ff9800;">
                            <p style="font-size: 13px; color: #2c2c2c; line-height: 1.6; text-align: left;">
                                <strong>Tips:</strong><br>
                                • Pastikan foto bukti transfer jelas<br>
                                • Format: JPG atau PNG<br>
                                • Ukuran maksimal 5MB
                            </p>
                        </div>
                        <button onclick="document.getElementById('warningModal').remove(); document.getElementById('proofFile').click();" style="
                            width: 100%;
                            background: #ff9800;
                            color: white;
                            border: none;
                            padding: 14px;
                            border-radius: 25px;
                            font-size: 16px;
                            font-weight: 600;
                            cursor: pointer;
                            transition: all 0.3s;
                            margin-bottom: 10px;
                        " onmouseover="this.style.background='#f57c00'; this.style.transform='translateY(-2px)'" 
                        onmouseout="this.style.background='#ff9800'; this.style.transform='translateY(0)'">
                            Upload Bukti Sekarang
                        </button>
                        <button onclick="document.getElementById('warningModal').remove()" style="
                            width: 100%;
                            background: white;
                            color: #4a4a4a;
                            border: 2px solid #e0e0e0;
                            padding: 12px;
                            border-radius: 25px;
                            font-size: 15px;
                            font-weight: 600;
                            cursor: pointer;
                            transition: all 0.3s;
                        " onmouseover="this.style.background='#f5f5f0'" 
                        onmouseout="this.style.background='white'">
                            Tutup
                        </button>
                    </div>
                `;

                // Add animations
                const style = document.createElement('style');
                style.textContent = `
                    @keyframes fadeIn {
                        from { opacity: 0; }
                        to { opacity: 1; }
                    }
                    @keyframes shakeAndScale {
                        0% { opacity: 0; transform: scale(0.8) translateY(20px); }
                        50% { transform: scale(1.05) translateY(0); }
                        60% { transform: scale(0.95) rotate(-2deg); }
                        70% { transform: scale(1.02) rotate(2deg); }
                        80% { transform: scale(0.98) rotate(-1deg); }
                        100% { opacity: 1; transform: scale(1) rotate(0); }
                    }
                    @keyframes pulse {
                        0%, 100% { transform: scale(1); }
                        50% { transform: scale(1.1); }
                    }
                `;
                document.head.appendChild(style);

                document.body.appendChild(modal);

                // Close on outside click
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        modal.remove();
                    }
                });
            }

            function showSuccessOrderModal(paymentMethod, total, orderNumber, data) {
                // Jika bank_transfer, langsung redirect
                if (paymentMethod === 'bank_transfer' && data && data.redirect) {
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1500);
                }

                const modal = document.createElement('div');
                modal.style.cssText = `
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.6);
                    z-index: 10000;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                `;

                const paymentName = {
                    'qris': 'QRIS',
                    'cod': 'Cash on Delivery (COD)',
                    'bank_transfer': 'Transfer Bank',
                };

                modal.innerHTML = `
                    <div style="
                        background: white;
                        border-radius: 20px;
                        padding: 40px;
                        max-width: 450px;
                        width: 90%;
                        text-align: center;
                        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
                        animation: bounceIn 0.5s ease-out;
                    ">
                        <div style="
                            width: 80px;
                            height: 80px;
                            margin: 0 auto 20px;
                            background: #e8f5e9;
                            border-radius: 50%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        ">
                            <svg viewBox="0 0 24 24" style="width: 50px; height: 50px; stroke: #4caf50; fill: none; stroke-width: 2.5;">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="8 12 11 15 16 9"></polyline>
                            </svg>
                        </div>
                        <h3 style="font-size: 22px; font-weight: 600; color: #2c2c2c; margin-bottom: 10px;">
                            Pesanan Berhasil Dibuat!
                        </h3>
                        <p style="font-size: 15px; color: #6b6b6b; margin-bottom: 20px; line-height: 1.6;">
                            ${paymentMethod === 'cod' ? 
                                'Pesanan Anda sedang diproses. Siapkan uang pas saat pesanan tiba.' : 
                            paymentMethod === 'bank_transfer' ?
                                'Silakan upload bukti transfer untuk memverifikasi pembayaran Anda. Anda akan diarahkan ke halaman upload dalam sebentar...' :
                                'Pesanan Anda diterima. Admin akan segera memverifikasi dan menghubungi Anda.'}
                        </p>
                        <div style="background: #f5f5f0; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px;">
                                <span style="color: #6b6b6b;">No. Pesanan:</span>
                                <span style="font-weight: 600; color: #2c2c2c;">${orderNumber}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px;">
                                <span style="color: #6b6b6b;">Status:</span>
                                <span style="font-weight: 600; color: #ff9800;">
                                    ${paymentMethod === 'bank_transfer' ? 'Menunggu Upload Bukti' : 'Menunggu Verifikasi'}
                                </span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px;">
                                <span style="color: #6b6b6b;">Pembayaran:</span>
                                <span style="font-weight: 600; color: #2c2c2c;">${paymentName[paymentMethod] || paymentMethod}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; font-size: 16px; padding-top: 10px; border-top: 1px solid #e0e0e0;">
                                <span style="color: #6b6b6b; font-weight: 600;">Total:</span>
                                <span style="font-weight: 600; color: #8b7355;">Rp ${total.toLocaleString('id-ID')}</span>
                            </div>
                        </div>
                        ${paymentMethod !== 'bank_transfer' ? `
                        <button onclick="window.location.href='/riwayat'" style="
                            width: 100%;
                            background: #4caf50;
                            color: white;
                            border: none;
                            padding: 12px 40px;
                            border-radius: 25px;
                            font-size: 15px;
                            font-weight: 600;
                            cursor: pointer;
                            margin-bottom: 10px;
                        ">Lihat Status Pesanan</button>
                        <button onclick="window.location.href='/'" style="
                            width: 100%;
                            background: white;
                            color: #4a4a4a;
                            border: 2px solid #e0e0e0;
                            padding: 12px 40px;
                            border-radius: 25px;
                            font-size: 15px;
                            font-weight: 600;
                            cursor: pointer;
                        ">Kembali ke Beranda</button>
                        ` : `
                        <button onclick="window.location.href='/riwayat'" style="
                            width: 100%;
                            background: #8b7355;
                            color: white;
                            border: none;
                            padding: 12px 40px;
                            border-radius: 25px;
                            font-size: 15px;
                            font-weight: 600;
                            cursor: pointer;
                        ">Lihat Pesanan Saya</button>
                        `}
                    </div>
                `;

                document.body.appendChild(modal);
            }

            function showAddressRequiredModal() {
                const modal = document.createElement('div');
                modal.id = 'addressRequiredModal';
                modal.style.cssText = `
                    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                    background: rgba(0,0,0,0.6); z-index: 10001;
                    display: flex; align-items: center; justify-content: center; padding: 20px;
                `;
                modal.innerHTML = `
                    <div style="background:white;border-radius:20px;padding:35px 30px;max-width:420px;width:100%;text-align:center;box-shadow:0 10px 40px rgba(0,0,0,0.3);">
                        <div style="width:70px;height:70px;margin:0 auto 20px;background:#fff3e0;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                            <svg viewBox="0 0 24 24" style="width:38px;height:38px;stroke:#ff9800;fill:none;stroke-width:2;">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </div>
                        <h3 style="font-size:20px;font-weight:600;color:#2c2c2c;margin-bottom:10px;">Alamat Pengiriman Belum Diisi</h3>
                        <p style="font-size:14px;color:#6b6b6b;margin-bottom:25px;line-height:1.6;">
                            Silakan lengkapi alamat pengiriman di profil Anda sebelum melakukan checkout.
                        </p>
                        <a href="/profile#address" style="display:block;background:#8b7355;color:white;padding:12px 30px;border-radius:25px;font-size:15px;font-weight:600;text-decoration:none;margin-bottom:10px;">
                            Isi Alamat Sekarang
                        </a>
                        <button onclick="document.getElementById('addressRequiredModal').remove()" style="background:none;border:none;color:#8b7355;font-size:14px;cursor:pointer;margin-top:5px;">
                            Tutup
                        </button>
                    </div>
                `;
                modal.addEventListener('click', e => { if (e.target === modal) modal.remove(); });
                document.body.appendChild(modal);
            }

            function showLoginRequiredModal() {
                const modal = document.createElement('div');
                modal.style.cssText = `
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.6);
                    z-index: 10000;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                `;

                modal.innerHTML = `
                    <div style="
                        background: white;
                        border-radius: 20px;
                        padding: 40px;
                        max-width: 400px;
                        width: 90%;
                        text-align: center;
                        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
                        animation: scaleIn 0.3s ease-out;
                    ">
                        <div style="
                            width: 80px;
                            height: 80px;
                            margin: 0 auto 20px;
                            background: #fff3e0;
                            border-radius: 50%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        ">
                            <svg viewBox="0 0 24 24" style="width: 45px; height: 45px; stroke: #ff9800; fill: none; stroke-width: 2.5;">
                                <circle cx="12" cy="12" r="10"></circle>
                                <circle cx="12" cy="10" r="3"></circle>
                                <path d="M6.168 18.849A4 4 0 0 1 10 16h4a4 4 0 0 1 3.834 2.855"></path>
                            </svg>
                        </div>
                        <h3 style="font-size: 22px; font-weight: 600; color: #2c2c2c; margin-bottom: 10px;">
                            Login Diperlukan
                        </h3>
                        <p style="font-size: 15px; color: #6b6b6b; margin-bottom: 25px; line-height: 1.5;">
                            Silakan login terlebih dahulu untuk melakukan checkout
                        </p>
                        <div style="display: flex; gap: 10px;">
                            <button onclick="this.closest('div').parentElement.remove()" style="
                                flex: 1;
                                background: #f5f5f0;
                                color: #4a4a4a;
                                border: none;
                                padding: 12px 20px;
                                border-radius: 10px;
                                font-size: 15px;
                                font-weight: 600;
                                cursor: pointer;
                            ">Batal</button>
                            <button onclick="window.location.href='/login'" style="
                                flex: 1;
                                background: #8b7355;
                                color: white;
                                border: none;
                                padding: 12px 20px;
                                border-radius: 10px;
                                font-size: 15px;
                                font-weight: 600;
                                cursor: pointer;
                            ">Login</button>
                        </div>
                    </div>
                `;

                const style = document.createElement('style');
                style.textContent = `
                    @keyframes scaleIn {
                        from { opacity: 0; transform: scale(0.8); }
                        to { opacity: 1; transform: scale(1); }
                    }
                `;
                document.head.appendChild(style);

                document.body.appendChild(modal);

                // Close on outside click
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        modal.remove();
                    }
                });
            }
        </script>
        <script
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"
        ></script>
    </body>
    </html>
