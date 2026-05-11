<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Helpers\WhatsAppHelper;
use App\Models\PaymentProof;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;

// ... (namespace dan use tetap sama)

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    /**
     * Fungsi ini berjalan saat halaman Detail dibuka
     */
    public function mount($record): void
    {
        parent::mount($record);

        // Jika pesanan ini belum dibaca, tandai sebagai sudah dibaca
        if (!$this->record->is_read) {
            $this->record->update([
                'is_read' => true
            ]);
        }
    }

    protected function getHeaderActions(): array
    {
        // ... (isi header actions kamu tetap sama, tidak ada yang diubah)
        $actions = [];
        
        // ... dst

        // Action untuk verifikasi payment jika ada bukti transfer yang pending
        if ($this->record->payment_method === 'bank_transfer' && $this->record->paymentProof) {
            if ($this->record->paymentProof->status === 'pending') {
                $actions[] = Actions\Action::make('verify_payment')
                    ->label('Verifikasi Pembayaran')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Verifikasi Bukti Transfer')
                    ->modalDescription('Tandai pembayaran transfer ini sebagai terverifikasi?')
                    ->form([
                        Textarea::make('admin_notes')
                            ->label('Catatan (Opsional)')
                            ->placeholder('Tuliskan catatan jika ada'),
                    ])
                    ->action(function (array $data) {
                        $this->record->paymentProof->update([
                            'status'      => 'verified',
                            'admin_notes' => $data['admin_notes'] ?? null,
                            'verified_at' => now(),
                        ]);

                        $this->record->update(['status' => 'confirmed']);

                        Notification::make()
                            ->title('Pembayaran Berhasil Diverifikasi')
                            ->body('Pesanan telah terkonfirmasi.')
                            ->success()
                            ->send();

                        $this->refresh();
                    });

                $actions[] = Actions\Action::make('reject_payment')
                    ->label('Tolak Pembayaran')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Tolak Bukti Transfer')
                    ->modalDescription('Tandai pembayaran ini sebagai ditolak?')
                    ->form([
                        Textarea::make('admin_notes')
                            ->label('Alasan Penolakan')
                            ->placeholder('Jelaskan mengapa bukti transfer ditolak')
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $this->record->paymentProof->update([
                            'status'      => 'rejected',
                            'admin_notes' => $data['admin_notes'],
                        ]);

                        $this->record->update(['status' => 'pending']);

                        Notification::make()
                            ->title('Pembayaran Ditolak')
                            ->body('Pembayaran telah ditolak. Status pesanan kembali ke pending.')
                            ->danger()
                            ->send();

                        $this->refresh();
                    });
            }
        }

        // Existing verification action (untuk method QRIS/COD)
        $actions[] = Actions\Action::make('verify')
            ->label('Verifikasi')
            ->icon('heroicon-o-check-circle')
            ->color('success')
            ->requiresConfirmation()
            ->modalHeading('Verifikasi Pesanan')
            ->modalDescription('Pesanan akan diubah statusnya menjadi "Diverifikasi" dan notifikasi WhatsApp akan dikirim ke customer.')
            ->action(function () {
                $this->record->load(['user', 'orderItems.product']);
                $this->record->update(['status' => 'verified']);

                $waUrl = WhatsAppHelper::buildUrl($this->record);

                Notification::make()
                    ->title('Pesanan berhasil diverifikasi')
                    ->body($waUrl
                        ? 'Klik tombol WhatsApp untuk notifikasi customer.'
                        : 'Customer tidak memiliki nomor telepon.')
                    ->success()
                    ->actions($waUrl ? [
                        \Filament\Notifications\Actions\Action::make('whatsapp')
                            ->label('Kirim WhatsApp')
                            ->icon('heroicon-o-chat-bubble-left-ellipsis')
                            ->url($waUrl, shouldOpenInNewTab: true),
                    ] : [])
                    ->persistent()
                    ->send();

                $this->refreshFormData(['status']);
            })
            ->visible(fn () => $this->record->payment_method !== 'bank_transfer' && $this->record->status === 'pending');

        $actions[] = Actions\Action::make('process')
                ->label('Proses')
                ->icon('heroicon-o-cog-6-tooth')
                ->color('primary')
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->update(['status' => 'in_progress']);
                    $this->refreshFormData(['status']);
                })
                ->visible(fn () => in_array($this->record->status, ['verified', 'confirmed']));

        $actions[] = Actions\Action::make('complete')
                ->label('Selesai')
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->update(['status' => 'completed']);
                    $this->refreshFormData(['status']);
                })
                ->visible(fn () => $this->record->status === 'in_progress');

        $actions[] = Actions\Action::make('cancel')
                ->label('Batalkan')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->update(['status' => 'cancelled']);
                    $this->refreshFormData(['status']);
                })
                ->visible(fn () => in_array($this->record->status, ['pending', 'verified', 'confirmed', 'pending_payment']));

        return $actions;
    }

    
}
