<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Pesanan Terbaru';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::with('user')->latest()->limit(10)
            )
            ->columns([
                TextColumn::make('order_number')
                    ->label('No. Pesanan')
                    ->weight('bold'),

                TextColumn::make('user.name')
                    ->label('Pelanggan'),

                TextColumn::make('payment_method')
                    ->label('Pembayaran')
                    ->badge()
                    ->formatStateUsing(fn ($state) => strtoupper($state))
                    ->color(fn ($state) => match ($state) {
                        'qris' => 'info',
                        'cod'  => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('total')
                    ->label('Total')
                    ->money('IDR'),

               TextColumn::make('status')
    ->label('Status')
    ->badge()
    ->formatStateUsing(fn ($state) => match ($state) {
        'pending'     => 'Menunggu',
        'verified'    => 'Diverifikasi',
        'in_progress' => 'Diproses',
        'shipping'    => 'Dikirim', // <-- Tambahkan baris ini
        'completed'   => 'Selesai',
        'cancelled'   => 'Dibatalkan',
        default       => $state,
    })
    ->color(fn ($state) => match ($state) {
        'pending'     => 'warning',
        'verified'    => 'info',
        'in_progress' => 'primary',
        'shipping'    => 'info',    // <-- Tambahkan warna (info = biru)
        'completed'   => 'success',
        'cancelled'   => 'danger',
        default       => 'gray',
    }),
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Detail')
                    ->url(fn (Order $record) => \App\Filament\Resources\OrderResource::getUrl('view', ['record' => $record]))
                    ->icon('heroicon-m-eye'),
            ]);
    }
}
