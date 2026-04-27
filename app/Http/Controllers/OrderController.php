<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function history()
    {
        $orders = Order::with(['orderItems.product'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $reviewedOrders = \App\Models\Review::whereIn(
            'order_number',
            $orders->pluck('order_number')
        )->pluck('order_number')->toArray();

        return view('riwayat', compact('orders', 'reviewedOrders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:qris,cod,bank_transfer',
            'notes'          => 'nullable|string|max:500',
        ]);

        $user = Auth::user()->fresh();
        $userAddress = $user->address ?? $user->alamat;

        // Cek alamat pengiriman (sesuai User Summary)
        if (empty($userAddress)) {
            return response()->json([
                'success'         => false,
                'message'         => 'Silakan lengkapi alamat pengiriman di profil terlebih dahulu.',
                'require_address' => true,
            ], 422);
        }

        $cartItems = Cart::forUser($user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang belanja kosong',
            ], 422);
        }

        DB::beginTransaction();
        try {
            $subtotal = $cartItems->sum(function ($item) {
                return $item->quantity * ($item->price ?? $item->product->price);
            });
            $shippingCost = 5000;
            $discount     = 0;
            $total        = $subtotal + $shippingCost - $discount;

            $orderNumber = 'ORD-' . strtoupper(uniqid());

            $order = Order::create([
                'order_number'     => $orderNumber,
                'user_id'          => $user->id,
                'subtotal'         => $subtotal,
                'shipping_cost'    => $shippingCost,
                'discount'         => $discount,
                'total'            => $total,
                'payment_method'   => $request->payment_method,
                'notes'            => $request->notes,
                'delivery_address' => $userAddress,
                'status'           => 'pending',
            ]);

            foreach ($cartItems as $item) {
                $itemPrice = $item->price ?? $item->product->price;
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $itemPrice,
                    'subtotal'   => $item->quantity * $itemPrice,
                ]);
            }

            DB::commit();

            if ($request->payment_method === 'qris') {
                $qrisResult = $this->processQrisPayment($order, $user, $cartItems, $shippingCost);
                
                // Jika Snap Token berhasil dibuat, hapus keranjang
                $data = $qrisResult->getData();
                if (isset($data->success) && $data->success) {
                    Cart::forUser($user->id)->delete();
                }
                return $qrisResult;
            }

            Cart::forUser($user->id)->delete();

            if ($request->payment_method === 'bank_transfer') {
                return response()->json([
                    'success' => true,
                    'message' => 'Pesanan berhasil dibuat. Silakan upload bukti transfer.',
                    'redirect' => route('payment.upload', $order->id),
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat (COD)',
                'order_number' => $order->order_number,
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Order Store Error: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Sistem Error: ' . $e->getMessage()
            ], 500);
        }
    }

    private function processQrisPayment($order, $user, $cartItems, $shippingCost)
    {
        // Konfigurasi Midtrans (Sesuai Dashboard)
        $serverKey = config('services.midtrans.server_key') ?? 'Mid-server-M-KhvSN5ZIiU-zxjdlMKZkOV';
        $clientKey = config('services.midtrans.client_key') ?? 'Mid-client-uWWcBH2KzsJhMH1_';

        try {
            MidtransConfig::$serverKey = $serverKey;
            MidtransConfig::$isProduction = config('services.midtrans.is_production', false);
            MidtransConfig::$isSanitized = true;
            MidtransConfig::$is3ds = true;
            
            // Solusi Error 10023: Paksa IPv4 dan Bypass SSL Localhost
            MidtransConfig::$curlOptions = [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4,
            ];

            $item_details = [];
            $packageMapping = [
                100 => 'Paketan Hemat A',
                101 => 'Paketan Hemat B',
                102 => 'Paketan Hemat C',
            ];

            foreach ($cartItems as $item) {
                $price = (int) ($item->price ?? $item->product->price);
                
                // Handle package products (virtual IDs 100-102)
                if (in_array($item->product_id, [100, 101, 102])) {
                    $itemName = $packageMapping[$item->product_id] ?? 'Paket';
                } else {
                    $itemName = $item->product->name ?? 'Produk';
                }

                $item_details[] = [
                    'id'       => 'PRD-' . $item->product_id,
                    'price'    => $price,
                    'quantity' => (int) $item->quantity,
                    'name'     => (string) substr($itemName, 0, 50),
                ];
            }

            // Tambahkan ongkos kirim ke detail item
            $item_details[] = [
                'id'       => 'SHIPPING-FEE',
                'price'    => (int)$shippingCost,
                'quantity' => 1,
                'name'     => 'Ongkos Kirim',
            ];

            $params = [
                'transaction_details' => [
                    'order_id'     => $order->order_number . '-' . time(),
                    'gross_amount' => (int)$order->total, 
                ],
                'customer_details' => [
                    'first_name' => (string) ($user->name ?? 'Customer'),
                    'email'      => (string) ($user->email ?? 'customer@mail.com'),
                    'phone'      => (string) ($user->phone ?? '08123456789'),
                ],
                'item_details' => $item_details,
                'enabled_payments' => ['qris'],
            ];

            $snapToken = Snap::getSnapToken($params);

            return response()->json([
                'success'             => true,
                'message'             => 'Snap token berhasil dibuat',
                'snap_token'          => $snapToken,
                'midtrans_client_key' => $clientKey,
                'order_number'        => $order->order_number,
            ]);

        } catch (\Throwable $e) {
            Log::error('MIDTRANS API ERROR: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Koneksi Midtrans Gagal: ' . $e->getMessage()
            ], 500);
        }
    }

    public function historyJson()
    {
        $orders = Order::with(['orderItems.product'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
        return response()->json(['orders' => $orders]);
    }
}