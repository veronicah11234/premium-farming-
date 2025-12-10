<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run()
{
    $categories = [
        'Poultry',
        'Dairy',
        'Swine',
        'Pet Feeds',
        'By-products',
        'Goat Feeds'
    ];

    foreach ($categories as $cat) {
        \App\Models\Category::create([
            'name' => $cat,
            'slug' => \Str::slug($cat)
        ]);
    }


}

}
