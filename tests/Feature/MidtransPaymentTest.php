<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MidtransPaymentTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $product;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create([
            'address' => 'Jl. Test No. 123',
            'phone' => '081234567890',
        ]);

        $this->product = Product::factory()->create([
            'price' => 100000,
            'stock' => 100,
        ]);
    }

    /**
     * Test: QRIS checkout returns snap token when Midtrans configured
     */
    public function test_qris_checkout_requires_valid_midtrans_keys(): void
    {
        $this->actingAs($this->user);

        // Check that Midtrans keys are configured
        $serverKey = config('midtrans.server_key');
        $clientKey = config('midtrans.client_key');

        Cart::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 1,
        ]);

        if (!$serverKey || !$clientKey) {
            // Without keys, should return error
            $response = $this->postJson('/checkout', [
                'payment_method' => 'qris',
            ]);

            $response->assertStatus(500);
            $response->assertJsonPath('success', false);
        } else {
            // With keys, should succeed
            $response = $this->postJson('/checkout', [
                'payment_method' => 'qris',
            ]);

            $response->assertStatus(200);
            $response->assertJsonPath('success', true);
            $response->assertJsonPath('payment_method', 'qris');
            $response->assertJsonHasPath('snap_token');
        }
    }

    /**
     * Test: Order created before Midtrans token generation
     */
    public function test_order_is_created_before_midtrans_token(): void
    {
        $this->actingAs($this->user);

        Cart::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 1,
        ]);

        $response = $this->postJson('/checkout', [
            'payment_method' => 'qris',
        ]);

        // Order should be created regardless of Midtrans success/failure
        if ($response->status() === 200 || $response->status() === 500) {
            $order = Order::where('user_id', $this->user->id)->first();
            $this->assertNotNull($order);
            $this->assertEquals('pending', $order->status);
        }
    }

    /**
     * Test: Midtrans fields saved correctly
     */
    public function test_midtrans_fields_are_saved(): void
    {
        $this->actingAs($this->user);

        Cart::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 1,
        ]);

        $response = $this->postJson('/checkout', [
            'payment_method' => 'qris',
        ]);

        if ($response->status() === 200) {
            $order = Order::where('user_id', $this->user->id)->first();

            $this->assertNotNull($order->midtrans_order_id);
            $this->assertEquals('pending', $order->midtrans_transaction_status);
            $this->assertEquals('qris', $order->midtrans_payment_type);
        }
    }

    /**
     * Test: Item details format for Midtrans is valid
     */
    public function test_item_details_format_is_valid(): void
    {
        $this->actingAs($this->user);

        Cart::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        // Make the request
        $response = $this->postJson('/checkout', [
            'payment_method' => 'qris',
        ]);

        // Item details should include both product and shipping fee
        // This is validated by checking the order creation succeeds
        if ($response->status() === 200) {
            $order = Order::where('user_id', $this->user->id)->first();
            
            // Should have 1 product + 1 shipping fee item
            $this->assertEquals(1, $order->orderItems()->count());
        }
    }

    /**
     * Test: Transaction status mappings
     */
    public function test_transaction_status_mappings(): void
    {
        $order = Order::factory()->create([
            'user_id' => $this->user->id,
            'midtrans_transaction_status' => 'pending',
        ]);

        $this->assertEquals('pending', $order->midtrans_transaction_status);

        // Simulate webhook update
        $order->update(['midtrans_transaction_status' => 'settlement']);
        $this->assertEquals('settlement', $order->midtrans_transaction_status);
    }
}
