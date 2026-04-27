<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('midtrans_order_id')->nullable()->index();
            $table->string('midtrans_transaction_id')->nullable()->index();
            $table->string('midtrans_payment_type')->nullable();
            $table->string('midtrans_transaction_status')->nullable();
            $table->json('midtrans_raw_notification')->nullable();
        });

        // Tambah status "paid" ke enum orders.status
        // Note: MySQL membutuhkan ALTER TABLE untuk enum.
        DB::statement(
            "ALTER TABLE `orders` MODIFY `status` ENUM('pending','verified','in_progress','completed','cancelled','paid') NOT NULL DEFAULT 'pending'"
        );
    }

    public function down(): void
    {
        // Kembalikan enum ke versi awal (tanpa paid)
        DB::statement(
            "ALTER TABLE `orders` MODIFY `status` ENUM('pending','verified','in_progress','completed','cancelled') NOT NULL DEFAULT 'pending'"
        );

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'midtrans_order_id',
                'midtrans_transaction_id',
                'midtrans_payment_type',
                'midtrans_transaction_status',
                'midtrans_raw_notification',
            ]);
        });
    }
};

