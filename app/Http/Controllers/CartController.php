<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();
        $totalItems = $cartItems->sum('quantity');
        $totalPrice = $cartItems->sum(function ($item) {
            $price = $item->price ?? ($item->product->price ?? 0);
            return $price * $item->quantity;
        });

        return view('cart', compact('cartItems', 'totalItems', 'totalPrice', 'user'));
    }

    public function add(Request $request): JsonResponse
{
    // 0. Cek auth terlebih dahulu
    $user = Auth::user();
    if (!$user) {
        return response()->json(['success' => false, 'message' => 'Login dulu'], 401);
    }

    $productId = $request->product_id;
    $quantity = $request->quantity ?? 1;
    $packageIds = [901, 902, 903];

    // 1. Tentukan Nama & Harga
    if (in_array($productId, $packageIds)) {
        $packageMapping = [
            901 => ['name' => 'Paketan Hemat A', 'price' => 20000],
            902 => ['name' => 'Paketan Hemat B', 'price' => 20000],
            903 => ['name' => 'Paketan Hemat C', 'price' => 20000],
        ];
        $productName = $packageMapping[$productId]['name'];
        $finalPrice = $packageMapping[$productId]['price'];
    } else {
        // Validasi hanya untuk produk biasa
        $request->validate(['product_id' => 'required|exists:products,id']);
        
        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
        }
        
        $productName = $product->name;
        $finalPrice = $request->price ?? $product->price;
    }

        // 2. Simpan ke Keranjang
        $cartItem = Cart::where('user_id', $user->id)->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->price = $finalPrice;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $finalPrice
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil ditambah',
            'data' => [
                'product_name' => $productName,
                'total_items' => Cart::getTotalItems($user->id),
                'total_price' => Cart::getTotalPrice($user->id)
            ]
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $user = Auth::user();
        $productId = $request->product_id;
        $quantity = $request->quantity;

        if ($quantity <= 0) {
            Cart::where('user_id', $user->id)->where('product_id', $productId)->delete();
        } else {
            Cart::where('user_id', $user->id)->where('product_id', $productId)->update(['quantity' => $quantity]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'total_items' => Cart::getTotalItems($user->id),
                'total_price' => Cart::getTotalPrice($user->id)
            ]
        ]);
    }

    public function remove(Request $request): JsonResponse
    {
        Cart::where('user_id', Auth::id())->where('product_id', $request->product_id)->delete();
        return response()->json([
            'success' => true,
            'data' => [
                'total_items' => Cart::getTotalItems(Auth::id()),
                'total_price' => Cart::getTotalPrice(Auth::id())
            ]
        ]);
    }

    public function summary(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'total_items' => Cart::getTotalItems(Auth::id()),
                'total_price' => Cart::getTotalPrice(Auth::id())
            ]
        ]);
    }

    public function count(): JsonResponse
    {
        $userId = Auth::id();
        $count = $userId ? Cart::getTotalItems($userId) : 0;
        return response()->json(['count' => $count]);
    }

    public function clear(): JsonResponse
    {
        Cart::where('user_id', Auth::id())->delete();
        return response()->json(['success' => true]);
    }
}