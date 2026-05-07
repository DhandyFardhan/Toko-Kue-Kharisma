<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Toko Kue Kharisma</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f5f5;
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: linear-gradient(135deg, #2c2c2c 0%, #1a1a1a 100%);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding: 30px 0;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 0 25px 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .admin-title {
            font-family: 'Brush Script MT', cursive;
            font-size: 24px;
            color: #d4b896;
            font-style: italic;
            margin-bottom: 5px;
        }

        .admin-subtitle {
            font-size: 12px;
            color: #999;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 25px;
            color: #ccc;
            text-decoration: none;
            transition: all 0.3s;
            cursor: pointer;
        }

        .menu-item:hover,
        .menu-item.active {
            background: rgba(212, 184, 150, 0.1);
            color: #d4b896;
            border-left: 4px solid #d4b896;
            padding-left: 21px;
        }

        .menu-item svg {
            width: 22px;
            height: 22px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
        }

        .logout-btn {
            position: absolute;
            bottom: 30px;
            left: 25px;
            right: 25px;
            background: #d32f2f;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s;
        }

        .logout-btn:hover {
            background: #b71c1c;
        }

        .logout-btn svg {
            width: 18px;
            height: 18px;
            stroke: white;
            fill: none;
            stroke-width: 2;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            flex: 1;
            padding: 30px;
        }

        .top-bar {
            background: white;
            padding: 20px 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .page-title {
            font-size: 28px;
            font-weight: 600;
            color: #2c2c2c;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .admin-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #d4b896 0%, #c9a882 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .admin-avatar svg {
            width: 25px;
            height: 25px;
            stroke: white;
            fill: none;
            stroke-width: 2;
        }

        .admin-name {
            font-size: 15px;
            font-weight: 600;
            color: #2c2c2c;
        }

        .admin-role {
            font-size: 12px;
            color: #999;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon svg {
            width: 30px;
            height: 30px;
            stroke: white;
            fill: none;
            stroke-width: 2;
        }

        .stat-icon.blue {
            background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
        }

        .stat-icon.green {
            background: linear-gradient(135deg, #4caf50 0%, #388e3c 100%);
        }

        .stat-icon.orange {
            background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
        }

        .stat-icon.purple {
            background: linear-gradient(135deg, #9c27b0 0%, #7b1fa2 100%);
        }

        .stat-info {
            flex: 1;
        }

        .stat-label {
            font-size: 13px;
            color: #999;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 600;
            color: #2c2c2c;
        }

        /* Content Section */
        .content-section {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: none;
        }

        .content-section.active {
            display: block;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: #2c2c2c;
        }

        .btn-primary {
            background: #8b7355;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background: #6b5845;
            transform: translateY(-2px);
        }

        .btn-primary svg {
            width: 18px;
            height: 18px;
            stroke: white;
            fill: none;
            stroke-width: 2;
        }

        /* Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead {
            background: #f5f5f0;
        }

        .data-table th {
            padding: 15px;
            text-align: left;
            font-size: 13px;
            font-weight: 600;
            color: #4a4a4a;
            text-transform: uppercase;
        }

        .data-table td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            color: #2c2c2c;
        }

        .data-table tr:hover {
            background: #fafafa;
        }

        .product-img {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-badge.pending {
            background: #fff3e0;
            color: #f57c00;
        }

        .status-badge.process {
            background: #e3f2fd;
            color: #1976d2;
        }

        .status-badge.completed {
            background: #e8f5e9;
            color: #388e3c;
        }
.status-badge.shipping {
    background: #e1f5fe; /* Biru muda */
    color: #0288d1;      /* Biru tua */
}
        .action-btns {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            padding: 8px 12px;
            border: none;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-edit {
            background: #e3f2fd;
            color: #1976d2;
        }

        .btn-edit:hover {
            background: #1976d2;
            color: white;
        }

        .btn-delete {
            background: #ffebee;
            color: #d32f2f;
        }

        .btn-delete:hover {
            background: #d32f2f;
            color: white;
        }

        @media (max-width: 968px) {
            .sidebar {
                width: 70px;
            }

            .sidebar-header,
            .menu-item span,
            .logout-btn span {
                display: none;
            }

            .menu-item {
                justify-content: center;
                padding: 15px;
            }

            .main-content {
                margin-left: 70px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="admin-title">Admin Panel</div>
            <div class="admin-subtitle">Toko Kue Kharisma</div>
        </div>

        <div class="sidebar-menu">
            <a class="menu-item active" onclick="showSection('dashboard')">
                <svg viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
                <span>Dashboard</span>
            </a>

            <a class="menu-item" href="/admin/pesanan-baru" style="position: relative;">
                <svg viewBox="0 0 24 24">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
                <span>Pesanan Baru</span>
                @if(!empty($newOrdersCount) && $newOrdersCount > 0)
                <span style="position: absolute; right: 20px; background: #ff9800; color: white; border-radius: 50%; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: bold;">{{ $newOrdersCount }}</span>
                @endif
            </a>

            <a class="menu-item" onclick="showSection('products')">
                <svg viewBox="0 0 24 24">
                    <path d="M20 7h-9"></path>
                    <path d="M14 17H5"></path>
                    <circle cx="17" cy="17" r="3"></circle>
                    <circle cx="7" cy="7" r="3"></circle>
                </svg>
                <span>Produk</span>
            </a>

            <a class="menu-item" onclick="showSection('orders')">
                <svg viewBox="0 0 24 24">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                <span>Pesanan</span>
            </a>

            <a class="menu-item" onclick="showSection('customers')">
                <svg viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span>Pelanggan</span>
            </a>
        </div>

        <button class="logout-btn" onclick="window.location.href='/'">
            <svg viewBox="0 0 24 24">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                <polyline points="16 17 21 12 16 7"></polyline>
                <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg>
            <span>Logout</span>
        </button>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <h1 class="page-title" id="pageTitle">Dashboard</h1>
            <div class="admin-info">
                <div>
                    <div class="admin-name">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <div class="admin-role">{{ ucfirst(auth()->user()->role ?? 'administrator') }}</div>
                </div>
                <div class="admin-avatar">
                    <svg viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <svg viewBox="0 0 24 24">
                        <path d="M20 7h-9"></path>
                        <path d="M14 17H5"></path>
                        <circle cx="17" cy="17" r="3"></circle>
                        <circle cx="7" cy="7" r="3"></circle>
                    </svg>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Total Produk</div>
                    <div class="stat-value">{{ $totalProducts }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon green">
                    <svg viewBox="0 0 24 24">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Total Pesanan</div>
                    <div class="stat-value">{{ $totalOrders }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon orange">
                    <svg viewBox="0 0 24 24">
                        <line x1="12" y1="1" x2="12" y2="23"></line>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Total Revenue</div>
                    <div class="stat-value">{{ number_format($totalRevenue / 1000000, 1) }}M</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon purple">
                    <svg viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Total Pelanggan</div>
                    <div class="stat-value">{{ $totalCustomers }}</div>
                </div>
            </div>
        </div>

        <!-- Dashboard Section -->
        <div class="content-section active" id="dashboard">
            <div class="section-header">
                <h2 class="section-title">Pesanan Terbaru</h2>
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td>#{{ $order->order_number }}</td>
                        <td>{{ $order->user?->name ?? '-' }}</td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td>
                            @php
                                $statusClass = match($order->status) {
                                    'pending' => 'pending',
                                    'verified' => 'process',
                                    'shipping' => 'shipping',
                                    'completed' => 'completed',
                                    default => 'pending',
                                };
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td>
             <div class="action-btns">
    <!-- Tombol Detail selalu tampil -->
    <a href="/admin/order/{{ $order->id }}" class="btn-action btn-edit">Detail</a>

    @if($order->status == 'verified')
        <!-- Tombol untuk mengubah dari Diproses ke Dikirim -->
        <form action="{{ route('admin.updateStatus', $order->id) }}" method="POST" style="display:inline;">
            @csrf
            <input type="hidden" name="status" value="shipping">
            <button type="submit" class="btn-action" style="background: #0288d1; color: white;">Kirim</button>
        </form>
    @elseif($order->status == 'shipping')
        <!-- Tombol untuk mengubah dari Dikirim ke Selesai -->
        <form action="{{ route('admin.updateStatus', $order->id) }}" method="POST" style="display:inline;">
            @csrf
            <input type="hidden" name="status" value="completed">
            <button type="submit" class="btn-action" style="background: #388e3c; color: white;">Selesaikan</button>
        </form>
    @endif

    @if($order->status == 'pending')
        <button class="btn-action btn-delete">Batalkan</button>
    @endif
</div>

        <!-- Products Section -->
        <div class="content-section" id="products">
            <div class="section-header">
                <h2 class="section-title">Daftar Produk</h2>
                <button class="btn-primary" onclick="alert('Fitur tambah produk')">
                    <svg viewBox="0 0 24 24">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Tambah Produk
                </button>
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td><img src="{{ $product->image_url }}" class="product-img"></td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category }}</td>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>
                            <div class="action-btns">
                                <button class="btn-action btn-edit">Edit</button>
                                <button class="btn-action btn-delete">Hapus</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Orders Section -->
        <div class="content-section" id="orders">
            <div class="section-header">
                <h2 class="section-title">Semua Pesanan</h2>
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>#{{ $order->order_number }}</td>
                        <td>{{ $order->user?->name ?? '-' }}</td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td>
                            @php
                                $statusClass = match($order->status) {
                                    'pending' => 'pending',
                                    'verified' => 'process',
                                    'shipping'  => 'Dikirim',
                                    'completed' => 'completed',
                                    default => 'pending',
                                };
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td>
                            <div class="action-btns">
                                <button class="btn-action btn-edit">Detail</button>
                                <button class="btn-action btn-delete">Batalkan</button>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;">Belum ada pesanan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Customers Section -->
        <div class="content-section" id="customers">
            <div class="section-header">
                <h2 class="section-title">Daftar Pelanggan</h2>
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Total Pesanan</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                    <tr>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>-</td>
                        <td>0</td>
                        <td>{{ $customer->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="action-btns">
                                <button class="btn-action btn-edit">Detail</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function showSection(sectionName) {
            // Hide all sections
            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.remove('active');
            });

            // Remove active class from all menu items
            document.querySelectorAll('.menu-item').forEach(item => {
                item.classList.remove('active');
            });

            // Show selected section
            document.getElementById(sectionName).classList.add('active');

            // Add active class to clicked menu item
            event.target.closest('.menu-item').classList.add('active');

            // Update page title
            const titles = {
                'dashboard': 'Dashboard',
                'products': 'Produk',
                'orders': 'Pesanan',
                'customers': 'Pelanggan'
            };
            document.getElementById('pageTitle').textContent = titles[sectionName];
        }
    </script>
</body>
</html>
