<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Makanan Utama',
                'description' => 'Berbagai menu makanan utama khas restoran.',
            ],
            [
                'name' => 'Minuman',
                'description' => 'Aneka minuman segar dan hangat.',
            ],
            [
                'name' => 'Camilan',
                'description' => 'Snack ringan untuk teman ngobrol.',
            ],
            [
                'name' => 'Dessert',
                'description' => 'Hidangan penutup manis dan lezat.',
            ],
            [
                'name' => 'Paket Spesial',
                'description' => 'Menu paket hemat dan pilihan favorit pelanggan.',
            ],
            [
                'name' => 'Kopi & Teh',
                'description' => 'Pilihan minuman kopi dan teh premium.',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
            ]);
        }
    }
}
