<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    // Tambahkan ini supaya angka update otomatis tiap 15 detik tanpa refresh browser
    protected static ?string $pollingInterval = '15s';

 protected function getStats(): array
    {
        // 1. Pesanan yang statusnya 'in_progress' (Sudah bayar Midtrans & perlu dikirim)
        $processingOrders = Order::where('status', 'in_progress')->count();
        
        $totalOrders = Order::count();
        
        // 2. Revenue hanya dihitung dari yang statusnya 'completed'
        $totalRevenue = Order::where('status', 'completed')->sum('total');
        
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 'user')->count();

        return [
            Stat::make('Pesanan Masuk', $processingOrders)
                ->description('Sedang Diproses') // Lebih spesifik buat penguji
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color($processingOrders > 0 ? 'warning' : 'gray')
                ->icon('heroicon-o-shopping-cart'),

            Stat::make('Total Pesanan', $totalOrders)
                ->description('Seluruh transaksi')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary')
                ->icon('heroicon-o-clipboard-document-list'),

            Stat::make('Total Revenue', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Pesanan selesai')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success')
                ->icon('heroicon-o-currency-dollar'),


            Stat::make('Total Pelanggan', $totalCustomers)
                ->description('User terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('info')
                ->icon('heroicon-o-users'),

            Stat::make('Total Produk', $totalProducts)
                ->description('Produk tersedia')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->icon('heroicon-o-cake'),
            
            Stat::make('Pesanan Terkirim', Order::whereIn('status', ['shipping', 'completed'])->count())
            ->description('Sudah dikirim & Selesai')
            ->descriptionIcon('heroicon-m-truck')
            ->color('success'),
        ];
    }
}