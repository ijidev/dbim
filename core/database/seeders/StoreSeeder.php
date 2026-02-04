<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'title' => 'Anointing Oil (Blessed)',
                'slug' => 'anointing-oil-blessed',
                'description' => 'Specially consecrated anointing oil for your spiritual journey.',
                'price' => 2500.00,
                'type' => 'physical',
                'stock' => 50,
                'status' => true,
            ],
            [
                'title' => 'The Power of Prayer (Digital Guide)',
                'slug' => 'the-power-of-prayer-digital',
                'description' => 'A comprehensive PDF guide on deepening your prayer life.',
                'price' => 1500.00,
                'type' => 'digital',
                'stock' => 999,
                'status' => true,
            ],
            [
                'title' => 'DBIM Branded T-Shirt',
                'slug' => 'dbim-branded-tshirt',
                'description' => 'High-quality cotton t-shirt with DBIM logo.',
                'price' => 5000.00,
                'type' => 'physical',
                'stock' => 100,
                'status' => true,
            ],
        ];

        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }
    }
}
