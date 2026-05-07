<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Toko Kue Kharisma</title>
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
            position: relative;
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

        /* Hamburger Menu */
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

        .icon-btn:hover svg {
            stroke: #000;
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

        /* Mobile Menu */
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

            .header-icons {
                margin-left: auto;
                gap: 15px;
            }

            .icon-label {
                font-size: 9px;
            }
        }

        /* Overlay for mobile menu */
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

        /* Review Modal */
        .review-modal {
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

        .review-modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .modal-title {
            font-size: 24px;
            font-weight: 600;
            color: #2c2c2c;
        }

        .btn-close-modal {
            background: none;
            border: none;
            font-size: 28px;
            color: #8b7355;
            cursor: pointer;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s;
        }

        .btn-close-modal:hover {
            background: #f5f5f0;
            color: #2c2c2c;
        }

        .rating-input {
            margin-bottom: 25px;
        }

        .rating-label {
            display: block;
            font-size: 16px;
            font-weight: 600;
            color: #4a4a4a;
            margin-bottom: 10px;
        }

        .stars-input {
            display: flex;
            gap: 10px;
            font-size: 32px;
        }

        .star {
            cursor: pointer;
            color: #e0e0e0;
            transition: color 0.2s;
        }

        .star:hover,
        .star.active {
            color: #ffd700;
        }

        .review-form-group {
            margin-bottom: 20px;
        }

        .review-form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #4a4a4a;
            margin-bottom: 8px;
        }

        .review-form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 14px;
            color: #2c2c2c;
            transition: border-color 0.3s;
        }

        .review-form-control:focus {
            outline: none;
            border-color: #8b7355;
        }

        textarea.review-form-control {
            resize: vertical;
            min-height: 100px;
        }

        .btn-submit-review {
            width: 100%;
            background: #8b7355;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .btn-submit-review:hover {
            background: #6b5845;
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero {
            position: relative;
            height: 250px;
            overflow: hidden;
            cursor: pointer;
        }

        .hero-images {
            display: flex;
            height: 100%;
            transition: transform 0.8s ease-in-out;
        }

        .hero-image {
            min-width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
        }

        /* Slider Navigation Areas */
        .slider-nav {
            position: absolute;
            top: 0;
            height: 100%;
            width: 20%;
            z-index: 5;
            cursor: pointer;
            transition: background 0.3s;
        }

        .slider-nav:hover {
            background: rgba(0, 0, 0, 0.1);
        }

        .slider-nav-left {
            left: 0;
        }

        .slider-nav-right {
            right: 0;
        }

        .slider-indicators {
            position: absolute;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 11;
        }

        .indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s;
        }

        .indicator.active {
            background: white;
            width: 30px;
            border-radius: 5px;
        }

        /* Best Sellers Section */
        .best-sellers {
            padding: 50px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 28px;
            color: #8b7355;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .section-divider {
            width: 200px;
            height: 2px;
            background: #8b7355;
            margin: 0 auto 40px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

       .product-card {
    background: linear-gradient(135deg, #d4b896 0%, #c9a882 100%);
    border-radius: 20px;
    padding: 25px;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);

    opacity: 0;
    transform: translateY(20px);
    animation: fadeUp 0.6s ease forwards;
}

/* delay animasi */
.product-card:nth-child(1) { animation-delay: 0.1s; }
.product-card:nth-child(2) { animation-delay: 0.2s; }
.product-card:nth-child(3) { animation-delay: 0.3s; }
.product-card:nth-child(4) { animation-delay: 0.4s; }
.product-card:nth-child(5) { animation-delay: 0.5s; }
.product-card:nth-child(6) { animation-delay: 0.6s; }

/* INI YANG KURANG */
@keyframes fadeUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.product-card:hover {
    transform: translateY(-10px) scale(1.03);
    box-shadow: 0 15px 30px rgba(0,0,0,0.2);
}

        @keyframes highlight {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); box-shadow: 0 8px 25px rgba(139, 115, 85, 0.3); }
        }

        /* Not Found Modal */
        .not-found-modal {
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

        .not-found-modal.active {
            display: flex;
        }

        .not-found-content {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .not-found-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: #f5f5f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .not-found-icon svg {
            width: 50px;
            height: 50px;
            stroke: #8b7355;
            fill: none;
            stroke-width: 2;
        }

        .not-found-title {
            font-size: 22px;
            font-weight: 600;
            color: #2c2c2c;
            margin-bottom: 10px;
        }

        .not-found-message {
            font-size: 15px;
            color: #6b6b6b;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        .not-found-keyword {
            color: #8b7355;
            font-weight: 600;
        }

        .btn-close-not-found {
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

        .btn-close-not-found:hover {
            background: #6b5845;
            transform: translateY(-2px);
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
            z-index: 1001;
            align-items: center;
            justify-content: center;
        }

        .success-modal.active {
            display: flex;
        }

        .success-modal-content {
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
            0% {
                opacity: 0;
                transform: scale(0.3);
            }
            50% {
                opacity: 1;
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                transform: scale(1);
            }
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
            animation: checkmark 0.5s ease-out 0.3s both;
        }

        @keyframes checkmark {
            0% {
                transform: scale(0);
            }
            50% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
            }
        }

        .success-icon svg {
            width: 50px;
            height: 50px;
            stroke: #4caf50;
            fill: none;
            stroke-width: 3;
        }

        .success-icon svg polyline {
            stroke-dasharray: 20;
            stroke-dashoffset: 20;
            animation: draw 0.5s ease-out 0.5s forwards;
        }

        @keyframes draw {
            to {
                stroke-dashoffset: 0;
            }
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

        .btn-close-success {
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

        .btn-close-success:hover {
            background: #388e3c;
            transform: translateY(-2px);
        }

        .product-image-container {
            background: white;
            border-radius: 15px;
            padding: 15px;
            margin-bottom: 15px;
            height: 200px;
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

        .product-name {
            font-size: 16px;
            font-weight: 600;
            color: #2c2c2c;
            margin-bottom: 8px;
            text-transform: capitalize;
        }

        .product-price {
            font-size: 16px;
            color: #4a4a4a;
            margin-bottom: 15px;
            font-weight: 500;
        }

        .product-info {
            text-align: center;
        }

        .product-actions {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
        }

        .product-description {
            font-size: 13px;
            color: #6b6b6b;
            margin-bottom: 10px;
            line-height: 1.4;
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

        .btn-add-cart:hover {
            background: #6b5845;
            transform: scale(1.05);
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

        .btn-add-cart svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
        }

        .btn-add-cart .icon {
            font-size: 18px;
            font-weight: bold;
        }

        /* Decorative flowers */
        .flower-decoration {
            position: absolute;
            width: 80px;
            opacity: 0.6;
        }

        .flower-left {
            bottom: 10px;
            left: 20px;
        }

        .flower-right {
            bottom: 10px;
            right: 20px;
        }

        /* About Section */
        .about-section {
            background: linear-gradient(135deg, #f5deb3 0%, #f4d4a8 100%);
            padding: 60px 50px;
        }

        .about-title {
            font-family: 'Brush Script MT', cursive;
            font-size: 48px;
            color: #8b7355;
            text-align: center;
            margin-bottom: 20px;
            font-style: italic;
        }

        .about-subtitle {
            text-align: center;
            color: #8b7355;
            font-size: 16px;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .about-images {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto 40px;
        }

        .about-image {
            width: 100%;
            height: 200px;
            border-radius: 15px;
            object-fit: cover;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .about-description {
            text-align: center;
            color: #8b7355;
            font-size: 15px;
            line-height: 1.8;
            max-width: 900px;
            margin: 0 auto 30px;
        }

        .heart-divider {
            text-align: center;
            color: #8b7355;
            font-size: 24px;
            margin: 30px 0;
        }

        .heart-divider::before,
        .heart-divider::after {
            content: '';
            display: inline-block;
            width: 100px;
            height: 1px;
            background: #8b7355;
            vertical-align: middle;
            margin: 0 20px;
        }

        /* Reviews Section */
        .reviews-section {
            background: linear-gradient(135deg, #d4b896 0%, #c9a882 100%);
            padding: 50px;
        }

        .reviews-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto 30px;
        }

        .reviews-title {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 28px;
            color: #2c2c2c;
            font-weight: 600;
        }

        .add-review-btn {
            background: #2c2c2c;
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            font-size: 24px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }

        .add-review-btn:hover {
            background: #000;
            transform: scale(1.1);
        }

        .add-review-text {
            font-size: 14px;
            font-weight: 600;
            color: #2c2c2c;
            margin-left: 15px;
        }

        .add-review-wrapper {
            display: flex;
            align-items: center;
        }

        .reviews-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            gap: 20px;
        }

        .review-card {
            background: #f5f5f0;
            border-radius: 20px;
            padding: 25px 30px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .review-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .review-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #2c2c2c;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .review-avatar svg {
            width: 30px;
            height: 30px;
            stroke: white;
            fill: none;
            stroke-width: 2;
        }

        .review-info {
            flex: 1;
        }

        .review-stars {
            color: #ffd700;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .review-name {
            font-size: 16px;
            font-weight: 600;
            color: #2c2c2c;
        }

        .review-text {
            color: #8b7355;
            font-size: 14px;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .about-images {
                grid-template-columns: 1fr;
            }

            .about-title {
                font-size: 36px;
            }

            .reviews-header {
                flex-direction: column;
                gap: 20px;
            }
        }

        @media (max-width: 480px) {
            .best-sellers { padding: 30px 15px; }
            .products-grid { grid-template-columns: repeat(2, 1fr); gap: 15px; }
            .about-section { padding: 40px 15px; }
            .reviews-section { padding: 30px 15px; }
            .hero { height: 250px; }
        }
        .hero {
    animation: zoomHero 6s ease-in-out infinite alternate;
}

@keyframes zoomHero {
    from { transform: scale(1); }
    to { transform: scale(1.05); }
}
        .fade-up {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s ease;
}

.fade-up.show {
    opacity: 1;
    transform: translateY(0);
}
/* Efek kartu produk biar interaktif */
.product-card {
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); /* Biar ada efek mantul (bounce) dikit */
    opacity: 0;
    transform: translateY(30px);
}

/* Saat muncul lewat scroll */
.product-card.show {
    opacity: 1;
    transform: translateY(0);
}

.product-card:hover {
    transform: translateY(-12px) scale(1.02);
    box-shadow: 0 20px 30px rgba(0,0,0,0.15);
    background: linear-gradient(135deg, #dfc4a3 0%, #d4b896 100%);
}

/* Animasi Gambar biar nge-zoom di dalam kartu */
.product-image-container {
    overflow: hidden; /* Wajib ada ini */
}

.product-image {
    transition: transform 0.5s ease;
}

.product-card:hover .product-image {
    transform: scale(1.1) rotate(2deg); /* Ngezoom sambil miring dikit biar asik */
}

/* Animasi Tombol pas diklik */
.btn-add-cart:active {
    transform: scale(0.9);
}
/* Logo goyang dikit pas dihover */
.store-name:hover {
    animation: wiggle 0.5s ease-in-out;
}

@keyframes wiggle {
    0%, 100% { transform: rotate(0); }
    25% { transform: rotate(-3deg); }
    75% { transform: rotate(3deg); }
}
    </style>
</head>
<body>
    <!-- Menu Overlay -->
    <div class="menu-overlay" id="menuOverlay"></div>

    <!-- Header -->
    <header>
        <div class="logo-section">
            <span class="store-name">Toko kue kharisma</span>
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

    <!-- Hero Section -->
    <section class="hero">
        <!-- Navigation Areas -->
        <div class="slider-nav slider-nav-left" onclick="prevSlide()"></div>
        <div class="slider-nav slider-nav-right" onclick="nextSlideManual()"></div>

        <div class="hero-images" id="heroSlider">
            <div class="hero-image" style="background-image: url('/images/products/bolu-pelangi.jpg')"></div>
            <div class="hero-image" style="background-image: url('/images/products/putu-ayu.jpg')"></div>
            <div class="hero-image" style="background-image: url('/images/products/pepe-pelangi.jpg')"></div>
            <div class="hero-image" style="background-image: url('/images/products/lemper.jpg')"></div>
            <div class="hero-image" style="background-image: url('/images/products/dadar-gulung.jpg')"></div>
        </div>

        <div class="slider-indicators" id="sliderIndicators">
            <div class="indicator active" data-slide="0"></div>
            <div class="indicator" data-slide="1"></div>
            <div class="indicator" data-slide="2"></div>
            <div class="indicator" data-slide="3"></div>
            <div class="indicator" data-slide="4"></div>
        </div>
    </section>

    <!-- Best Sellers Section -->
    <section class="best-sellers">
        <h2 class="section-title">Best Sellers</h2>
        <div class="section-divider"></div>

        <div class="products-grid">
            @foreach($products as $product)
                @include('partials.product-card', [
                    'product' => $product,
                    'showDescription' => false,
                    'buttonLabel' => 'Masukkan ke keranjang'
                ])
            @endforeach
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section">
        <h2 class="about-title">Tentang Kami</h2>
        <p class="about-subtitle">
            Selamat datang di toko kue kharisma toko kue yang manis,<br>
            enak dan lezat.
        </p>

        <div class="about-images">
            <img src="/images/products/bolu-pelangi.jpg" alt="Bolu Pelangi" class="about-image">
            <img src="/images/products/putu-ayu.jpg" alt="Putu Ayu" class="about-image">
        </div>

        <p class="about-description">
            Toko ini berdiri sejak tahun 2009, kami mulai dari dapur kecil sampai mempunyai 
            pedagang keliling 4 orang. toko ini membawa kebahagiaan melalui kue jaman dahulu 
            yang di buat dengan cinta.
        </p>

        <div class="heart-divider">♡</div>
    </section>

    <!-- Reviews Section -->
    <section class="reviews-section">
        <div class="reviews-header">
            <h2 class="reviews-title">Customer reviews</h2>
        </div>

        <div class="reviews-container">
            @foreach($reviews as $review)
            <div class="review-card">
                <div class="review-header">
                    <div class="review-avatar">
                        <svg viewBox="0 0 24 24">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div class="review-info">
                        <div class="review-stars">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</div>
                        <div class="review-name">{{ $review->name }}</div>
                        <div style="font-size:12px;color:#a89f8c;margin-top:2px;">{{ $review->created_at->format('d M Y') }}</div>
                    </div>
                </div>
                <p class="review-text">{{ $review->review }}</p>
            </div>
            @endforeach
        </div>

        @if($totalReviews > 10)
        <div style="text-align:center;margin-top:30px;">
            <a href="{{ route('reviews.index') }}" style="
                display: inline-block;
                background: #2c2c2c;
                color: white;
                padding: 12px 35px;
                border-radius: 25px;
                font-size: 15px;
                font-weight: 600;
                text-decoration: none;
                transition: all 0.3s;
            " onmouseover="this.style.background='#000'" onmouseout="this.style.background='#2c2c2c'">
                Lihat Selengkapnya ({{ $totalReviews }} ulasan)
            </a>
        </div>
        @endif
    </section>

    <!-- Review Modal -->
    <div class="review-modal" id="reviewModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Tambahkan Ulasan</h2>
                <button class="btn-close-modal" onclick="closeReviewModal()">×</button>
            </div>

            <form onsubmit="submitReview(event)">
                <div class="rating-input">
                    <label class="rating-label">Rating</label>
                    <div class="stars-input" id="starsInput">
                        <span class="star" data-rating="1" onclick="setRating(1)">★</span>
                        <span class="star" data-rating="2" onclick="setRating(2)">★</span>
                        <span class="star" data-rating="3" onclick="setRating(3)">★</span>
                        <span class="star" data-rating="4" onclick="setRating(4)">★</span>
                        <span class="star" data-rating="5" onclick="setRating(5)">★</span>
                    </div>
                    <input type="hidden" id="ratingValue" value="0" required>
                </div>

                <div class="review-form-group">
                    <label for="reviewName">Nama</label>
                    <input type="text" id="reviewName" class="review-form-control" placeholder="Masukkan nama Anda" required>
                </div>

                <div class="review-form-group">
                    <label for="reviewText">Ulasan</label>
                    <textarea id="reviewText" class="review-form-control" placeholder="Tulis ulasan Anda..." required></textarea>
                </div>

                <button type="submit" class="btn-submit-review">Kirim Ulasan</button>
            </form>
        </div>
    </div>

    <!-- Review Success Modal -->
    <div class="success-modal" id="successModal">
        <div class="success-modal-content">
            <div class="success-icon">
                <svg viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="8 12 11 15 16 9"></polyline>
                </svg>
            </div>
            <h3 class="success-title">Ulasan Berhasil Ditambahkan!</h3>
            <p class="success-message">
                Terima kasih atas ulasan Anda. Ulasan Anda sangat membantu kami untuk terus meningkatkan kualitas produk.
            </p>
            <button class="btn-close-success" onclick="closeSuccessModal()">Tutup</button>
        </div>
    </div>

    <!-- Not Found Modal -->
    <div class="not-found-modal" id="notFoundModal">
        <div class="not-found-content">
            <div class="not-found-icon">
                <svg viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.35-4.35"></path>
                    <line x1="8" y1="11" x2="14" y2="11"></line>
                </svg>
            </div>
            <h3 class="not-found-title">Produk Tidak Ditemukan</h3>
            <p class="not-found-message">
                Maaf, produk dengan kata kunci <span class="not-found-keyword" id="notFoundKeyword"></span> tidak ditemukan.
            </p>
            <button class="btn-close-not-found" onclick="closeNotFoundModal()">Tutup</button>
        </div>
    </div>

    <script>
        function addReview() {
            document.getElementById('reviewModal').classList.add('active');
        }

        function closeReviewModal() {
            document.getElementById('reviewModal').classList.remove('active');
            // Reset form
            document.getElementById('reviewName').value = '';
            document.getElementById('reviewText').value = '';
            document.getElementById('ratingValue').value = '0';
            document.querySelectorAll('.star').forEach(star => star.classList.remove('active'));
        }

        // Close modal when clicking outside
        document.getElementById('reviewModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeReviewModal();
            }
        });

        let selectedRating = 0;

        function setRating(rating) {
            selectedRating = rating;
            document.getElementById('ratingValue').value = rating;
            
            // Update star display
            document.querySelectorAll('.star').forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
            });
        }

        function submitReview(event) {
            event.preventDefault();
            
            const rating = document.getElementById('ratingValue').value;
            const name = document.getElementById('reviewName').value;
            const review = document.getElementById('reviewText').value;

            if (rating === '0') {
                alert('Silakan pilih rating terlebih dahulu!');
                return;
            }

            // Save to database via AJAX
            fetch('{{ route("reviews.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    name: name,
                    rating: parseInt(rating),
                    review: review
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Create new review card
                    const reviewCard = document.createElement('div');
                    reviewCard.className = 'review-card';
                    reviewCard.style.animation = 'fadeIn 0.5s ease-out';
                    reviewCard.innerHTML = `
                        <div class="review-header">
                            <div class="review-avatar">
                                <svg viewBox="0 0 24 24">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <div class="review-info">
                                <div class="review-stars">${'★'.repeat(rating)}</div>
                                <div class="review-name">${name}</div>
                            </div>
                        </div>
                        <p class="review-text">${review}</p>
                    `;

                    // Add animation style
                    const style = document.createElement('style');
                    style.textContent = `
                        @keyframes fadeIn {
                            from { opacity: 0; transform: translateY(-20px); }
                            to { opacity: 1; transform: translateY(0); }
                        }
                    `;
                    if (!document.querySelector('style[data-fadein]')) {
                        style.setAttribute('data-fadein', 'true');
                        document.head.appendChild(style);
                    }

                    // Add to reviews container
                    document.querySelector('.reviews-container').prepend(reviewCard);

                    // Close review modal
                    closeReviewModal();

                    // Show success modal
                    document.getElementById('successModal').classList.add('active');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menambahkan review');
            });
        }

        function closeSuccessModal() {
            document.getElementById('successModal').classList.remove('active');
        }

        // Close success modal when clicking outside
        document.getElementById('successModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeSuccessModal();
            }
        });

        // Hero Slider
        let currentSlide = 0;
        const slider = document.getElementById('heroSlider');
        const indicators = document.querySelectorAll('.indicator');
        const totalSlides = 5;

        function goToSlide(slideIndex) {
            currentSlide = slideIndex;
            slider.style.transform = `translateX(-${currentSlide * 100}%)`;
            
            // Update indicators
            indicators.forEach((indicator, index) => {
                indicator.classList.toggle('active', index === currentSlide);
            });
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            goToSlide(currentSlide);
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            goToSlide(currentSlide);
        }

        function nextSlideManual() {
            clearInterval(autoSlide);
            nextSlide();
            autoSlide = setInterval(nextSlide, 4000);
        }

        // Auto slide every 4 seconds
        let autoSlide = setInterval(nextSlide, 4000);

        // Manual slide control
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                clearInterval(autoSlide);
                goToSlide(index);
                autoSlide = setInterval(nextSlide, 4000);
            });
        });

        // Hamburger Menu Toggle
        const hamburger = document.getElementById('hamburger');
        const navMenu = document.getElementById('navMenu');
        const menuOverlay = document.getElementById('menuOverlay');

        hamburger.addEventListener('click', function() {
            hamburger.classList.toggle('active');
            navMenu.classList.toggle('active');
            menuOverlay.classList.toggle('active');
        });

        // Close menu when clicking overlay
        menuOverlay.addEventListener('click', function() {
            hamburger.classList.remove('active');
            navMenu.classList.remove('active');
            menuOverlay.classList.remove('active');
        });

        // Close menu when clicking a link
        document.querySelectorAll('nav a').forEach(link => {
            link.addEventListener('click', function() {
                hamburger.classList.remove('active');
                navMenu.classList.remove('active');
                menuOverlay.classList.remove('active');
            });
        });

        function addToCart(button, productId, productName) {
            // Pastikan productId adalah integer
            const id = parseInt(productId);
            if (isNaN(id)) {
                console.error('Invalid product ID:', productId);
                showCartError('ID produk tidak valid');
                return;
            }

            button.disabled = true;
            const originalContent = button.innerHTML;
            button.innerHTML = '<span class="loading">Menambah...</span>';

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            console.log('Adding to cart:', { productId: id, productName, csrfToken });

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
            .then(async response => {
                console.log('Response status:', response.status);
                const data = await response.json().catch(() => null);
                console.log('Response data:', data);

                if (!response.ok || !data || data.success !== true) {
                    const message = data?.message || 'Gagal menambahkan ke keranjang';
                    console.error('Add to cart failed:', message);
                    showCartError(message);
                    if (response.status === 401) {
                        console.log('Redirecting to login...');
                        setTimeout(() => window.location.href = '/login', 1000);
                    }
                    return;
                }

                const badge = document.getElementById('cartBadge');
                if (badge && data.data?.total_items) {
                    badge.textContent = data.data.total_items;
                }
                showCartNotification(productName);
            })
            .catch(error => {
                console.error('Add to cart error:', error);
                showCartError('Terjadi kesalahan. Silakan coba lagi.');
            })
            .finally(() => {
                button.disabled = false;
                button.innerHTML = originalContent;
            });
        }

        function showCartNotification(productName) {
            // Create notification element
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 100px;
                right: 30px;
                background: #4caf50;
                color: white;
                padding: 15px 25px;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.3);
                z-index: 10000;
                animation: slideIn 0.3s ease-out;
                font-weight: 600;
            `;
            notification.innerHTML = `
                <div style="display: flex; align-items: center; gap: 10px;">
                    <svg viewBox="0 0 24 24" style="width: 20px; height: 20px; stroke: white; fill: none; stroke-width: 2;">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <span>${productName} berhasil ditambahkan ke keranjang!</span>
                </div>
            `;

            // Add animation
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

            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease-out';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }

        function showCartError(message) {
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 100px;
                right: 30px;
                background: #d32f2f;
                color: white;
                padding: 15px 25px;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.3);
                z-index: 10000;
                animation: slideIn 0.3s ease-out;
                font-weight: 600;
            `;
            notification.innerHTML = `
                <div style="display: flex; align-items: center; gap: 10px;">
                    <svg viewBox="0 0 24 24" style="width: 20px; height: 20px; stroke: white; fill: none; stroke-width: 2;">
                        <path d="M6 6l12 12M18 6L6 18"></path>
                    </svg>
                    <span>${message}</span>
                </div>
            `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease-out';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Search functionality dihapus

        function closeNotFoundModal() {
            document.getElementById('notFoundModal').classList.remove('active');
        }

        // Close modal when clicking outside
        document.getElementById('notFoundModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeNotFoundModal();
            }
        });

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

            // Add to Cart for product cards with data attributes
            document.querySelectorAll('.btn-add-cart[data-product-id]').forEach(button => {
                if (!button.getAttribute('onclick')) {
                    button.addEventListener('click', function() {
                        const productId = this.getAttribute('data-product-id');
                        const productName = this.getAttribute('data-product-name');
                        addToCart(this, productId, productName);
                    });
                }
            });
        });
    </script>
    <script>
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('show');
        }
    });
});

document.querySelectorAll('.fade-up').forEach(el => {
    observer.observe(el);
});
</script>
<script>
    // Inisialisasi Observer
    const observerOptions = {
        threshold: 0.2 // Muncul kalau 20% elemen udah masuk layar
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                // Kasih delay dikit tiap kartu biar munculnya gantian (staggered)
                setTimeout(() => {
                    entry.target.classList.add('show');
                }, index * 100); 
                observer.unobserve(entry.target); // Cukup animasiin sekali aja
            }
        });
    }, observerOptions);

    // Targetkan semua kartu produk
    document.querySelectorAll('.product-card').forEach((card) => {
        observer.observe(card);
    });
</script>
</body>
</html>
