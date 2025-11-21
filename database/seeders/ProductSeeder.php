<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $samples = [
            [
                'name' => 'Layers Mash',
                'sku' => 'PF-LAY-001',
                'description' => 'Premium layers mash for improved egg quality and consistent production.',
                'price' => 2450,
                'quantity' => 50,
                'image' => 'images/kienyeji.jpeg',
            ],
            [
                'name' => 'Dairy High',
                'sku' => 'PF-DAI-001',
                'description' => 'High-energy dairy feed for increased milk yield.',
                'price' => 5600,
                'quantity' => 30,
                'image' => 'images/dairyhigh.jpeg',
            ],
            [
                'name' => 'Chicken Starter',
                'sku' => 'PF-CHK-001',
                'description' => 'Starter feed for day-old chicks to boost early growth.',
                'price' => 1200,
                'quantity' => 100,
                'image' => 'images/dairy.jpeg',
            ],
        ];

        foreach ($samples as $s) {
            Product::updateOrCreate(
                ['sku' => $s['sku']], // UNIQUE FIELD
                $s                     // FIELDS TO UPDATE
            );
        }
    }
}
