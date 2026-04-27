<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_number' => 'ORD-' . strtoupper($this->faker->unique()->bothify('?????')),
            'user_id' => User::factory(),
            'subtotal' => $this->faker->numberBetween(50000, 500000),
            'shipping_cost' => 5000,
            'discount' => 0,
            'total' => $this->faker->numberBetween(55000, 505000),
            'payment_method' => $this->faker->randomElement(['cod', 'qris']),
            'status' => $this->faker->randomElement(['pending', 'verified', 'in_progress', 'completed', 'cancelled', 'paid']),
            'delivery_address' => $this->faker->address(),
            'notes' => $this->faker->optional()->sentence(),
            'midtrans_order_id' => null,
            'midtrans_transaction_id' => null,
            'midtrans_payment_type' => null,
            'midtrans_transaction_status' => null,
            'midtrans_raw_notification' => null,
        ];
    }
}
