<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Insert paket promo dengan ID tetap 901, 902, 903
        DB::table('products')->insert([
            [
                'id' => 901,
                'name' => 'Paketan Hemat A',
                'description' => 'Paket promo: Dadar Gulung, Lemper, Putu Ayu, Lupis, Kue Apem',
                'price' => 20000,
                'category' => 'Paket Promo',
                'image_url' => '/images/products/dadar-gulung.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 902,
                'name' => 'Paketan Hemat B',
                'description' => 'Paket promo: Talam Suji, Pepe Hijau, Pepe Pelangi, Ongol-Ongol, Kue Lumpur',
                'price' => 20000,
                'category' => 'Paket Promo',
                'image_url' => '/images/products/kue-talam-suji.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 903,
                'name' => 'Paketan Hemat C',
                'description' => 'Paket promo: Bolu Pelangi, Pie Buah, Pie Brownies, Risoles, Pastel',
                'price' => 20000,
                'category' => 'Paket Promo',
                'image_url' => '/images/products/bolu-pelangi.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        DB::table('products')->whereIn('id', [901, 902, 903])->delete();
    }
};
