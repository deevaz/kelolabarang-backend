<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StockIn;
use Illuminate\Support\Facades\DB;

class StockInSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('stockIn')->truncate();

        StockIn::create([
            'product_id' => 4,
            'supplier_id' => 1,
            'jumlah_stok_masuk' => 50,
            'total_stok' => 150,
            'tanggal_masuk' => now(),
            'catatan' => 'Initial stock entry',
            'total_harga' => 500000,
            'user_id' => 4,
        ]);

        StockIn::create([
            'product_id' => 5,
            'supplier_id' => 7,
            'jumlah_stok_masuk' => 30,
            'total_stok' => 80,
            'tanggal_masuk' => now(),
            'catatan' => 'Restocking',
            'total_harga' => 300000,
            'user_id' => 4,
        ]);
    }
}
