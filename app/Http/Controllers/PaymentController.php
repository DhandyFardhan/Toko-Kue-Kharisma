<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\PaymentProof;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Upload bukti transfer pembayaran
     */
    public function uploadProof(Request $request)
    {
        try {
            $request->validate([
                'order_id'        => 'required|exists:orders,id',
                // Banyak HP mengirim screenshot sebagai WEBP/JFIF/HEIC.
                'proof_image'     => 'required|image|mimes:jpeg,png,jpg,gif,webp,jfif,heic,heif|max:5120', // Max 5MB
                'payment_method'  => 'nullable|string|in:qris,bank_transfer',
                'bank_name'       => 'nullable|string',
                'account_name'    => 'nullable|string',
                'amount'          => 'required|numeric|min:0',
            ]);

            $order = Order::findOrFail($request->order_id);

            // Pastikan order milik user yang login
            if ($order->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized - Order tidak milik user yang login',
                ], 403);
            }

            // Jika order payment_method bank_transfer, wajib info rekening pengirim
            if ($order->payment_method === 'bank_transfer') {
                $request->validate([
                    'bank_name'    => 'required|string',
                    'account_name' => 'required|string',
                ]);
            }

            // Cek apakah sudah ada payment proof untuk order ini
            if ($order->paymentProof) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bukti transfer sudah pernah diunggah untuk order ini',
                ], 422);
            }

            // Upload file
            $file = $request->file('proof_image');
            $filename = 'payment_' . $order->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('payment_proofs', $filename, 'public');

            if (!$path) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan file ke storage',
                ], 500);
            }

            // Create payment proof record
            $paymentProof = PaymentProof::create([
                'order_id'     => $order->id,
                'proof_image'  => $path,
                'bank_name'    => $request->bank_name,
                'account_name' => $request->account_name,
                'amount'       => $request->amount,
                'status'       => 'pending',
            ]);

            // Update order status
            // Status order hanya boleh: pending, verified, in_progress, completed, cancelled
            // Setelah bukti diunggah, tetap "pending" sampai diverifikasi admin.
            $order->update(['status' => 'pending']);

            return response()->json([
                'success' => true,
                'message' => 'Bukti transfer berhasil diunggah. Admin akan memverifikasi dalam waktu singkat.',
                'payment_proof' => $paymentProof,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Payment upload error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengunggah bukti transfer: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Tampilkan halaman upload bukti transfer
     */
    public function show($orderId)
    {
        $order = Order::findOrFail($orderId);

        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('payment.upload-proof', compact('order'));
    }

    /**
     * Verify payment (admin)
     */
    public function verify(Request $request, $paymentProofId)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected',
            'notes'  => 'nullable|string|max:1000',
        ]);

        $paymentProof = PaymentProof::findOrFail($paymentProofId);

        if ($request->status === 'verified') {
            $paymentProof->update([
                'status'      => 'verified',
                'admin_notes' => $request->notes,
                'verified_at' => now(),
            ]);

            // Update order status to confirmed
            $paymentProof->order->update(['status' => 'confirmed']);

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil diverifikasi',
            ]);
        } else {
            $paymentProof->update([
                'status'      => 'rejected',
                'admin_notes' => $request->notes,
            ]);

            // Update order status back to pending
            $paymentProof->order->update(['status' => 'pending']);

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran ditolak',
            ]);
        }
    }

    /**
     * List semua payment proofs (admin)
     */
    public function listPending()
    {
        $paymentProofs = PaymentProof::where('status', 'pending')
            ->with(['order.user'])
            ->latest()
            ->paginate(10);

        return view('admin.payment-verification', compact('paymentProofs'));
    }
}
