<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            DB::table('products')->insert([
            'kode_barang' => $faker->unique()->numerify('KB###'),
            'nama_barang' => $faker->word(),
            'stok_awal' => $faker->numberBetween(10, 100),
            'harga_beli' => $faker->numberBetween(1000, 10000),
            'harga_jual' => $faker->numberBetween(1100, 15000),
            'kadaluarsa' => $faker->dateTimeBetween('now', '+2 years'),
            'deskripsi' => $faker->sentence(),
            'gambar' => $faker->imageUrl(),
            'kategori' => $faker->word(),
            'total_stok' => $faker->numberBetween(10, 100),
            'user_id' => 4,
            'created_at' => now(),
            'updated_at' => now(),
            ]);
        }
    }
}
