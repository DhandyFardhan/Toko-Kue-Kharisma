<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckoutFlowTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $products;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Setup test user
        $this->user = User::factory()->create([
            'address' => 'Jl. Test No. 123, Jakarta',
            'phone' => '081234567890',
        ]);

        // Setup test products
        $this->products = Product::factory()->count(3)->create([
            'stock' => 100,
            'price' => 50000,
        ]);
    }

    /**
     * Test: User bisa checkout dengan metode COD
     */
    public function test_user_can_checkout_with_cod(): void
    {
        $this->actingAs($this->user);

        // Add items to cart
        Cart::create([
            'user_id' => $this->user->id,
            'product_id' => $this->products[0]->id,
            'quantity' => 2,
        ]);

        // Checkout
        $response = $this->postJson('/checkout', [
            'payment_method' => 'cod',
            'notes' => 'Tolong dikemas dengan rapi ya',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('payment_method', 'cod');

        // Verify order created
        $this->assertDatabaseHas('orders', [
            'user_id' => $this->user->id,
            'payment_method' => 'cod',
            'status' => 'pending',
        ]);

        // Verify cart cleared
        $this->assertEquals(0, Cart::where('user_id', $this->user->id)->count());
    }

    /**
     * Test: User tidak bisa checkout tanpa alamat
     */
    public function test_user_cannot_checkout_without_address(): void
    {
        $userNoAddress = User::factory()->create([
            'address' => null,
        ]);

        $this->actingAs($userNoAddress);

        Cart::create([
            'user_id' => $userNoAddress->id,
            'product_id' => $this->products[0]->id,
            'quantity' => 1,
        ]);

        $response = $this->postJson('/checkout', [
            'payment_method' => 'cod',
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('success', false);
        $response->assertJsonPath('require_address', true);
    }

    /**
     * Test: User tidak bisa checkout dengan keranjang kosong
     */
    public function test_user_cannot_checkout_with_empty_cart(): void
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/checkout', [
            'payment_method' => 'cod',
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('success', false);
    }

    /**
     * Test: Order total calculation correct
     */
    public function test_order_total_calculation_is_correct(): void
    {
        $this->actingAs($this->user);

        // Add multiple items
        Cart::create([
            'user_id' => $this->user->id,
            'product_id' => $this->products[0]->id,
            'quantity' => 2,
        ]);

        Cart::create([
            'user_id' => $this->user->id,
            'product_id' => $this->products[1]->id,
            'quantity' => 3,
        ]);

        $response = $this->postJson('/checkout', [
            'payment_method' => 'cod',
        ]);

        $response->assertStatus(200);

        // Expected: (2 * 50000) + (3 * 50000) + 5000 = 300000
        $expectedTotal = (2 * 50000) + (3 * 50000) + 5000;
        
        $response->assertJsonPath('total', $expectedTotal);

        $this->assertDatabaseHas('orders', [
            'user_id' => $this->user->id,
            'subtotal' => 250000,
            'shipping_cost' => 5000,
            'total' => 300000,
        ]);
    }

    /**
     * Test: Order items created with correct data
     */
    public function test_order_items_are_created_correctly(): void
    {
        $this->actingAs($this->user);

        Cart::create([
            'user_id' => $this->user->id,
            'product_id' => $this->products[0]->id,
            'quantity' => 5,
        ]);

        $this->postJson('/checkout', [
            'payment_method' => 'cod',
        ]);

        // Get created order
        $order = Order::where('user_id', $this->user->id)->first();

        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $this->products[0]->id,
            'quantity' => 5,
            'price' => 50000,
            'subtotal' => 250000,
        ]);
    }

    /**
     * Test: Cart cleared after checkout
     */
    public function test_cart_is_cleared_after_checkout(): void
    {
        $this->actingAs($this->user);

        // Add 5 items
        for ($i = 0; $i < 5; $i++) {
            Cart::create([
                'user_id' => $this->user->id,
                'product_id' => $this->products[$i % 3]->id,
                'quantity' => 1,
            ]);
        }

        $this->assertEquals(5, Cart::where('user_id', $this->user->id)->count());

        $this->postJson('/checkout', [
            'payment_method' => 'cod',
        ]);

        $this->assertEquals(0, Cart::where('user_id', $this->user->id)->count());
    }

    /**
     * Test: Invalid payment method rejected
     */
    public function test_invalid_payment_method_is_rejected(): void
    {
        $this->actingAs($this->user);

        Cart::create([
            'user_id' => $this->user->id,
            'product_id' => $this->products[0]->id,
            'quantity' => 1,
        ]);

        $response = $this->postJson('/checkout', [
            'payment_method' => 'invalid_method',
        ]);

        $response->assertStatus(422);
        $response->assertSessionHasErrors('payment_method');
    }

    /**
     * Test: Notes are saved in order
     */
    public function test_order_notes_are_saved(): void
    {
        $this->actingAs($this->user);

        Cart::create([
            'user_id' => $this->user->id,
            'product_id' => $this->products[0]->id,
            'quantity' => 1,
        ]);

        $notes = 'Jangan lupa pakai kotak kado!';

        $this->postJson('/checkout', [
            'payment_method' => 'cod',
            'notes' => $notes,
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $this->user->id,
            'notes' => $notes,
        ]);
    }

    /**
     * Test: Order number is unique
     */
    public function test_order_number_is_unique(): void
    {
        $this->actingAs($this->user);

        // First checkout
        Cart::create([
            'user_id' => $this->user->id,
            'product_id' => $this->products[0]->id,
            'quantity' => 1,
        ]);

        $response1 = $this->postJson('/checkout', [
            'payment_method' => 'cod',
        ]);

        $orderNumber1 = $response1->json('order_number');

        // Second checkout
        Cart::create([
            'user_id' => $this->user->id,
            'product_id' => $this->products[1]->id,
            'quantity' => 1,
        ]);

        $response2 = $this->postJson('/checkout', [
            'payment_method' => 'cod',
        ]);

        $orderNumber2 = $response2->json('order_number');

        $this->assertNotEquals($orderNumber1, $orderNumber2);
    }

    /**
     * Test: User must be authenticated to checkout
     */
    public function test_unauthenticated_user_cannot_checkout(): void
    {
        $response = $this->postJson('/checkout', [
            'payment_method' => 'cod',
        ]);

        $response->assertStatus(401);
    }
}
