<?php

namespace App\Filament\Resources\PaymentProofResource\Pages;

use App\Filament\Resources\PaymentProofResource;
use Filament\Resources\Pages\ViewRecord;

class ViewPaymentProof extends ViewRecord
{
    protected static string $resource = PaymentProofResource::class;

    protected function getHeaderActions(): array
    {
        // Halaman ini hanya untuk melihat bukti transfer.
        // Verifikasi/Tolak dilakukan di menu Pesanan.
        return [];
    }
}
