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

            // Status otomatis untuk COD dan QRIS (langsung in_progress), pending untuk metode pembayaran lain
            $status = in_array($request->payment_method, ['cod', 'qris']) ? 'in_progress' : 'pending';

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
    'status'           => $status, 
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
                'message' => 'Pesanan berhasil dibuat! Pesanan sedang diproses. Terimakasih atas pembelian Anda 🙏',
                'order_number' => $order->order_number,
                'status' => 'in_progress',
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
        $serverKey = config('services.midtrans.server_key');
$clientKey = config('services.midtrans.client_key');
        $isProduction = config('services.midtrans.is_production', false);

        try {
            // Validasi keys
            if (empty($serverKey) || empty($clientKey)) {
                Log::error('Midtrans keys missing', ['serverKey' => !empty($serverKey), 'clientKey' => !empty($clientKey)]);
                throw new \Exception('Midtrans configuration incomplete');
            }

            // Konfigurasi Midtrans
            MidtransConfig::$serverKey = $serverKey;
            MidtransConfig::$isProduction = $isProduction;
            MidtransConfig::$isSanitized = true;
            MidtransConfig::$is3ds = true;
            
            // Solusi Error 10023: Paksa IPv4 dan Bypass SSL Localhost (untuk development)
            if (!$isProduction) {
                MidtransConfig::$curlOptions = [
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4,
                ];
            }

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

            // Validasi total item vs gross amount
            $itemTotal = array_reduce($item_details, function ($sum, $item) {
                return $sum + ($item['price'] * $item['quantity']);
            }, 0);

            if ($itemTotal != (int)$order->total) {
                Log::warning('Item total mismatch', [
                    'itemTotal' => $itemTotal,
                    'orderTotal' => $order->total
                ]);
            }

            $params = [
                'transaction_details' => [
                    'order_id'     => $order->order_number . '-' . time(),
                    'gross_amount' => (int)$order->total,
                ],
                'customer_details' => [
                    'first_name' => $user->name ?? 'Pelanggan',
                    'email'      => $user->email ?? 'customer@mail.com',
                    'phone'      => $user->phone ?? '08123456789',
                ],
                'item_details' => $item_details,
                // Biarkan semua payment method tersedia (QRIS, e-wallet, transfer bank, dll)
                // Jika ingin hanya QRIS: uncomment baris bawah
                // 'enabled_payments' => ['qris'],
               'callbacks' => [
        'finish' => url('/riwayat'),
        'error'  => url('/riwayat'),
        'pending'=> url('/riwayat'),
    ],
];

            Log::info('Midtrans request params', [
                'order_id' => $params['transaction_details']['order_id'],
                'amount' => $params['transaction_details']['gross_amount'],
                'items' => count($item_details)
            ]);

            // Coba generate Snap Token dengan error handling
            $snapToken = @Snap::getSnapToken($params);

            if (!$snapToken) {
                throw new \Exception('Failed to generate Snap token - empty response');
            }

            Log::info('Snap token generated successfully', ['order' => $order->order_number]);

            return response()->json([
                'success'             => true,
                'message'             => 'Snap token berhasil dibuat',
                'snap_token'          => $snapToken,
                'midtrans_client_key' => $clientKey,
                'order_number'        => $order->order_number,
            ]);

        } catch (\Exception $e) {
            $errorMsg = $e->getMessage();
            Log::error('MIDTRANS ERROR', [
                'message' => $errorMsg,
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            
            return response()->json([
                'success' => false, 
                'message' => 'Koneksi Midtrans gagal: ' . $errorMsg
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
    
    // Tambahkan di dalam class OrderController

public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:shipping,completed'
    ]);

    $order = Order::findOrFail($id);
    $order->status = $request->status;
    $order->save();

    return back()->with('success', 'Status pesanan berhasil diperbarui menjadi ' . $request->status);
}
}