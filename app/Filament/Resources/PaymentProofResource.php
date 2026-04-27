<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentProofResource\Pages;
use App\Models\PaymentProof;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;

class PaymentProofResource extends Resource
{
    protected static ?string $model = PaymentProof::class;

    // Payment gateway dipakai, jadi menu bukti transfer manual disembunyikan.
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';

    protected static ?string $navigationLabel = 'Bukti Transfer';

    protected static ?string $modelLabel = 'Bukti Transfer';

    protected static ?string $pluralModelLabel = 'Bukti Transfer';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending'   => 'Menunggu Verifikasi',
                        'verified'  => 'Diverifikasi',
                        'rejected'  => 'Ditolak',
                    ])
                    ->required(),
                Textarea::make('admin_notes')
                    ->label('Catatan Admin')
                    ->placeholder('Tuliskan catatan untuk customer jika ada'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order.order_number')
                    ->label('No. Pesanan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('order.user.name')
                    ->label('Pelanggan')
                    ->searchable()
                    ->sortable(),

                ImageColumn::make('proof_image')
                    ->label('Bukti Transfer')
                    // Paksa source <img> ke /storage/... (hindari double /storage/storage).
                    ->getStateUsing(fn (PaymentProof $record) => ltrim((string) $record->proof_image, '/'))
                    ->disk('public')
                    ->size(100)
                    ->toggleable(),

                TextColumn::make('bank_name')
                    ->label('Bank')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('account_name')
                    ->label('Atas Nama')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('amount')
                    ->label('Jumlah')
                    ->money('IDR')
                    ->sortable()
                    ->toggleable(),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending'   => 'Menunggu',
                        'verified'  => 'Diverifikasi',
                        'rejected'  => 'Ditolak',
                        default     => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'pending'   => 'warning',
                        'verified'  => 'success',
                        'rejected'  => 'danger',
                        default     => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Tanggal Upload')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending'   => 'Menunggu Verifikasi',
                        'verified'  => 'Diverifikasi',
                        'rejected'  => 'Ditolak',
                    ]),
            ])
            // Halaman ini hanya untuk melihat bukti transfer.
            // Verifikasi/Tolak dilakukan di menu Pesanan.
            ->actions([])
            ->bulkActions([]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informasi Bukti Transfer')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('order.order_number')
                            ->label('No. Pesanan')
                            ->weight('bold'),
                        TextEntry::make('order.user.name')
                            ->label('Pelanggan'),
                        TextEntry::make('bank_name')
                            ->label('Bank Pengirim'),
                        TextEntry::make('account_name')
                            ->label('Atas Nama'),
                        TextEntry::make('amount')
                            ->label('Jumlah Transfer')
                            ->money('IDR'),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->formatStateUsing(fn ($state) => match ($state) {
                                'pending'   => 'Menunggu Verifikasi',
                                'verified'  => 'Diverifikasi',
                                'rejected'  => 'Ditolak',
                                default     => $state,
                            })
                            ->color(fn ($state) => match ($state) {
                                'pending'   => 'warning',
                                'verified'  => 'success',
                                'rejected'  => 'danger',
                                default     => 'gray',
                            }),
                        TextEntry::make('created_at')
                            ->label('Tanggal Upload')
                            ->dateTime('d M Y, H:i'),
                        TextEntry::make('verified_at')
                            ->label('Tanggal Verifikasi')
                            ->dateTime('d M Y, H:i')
                            ->placeholder('-'),
                    ]),

                Section::make('Bukti Transaksi')
                    ->schema([
                        ImageEntry::make('proof_image')
                            ->label('')
                            ->getStateUsing(fn (PaymentProof $record) => ltrim((string) $record->proof_image, '/'))
                            ->disk('public'),
                    ]),

                Section::make('Catatan Admin')
                    ->schema([
                        TextEntry::make('admin_notes')
                            ->label('')
                            ->default('-')
                            ->markdown(),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->with(['order', 'order.user'])
            ->orderByDesc('created_at');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPaymentProofs::route('/'),
            'view'  => Pages\ViewPaymentProof::route('/{record}'),
        ];
    }
}
