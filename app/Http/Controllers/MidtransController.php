<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    /**
     * Webhook endpoint: Midtrans akan POST notifikasi transaksi ke sini.
     */
    public function notification(Request $request)
    {
        $payload = $request->all();

        $orderId = $payload['order_id'] ?? null;
        $statusCode = (string) ($payload['status_code'] ?? '');
        $grossAmount = (string) ($payload['gross_amount'] ?? '');
        $signatureKey = (string) ($payload['signature_key'] ?? '');

        if (!$orderId) {
            return response()->json(['message' => 'order_id missing'], 400);
        }

        $serverKey = (string) config('midtrans.server_key');
        if ($serverKey === '') {
            return response()->json(['message' => 'server key not configured'], 500);
        }

        // Validasi signature sesuai dokumentasi Midtrans.
        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
        if (!hash_equals($expectedSignature, $signatureKey)) {
            Log::warning('Midtrans signature mismatch', [
                'order_id' => $orderId,
            ]);
            return response()->json(['message' => 'invalid signature'], 401);
        }

        $order = Order::where('order_number', $orderId)->first();
        if (!$order) {
            return response()->json(['message' => 'order not found'], 404);
        }

        $transactionStatus = (string) ($payload['transaction_status'] ?? '');
        $paymentType = (string) ($payload['payment_type'] ?? '');

        // Simpan raw notification untuk debugging uji level.
        $order->midtrans_order_id = $orderId;
        $order->midtrans_transaction_id = $payload['transaction_id'] ?? $order->midtrans_transaction_id;
        $order->midtrans_payment_type = $paymentType ?: $order->midtrans_payment_type;
        $order->midtrans_transaction_status = $transactionStatus ?: $order->midtrans_transaction_status;
        $order->midtrans_raw_notification = $payload;

        // Mapping status Midtrans -> status order
        if (in_array($transactionStatus, ['capture', 'settlement'], true)) {
            $order->status = 'paid';
        } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'], true)) {
            $order->status = 'cancelled';
        } else {
            // pending / lainnya -> tetap pending
            $order->status = 'pending';
        }

        $order->save();

        return response()->json(['message' => 'ok']);
    }
}

