<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Upload Bukti Transfer - Toko Kue Kharisma</title>
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

        .store-name {
            font-family: 'Brush Script MT', 'Lucida Handwriting', cursive;
            font-size: 28px;
            color: #2c2c2c;
            font-style: italic;
            font-weight: bold;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .payment-step {
            margin-bottom: 30px;
        }

        .step-number {
            display: inline-block;
            width: 30px;
            height: 30px;
            background: #b8956a;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            font-weight: bold;
            margin-right: 10px;
        }

        .step-title {
            font-size: 18px;
            font-weight: bold;
            color: #2c2c2c;
            margin-bottom: 10px;
        }

        .step-content {
            background: #f9f5f0;
            padding: 15px;
            border-radius: 10px;
            margin-left: 40px;
            line-height: 1.6;
            color: #555;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #2c2c2c;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            font-family: Arial, sans-serif;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #b8956a;
            box-shadow: 0 0 5px rgba(184, 149, 106, 0.3);
        }

        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .file-input-wrapper input[type=file] {
            position: absolute;
            left: -9999px;
        }

        .file-input-label {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            border: 2px dashed #b8956a;
            border-radius: 10px;
            background: #faf8f3;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
        }

        .file-input-label:hover {
            background: #f5f1eb;
            border-color: #a0845f;
        }

        .file-input-label.has-file {
            border-color: #4caf50;
            background: #f1f8f5;
        }

        .file-icon {
            font-size: 40px;
            margin-right: 15px;
        }

        .file-text {
            text-align: left;
        }

        .file-text p:first-child {
            font-weight: 600;
            color: #b8956a;
            margin-bottom: 5px;
        }

        .file-text p:last-child {
            font-size: 12px;
            color: #999;
        }

        .file-preview {
            margin-top: 10px;
            font-size: 14px;
            color: #4caf50;
            font-weight: 600;
        }

        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 15px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #b8956a;
            color: white;
        }

        .btn-primary:hover {
            background: #a0845f;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(184, 149, 106, 0.4);
        }

        .btn-primary:disabled {
            background: #ddd;
            cursor: not-allowed;
            transform: none;
        }

        .btn-secondary {
            background: #e8e8e8;
            color: #666;
        }

        .btn-secondary:hover {
            background: #d8d8d8;
        }

        .success-message {
            display: none;
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }

        .error-message {
            display: none;
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }

        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }

        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #b8956a;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .info-box {
            background: #fff3cd;
            border: 1px solid #ffc107;
            color: #856404;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            line-height: 1.6;
        }

        @media (max-width: 600px) {
            .container {
                margin: 20px 10px;
            }

            .btn-group {
                flex-direction: column;
            }

            .file-input-label {
                padding: 30px 15px;
            }

            .file-icon {
                font-size: 30px;
                margin-right: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-left">
            <a href="{{ route('riwayat') }}" class="btn-back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
        </div>
        <div class="store-name">Toko Kue Kharisma</div>
        <div></div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <h1 style="color: #2c2c2c; margin-bottom: 30px; text-align: center;">Upload Bukti Transfer</h1>

        @if ($order)
            <div class="info-box">
                <strong>Pesanan: {{ $order->order_number }}</strong><br>
                Total Pembayaran: <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
            </div>

            <div class="success-message" id="successMessage"></div>
            <div class="error-message" id="errorMessage"></div>

            <!-- Step 1: Instruksi -->
            <div class="payment-step">
                <div>
                    <span class="step-number">1</span>
                    <span class="step-title">Instruksi Pembayaran</span>
                </div>
                <div class="step-content">
                    <p>📍 <strong>Rekening Tujuan:</strong></p>
                    <p style="margin-left: 25px; margin-top: 5px;">
                        Bank: <strong>BCA</strong><br>
                        No. Rekening: <strong>1234567890</strong><br>
                        Atas Nama: <strong>Toko Kue Kharisma</strong>
                    </p>
                    <p style="margin-top: 15px;">
                        💰 <strong>Jumlah Transfer:</strong> Rp {{ number_format($order->total, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <!-- Step 2: Upload Bukti -->
            <div class="payment-step">
                <div>
                    <span class="step-number">2</span>
                    <span class="step-title">Upload Bukti Transfer</span>
                </div>
                <div class="step-content">
                    <form id="paymentForm" method="POST" action="{{ route('payment.upload-proof') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Hidden Order ID -->
                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                        <!-- Bank Name -->
                        <div class="form-group">
                            <label for="bank_name">Bank Pengirim *</label>
                            <input type="text" id="bank_name" name="bank_name" placeholder="Contoh: BCA, Mandiri, BNI" required>
                        </div>

                        <!-- Account Name -->
                        <div class="form-group">
                            <label for="account_name">Atas Nama (sesuai rekening) *</label>
                            <input type="text" id="account_name" name="account_name" placeholder="Nama sesuai buku tabungan" required>
                        </div>

                        <!-- Amount -->
                        <div class="form-group">
                            <label for="amount">Jumlah Transfer (Rp) *</label>
                            <input type="number" id="amount" name="amount" placeholder="Contoh: 150000" value="{{ $order->total }}" required>
                        </div>

                        <!-- File Upload -->
                        <div class="form-group">
                            <label>Bukti Transfer (Screenshot/Foto) *</label>
                            <div class="file-input-wrapper">
                                <input type="file" id="proof_image" name="proof_image" accept="image/*" required>
                                <label for="proof_image" class="file-input-label" id="fileLabel">
                                    <span class="file-icon">📸</span>
                                    <div class="file-text">
                                        <p>Klik atau drag & drop gambar di sini</p>
                                        <p>Format: JPG, PNG, GIF (Max 5MB)</p>
                                    </div>
                                </label>
                                <div class="file-preview" id="filePreview"></div>
                            </div>
                        </div>

                        <!-- Loading State -->
                        <div class="loading" id="loadingState">
                            <div class="spinner"></div>
                            <p>Sedang mengunggah bukti transfer...</p>
                        </div>

                        <!-- Buttons -->
                        <div class="btn-group">
                            <a href="{{ route('riwayat') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">Upload Bukti</button>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <div class="error-message" style="display: block;">
                Pesanan tidak ditemukan!
            </div>
        @endif
    </div>

    <script>
        const form = document.getElementById('paymentForm');
        const fileInput = document.getElementById('proof_image');
        const fileLabel = document.getElementById('fileLabel');
        const filePreview = document.getElementById('filePreview');
        const successMessage = document.getElementById('successMessage');
        const errorMessage = document.getElementById('errorMessage');
        const loadingState = document.getElementById('loadingState');
        const submitBtn = document.getElementById('submitBtn');

        // Handle file selection
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                fileLabel.classList.add('has-file');
                filePreview.innerHTML = `✓ ${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
            } else {
                fileLabel.classList.remove('has-file');
                filePreview.innerHTML = '';
            }
        });

        // Handle drag & drop
        fileLabel.addEventListener('dragover', (e) => {
            e.preventDefault();
            fileLabel.style.borderColor = '#a0845f';
            fileLabel.style.background = '#f5f1eb';
        });

        fileLabel.addEventListener('dragleave', () => {
            fileLabel.style.borderColor = '#b8956a';
            fileLabel.style.background = '#faf8f3';
        });

        fileLabel.addEventListener('drop', (e) => {
            e.preventDefault();
            fileLabel.style.borderColor = '#b8956a';
            fileLabel.style.background = '#faf8f3';
            fileInput.files = e.dataTransfer.files;
            const event = new Event('change', { bubbles: true });
            fileInput.dispatchEvent(event);
        });

        // Handle form submission
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(form);

            loadingState.style.display = 'block';
            submitBtn.disabled = true;
            successMessage.style.display = 'none';
            errorMessage.style.display = 'none';

            try {
                console.log('Submitting form to: {{ route("payment.upload-proof") }}');
                console.log('Form data:', formData);

                const response = await fetch('{{ route("payment.upload-proof") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: formData
                });

                console.log('Response status:', response.status);
                const data = await response.json();
                console.log('Response data:', data);

                if (data.success) {
                    successMessage.innerHTML = `
                        <strong>✓ Sukses!</strong><br>
                        ${data.message}<br>
                        <small style="display: block; margin-top: 10px;">Anda akan diarahkan ke halaman riwayat dalam 3 detik...</small>
                    `;
                    successMessage.style.display = 'block';
                    setTimeout(() => {
                        window.location.href = '{{ route("riwayat") }}';
                    }, 3000);
                } else {
                    errorMessage.innerHTML = `<strong>✗ Gagal!</strong><br>${data.message || 'Terjadi kesalahan'}<br><small>${data.errors ? JSON.stringify(data.errors) : ''}</small>`;
                    errorMessage.style.display = 'block';
                }
            } catch (error) {
                console.error('Error:', error);
                errorMessage.innerHTML = `<strong>✗ Error!</strong><br>Terjadi kesalahan: ${error.message}`;
                errorMessage.style.display = 'block';
            } finally {
                loadingState.style.display = 'none';
                submitBtn.disabled = false;
            }
        });
    </script>
</body>
</html>
