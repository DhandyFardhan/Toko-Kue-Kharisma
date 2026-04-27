<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pembayaran - Toko Kue Kharisma</title>
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

        .store-name {
            font-family: 'Brush Script MT', 'Lucida Handwriting', cursive;
            font-size: 28px;
            color: #2c2c2c;
            font-style: italic;
            font-weight: bold;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        /* Payment Container */
        .payment-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 50px;
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 30px;
        }

        .payment-title {
            font-size: 28px;
            font-weight: 600;
            color: #2c2c2c;
            margin-bottom: 30px;
        }

        /* Payment Methods */
        .payment-methods {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .method-section {
            margin-bottom: 30px;
        }

        .method-section:last-child {
            margin-bottom: 0;
        }

        .method-title {
            font-size: 16px;
            font-weight: 600;
            color: #4a4a4a;
            margin-bottom: 15px;
        }

        .payment-option {
            display: flex;
            align-items: center;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .payment-option:hover {
            border-color: #8b7355;
            background: #f5f5f0;
        }

        .payment-option.selected {
            border-color: #8b7355;
            background: #f5f5f0;
        }

        .payment-option input[type="radio"] {
            width: 20px;
            height: 20px;
            margin-right: 15px;
            cursor: pointer;
        }

        .payment-logo {
            width: 50px;
            height: 30px;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
            color: white;
            border-radius: 5px;
        }

        .payment-name {
            flex: 1;
            font-size: 15px;
            font-weight: 600;
            color: #2c2c2c;
        }

        /* Order Summary */
        .order-summary {
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

        .summary-items {
            margin-bottom: 20px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
            color: #4a4a4a;
        }

        .summary-divider {
            height: 1px;
            background: rgba(44, 44, 44, 0.2);
            margin: 20px 0;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            font-size: 18px;
            font-weight: 600;
            color: #2c2c2c;
            margin-bottom: 20px;
        }

        .btn-pay {
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
        }

        .btn-pay:hover {
            background: #000;
            transform: translateY(-2px);
        }

        .btn-pay:disabled {
            background: #9e9e9e;
            cursor: not-allowed;
            transform: none;
        }

        /* Success Modal */
        .success-modal {
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

        .success-modal.active {
            display: flex;
        }

        .success-content {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            animation: bounceIn 0.5s ease-out;
        }

        @keyframes bounceIn {
            0% { opacity: 0; transform: scale(0.3); }
            50% { opacity: 1; transform: scale(1.05); }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); }
        }

        .success-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: #e8f5e9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .success-icon svg {
            width: 50px;
            height: 50px;
            stroke: #4caf50;
            fill: none;
            stroke-width: 3;
        }

        .success-title {
            font-size: 22px;
            font-weight: 600;
            color: #2c2c2c;
            margin-bottom: 10px;
        }

        .success-message {
            font-size: 15px;
            color: #6b6b6b;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .btn-view-order {
            background: #4caf50;
            color: white;
            border: none;
            padding: 12px 40px;
            border-radius: 25px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-view-order:hover {
            background: #388e3c;
            transform: translateY(-2px);
        }

        @media (max-width: 968px) {
            .payment-container {
                grid-template-columns: 1fr;
                padding: 0 20px;
            }

            .order-summary {
                position: static;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-left">
            <a href="/cart" class="btn-back">
                <svg viewBox="0 0 24 24">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
            <span class="store-name">Toko kue kharisma</span>
        </div>
    </header>

    <!-- Payment Container -->
    <div class="payment-container">
        <!-- Payment Methods -->
        <div>
            <h1 class="payment-title">Pilih Metode Pembayaran</h1>

            <div class="payment-methods">
                <!-- E-Wallet -->
                <div class="method-section">
                    <div class="method-title">E-Wallet</div>
                    
                    <label class="payment-option">
                        <input type="radio" name="payment" value="qris" onchange="selectPayment(this)">
                        <div class="payment-logo" style="background: #8b7355;">QR</div>
                        <span class="payment-name">QRIS (Scan QR)</span>
                    </label>
                </div>

                <!-- Bank Transfer -->
                <div class="method-section">
                    <div class="method-title">Transfer Bank</div>
                    
                    <label class="payment-option">
                        <input type="radio" name="payment" value="bank_transfer" onchange="selectPayment(this)">
                        <div class="payment-logo" style="background: #2196F3;">🏦</div>
                        <span class="payment-name">Transfer Bank (Manual)</span>
                    </label>
                </div>

                <!-- COD -->
                <div class="method-section">
                    <div class="method-title">Bayar di Tempat</div>
                    
                    <label class="payment-option">
                        <input type="radio" name="payment" value="cod" onchange="selectPayment(this)">
                        <div class="payment-logo" style="background: #4caf50;">COD</div>
                        <span class="payment-name">Cash on Delivery (Bayar di Tempat)</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="order-summary">
            <h2 class="summary-title">Ringkasan Pesanan</h2>
            
            <div class="summary-items">
                <div class="summary-item">
                    <span>Subtotal</span>
                    <span id="summarySubtotal">-</span>
                </div>
                <div class="summary-item">
                    <span>Ongkos Kirim</span>
                    <span>Rp 5.000</span>
                </div>
                <div class="summary-item">
                    <span>Diskon</span>
                    <span style="color: #d32f2f;">- Rp 0</span>
                </div>
            </div>

            <div class="summary-divider"></div>

            <div class="summary-total">
                <span>Total Pembayaran</span>
                <span id="summaryTotal">-</span>
            </div>

            <button class="btn-pay" id="btnPay" disabled onclick="processPayment()">
                Bayar Sekarang
            </button>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="success-modal" id="successModal">
        <div class="success-content">
            <div class="success-icon">
                <svg viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="8 12 11 15 16 9"></polyline>
                </svg>
            </div>
            <h3 class="success-title">Pembayaran Berhasil!</h3>
            <p class="success-message">
                Pesanan Anda telah dikonfirmasi dan sedang diproses. Terima kasih telah berbelanja di toko kami!
            </p>
            <button class="btn-view-order" onclick="window.location.href='/riwayat'">
                Lihat Pesanan
            </button>
        </div>
    </div>

    <script>
        let selectedPaymentMethod = null;

        // Load cart summary on page load
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/cart/summary', {
                headers: { 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && data.data) {
                    const subtotal = data.data.total_price;
                    const total = subtotal + 5000;
                    document.getElementById('summarySubtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
                    document.getElementById('summaryTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
                }
            })
            .catch(() => {});
        });

        function selectPayment(radio) {
            selectedPaymentMethod = radio.value;
            
            document.querySelectorAll('.payment-option').forEach(option => {
                option.classList.remove('selected');
            });
            
            radio.closest('.payment-option').classList.add('selected');
            document.getElementById('btnPay').disabled = false;
        }

        function processPayment() {
            if (!selectedPaymentMethod) {
                alert('Silakan pilih metode pembayaran terlebih dahulu');
                return;
            }

            const btnPay = document.getElementById('btnPay');
            btnPay.textContent = 'Memproses...';
            btnPay.disabled = true;

            fetch('/checkout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ payment_method: selectedPaymentMethod }),
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('successModal').classList.add('active');
                } else {
                    alert(data.message || 'Gagal membuat pesanan');
                    btnPay.textContent = 'Bayar Sekarang';
                    btnPay.disabled = false;
                }
            })
            .catch(() => {
                alert('Terjadi kesalahan, silakan coba lagi');
                btnPay.textContent = 'Bayar Sekarang';
                btnPay.disabled = false;
            });
        }
    </script>
</body>
</html>
