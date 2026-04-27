<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test: Order has correct relationships
     */
    public function test_order_has_order_items_relationship(): void
    {
        $order = Order::factory()->create();
        
        OrderItem::factory()->create(['order_id' => $order->id]);
        OrderItem::factory()->create(['order_id' => $order->id]);

        $this->assertEquals(2, $order->orderItems()->count());
    }

    /**
     * Test: Order has user relationship
     */
    public function test_order_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $this->assertTrue($order->user->is($user));
    }

    /**
     * Test: Order total calculation
     */
    public function test_order_totals_are_calculated_correctly(): void
    {
        $order = Order::factory()->create([
            'subtotal' => 250000,
            'shipping_cost' => 5000,
            'discount' => 0,
        ]);

        $expectedTotal = 250000 + 5000 - 0;
        $this->assertEquals($expectedTotal, $order->total);
    }

    /**
     * Test: Order status validation
     */
    public function test_order_status_must_be_valid(): void
    {
        $validStatuses = ['pending', 'verified', 'in_progress', 'completed', 'cancelled', 'paid'];

        foreach ($validStatuses as $status) {
            $order = Order::factory()->create(['status' => $status]);
            $this->assertEquals($status, $order->status);
        }
    }

    /**
     * Test: Order number generation
     */
    public function test_order_number_is_unique(): void
    {
        $order1 = Order::factory()->create();
        $order2 = Order::factory()->create();

        $this->assertNotEquals($order1->order_number, $order2->order_number);
    }

    /**
     * Test: Order items have correct relationships
     */
    public function test_order_item_belongs_to_order(): void
    {
        $order = Order::factory()->create();
        $item = OrderItem::factory()->create(['order_id' => $order->id]);

        $this->assertTrue($item->order->is($order));
    }

    /**
     * Test: Order item belongs to product
     */
    public function test_order_item_belongs_to_product(): void
    {
        $product = Product::factory()->create();
        $item = OrderItem::factory()->create(['product_id' => $product->id]);

        $this->assertTrue($item->product->is($product));
    }

    /**
     * Test: Order item subtotal calculation
     */
    public function test_order_item_subtotal_is_calculated(): void
    {
        $item = OrderItem::factory()->create([
            'price' => 50000,
            'quantity' => 3,
        ]);

        $expectedSubtotal = 50000 * 3;
        $this->assertEquals($expectedSubtotal, $item->subtotal);
    }

    /**
     * Test: Multiple items in one order
     */
    public function test_order_can_have_multiple_different_items(): void
    {
        $order = Order::factory()->create();
        $product1 = Product::factory()->create();
        $product2 = Product::factory()->create();

        OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_id' => $product1->id,
            'quantity' => 2,
        ]);

        OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_id' => $product2->id,
            'quantity' => 3,
        ]);

        $this->assertEquals(2, $order->orderItems()->count());
        $this->assertTrue($order->orderItems()->first()->product->is($product1));
        $this->assertTrue($order->orderItems()->last()->product->is($product2));
    }
}
